<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeType extends Model
{
    use SoftDeletes;

    /**
     * @table
     */
    protected $table = 'employee_type';

    /**
     * @filds of table employee_type
     */
    protected $fillable = [
        'id',
        'hospital_id',
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
    public function scopeEmployeeTypeHospital($query)
    {
    return (!isSuperAdmin())?
        $query->where('employee_type.hospital_id', loggedInHospitalId()) : null;
    }

    /**
     * add validation
     * @param $inputs
     * @param null $id
     * @return mixed
     */

    public function validateEmployeeType($inputs, $id = null)
    {
        if($id) {
            $rules['name'] = 'required|alpha_spaces|unique:employee_type,name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['name'] = 'required|alpha_spaces|unique:employee_type,name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['status'] = 'required';
        }
        return \Validator::make($inputs, $rules);
    }

    /**
     * @param $input
     * @param null $id
     * @return bool|mixed
     */
    public function store($input, $id=null){
        if($id){
           return $this->find($id)->update($input);
        } else {
           return $this->create($input)->id;
        }
    }

    /**
     * @return array
     */
    public function listEmployeeType(){
       $result = $this->active()->pluck('name', 'id')
           ->employeeTypeHospital()
           ->toArray();
        return [''=>'--Employee Type--'] + $result;
    }

    /**
     * @param null $search
     * @param $skip
     * @param $perPage
     * @return \Illuminate\Support\Collection
     */
    public function getEmployeeType($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'id',
            'name',
            'status',
        ];
        /**
         *
         */
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND employee_type.name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->whereRaw($filter)
            ->where('employee_type.hospital_id', loggedInHospitalId())
            ->orderBy('id', 'ASC')->skip($skip)->take($take)->get($fields);
    }

    /**
     * @param null $search
     * @return Model|null|static
     */
    public function totalEmployeeType($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND employee_type.name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }
}
