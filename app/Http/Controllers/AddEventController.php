<?php

namespace App\Http\Controllers;

use App\Department;
use App\EventType;
use Illuminate\Http\Request;
use App\AddEvent;

class AddEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.add_events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eventCode         = (new AddEvent)->getEventCode();
        $departmentService = (new Department)->getDepartmentService();
        $eventTypeService  = (new EventType)->getEventTypeService();
        $eventFor          = lang('common.event_for');
        return view('admin.add_events.create', compact('eventCode', 'departmentService', 'eventTypeService', 'eventFor'));
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

        $validator = (new AddEvent)->validateEvent($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        if ((isset($inputs['is_holiday']) && $inputs['is_holiday'] != '') && $inputs['event_type'] != '') {
            $message = lang('common.you_cant_fill_both', lang('common.please_choose_one', 'Is holiday and Event type field'));
            return validationResponse(false, 207, $message);
        }else if(!isset($inputs['is_holiday']) && $inputs['event_type'] == '') {
            $message = lang('common.please_choose_one', 'Is holiday and Event type field');
            return validationResponse(false, 207, $message);
        }

        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $inputs['event_start'] = ($inputs['event_start']!= '')?
                convertToUtc($inputs['event_start'], 'Y-m-d H:i:s') : null;

            $inputs['event_end'] = ($inputs['event_end']!= '')?
                convertToUtc($inputs['event_end'], 'Y-m-d H:i:s') : null;

            $inputs['department_id'] = null;
            if(isset($inputs['department']) && is_array($inputs['department']) && count($inputs['department']) > 0) {
                $inputs['department_id'] = implode(',', $inputs['department']);
            }
            unset($inputs['department']);


            $inputs['event_type_id'] = ($inputs['event_type']!= '')? $inputs['event_type'] : null;
            unset($inputs['event_type']);

            $inputs = $inputs + [
                'created_by'  => authUserId(),
                'hospital_id' => loggedIncompanyId()
            ];
            (new AddEvent)->store($inputs);

            \DB::commit();
            return validationResponse(true, 201, lang('messages.created', lang('event.add_events')), route('add_events.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AddEvent  $addEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(AddEvent $addEvent)
    {
        $result = $addEvent;
        if (!$result) {
            abort(404);
        }
        if(!isSuperAdmin() && $result->hospital_id != loggedIncompanyId()) {
            abort(401);
        }

        $departmentService = (new Department)->getDepartmentService();
        $eventTypeService  = (new EventType)->getEventTypeService();
        $eventFor          = lang('common.event_for');

        $departmentIds = ($result->department_id != '')? array_map('intval', explode(',', $result->department_id)): $result->department_id;

        return view('admin.add_events.edit', compact('result', 'departmentService', 'eventTypeService', 'eventFor', 'departmentIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AddEvent  $addEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddEvent $addEvent)
    {
        $result = $addEvent;
        if (!$result) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('event.add_events'))));
        }
        $id = $result->id;
        $inputs = $request->all();

        $validator = (new AddEvent)->validateEvent($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        if ((isset($inputs['is_holiday']) && $inputs['is_holiday'] != '') && $inputs['event_type'] != '') {
            $message = lang('common.you_cant_fill_both', lang('common.please_choose_one', 'Is holiday and Event type field'));
            return validationResponse(false, 207, $message);
        }else if(!isset($inputs['is_holiday']) && $inputs['event_type'] == '') {
            $message = lang('common.please_choose_one', 'Is holiday and Event type field');
            return validationResponse(false, 207, $message);
        }

        try {
            \DB::beginTransaction();

            $inputs['event_start'] = ($inputs['event_start']!= '')?
                convertToUtc($inputs['event_start'], 'Y-m-d H:i:s') : null;

            $inputs['event_end'] = ($inputs['event_end']!= '')?
                convertToUtc($inputs['event_end'], 'Y-m-d H:i:s') : null;

            $inputs['department_id'] = null;
            if(isset($inputs['department']) && is_array($inputs['department']) && count($inputs['department']) > 0) {
                $inputs['department_id'] = implode(',', $inputs['department']);
            }
            unset($inputs['department']);


            $inputs['event_type_id'] = ($inputs['event_type']!= '')? $inputs['event_type'] : null;
            unset($inputs['event_type']);

            $inputs = $inputs + [
                'updated_by' => authUserId()
            ];
            (new AddEvent)->store($inputs, $id);

            \DB::commit();
            return validationResponse(true, 201, lang('messages.updated', lang('event.add_events')), route('add_events.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AddEvent  $addEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddEvent $addEvent)
    {
        return "In Progress";
    }

    /**
     * Used to update role active status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AddEvent $addEvent
     * @return Response
     */
    public function eventToggle($id)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = AddEvent::find($id);
        if (!$result) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('event.add_events'))));
        }

        try {
            // get the role w.r.t id

            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('event.add_events')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function eventPaginate(Request $request, $pageNumber = null)
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

            $data = (new AddEvent)->getEvents($inputs, $start, $perPage);
            $totalRole = (new AddEvent)->totalEvents($inputs);
            $total = $totalRole->total;
        } else {

            $data = (new AddEvent)->getEvents($inputs, $start, $perPage);
            $totalRole = (new AddEvent)->totalEvents($inputs);
            $total = $totalRole->total;
        }
        return view('admin.add_events.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
