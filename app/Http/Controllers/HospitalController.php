<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\State;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.hospital.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospitalCode = (new Hospital)->getHospitalCode();
        $state = (new State)->getStateService();
        return view('admin.hospital.create',compact('hospitalCode', 'state'));
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
        $validator = (new Hospital)->validateHospital($inputs);
        if($validator->fails()){
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try{
            \DB::beginTransaction();
            unset($inputs['_token']);

            $state = $inputs['state'];
            unset($inputs['state']);

            $inputs = $inputs + [
                'state_id' => $state,
                'created_by' => authUserId(),
                'hospital_id' => loggedInHospitalId()
            ];
            $hospitalId = (new Hospital)->store($inputs);
            if ($request->hasFile('image') && $hospitalId > 0)
            {
                $imageName = fileUploader('image', $hospitalId);
                $update = ['hospital_logo'  => $imageName];
                (new Hospital)->store($update, $hospitalId);
            }
            \DB::commit();
            $route = route('hospital.index');
            return validationResponse(true, 201, lang('messages.created', lang('hospital.hospital')), $route);
        } catch(\Exception $exception){
            \DB:: Rollback();
            return validationResponse(false, 207, $exception->getMessage() . $exception->getFile() . $exception->getLine() . lang('messages.server_error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit(Hospital $hospital)
    {
        $result = $hospital;
        if(!$result){
            abort(404);
        }
        $state = (new State)->getStateService();
        return view('admin.hospital.edit', compact('result', 'state'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = Hospital :: Find($id);
        if(!$result){
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('hospital.hospital'))));
        }

        $inputs = $request->except('image');

        $validator = (new Hospital)-> validateHospital($inputs, $id);
        if($validator->fails()){
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try{
            \DB::beginTransaction();

            $prevImage = $result->image;
            $state = $inputs['state'];
            unset($inputs['state']);

            $inputs =$inputs + [
                'state_id' => $state,
                'status' => isset($inputs['status']) ? 1 : 0,
                'updated_by' => authUserId()
            ];
            $id=(new Hospital)->store($inputs, $id);
            if($request->hasFile('image') && $id > 0)
            {
                $imageName = fileUploader('image', $id);
                $update = ['hospital_logo'  => $imageName];
                (new Hospital)->store($update, $id);
                $fileExist = file_exists(ROOT . \Config::get('constants.UPLOADS') . $prevImage);
                if($prevImage && $fileExist) {
                    unlink(ROOT . \Config::get('constants.UPLOADS') . $prevImage);
                }
            }
            \DB::commit();
            $route = route('hospital.index');
            return validationResponse(true, 201, lang('messages.updated', lang('hospital.hospital')), $route);
        }catch(\Exception $exception){
            \DB::rollBack();
            return validationResponse(false, 207, lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        return "In Progress";
    }

    /**
     * @param Request $request
     * @param null $pageNumber
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|String
     */
    public function hospitalPaginate(Request $request, $pageNumber = null)
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
        if (isset($inputs['form-search']) && $inputs['form-search'] != '') {
            $inputs = array_filter($inputs);
            unset($inputs['_token']);

            $data = (new Hospital)->getHospital($inputs, $start, $perPage);
            $totalHospital = (new Hospital)->totalHospital($inputs);
            $total = $totalHospital->total;
        } else {

            $data = (new Hospital)->getHospital($inputs, $start, $perPage);
            $totalHospital = (new Hospital)->totalHospital($inputs);
            $total = $totalHospital->total;
        }

        return view('admin.hospital.load_data', compact('data', 'total', 'page', 'perPage'));
    }

    /**
     * @param null $id
     * @return string
     */
    public function hospitalToggle($id = null)
    {
        if(!\Request::ajax()){
            return lang('messages.server_error');
        }
        $result = Hospital::find($id);
        try{

            $result->update(['status'=>!$result->status]);
            $response=['status'=>1, 'data'=>(int)$result->status . '.gif'];
            return json_encode($response);
        }catch(\Exception $exception){
            return lang('messages.invalid_id', string_manip(lang('hospital.hospital')));
        }
    }
}
