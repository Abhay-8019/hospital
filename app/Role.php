<?php
namespace App;

/**
 * :: Role Model ::
 * To manage roles CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'role';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'hospital_id',
        'status',
        'isdefault'
    ];
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
     * @param int $id
     * @return Response
     **/
    public function validateRole($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        // validation rule
        if ($id) {
            $rules['name'] = 'required|unique:role,name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['code'] = 'required|unique:role,code,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['name'] = 'required|unique:role,name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['code'] = 'required|unique:role,code,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        }
        $message = [];
        if(!isSuperAdmin() && !isAdmin()) {
            if (isset($data['section']) && is_array($data['section']) && count($data['section']) > 0) {
                $rules['section']       = 'required';
                $message += ['section.required'  => 'Please select the permission section.'];
            }
        }
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
        //$input['hospital_id'] = 1;
        if ($id) {
            // save role
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
    public function getRoles($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'id',
            'isdefault',
            'name',
            'code',
            'status'
        ];

        if (is_array($search) && count($search) > 0)
        {
            $filter .=  (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
        }
        if(!isSuperAdmin()) {
            $filter .= " AND (isdefault = 1 AND id != 1) OR hospital_id =". addslashes(trim(loggedInHospitalId()));
        }
        //dd($filter);
        return $this->whereRaw($filter)
            ->orderBy('role.id', 'ASC')
            ->skip($skip)->take($take)
            ->get($fields);
    }

    /**
     * Method is used to get total category search wise.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalRoles($search = null)
    {
        // if no search add where
        $filter = 1;

        // when search news
        if (is_array($search) && count($search) > 0)
        {
            $filter .= (array_key_exists('name', $search)) ? " AND name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
        }
        if(!isSuperAdmin()) {
            $filter .= " AND (isdefault =1 AND id != 1) OR hospital_id =". addslashes(trim(loggedInHospitalId()));
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getRoleService()
    {
        //$filter = " id !=1 AND hospital_id = ".loggedInHospitalId();
        $f1 = null;
        if(!isSuperAdmin()) {
            $f1 .= " OR hospital_id =". addslashes(trim(loggedInHospitalId()));
        }
        $filter = " (isdefault =1 AND id != 1) ". $f1;

        $data = $this->active()
            ->whereRaw($filter)->get([\DB::raw("concat(name, ' (', code) as name"), 'id']);
        $result = [];
        foreach($data as $detail) {
            $result[$detail->id] = $detail->name .')';
        }
        return ['' => '-Select Role-'] + $result;
    }
}
