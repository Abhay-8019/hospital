<?php
namespace App;
/**
 * :: State Model ::
 * To manage State CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'state_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state_name',
        'state_digit_code',
        'state_char_code',
    ];

    public $timestamps = false;

    /**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Method is used to validate roles
     *
     * @param $inputs
     * @param int $id
     * @return Response
     */
    public function validateState($inputs, $id = null)
    {
        // validation rule
        if ($id) {
            $rules['name'] = 'required|unique:state_master,state_name,' . $id .',id,deleted_at,NULL,company_id,'.loggedInCompanyId();
            $rules['code'] = 'required|unique:state_master,state_digit_code,' . $id .',id,deleted_at,NULL,company_id,'.loggedInCompanyId();
        } else {
            $rules['name'] = 'required|unique:state_master,state_name,NULL,id,deleted_at,NULL,company_id,'.loggedInCompanyId();
            $rules['code'] = 'required|unique:state_master,state_digit_code,NULL,id,deleted_at,NULL,company_id,'.loggedInCompanyId();
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
    public function getStates($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'id',
            'state_name',
            'state_digit_code',
            'state_char_code',
        ];

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('keyword', $search) && $search['keyword'] != "") ? " AND state_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $f1;
        }

        return $this->whereRaw($filter)
            ->orderBy('state_name', 'ASC')
            ->skip($skip)->take($take)->get($fields);
    }

    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalSizes($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search) && $search['keyword'] != "") ? " AND state_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
                    ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getStateService()
    {
        $data = $this->orderBy('state_digit_code', 'ASC')
            ->get(['state_name', 'state_digit_code', 'id']);
        $result = [];
        foreach($data as $detail) {
            $result[$detail->id] = $detail->state_name . ' (' . $detail->state_digit_code .')';
        }
        return ['' => '-Select State-'] + $result;
    }

    /**
     * @param null $name
     * @return mixed
     */
    public function getStateByName($name = null)
    {
        return $this->where(\DB::raw('LOWER(state_name)'), $name)->first();
    }
}
