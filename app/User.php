<?php

namespace App;

use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    use SoftDeletes;
    use Notifiable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id',
        //'user_type',
        'doctor_id',
        'patient_id',
        'staff_id',

        'role_id',
        'name',
        'username',
        'email',
        'password',
        'is_super_admin',
        'is_admin',
        //'is_default',

        'status',
        'remember_token',

        'otp',
        'forgot_otp',
        'last_login',
        'login_attempts',
        'is_reset_password',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_login'];

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
     * @param $query
     * @return mixed
     */
    public function scopeHospital($query)
    {
        if(!isSuperAdmin()) {
            return $query->where('users.hospital_id', loggedInHospitalId());
        }
    }
    /**
     * @param $inputs
     * @return \Illuminate\Validation\Validator
     */
    public function validatePassword($inputs)
    {
        $rules['password']          = 'required';
        $rules['new_password']      = 'required|same:confirm_password';
        $rules['confirm_password']  = 'required';
        return \Validator::make($inputs, $rules);
    }

    /**
     * @param $password
     * @return mixed
     */
    public function updatePassword($password, $isResetPassword)
    {
        return $this->where('id', authUserId())->update([
            'password' => $password,
            'is_reset_password' => $isResetPassword
        ]);
    }

    /**
     * @return mixed
     */
    public function updateLastLogin()
    {
        $loginTiming = [
            'last_login'        => new \DateTime,
            'login_attempts'    => 0,
        ];
        return $this->find(authUserId())->update($loginTiming);
    }

    /**
     * @param string $username
     *
     * @return mixed
     */
    public function updateFailedAttempts($username)
    {
        $user = $this->where('id', '!=', 1)
            ->where(function($query) use ($username) {
                $query->where('username', $username)
                    ->orWhere('email', $username);
            })->first();
        if ($user) {
            $user->increment('login_attempts', 1);
        }
    }

    /**
     * @param array $inputs
     * @param null $id
     * @param null $isSuperAdmin
     * @param null $isAdmin
     * @return \Illuminate\Validation\Validator
     */
    public function validateUser($inputs, $id = null, $isSuperAdmin = null, $isAdmin = null)
    {
        $inputs = array_filter($inputs);
        $message = [];
        $rules = [
            'name'        => 'required',
            'role'        => 'required',
            'status'      => 'required|in:0,1',
        ];

        if ($id) {
            $rules += [
                'username'  => 'required|unique:users,username,' . $id . ',id,deleted_at,NULL',
                'email'     => 'required|unique:users,email,' . $id . ',id,deleted_at,NULL',
            ];
        } else {
            $rules += [
                'username'  => 'required|unique:users,username,NULL,id,deleted_at,NULL',
                'email'     => 'required|unique:users,email,NULL,id,deleted_at,NULL',
                'password'  => 'required|min:5',
            ];
        }
        $rules['hospital_id']    = 'required|numeric';
        $message += [ 'hospital_id.required' => lang('common.hospital_required'), 'hospital_id.numeric' => lang('common.hospital_numeric')];

        return \Validator::make($inputs, $rules, $message);
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
     * Method is used to search results.
     *
     * @param array $search
     * @param int $skip
     * @param int $perPage
     *
     * @return mixed
     */
    public function getUsers($search = null, $skip, $perPage)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'users.id',
            'username',
            'users.name',
            'role.name as role',
            'users.status',
            \DB::raw("concat(hospital_name, '(', hospital_code, ')') as hospital_name"),
        ];

        if (is_array($search) && count($search) > 0) {
            $name = (array_key_exists('keyword', $search)) ? " AND username LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $name;
        }
        $f1 = " AND users.hospital_id != 0";
        if(!isSuperAdmin()) {
            $f1 .= " AND users.hospital_id = ".loggedInHospitalId();
        }

        $filter .= $f1;

        return $this->leftJoin('role', 'role.id', '=', 'users.role_id')
            ->leftJoin('hospital', 'hospital.id', '=', 'users.hospital_id')
            ->whereRaw($filter)
//            ->where('is_super_admin', 0)
            ->whereNotNull('users.hospital_id')
            ->orderBy('users.id', 'ASC')->skip($skip)->take($take)->get($fields);
    }

    /**
     * Method is used to get total results.
     *
     * @param array $search
     *
     * @return mixed
     */
    public function totalUser($search = null)
    {
        $filter = 1; // default filter if no search

        // when search
        if (is_array($search) && count($search) > 0) {
            $partyName = (array_key_exists('keyword', $search)) ? " AND username LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' " : "";
            $filter .= $partyName;
        }
        return $this->select(\DB::raw('count(*) as total'))->whereRaw($filter)->get()->first();
    }

    /**
     * @return mixed
     */
    public function getLastLoginLog()
    {
        return $this->where('user.id', '>', 1)->take(20)->get(['username', 'last_login', 'name']);
    }

    /**
     * @return mixed
     */
    public function getUsersService()
    {
        $result = $this->active()->where('id', '>', 1)->pluck('name', 'id')->toArray();
        return ['' => '-Select Users-'] + $result;
    }
}
