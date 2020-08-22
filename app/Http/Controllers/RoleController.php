<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Menu;
use App\RolePermissions;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tree = [];//(new Menu)->getMenuNavigation(null, null, isSuperAdmin());
        return view('admin.role.create', compact('tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = (new Role)->validateRole($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $inputs = $inputs + [
                'created_by' => authUserId(),
                'hospital_id' => loggedInHospitalId()
            ];
            (new Role)->store($inputs);

            /*if(isSuperAdmin() || isAdmin())
            {
                $menuId = null;
                if (isset($inputs['section']) && is_array($inputs['section']) &&
                    count($inputs['section']) > 0)
                {
                    $sections = $inputs['section'];
                    $sectionsData = implode(',',$sections);
                    $sectionExplode = explode(',',$sectionsData);
                    $uniqueValues = array_unique($sectionExplode);
                    $menuId = implode(',', $uniqueValues);
                }

                $section = [
                    'role_id' => $roleId,
                    'menu_id' => (isset($uniqueValues) && count($uniqueValues) > 0) ? $menuId : null,
                    'created_by' => authUserId(),
                    'created_at' => convertToUtc()
                ];
                (new RolePermissions)->store($section);
            }*/
            \DB::commit();
            return validationResponse(true, 201, lang('messages.created', lang('role.role')), route('role.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, lang('messages.server_error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (!$role) {
            abort(404);
        }
        if(!isSuperAdmin() && $role->hospital_id != loggedInHospitalId()) {
            abort(401);
        }

        if ($role->isdefault == 1)
        {
            return redirect()->route('role.index')
                ->with('error', lang('messages.isdefault', string_manip(lang('role.role'))));
        }

        $tree = [];//(new Menu)->getMenuNavigation(null, null, isSuperAdmin());
        $userPermissions = [];//(new RolePermissions)->getRolePermissions(['role_id'=> $role->id], true);
        $detail = [];
        if (count($userPermissions) > 0) {
            if ($userPermissions->menu_id != "") {
                $detail = explode(',', $userPermissions->menu_id);
            }
        }
        return view('admin.role.edit', compact('role', 'tree', 'userPermissions', 'detail'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPermission($id)
    {
        $role = Role::find($id);

        if (!$role) {
            abort(404);
        }
        if(!isSuperAdmin() && $role->hospital_id != loggedInHospitalId()) {
            abort(401);
        }
        
        if($role->isdefault) {
            return redirect()->route('role.index')
                ->with('error', lang('messages.isdefault', string_manip(lang('role.role'))));
        }

        $tree = [];//(new Menu)->getMenuNavigation(null, null, isSuperAdmin());

        $userPermissions = [];//(new RolePermissions)->getRolePermissions(['role_id'=> $role->id], true);

        $detail = [];
        if (count($userPermissions) > 0) {
            if ($userPermissions->menu_id != "") {
                $detail = explode(',', $userPermissions->menu_id);
            }
        }
//        dd($role);
        return view('admin.role.edit_permission', compact('role', 'tree', 'userPermissions', 'detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role = $role;
        if (!$role) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('role.role'))));
        }

        $id = $role->id;

        $inputs = $request->all();
        $validator = (new Role)->validateRole($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();
                $inputs = $inputs + [
                    'updated_by' => authUserId()
                ];
                (new Role)->store($inputs, $id);

            if(isSuperAdmin() || isAdmin()) {
                $menuId = null;
                if (isset($inputs['section']) && is_array($inputs['section']) && count($inputs['section']) > 0) {
                    $sections = $inputs['section'];
                    $sectionsData = implode(',', $sections);
                    $sectionExplode = explode(',', $sectionsData);
                    $uniqueValues = array_unique($sectionExplode);
                    $menuId = implode(',', $uniqueValues);
                }
                $section = [
                    'role_id' => $id,
                    'menu_id' => (isset($uniqueValues) && count($uniqueValues) > 0) ? $menuId : null,
                    'created_by' => authUserId(),
                    'created_at' => convertToUtc()
                ];

                (new RolePermissions)->store($section, $inputs['permission_id']);
            }

            \DB::commit();
            return validationResponse(true, 201, lang('messages.updated', lang('role.role')), route('role.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePermission(Request $request, $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('role.role'))));
        }
        $inputs = $request->all();
        $validator = (new Role)->validateRole($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            if(isSuperAdmin() || isAdmin()) {
                $menuId = null;
                if (isset($inputs['section']) && is_array($inputs['section']) && count($inputs['section']) > 0) {
                    $sections = $inputs['section'];
                    $sectionsData = implode(',', $sections);
                    $sectionExplode = explode(',', $sectionsData);
                    $uniqueValues = array_unique($sectionExplode);
                    $menuId = implode(',', $uniqueValues);
                }
                $section = [
                    'role_id' => $id,
                    'menu_id' => (isset($uniqueValues) && count($uniqueValues) > 0) ? $menuId : null,
                    'created_by' => authUserId(),
                    'created_at' => convertToUtc()
                ];

                (new RolePermissions)->store($section, $inputs['permission_id']);
            }

            \DB::commit();
            return validationResponse(true, 201, lang('messages.updated', lang('role.permission')), route('role.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        return "In Progress";
    }
    /**
     * Used to update role active status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role $role
     * @return Response
     */
    public function roleToggle(Role $role)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $role = $role;
        if (!$role) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('role.role'))));
        }

        try {
            // get the role w.r.t id

            $role->update(['status' => !$role->status]);
            $response = ['status' => 1, 'data' => (int)$role->status . '.gif'];
            // return json response
            return json_encode($response);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('role.role')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function rolePaginate(Request $request, $pageNumber = null)
    {
        if (!\Request::isMethod('post') && !\Request::ajax()) { //
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
        if (isset($inputs['form-search']) && $inputs['form-search'] != '') {
            $inputs = array_filter($inputs);
            unset($inputs['_token']);

            $data = (new Role)->getRoles($inputs, $start, $perPage);
            $totalRole = (new Role)->totalRoles($inputs);
            $total = $totalRole->total;
        } else {

            $data = (new Role)->getRoles($inputs, $start, $perPage);
            $totalRole = (new Role)->totalRoles($inputs);
            $total = $totalRole->total;
        }
        return view('admin.role.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
