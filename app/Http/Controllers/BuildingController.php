<?php

namespace App\Http\Controllers;

/**
 * :: Building Controller ::
 * To manage Building.
 *
 **/

use App\Floor;
use Illuminate\Http\Request;
use App\Building;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buildingCode = (new Building)->getBuildingCode();
        return view('admin.building.index', compact('buildingCode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buildingCode = (new Building)->getBuildingCode();
        return view('admin.building.create', compact('buildingCode'));
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
        $validator = (new Building)->validateBuilding($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $inputs = $inputs + [
                    'created_by' => authUserId(),
                    'hospital_id' => loggedIncompanyId()
                ];
            (new Building)->store($inputs);
            \DB::commit();

            $route = route('building.index');
            return validationResponse(true, 201, lang('messages.created', lang('building.building')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function edit(Building $building)
    {
        $result = $building;
        if (!$result) {
            abort(404);
        }

        return view('admin.building.edit', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Building $building)
    {
        $result = $building;
        if (!$result) {
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('building.building'))));
        }
        $id = $result->id;

        $inputs = $request->all();
        $validator = (new Building)->validateBuilding($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();

            $inputs = $inputs + [
                'status' => isset($inputs['status']) ? 1 : 0,
                'updated_by' => authUserId()
            ];
            (new Building)->store($inputs, $id);

            \DB::commit();

            $route = route('building.index');
            return validationResponse(true, 201, lang('messages.updated', lang('building.building')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();

            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy(Building $building)
    {
        return "In Progress";
    }

    /**
     * Used to update building active status.
     *
     * @param int $id
     * @return Response
     */
    public function buildingToggle($id = null)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = Building::find($id);

        try {
            // get the building w.r.t id
            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('building.building')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function buildingPaginate(Request $request, $pageNumber = null)
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

            $data = (new Building)->getBuilding($inputs, $start, $perPage);
            $totalBuilding = (new Building)->totalBuilding($inputs);
            $total = $totalBuilding->total;
        } else {

            $data = (new Building)->getBuilding($inputs, $start, $perPage);
            $totalBuilding = (new Building)->totalBuilding($inputs);
            $total = $totalBuilding->total;
        }

        return view('admin.building.load_data', compact('data', 'total', 'page', 'perPage'));
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addFloor($id = null){

        $result     = Building::find($id);
        $floorCode  = (new Floor)->getFloorCode();
        return view('admin.building.add_floor', compact('result', 'floorCode'));
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function storeFloor(Request $request, $id = null)
    {
        if(!$id) {
            return validationResponse(false, 206, "", "", lang('messages.server_error'));
        }

        $input = $request->except('code', 'name', 'total_rooms'); // inputs without array
        $inputs = $request->all(); // contains all inputs with array

        $buildingId = $inputs['building_id'];
        unset($inputs['building_id']);

        $inputs['building_name'] = $buildingId;

        $validator = (new Floor)->validateFloor($inputs, null, true);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $hospitalId = loggedInHospitalId();
            $authUserId = authUserId();
            $inputArr = [];
            if(isset($inputs['name']) && is_array($inputs['name']) && count($inputs['name']) > 0) {
                foreach($inputs['name'] as $key => $val){
                   $code        = $inputs['code'][$key];
                   $name        = $inputs['name'][$key];
                   $totalRooms  = $inputs['total_rooms'][$key];

                    $inputArr = [
                        'code'          => $code,
                        'name'          => $name,
                        'total_rooms'   => $totalRooms,
                        'building_id'   => $buildingId,
                        'hospital_id'   => $hospitalId,
                        'created_by'    => $authUserId,
                    ];
                    (new Floor)->store($inputArr);
                }
            }
            \DB::commit();
            $route = route('floor.index');
            return validationResponse(true, 201, lang('messages.created', lang('floor.floors')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

}

