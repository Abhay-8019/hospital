<?php

namespace App\Http\Controllers;

use App\RoomCost;
use App\Rooms;
use Illuminate\Http\Request;
use App\Floor;
use App\Building;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floorCode = (new Floor)->getFloorCode();
        $buildingName = (new Building)->getBuildingService();
        return view('admin.floor.index',compact('buildingName','floorCode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $floorCode = (new Floor)->getFloorCode();
        $buildingName = (new Building)->getBuildingService();
        return view('admin.floor.create',compact('buildingName','floorCode'));
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

        $buildingId = $inputs['building_id'];
        unset($inputs['building_id']);

        $inputs['building_name'] = $buildingId;

        $validator = (new Floor)->validateFloor($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);
            unset($inputs['building_name']);

            $inputs = $inputs + [
                'building_id'  => $buildingId,
                'created_by' => authUserId(),
                'hospital_id' => loggedInHospitalId()
            ];

            (new Floor)->store($inputs);
            \DB::commit();

            $route = route('floor.index');
            return validationResponse(true, 201, lang('messages.created', lang('floor.floor')), $route);
        } catch (\Exception $exception) {
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
    public function edit(Floor $floor)
    {
        $result = $floor;
        if (!$result) {
            abort(404);
        }
        $buildingName = (new Building)->getBuildingService();
        return view('admin.floor.edit', compact('result','buildingName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Floor $floor)
    {
        $result = $floor;
        if (!$result) {
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('floor.floor'))));
        }
        $id = $result->id;

        $inputs = $request->all();

        $buildingId = $inputs['building_id'];
        unset($inputs['building_id']);

        $inputs['building_name'] = $buildingId;

        $validator = (new Floor)->validateFloor($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();
            unset($inputs['building_name']);

            $inputs = $inputs + [
                'building_id'  => $buildingId,
                'status' => isset($inputs['status']) ? 1 : 0,
                'updated_by' => authUserId()
            ];
            (new Floor)->store($inputs, $id);

            \DB::commit();

            $route = route('floor.index');
            return validationResponse(true, 201, lang('messages.updated', lang('floor.floor')), $route);
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
     * Used to update building active status.
     *
     * @param int $id
     * @return Response
     */
    public function floorToggle($id = null)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = Floor::find($id);

        try {
            // get the floor w.r.t id
            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('floor.floor')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function floorPaginate(Request $request, $pageNumber = null)
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

            $data = (new Floor)->getFloor($inputs, $start, $perPage);
            $totalFloor = (new Floor)->totalFloor($inputs);
            $total = $totalFloor->total;
        } else {

            $data = (new Floor)->getFloor($inputs, $start, $perPage);
            $totalFloor = (new Floor)->totalFloor($inputs);
            $total = $totalFloor->total;
        }

        return view('admin.floor.load_data', compact('data', 'total', 'page', 'perPage'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addFloor($id){
        $result = Floor::find($id);
        if (!$result) {
            abort(404);
        }
        $roomCode = (new Rooms)->getRoomCode();
        $roomType = lang('common.room_type');
        return view('admin.floor.add_room',compact('result', 'roomCode', 'roomType'));
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRoom(Request $request, $id = null){
        if(!$id) {
            return validationResponse(false, 206, "", "", lang('messages.server_error'));
        }
        $input = $request->except('room_code', 'room_name', 'room_charges', 'room_type'); // inputs without array
        $inputs = $request->all(); // contains all inputs with array

        $floorId = $inputs['floor_id'];
        unset($inputs['floor_id']);

        $inputs['floor'] = $floorId;


        $validator = (new Rooms)->validateRoom($inputs, null, true);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $hospitalId = loggedInHospitalId();
            $authUserId = authUserId();
            $inputArr =[];

            if(isset($inputs['room_name']) && is_array($inputs['room_name']) && count($inputs['room_name']) > 0) {
                foreach($inputs['room_name'] as $key => $val){

                    $code        = $inputs['room_code'][$key];
                    $name        = $inputs['room_name'][$key];
                    $roomType    = $inputs['room_type'][$key];
                    $roomCharges = $inputs['room_charges'][$key];

                    $inputArr = [
                        'room_code'     => $code,
                        'room_name'     => $name,
                        'room_type'     => $roomType,
                        'floor_id'      => $floorId,
                        'hospital_id'   => $hospitalId,
                        'created_by'    => $authUserId,
                    ];

                    $roomId=(new Rooms)->store($inputArr);

                    $saveInputs = [
                        'room_id'       => $roomId,
                        'room_charges'  => $roomCharges,
                        'wef'           => convertToUtc(),
                        'wet'           => null,
                        'is_active'     => 1,
                    ];
                    (new RoomCost)->store($saveInputs);
                }
            }
            \DB::commit();
            $route = route('room.index');
            return validationResponse(true, 201, lang('messages.created', lang('room.rooms')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    public function dropDownFetch(){
        $roomType = lang('common.room_type');

        return view('admin.floor.add_floor', compact('roomType'));
    }
}
