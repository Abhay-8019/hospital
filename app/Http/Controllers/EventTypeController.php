<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventType;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.event_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event_type.create');
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

        $validator = (new EventType)->validateEventType($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $inputs = $inputs + [
                'created_by'  => authUserId(),
                'hospital_id' => loggedInHospitalId()
            ];
            (new EventType)->store($inputs);

            \DB::commit();
            return validationResponse(true, 201, lang('messages.created', lang('event_type.event_type')), route('event_type.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function edit(EventType $eventType)
    {
        $result = $eventType;
        if (!$result) {
            abort(404);
        }
        if(!isSuperAdmin() && $result->hospital_id != loggedInHospitalId()) {
            abort(401);
        }
        return view('admin.event_type.edit', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventType $eventType)
    {
        $result = $eventType;
        if (!$result) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('event_type.event_type'))));
        }
        $id = $result->id;
        $inputs = $request->all();

        $validator = (new EventType)->validateEventType($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();

            $inputs = $inputs + [
                'updated_by' => authUserId()
            ];
            (new EventType)->store($inputs, $id);

            \DB::commit();
            return validationResponse(true, 201, lang('messages.updated', lang('event_type.event_type')), route('event_type.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventType $eventType)
    {
        return "In Progress";
    }
    /**
     * Used to update role active status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventType $eventType
     * @return Response
     */
    public function eventTypeToggle($id)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = EventType::find($id);
        if (!$result) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('event_type.event_type'))));
        }

        try {
            // get the role w.r.t id

            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('event_type.event_type')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function eventTypePaginate(Request $request, $pageNumber = null)
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

            $data = (new EventType)->getEventType($inputs, $start, $perPage);
            $totalRole = (new EventType)->totalEventType($inputs);
            $total = $totalRole->total;
        } else {

            $data = (new EventType)->getEventType($inputs, $start, $perPage);
            $totalRole = (new EventType)->totalEventType($inputs);
            $total = $totalRole->total;
        }
        return view('admin.event_type.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
