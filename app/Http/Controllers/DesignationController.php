<?php

namespace App\Http\Controllers;

/**
 * :: Designation Controller ::
 * To manage Designation.
 *
 **/

use Illuminate\Http\Request;
use App\Designation;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.designation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.designation.create');
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
        $validator = (new Designation)->validateDesignation($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $inputs = $inputs + [
                'created_by' => authUserId(),
                'company_id' => loggedIncompanyId()
            ];
            (new Designation)->store($inputs);
            \DB::commit();

            $route = route('designation.index');
            return validationResponse(true, 201, lang('messages.created', lang('designation.designation')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        $result = $designation;
        if (!$result) {
            abort(404);
        }

        return view('admin.designation.edit', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {
        $result = $designation;
        if (!$result) {
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('designation.designation'))));
        }
        $id = $result->id;

        $inputs = $request->all();
        $validator = (new Designation)->validateDesignation($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();

            $inputs = $inputs + [
                    'status' => isset($inputs['status']) ? 1 : 0,
                    'updated_by' => authUserId()
                ];
            (new Designation)->store($inputs, $id);

            \DB::commit();

            $route = route('designation.index');
            return validationResponse(true, 201, lang('messages.updated', lang('designation.designation')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();

            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        return "In Progress";
    }
    /**
     * Used to update designation active status.
     *
     * @param int $id
     * @return Response
     */
    public function designationToggle($id = null)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = Designation::find($id);

        try {
            // get the designation w.r.t id
            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('designation.designation')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function designationPaginate(Request $request, $pageNumber = null)
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

            $data = (new Designation)->getDesignation($inputs, $start, $perPage);
            $totalDesignation = (new Designation)->totalDesignation($inputs);
            $total = $totalDesignation->total;
        } else {

            $data = (new Designation)->getDesignation($inputs, $start, $perPage);
            $totalDesignation = (new Designation)->totalDesignation($inputs);
            $total = $totalDesignation->total;
        }

        return view('admin.designation.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
