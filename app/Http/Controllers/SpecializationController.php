<?php

namespace App\Http\Controllers;

use App\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.specialization.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.specialization.create');
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

    $validator = (new Specialization)->validateSpecialization($inputs);
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
        (new Specialization)->store($inputs);
        \DB::commit();

        $route = route('specialization.index');
        return validationResponse(true, 201, lang('messages.created', lang('specialization.specialization')), $route);
    } catch (\Exception $exception) {
        \DB::rollBack();
        return validationResponse(false, 207, lang('messages.server_error'));
    }
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialization $specialization)
    {
     $result= $specialization;
        if(!$result){
            abort(404);
        }
        return view('admin.specialization.edit',compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Specialization $specialization
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Specialization $specialization)
    {
        $result = $specialization;
        if (!$result) {
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('specialization.specialization'))));
        }
        $id = $result->id;

        $inputs = $request->all();

        $validator = (new Specialization)->validateSpecialization($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();

            $inputs = $inputs + [
                    'status' => isset($inputs['status']) ? 1 : 0,
                    'updated_by' => authUserId()
                ];
            (new Specialization)->store($inputs, $id);

            \DB::commit();

            $route = route('specialization.index');
            return validationResponse(true, 201, lang('messages.updated', lang('specialization.specialization')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();

            return validationResponse(false, 207, lang('messages.server_error'));
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


    public function specializationToggle($id = null)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = Specialization::find($id);

        try {
            // get the specialization w.r.t id
            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('specialization.specialization')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param Request $request
     * @param int $pageNumber
     * @return \Response
     */
    public function specializationPaginate(Request $request, $pageNumber = null)
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

            $data = (new Specialization)->getSpecialization($inputs, $start, $perPage);
            $totalSpecialization = (new Specialization)->totalSpecialization($inputs);
            $total = $totalSpecialization->total;
        } else {

            $data = (new Specialization)->getSpecialization($inputs, $start, $perPage);
            $totalSpecialization = (new Specialization)->totalSpecialization($inputs);
            $total = $totalSpecialization->total;
        }

        return view('admin.specialization.load_data', compact('data', 'total', 'page', 'perPage'));
    }
    }

