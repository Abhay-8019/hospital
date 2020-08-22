<?php

namespace App\Http\Controllers;

use App\UserPermissions;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Hospital;
use App\Menu;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role    = (new Role)->getRoleService();
        $hospital = (new Hospital)->getHospitalService();
        $tree    = (new Menu)->getMenuNavigation(null, null, isSuperAdmin());
        return view('admin.user.create', compact('role', 'hospital','tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('section');
        $data = $request->all();

        $isSuperAdmin = (!empty($data['role']) && $data['role'] == 1)? true : false;
        $isAdmin      = (!empty($data['role']) && $data['role'] == 2)? true : false;

        $data['hospital_id'] = (isset($data['hospital_id']) && $data['hospital_id'] != '')? $data['hospital_id'] : loggedInHospitalId();

        $validator = (new User)->validateUser($data, null, $isSuperAdmin, $isAdmin);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            $password = $inputs['password'];
            $role = $inputs['role'];
            unset($inputs['password']);
            unset($inputs['role']);
            unset($inputs['hospital_id']);

            \DB::beginTransaction();
                $inputs = $inputs + [
                    'hospital_id'    => $data['hospital_id'],
                    'role_id'       => $role,
                    'password'      => \Hash::make($password),
                    'is_super_admin' => ($isSuperAdmin)? 1 : 0,
                    'is_admin' => ($isAdmin)? 1 : 0,
                    'created_by'    => authUserId()
                ];

                (new User)->store($inputs);
            \DB::commit();
            return validationResponse(true, 201, lang('messages.created', lang('user.user')), route('user.index'));
        } catch (\Exception $e) {
            \DB::rollBack();
            return validationResponse(false, 207, $e->getMessage().' '.lang('messages.server_error'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('user.index')
                ->with('error', lang('messages.invalid_id', string_manip(lang('user.user'))));
        }
        if($user->is_super_admin == 1 && $user->is_default == 1 || !isSuperAdmin() && $user->hospital_id != loggedInHospitalId()) {
            return redirect()->route('user.index')
                ->with('error', lang('messages.permission_denied'));
        }
        $isSuperAdmin = (!empty($user->role_id) && $user->role_id == 1 && $user->is_super_admin == 1)? true : false;
        $isAdmin      = (!empty($user->role_id) && $user->role_id == 2 && $user->is_admin == 1)? true : false;

        $role = (new Role)->getRoleService();


        $hospital = (new Hospital)->getHospitalService();
        $hospitalId = $user->hospital_id;

        return view('admin.user.edit', compact('user', 'role', 'isAdmin', 'isSuperAdmin', 'hospital', 'hospitalId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = (new User)->hospital()->find($id);
        if (!$user) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('user.user'))));
        }

        if ($user->id == 1) {
            if ($user->id != authUserId()) {
                return validationResponse(false, 207, lang('messages.permission_denied'));
            }
        }

        $inputs = $request->except('hospital');
        $data = $request->all();

        $isSuperAdmin = (!empty($data['role']) && $data['role'] == 1)? true : false;
        $isAdmin      = (!empty($data['role']) && $data['role'] == 2)? true : false;

        $data['hospital_id'] = (isset($data['hospital_id']) && $data['hospital_id'] != '')? $data['hospital_id'] : loggedInHospitalId();

        $validator = (new User)->validateUser($data, $id, $isSuperAdmin, $isAdmin);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();
                $password = $inputs['password'];
                unset($inputs['password']);
                $role = $inputs['role'];
                unset($inputs['role']);

                $inputs = $inputs + [
                    'role_id'       => $role,
                    'is_super_admin' => ($isSuperAdmin)? 1 : 0,
                    'is_admin' => ($isAdmin)? 1 : 0,
                    'updated_by'    => authUserId()
                ];
                if (trim($password) != "") {
                    $inputs['password'] = \Hash::make($password);
                }

                (new User)->store($inputs, $id);


            \DB::commit();
            return validationResponse(true, 201, lang('messages.updated', lang('user.user')), route('user.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "In Progress";
    }
    /**
     * Used to update User active status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return string
     */
    public function userToggle($id)
    {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }
        $user = User::find($id);
        if (!$user) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('user.user'))));
        }

        try {
            //$id = $user->id;
            // get the User w.r.t id

            $user->update(['status' => !$user->status]);
            $response = ['status' => 1, 'data' => (int)$user->status . '.gif'];
            // return json response
            return json_encode($response);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('user.user')));
        }
    }
    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     * @return mixed
     */
    public function userPaginate(Request $request, $pageNumber = null)
    {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        $inputs = $request->all();
        $page = 1;
        if (isset($inputs['page']) && (int)$inputs['page'] > 0) {
            $page = $inputs['page'];
        }

        $perPage = 20;
        if (isset($inputs['perpage']) && (int)$inputs['perpage'] > 0) {
            $perPage = $inputs['perpage'];
        }

        $start = ($page - 1) * $perPage;
        $filter = '';

        if (isset($inputs['form-search']) && $inputs['form-search'] != '') {
            $inputs = array_filter($inputs);
            unset($inputs['_token']);

            $data      = (new User)->getUsers($inputs, $start, $perPage);
            $totalUser = (new User)->totalUser($inputs);
            $total     = $totalUser->total;
        } else {
            $data      = (new User)->getUsers($filter, $start, $perPage);
            $totalUser = (new User)->totalUser();
            $total     = $totalUser->total;
        }
        return view('admin.user.load_data', compact('data', 'total', 'page', 'perPage'));
    }

    /**
     * Method is used to update status of user enable/disable
     *
     * @return Response
     */
    public function userAction(Request $request)
    {
        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('user.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('user.user'))));
        }

        $ids = '';
        foreach ($inputs['tick'] as $key => $value) {
            $ids .= $value . ',';
        }
        $ids = rtrim($ids, ',');
        $status = 0;
        if (isset($inputs['active'])) {
            $status = '1';
        }
        User::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('user.index')
            ->with('success', lang('messages.updated', lang('user.user_status')));
    }
}
