<?php
namespace App;
/**
 * :: Ward Master Model ::
 * To manage Ward Master CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WardMaster extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ward_master';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'company_id',
        'status',
        'deleted_at',
        'deleted_by',
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
     * @param type $query
     * @return type
     */
    public function scopeCompany($query)
    {
        return $query->where('company_id', loggedInHospitalId());
    }

    /**
     * Method is used to validate roles
     * @param $inputs
     * @param int $id
     * @return Response
     */
    public function validateWard($inputs, $id = null)
    {
        // validation rule
        if ($id) {
            $rules['name'] = 'required|unique:ward_master,name,' . $id .',id,deleted_at,NULL,company_id,'.loggedInHospitalId();
            $rules['code'] = 'required|unique:ward_master,code,' . $id .',id,deleted_at,NULL,company_id,'.loggedInHospitalId();
        } else {
            $rules['name'] = 'required|unique:ward_master,name,NULL,id,deleted_at,NULL,company_id,'.loggedInHospitalId();
            $rules['code'] = 'required|unique:ward_master,code,NULL,id,deleted_at,NULL,company_id,'.loggedInHospitalId();
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
     * @return mixed
     */
    public function getWards($search = null, $skip, $perPage)
    {
        $sortBy = [
            'name' => 'name',
            'code' => 'code',
        ];
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'id',
            'name',
            'code',
            'description',
            'status',
        ];

        $orderEntity = 'id';
        $orderAction = 'desc';

        if (is_array($search) && count($search) > 0)
        {
            $filter .= (array_key_exists('keyword', $search))?
                " AND (name LIKE '%".addslashes(trim($search['keyword'])).
                "%' OR code LIKE '%".addslashes(trim($search['keyword']))."%')"
                : "";
        }

        return $this->whereRaw($filter)->company()
            ->orderBy($orderEntity, $orderAction)
            ->skip($skip)->take($take)->get($fields);
    }

    /**
     * Method is used to get total results.
     * @param array $search
     * @return mixed
     */
    public function totalWards($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0)
        {
            $filter .= (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)
            ->company()
            ->first();
    }

    /**
     * @return mixed
     */
    public function getWardService()
    {
        $data = $this->active()->company()
            ->orderBy('name','ASC')
            ->get([\DB::raw("concat(name, ' (', code) as name"), 'id']);
        $result = [];
        foreach($data as $detail) {
            $result[$detail->id] = $detail->name.')';

        }
        return ['' =>'-Select Ward-'] + $result;
    }

    /**
     * @param $id
     */
    public function drop($id)
    {
        $this->find($id)->update([ 'deleted_by' => authUserId(), 'deleted_at' =>convertToUtc() ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function wardExists($id)
    {
        $unitExistsInProduct = (new Product)->company()->where('unit_id', $id)->first();
        if(count($unitExistsInProduct) > 0) {
            return true;
        }
    }

    /**
     * Method is used to find Unit ID.
     * @param string $search
     * @return id
     */
    public function findWardID($search = '')
    {
        if ($search != '') {
            $filter = "code = '" . $search . "' ";
            return $this->select('ward_master.id as ward_id')
                ->whereRaw($filter)
                ->company()
                ->first();
        }
        return null;
    }
}