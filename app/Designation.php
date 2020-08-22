<?php

namespace App;

/**
 * :: DesignationDesignationDesignationDesignationDesignationDesignationDesignationDesignation Model ::
 * To manage Designation CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'designations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        'designation_name',
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
    public function scopeDesignationHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('designations.hospital_id', loggedInHospitalId()) : null;
    }
    /**
     * Method is used to validate roles
     *
     * @param $inputs
     * @param int $id
     * @return Response
     */
    public function validateDesignation($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        // validation rule
        if ($id) {
            $rules['designation_name'] = 'required|unique:designations,designation_name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['designation_name'] = 'required|unique:designations,designation_name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
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

    /**
     * Method is used to search news detail.
     *
     * @param array $search
     * @param int $skip
     * @param int $perPage
     *
     * @return mixed
     */
    public function getDesignation($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'id',
            'hospital_id',
            'designation_name',
            'status',
        ];

        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND designation_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->whereRaw($filter)
            ->where('designations.hospital_id', loggedInHospitalId())
            ->orderBy('id', 'ASC')->skip($skip)->take($take)->get($fields);
    }
    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalDesignation($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND designation_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getDesignationService()
    {
        $result = $this->active()
            ->designationHospital()
            ->pluck('designation_name', 'id')->toArray();
        return ['' => '-Select Designation-'] + $result;
    }
}
