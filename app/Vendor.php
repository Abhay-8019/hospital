<?php

namespace App;

/**
 * :: Vendor Year Model ::
 * To manage Vendor CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        'vendor_code',
        'name',
        'company_name',
        'company_address',
        'company_phone',
        'mobile',
        'contact_number',
        'email',
        'bank_name',
        'branch_name',
        'account_number',
        'ifsc_code',
        'country',
        'state',
        'city',
        'zip_code',
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
    public function scopeVendorHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('vendor.hospital_id', loggedInHospitalId()) : null;
    }
    /**
     * @param null $code
     * @return mixed|string
     */
    public function getVendorCode($code = null)
    {
        $result =  $this->active()->vendorHospital()->where('vendor_code', $code)->first();
        if ($result) {
            $data =  $this->active()->vendorHospital()->orderBy('id', 'desc')->take(1)->first(['vendor_code']);
        } else {
            $data =  $this->active()->vendorHospital()->orderBy('id', 'desc')->take(1)->first(['vendor_code']);
        }

        if (count($data) == 0) {
            $number = 'VND-01';
        } else {
            $number = number_inc($data->vendor_code); // new vendor_code increment by 1
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
    public function validateVendor($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        $regex = regexIsAlphaSpaces();
        // validation rule
        if ($id) {
            $rules['name']         = 'required|alpha_spaces|unique:vendor,name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['vendor_code']  = 'required|unique:vendor,vendor_code,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['email']        = 'required|unique:vendor,email,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['company_name'] = 'required|alpha_spaces|unique:vendor,company_name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['name']         = 'required|alpha_spaces|unique:vendor,name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['vendor_code']  = 'required|unique:vendor,vendor_code,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['email']        = 'required|unique:vendor,email,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['company_name'] = 'required|alpha_spaces|unique:vendor,company_name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['status']       = 'required';
        }
        $rules +=  [
            'company_address'       => 'required',
            'contact_number'        => 'required|min:10|numeric',
            'country'               => 'alpha_spaces',
            'state'                 => 'alpha_spaces',
            'city'                  => 'alpha_spaces',
            'std_code'              => 'min:4|numeric',
            'company_phone'         => 'required|min:7|numeric',
            'mobile'                => 'required|min:10|numeric',
            'bank_name'             => 'required|alpha_spaces',
            'branch_name'           => 'required|alpha_spaces',
            'account_number'        => 'required|alpha_num',
            'ifsc_code'             => 'required|alpha_num',
            'zip_code'              => 'min:6|numeric',
        ];
        $message = [
            'company_phone.required'  => 'The phone number field is required.',
            'company_phone.numeric'  => 'The phone number must be a number.'
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
    public function getVendors($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'id',
            'hospital_id',
            'vendor_code',
            'name',
            'company_name',
            'company_address',
            'company_phone',
            'contact_number',
            'email',
            'bank_name',
            'branch_name',
            'account_number',
            'ifsc_code',
            'country',
            'state',
            'city',
            'zip_code',
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
    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalVendors($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getVendorService()
    {
        $result = $this->active()->pluck('name', 'id')->toArray();
        return ['' => '-Select Vendors -'] + $result;
    }
}
