<?php

namespace App;

/**
 * :: Building Model ::
 * To manage Building CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'building';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        'building_code',
        'name',
        'location',
        'no_of_floors',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    /**
     * Scope a query to only include active users.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    /**
     * @param $query
     * @return null
     */
    public function scopeBuildingHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('building.hospital_id', loggedInHospitalId()) : null;
    }
    /**
     * Method is used to validate roles
     *
     * @param $inputs
     * @param int $id
     * @return Response
     */
    public function validateBuilding($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        // validation rule
        if ($id) {
            $rules['name'] = 'required|unique:building,name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['building_code'] = 'required|unique:building,building_code,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['name'] = 'required|unique:building,name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['building_code'] = 'required|unique:building,building_code,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        }

        return \Validator::make($inputs, $rules);
    }
    /**
     * Method is used to save/update resource.
     *
     * @param   array $input
     * @param   int $id
     * @return  Response
     */
    public function store($input, $id = null)
    {
        if ($id) {
            return $this->find($id)->update($input);
        } else {
            return $this->create($input)->id;
        }
    }

    /**\
     * @param null $code
     * @return mixed|string
     */
    public function getBuildingCode($code = null)
    {
        $result =  $this->buildingHospital()->where('building_code', $code)->first();
        if ($result) {
            $data =  $this->buildingHospital()->orderBy('id', 'desc')->take(1)->first(['building_code']);
        } else {
            $data =  $this->buildingHospital()->orderBy('id', 'desc')->take(1)->first(['building_code']);
        }

        if (count($data) == 0) {
            $number = 'B-01';
        } else {
            $number = number_inc($data->building_code); // new building_code increment by 1
        }
        return $number;
    }

    /**
     * Method is used to search news detail.
     *
     * @param array $search
     * @param int $skip
     * @param int $perPage
     *
     * @return mixed
     */
    public function getBuilding($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'id',
            'hospital_id',
            'building_code',
            'name',
            'location',
            'no_of_floors',
            'status',
        ];

        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->whereRaw($filter)
            ->where('building.hospital_id', loggedInHospitalId())
            ->orderBy('id', 'ASC')
            ->skip($skip)->take($take)->get($fields);
    }
    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalBuilding($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getBuildingService()
    {
        $result = $this->active()->buildingHospital()
            ->pluck('name', 'id')->toArray();
        return ['' => '-Select Building-'] + $result;
    }

}
