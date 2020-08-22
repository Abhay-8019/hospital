<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialization extends Model
{
    use SoftDeletes;


    protected $table = 'specialization';

    protected $fillable =[
        'id',
        'hospital_id',
        'name',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function scopeActive($query)
    {
        return $query->where(['status' => 1]);
    }

    public function scopeSpecializationHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('specialization.hospital_id', loggedInHospitalId()) : null;
    }

    public function validateSpecialization($inputs, $id = null)
    {
        // validation rule
        if ($id) {
            $rules['name'] = 'required|alpha|unique:specialization,name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['name'] = 'required|alpha|unique:specialization,name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        }

        return \Validator::make($inputs, $rules);
    }

    public function store($input, $id = null)
    {
        if ($id) {
            return $this->find($id)->update($input);
        } else {
            return $this->create($input)->id;
        }
    }

    public function getSpecializationName()
    {
        $result = $this->active()
            ->specializationHospital()
            ->pluck('name', 'id')->toArray();
        return ['' => '-Select Specialization-'] + $result;
    }

    public function getSpecialization($search = null, $skip, $perPage)
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
            $partyName = (array_key_exists('keyword', $search)) ? " AND specialization.name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->whereRaw($filter)
            ->where('specialization.hospital_id', loggedInHospitalId())
            ->orderBy('id', 'ASC')
            ->skip($skip)->take($take)->get($fields);
    }

    public function totalSpecialization($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND specialization.name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

}
