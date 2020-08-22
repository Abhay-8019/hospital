<?php

namespace App;

/**
 * :: EventType Model ::
 * To manage EventType CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        'event_type',
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
    public function scopeEventTypeHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('event_types.hospital_id', loggedInHospitalId()) : null;
    }
    /**
     * Method is used to validate roles
     *
     * @param $inputs
     * @param int $id
     * @return Response
     */
    public function validateEventType($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        $regex = regexIsAlphaSpaces();
        // validation rule
        if ($id) {
            $rules['event_type'] = 'required|regex:'.$regex.'|unique:event_types,event_type,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['event_type'] = 'required|regex:'.$regex.'|unique:event_types,event_type,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['status']    = 'required';
        }
        $message = [
            'event_type.regex'  => 'The event type format is invalid. event type accepts alphabet and spaces only.'
        ];

        return \Validator::make($inputs, $rules, $message);
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
    public function getEventType($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'event_types.id',
            'event_types.hospital_id',
            'event_types.event_type',
            'event_types.status',
        ];

        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND event_type LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->whereRaw($filter)
            ->where('event_types.hospital_id', loggedInHospitalId())
            ->orderBy('id', 'ASC')->skip($skip)->take($take)->get($fields);
    }
    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalEventType($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND event_type LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getEventTypeService()
    {
        $result = $this->active()
            ->eventTypeHospital()
            ->pluck('event_type', 'id')->toArray();
        return ['' => '-Select Event Type-'] + $result;
    }
}
