<?php

namespace App;

/**
 * :: AddEvent Model ::
 * To manage AddEvent CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddEvent extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'add_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        'event_type_id',
        'department_id',
        'event_name',
        'event_code',
        'is_holiday',
        'event_start',
        'event_end',
        'event_description',
        'event_for',
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
    public function scopeEventHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('add_events.hospital_id', loggedInHospitalId()) : null;
    }
    /**
     * @param null $code
     * @return mixed|string
     */
    public function getEventCode($code = null)
    {
        $result =  $this->active()->eventHospital()->where('event_code', $code)->first();
        if ($result) {
            $data =  $this->active()->eventHospital()->orderBy('id', 'desc')->take(1)->first(['event_code']);
        } else {
            $data =  $this->active()->eventHospital()->orderBy('id', 'desc')->take(1)->first(['event_code']);
        }

        if (count($data) == 0) {
            $number = 'EVENT-01';
        } else {
            $number = number_inc($data->event_code); // new event_code increment by 1
        }
        return $number;
    }

    /**
     * Method is used to validate roles
     *
     * @param $inputs
     * @param int $id
     * @return Response
     */
    public function validateEvent($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        $regex = regexIsAlphaSpaces();
        // validation rule
        if ($id) {
            $rules['event_name'] = 'required|regex:'.$regex.'|unique:add_events,event_name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['event_code'] = 'required|unique:add_events,event_code,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['event_name'] = 'required|regex:'.$regex.'|unique:add_events,event_name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['event_code'] = 'required|unique:add_events,event_code,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['status']    = 'required';
        }
        $rules +=[
            'event_start' => 'required|date',
            'event_end'   => 'required|date',
            'event_for'   => 'required',
        ];
        $message = [
            'event_name.regex'  => 'The event name format is invalid. event name accepts alphabet and spaces only.'
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
    public function getEvents($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'add_events.id',
            'add_events.event_type_id',
            'add_events.department_id',
            'add_events.event_name',
            'add_events.event_code',
            'add_events.is_holiday',
            'add_events.event_start',
            'add_events.event_end',
            'add_events.event_description',
            'add_events.event_for',
            'add_events.status',
            'event_types.event_type',
        ];

        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND event_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->leftJoin('event_types', 'event_types.id', '=', 'add_events.event_type_id')
            ->whereRaw($filter)
            ->where('add_events.hospital_id', loggedInHospitalId())
            ->orderBy('id', 'ASC')->skip($skip)->take($take)->get($fields);
    }
    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalEvents($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND event_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getEventService()
    {
        $result = $this->active()
            ->eventHospital()
            ->pluck('name', 'id')->toArray();
        return ['' => '-Select Events -'] + $result;
    }
}
