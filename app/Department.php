<?php

namespace App;

/**
 * :: Department Model ::
 * To manage Department CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'department';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        'floor_id',
        'name',
        'code',
        'description',
        'head_name',
        'contact_number',
        'address',
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
    public function scopeDepartmentHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('department.hospital_id', loggedInHospitalId()) : null;
    }
    /**
     * Method is used to validate roles
     *
     * @param $inputs
     * @param int $id
     * @return Response
     */
    public function validateDepartment($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        // validation rule
        if ($id) {
            $rules['name'] = 'required|unique:department,name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['code'] = 'required|unique:department,code,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['name'] = 'required|unique:department,name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['code'] = 'required|unique:department,code,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        }
        // $rules['floor_name'] = 'required';

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
    public function getDepartmentCode($code = null)
    {
        $result =  $this->departmentHospital()->where('code', $code)->first();
        if ($result) {
            $data =  $this->departmentHospital()->orderBy('id', 'desc')->take(1)->first(['code']);
        } else {
            $data =  $this->departmentHospital()->orderBy('id', 'desc')->take(1)->first(['code']);
        }

        if (count($data) == 0) {
            $number = 'DEPT-01';
        } else {
            $number = number_inc($data->code); // new code increment by 1
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
    public function getDepartments($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'department.id',
            'department.name',
            'department.code',
            'floor.name as floor_name',
            'department.description',
            'department.status',
        ];

        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND department.name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->leftJoin('floor', 'floor.id', 'department.floor_id')
            ->whereRaw($filter)
            ->where('department.hospital_id', loggedInHospitalId())
            ->orderBy('id', 'ASC')->skip($skip)->take($take)->get($fields);
    }

    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalDepartments($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND department.name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getDepartmentService()
    {
        $result = $this->active()
            ->departmentHospital()
            ->pluck('name', 'id')->toArray();
        return ['' => '-Select Department-'] + $result;
    }
}
