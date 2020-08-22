<?php

namespace App;
/**
 * :: Timestamp Model ::
 * To manage Timestamp CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timestamp extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timezones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'timestamp',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * @return mixed
     */
    public function getTimeStampsService()
    {
        $result = $this->pluck('name', 'id')->toArray();
        return ['' => '-Select Time Zone-'] + $result;
    }

    public function getTimeStamps($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'id',
            'name',
            'timestamp',
            'status',
        ];

        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->whereRaw($filter)
            ->orderBy('id', 'ASC')->skip($skip)->take($take)->get($fields);
    }

    public function totalTimeStamps($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    public function updateStatusAll()
    {
        return $this->where('status', '=' ,1)->update([ 'status' => 0 ]);
    }

//    public function drop($id)
//    {
//        return $this->find($id)->delete();
//    }
}
