<?php

namespace App\Http\Controllers;

use App\EmployeeType;
use Illuminate\Http\Request;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.employee_type.create');
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
        // dd($inputs);

        $validator = (new EmployeeType)->validateEmployeeType($inputs);
        if($validator->fails()){
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try{
        \DB::beginTransaction();
            unset($inputs['_token']);

            $inputs += [
                'created_by' => authUserId(),
                'hospital_id' => loggedInHospitalId()
            ];

            (new EmployeeType) -> store($inputs);
            \DB::commit();
            $route = route('employee-type.index');
            return validationResponse(true, 201, lang('messages.created', lang('employee_type.employee')), $route);
        }catch(\Exception $exception){
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeType $employeeType)
    {
        $result = $employeeType;
        if(!$result){
            abort(404);
        }
        return view('admin.employee_type.edit', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeType $employeeType)
    {
        $result = $employeeType;
        if (!$result) {
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('employee_type.employee'))));
        }
        $id = $result->id;

        $inputs = $request->all();

        $validator = (new EmployeeType) -> validateEmployeeType($inputs, $id);
        if($validator->fails()){
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try{
            \DB::beginTransaction();
            unset($inputs['_token']);

            $inputs=$inputs + [
                    'status'=> isset($inputs['status'])? 1 : 0,
                    'updated_by' => authUserId()
                ];
            (new EmployeeType) -> store($inputs, $id);
            \DB::commit();
            $route =route('employee-type.index');
            return validationResponse(true, 201, lang('messages.updated', lang('employee_type.employee')), $route);
        }catch(\Exception $exception){
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

    public function employeeTypeToggle($id = null){
        if(!\Request::ajax()){
            return lang('messages.server_error');
        }
        $result = EmployeeType::find($id);
        try{

            $result->update(['status'=>!$result->status]);
            $response=['status'=>1, 'data'=>(int)$result->status . '.gif'];
            return json_encode($response);
        }catch(Exception $exception){
            return lang('messages.invalid_id',string_manip(lang('employee_type.employee')));
        }
    }

    public function employeeTypePaginate(Request $request, $pageNumber = null)
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

            $data = (new EmployeeType)->getEmployeeType($inputs, $start, $perPage);
            $totalEmployeeType = (new EmployeeType)->totalEmployeeType($inputs);
            $total = $totalEmployeeType->total;
        } else {

            $data = (new EmployeeType)->getEmployeeType($inputs, $start, $perPage);
            $totalEmployeeType = (new EmployeeType)->totalEmployeeType($inputs);
            $total = $totalEmployeeType->total;
        }

        return view('admin.employee_type.load_data', compact('data', 'total', 'page', 'perPage'));
    }

}
