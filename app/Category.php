<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        'vendor_id',
        'name',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where(['status' => 1]);
    }

    /**
     * @param $query
     * @return null
     */
    public function scopeCategoryHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('category.hospital_id', loggedInHospitalId()) : null;
    }

    /**
     * @param null $code
     * @return mixed|string
     */
    /*public function getCategoryCode($code = null)
    {
        $result =  $this->active()->categoryHospital()->where('code', $code)->first();
        if ($result) {
            $data =  $this->active()->categoryHospital()->orderBy('id', 'desc')->take(1)->first(['code']);
        } else {
            $data =  $this->active()->categoryHospital()->orderBy('id', 'desc')->take(1)->first(['code']);
        }

        if (count($data) == 0) {
            $number = 'C-01';
        } else {
            $number = number_inc($data->code); // new code increment by 1
        }
        return $number;
    }*/

    /**
     * @return array
     */
    public function getCategoryName()
    {
        $result = $this->active()->pluck('name', 'id')->toArray();
        return ['' => '-Select Category-'] + $result;
    }

    /**
     * @param $inputs
     * @param null $id
     * @return mixed
     */
    public function validateCategory($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        // validation rule
        if ($id) {
            $rules['name'] = 'required|unique:category,name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['name'] = 'required|unique:category,name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        }
        $rules['vendor_name'] = "required";

        return \Validator::make($inputs, $rules);
    }

    /**
     * @param $input
     * @param null $id
     * @return bool|mixed
     */
    public function store($input, $id = null)
    {
        if ($id) {
            return $this->find($id)->update($input);
        } else {
            return $this->create($input)->id;
        }
    }

    /**
     * @param null $search
     * @param $skip
     * @param $perPage
     * @return \Illuminate\Support\Collection
     */
    public function getCategory($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'category.id',
            'category.hospital_id',
            'category.vendor_id',
            /*'category.code',*/
            'category.name',
            'vendor.name as vendor_name',
            'category.status',
        ];
        /**
         *
         */
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND category.name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->leftJoin('vendor', 'vendor.id', 'category.vendor_id')->whereRaw($filter)
            ->orderBy('id', 'ASC')->skip($skip)->take($take)->get($fields);
    }
    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalCategory($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND category.name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

}
