<?php

namespace App\Http\Controllers;

/**
 * :: Department Controller ::
 * To manage department.
 *
 **/

use Illuminate\Http\Request;
use App\Department;
use App\Floor;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.department.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departmentCode = (new Department)->getDepartmentCode();
        $floorName= (new Floor)->getFloorName();
        return view('admin.department.create', compact('departmentCode', 'floorName'));
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

        $floorId = $inputs['floor_id'];
        unset($inputs['floor_id']);

        $inputs['floor_name'] = $floorId;

        $validator = (new Department)->validateDepartment($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);
            unset($inputs['floor_name']);

            $inputs = $inputs + [
                'floor_id'  => $floorId,
                'created_by' => authUserId(),
                'company_id' => loggedIncompanyId()
            ];
            (new Department)->store($inputs);
            \DB::commit();

            $route = route('department.index');
            return validationResponse(true, 201, lang('messages.created', lang('department.department')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $result = $department;
        if (!$result) {
            abort(404);
        }
        $floorName= (new Floor)->getFloorName();
        return view('admin.department.edit', compact('result', 'floorName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $result = $department;
        if (!$result) {
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('department.department'))));
        }
        $id = $result->id;

        $inputs = $request->all();

        $floorId = $inputs['floor_id'];
        unset($inputs['floor_id']);

        $inputs['floor_name'] = $floorId;

        $validator = (new Department)->validateDepartment($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();
            unset($inputs['floor_name']);

            $inputs = $inputs + [
                'floor_id'  => $floorId,
                'status' => isset($inputs['status']) ? 1 : 0,
                'updated_by' => authUserId()
            ];
            (new Department)->store($inputs, $id);

            \DB::commit();

            $route = route('department.index');
            return validationResponse(true, 201, lang('messages.updated', lang('department.department')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();

            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        return "In Progress";
    }
    /**
     * Used to update department active status.
     *
     * @param int $id
     * @return Response
     */
    public function departmentToggle($id = null)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = Department::find($id);

        try {
            // get the department w.r.t id
            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('department.department')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function departmentPaginate(Request $request, $pageNumber = null)
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

            $data = (new Department)->getDepartments($inputs, $start, $perPage);
            $totalDepartment = (new Department)->totalDepartments($inputs);
            $total = $totalDepartment->total;
        } else {

            $data = (new Department)->getDepartments($inputs, $start, $perPage);
            $totalDepartment = (new Department)->totalDepartments($inputs);
            $total = $totalDepartment->total;
        }

        return view('admin.department.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
