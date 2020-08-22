<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;
use App\Floor;
use App\Rooms;
use App\RoomCost;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomCode = (new Rooms)->getRoomCode();
        $buildingCode = (new Building)->getBuildingService();
        $floorName = (new Floor)->getFloorName();
        $roomType = lang('common.room_type');
        return view('admin.room.index', compact('buildingCode', 'roomCode', 'floorName', 'roomType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roomCode = (new Rooms)->getRoomCode();
        $buildingCode = (new Building)->getBuildingService();
        $floorName = (new Floor)->getFloorName();
        $roomType = lang('common.room_type');
        return view('admin.room.create', compact('buildingCode', 'roomCode', 'floorName', 'roomType'));
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

        $inputs['floor'] = $floorId;

        $validator = (new Rooms)->validateRoom($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);
            unset($inputs['floor']);

            $inputs = $inputs + [
                'floor_id'    => $floorId,
                'created_by'  => authUserId(),
                'hospital_id' => loggedInHospitalId()
            ];
            $roomId = (new Rooms)->store($inputs);

            $saveInputs = [
                'room_id'       => $roomId,
                'room_charges'  => $inputs['room_charges'],
                'wef'           => convertToUtc(),
                'wet'           => null,
                'is_active'     => 1,
            ];
            (new RoomCost)->store($saveInputs);

            \DB::commit();
            return validationResponse(true, 201, lang('messages.created', lang('room.room')), route('room.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Rooms::find($id);
        if (!$room) {
            abort(404);
        }
        if(!isSuperAdmin() && $room->hospital_id != loggedInHospitalId()) {
            abort(401);
        }

        $floorName = (new Floor)->getFloorName();
        $roomType = lang('common.room_type');
        $search = [
            'room_id'   => $id
        ];
        $roomCharges = (new RoomCost)->getRoomCharges($search);

        return view('admin.room.edit', compact('room', 'floorName', 'roomType', 'roomCharges'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $room = Rooms::find($id);
        if (!$room) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('room.room'))));
        }

        $inputs = $request->all();

        $floorId = $inputs['floor_id'];
        unset($inputs['floor_id']);

        $inputs['floor'] = $floorId;
        $roomCharges = (new RoomCost)->getEffectedRoom(true, ['room_id' => $id]);

        $validator = (new Rooms)->validateRoom($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();
            unset($inputs['floor']);

            $inputs = $inputs + [
                'floor_id'    => $floorId,
                'updated_by' => authUserId()
            ];
            (new Rooms)->store($inputs, $id);

            $charges = 0;
            $inputs['room_id'] = $id;

            if ($roomCharges) {
                $charges = $roomCharges->room_charges;

                if (($charges > 0 && $charges != $inputs['room_charges'])) {

                    //update older costs
                    $update = [
                        'is_active' => 0,
                        'wet' => convertToUtc(),
                    ];
                    (new RoomCost)->store($update, $roomCharges->id);
                    unset($inputs['wet']);
                    //add new costs
                    $inputs['is_active'] = 1;
                    $inputs['wef'] = convertToUtc();
                    (new RoomCost)->store($inputs);
                }
            } else {
                //add new costs
                $inputs['is_active'] = 1;
                $inputs['wef'] = convertToUtc();
                (new RoomCost)->store($inputs, $roomCharges->id);
            }

            \DB::commit();
            return validationResponse(true, 201, lang('messages.updated', lang('room.room')), route('room.index'));
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rooms $rooms)
    {
        return "In Progress";
    }
    /**
     * Used to update role active status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rooms $rooms
     * @return Response
     */
    public function roomToggle($id)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $room = Rooms::find($id);
        if (!$room) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('room.room'))));
        }

        try {
            // get the role w.r.t id

            $room->update(['status' => !$room->status]);
            $response = ['status' => 1, 'data' => (int)$room->status . '.gif'];
            // return json response
            return json_encode($response);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('room.room')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function roomPaginate(Request $request, $pageNumber = null)
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

            $data = (new Rooms)->getRoom($inputs, $start, $perPage);
            $totalRooms = (new Rooms)->totalRoom($inputs);
            $total = $totalRooms->total;
        } else {

            $data = (new Rooms)->getRoom($inputs, $start, $perPage);
            $totalRooms = (new Rooms)->totalRoom($inputs);
            $total = $totalRooms->total;
        }
        return view('admin.room.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
