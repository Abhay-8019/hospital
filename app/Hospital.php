<?php

namespace App;
/**
 * :: Hospital Model ::
 * To manage Hospital CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'hospital';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'hospital_logo',
        'hospital_code',
        'hospital_name',
        'hospital_building',
        'contact_person',
        'tin_number',
        'email',
        'email1',
        'mobile',
        'mobile1',
        'phone',
        'website',
        'status',
        'permanent_address',
        'correspondence_address',
        'country',
        'state_id',
        'city',
        'pincode',
        'timezone',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * Scope a query to only include active users.
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
    public function scopeUserHospital($query)
    {
        return (!isSuperAdmin()) ?
            $query->where('id', loggedInHospitalId()) : null;
    }

    /**
     * @param array $inputs
     * @param int $id
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validateHospital($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        $regex = validWebSiteRegex();
        $rules = [
            'hospital_name' => 'required',
            'contact_person' => 'required',
            'mobile' => 'required|digits_between:7,11',
            'mobile2' => 'digits_between:7,11',
            'phone' => 'numeric_hyphen',
            'permanent_address' => 'required',
            'state' => 'alpha_spaces',
            'city' => 'alpha_spaces',
            'pincode' => 'digits_between:5,6',
            'status' => 'required|in:0,1'
        ];
        if($id) {
            //$rules['tin_number'] = 'required|numeric|unique:hospital,tin_number,' . $id . ',id,deleted_at,NULL';
            $rules['email'] = 'required|unique:hospital,email1,' . $id . ',id,deleted_at,NULL';
            $rules['email2'] = 'email|unique:hospital,email2,' . $id . ',id,deleted_at,NULL';
            $rules['website'] = 'regex:' . $regex.'|unique:hospital,website,' . $id . ',id,deleted_at,NULL';
        } else {
            //$rules['tin_number'] = 'required|numeric|unique:hospital,tin_number,NULL,id,deleted_at,NULL';
            $rules['email'] = 'required|email|unique:hospital,email1,NULL,id,deleted_at,NULL';
            $rules['email2'] = 'email|unique:hospital,email2,NULL,id,deleted_at,NULL';
            $rules['website'] = 'regex:' . $regex.'|unique:hospital,website,NULL,id,deleted_at,NULL';
        }
        return \Validator::make($inputs, $rules);
    }

    /**
     * @param $inputs
     * @param null $id
     * @return mixed
     */
    public function validateHospitalLogo($inputs, $id = null)
    {
        //|dimensions:max_width=300
        $rules = [
            'hospital_logo' => 'required|image|mimes:jpeg,jpg,png'
        ];
        $message = [
            'hospital_logo.dimensions' => lang('hospital.logo_max_width')
        ];
        return \Validator::make($inputs, $rules, $message );
    }

    /**
     * @param null $code
     * @return mixed|string
     */
    public function getHospitalCode($code = null)
    {
        $result =  $this->where('hospital_code', $code)->first();
        if ($result) {
            $data =  $this->orderBy('id', 'desc')->take(1)->first(['hospital_code']);
        } else {
            $data =  $this->orderBy('id', 'desc')->take(1)->first(['hospital_code']);
        }

        if (count($data) == 0) {
            $number = 'HP-01';
        } else {
            $number = number_inc($data->hospital_code); // new enquiry_number increment by 1
            //$number = paddingLeft(++$data->hospital);
        }
        return $number;
    }

    /**
     * @param array $inputs
     * @param int $id
     *
     * @return mixed
     */
    public function store($inputs, $id = null)
    {
        if ($id) {
            $this->find($id)->update($inputs);
            return $id;
        } else {
            return $this->create($inputs)->id;
        }
    }

    /**
     * Method is used to search total results.
     *
     * @param array $search
     * @param int $skip
     * @param int $perPage
     *
     * @return mixed
     */
    public function getHospital($search = null, $skip, $perPage)
    {
        trimInputs();
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'id',
            'hospital_code',
            'hospital_name',
            'contact_person',
            'gst_number',
            'email',
            'mobile',
            'status',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        if (is_array($search) && count($search) > 0)
        {
            $filter .= (array_key_exists('keyword', $search)) ? " AND (hospital_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%')" : "";
        }

        $filter .= (!isSuperAdmin()) ? ' AND id = ' . loggedInHospitalId() : '';

        return $this->whereRaw($filter)
            ->orderBy('id', 'ASC')
            ->skip($skip)->take($take)
            ->get($fields);
    }

    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalHospital($search = null)
    {
        trimInputs();
        $filter = 1; // default filter if no search

        if (is_array($search) && count($search) > 0)
        {
            $filter .= (array_key_exists('keyword', $search)) ? " AND (hospital_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%')" : "";
        }

        $filter .= (!isSuperAdmin()) ? ' AND id = '.loggedInHospitalId() : '';
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->get()
            ->first();
    }

    /**
     * @return mixed
     */
    public function getHospitalService()
    {
        $result = $this->active()
            ->userHospital()
            ->select(\DB::raw("concat(hospital_name, '(', hospital_code, ')') as hospital_name"), 'id')
            ->pluck('hospital_name', 'id')
            ->toArray();
        return ['' => '-Select Hospital-'] + $result;
    }

    /**
     * @param $id
     * @return mixed|static
     */
    public function getHospitalInfo($id)
    {
        return $this->find($id);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->userHospital()->select('*')->get();
    }
}
