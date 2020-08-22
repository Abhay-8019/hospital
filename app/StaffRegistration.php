<?php

namespace App;

/**
 * :: Staff Registration Model ::
 * To manage Staff Registration CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffRegistration extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'staff_registrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Personal Details..............
        'hospital_id',
        'role_id',
        'user_id',
        'department_id',
        'designation_id',
        'image',
        'register_number',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'blood_group',
        'address',
        //............................
        //Contact Details..............
        'email',
        'contact_number',
        //.............................
        //Department Details..............
        'do_joining',
        'do_relieving',
        'do_retirement',
        //................................
        //Emergency Contact Details............
        'e_name',
        'e_contact_number',
        'relationship',
        //........................
        //REFERANCE Details.......
        'reference_person',
        'reference_contact',
        //.........................
        //Previous Qualification Details.......
        'q_name',
        'q_address',
        'qualification',
        //...........................
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
    public function scopeStaffHospital($query)
    {
        return (!isSuperAdmin())?
            $query->where('staff_registrations.hospital_id', loggedInHospitalId()) : null;
    }
    /**
     * Method is used to validate roles
     *
     * @param $inputs
     * @param int $id
     * @return Response
     */
    public function validateStaff($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        // validation rule
        if ($id) {
            $rules['first_name']      = 'required|unique:staff_registrations,first_name,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['register_number'] = 'required|unique:staff_registrations,register_number,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['email']           = 'required|email|unique:staff_registrations,email,' . $id .',id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
        } else {
            $rules['first_name']      = 'required|unique:staff_registrations,first_name,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['register_number'] = 'required|unique:staff_registrations,register_number,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['email']           = 'required|email|unique:staff_registrations,email,NULL,id,deleted_at,NULL,hospital_id,'.loggedInHospitalId();
            $rules['status']          = 'required';
        }
        if (isset($inputs['image']) && $inputs['image'] != ''){
            $rules['image'] = 'image|mimes:jpeg,jpg,png|max:1000';
        }

        $rules += [
            'dob'                 => 'required|date|before:18 years ago',
            'address'             => 'required',
            'role'                => 'required',
            'department'          => 'required',
            'designation'         => 'required',
            'do_joining'          => 'required|date',
            'do_retirement'       => 'date',
            'mobile'              => 'required|numeric|min:10',
            'e_name'              => 'required',
            'e_contact_number'    => 'required|numeric|min:10',
            'relationship'        => 'required',
            'reference_contact'   => 'min:10|numeric',
        ];

        $messages  =  [
            'dob.required'                  => 'The date of birth field is required.',
            'dob.date'                      => 'The date of birth is not a valid date.',
            'dob.before'                    => 'The date of birth must be a date before 18 years ago.',
            'do_joining.required'           => 'The date of joining field is required.',
            'do_joining.date'               => 'The date of joining is not a valid date.',
            'do_retirement.date'            => 'The date of retirement is not a valid date.',
            'e_name.required'               => 'The emergency name field is required.',
            'e_contact_number.required'     => 'The emergency contact number field is required.',
            'e_contact_number.numeric'      => 'The emergency contact number must be a number.',
        ];

        return \Validator::make($inputs, $rules, $messages);
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

    /**\
     * @param null $code
     * @return mixed|string
     */
    public function getRegistrationNumber($code = null)
    {
        $result =  $this->staffHospital()->where('register_number', $code)->first();
        if ($result) {
            $data =  $this->staffHospital()->orderBy('id', 'desc')->take(1)->first(['register_number']);
        } else {
            $data =  $this->staffHospital()->orderBy('id', 'desc')->take(1)->first(['register_number']);
        }

        if (count($data) == 0) {
            $number = 'ST-01';
        } else {
            $number = number_inc($data->register_number); // new register_number increment by 1
        }
        return $number;
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
    public function getStaff($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        // default filter if no search
        $filter = 1;

        $fields = [
            'staff_registrations.id',
            'staff_registrations.hospital_id',
            'staff_registrations.role_id',
            'staff_registrations.user_id',
            'staff_registrations.department_id',
            'staff_registrations.designation_id',
            'staff_registrations.image',
            'staff_registrations.register_number',
            'staff_registrations.first_name',
            'staff_registrations.last_name',
            'staff_registrations.gender',
            'staff_registrations.dob',
            'staff_registrations.blood_group',
            'staff_registrations.email',
            'staff_registrations.contact_number',
            'staff_registrations.do_joining',
            'staff_registrations.do_retirement',
            'staff_registrations.status',
            'department.name as department_name',
            'department.code as department_code',
            'designations.designation_name',
        ];

        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND first_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->leftJoin('department', 'department.id', '=', 'staff_registrations.department_id')
            ->leftJoin('designations', 'designations.id', '=', 'staff_registrations.designation_id')
            ->whereRaw($filter)
            ->where('staff_registrations.hospital_id', loggedInHospitalId())
            ->orderBy('id', 'ASC')->skip($skip)->take($take)->get($fields);
    }
    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalStaff($search = null)
    {
        $filter = 1; // if no search add where

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('name', $search)) ? " AND first_name LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)->first();
    }

    /**
     * @return mixed
     */
    public function getStaffService()
    {
        $result = $this->active()
            ->staffHospital()
            ->pluck('first_name', 'id')->toArray();
        return ['' => '-Select Staff-'] + $result;
    }
}
