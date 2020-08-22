<?php

namespace App\Http\Controllers;

/**
 * :: StaffRegistration Controller ::
 * To manage StaffRegistration.
 *
 **/

use App\Department;
use App\Designation;
use App\Role;
use App\StaffRegistration;
use App\User;
use Illuminate\Http\Request;

class StaffRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.staff.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $registrationNumber     = (new StaffRegistration)->getRegistrationNumber();
        $departmentService      = (new Department)->getDepartmentService();
        $designationService     = (new Designation)->getDesignationService();
        $roleService            = (new Role)->getRoleService();
        return view('admin.staff.create', compact('registrationNumber', 'departmentService', 'designationService', 'roleService'));
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
        $validator = (new StaffRegistration)->validateStaff($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
             \DB::beginTransaction();
             unset($inputs['_token']);

//            dd(58, $inputs);
            $inputs['contact_number'] = $inputs['mobile'];
            unset($inputs['mobile']);

            $inputs['dob'] = ($inputs['dob']!= '')? dateFormat('Y-m-d', $inputs['dob']) : null;

            $inputs['do_joining'] = ($inputs['do_joining']!= '')?
                convertToUtc($inputs['do_joining'].Date('H:i:s'), 'Y-m-d H:i:s') : null;

            /*$inputs['do_relieving'] = ($inputs['do_relieving']!= '')?
                convertToUtc($inputs['do_relieving'].Date('H:i:s'), 'Y-m-d H:i:s') : null;*/

            $inputs['do_retirement'] = ($inputs['do_retirement']!= '')?
                convertToUtc($inputs['do_retirement'].Date('H:i:s'), 'Y-m-d H:i:s') : null;

            $age = $inputs['age'];
            unset($inputs['age']);

            $inputs['role_id'] = $inputs['role'];
            unset($inputs['role']);

            $inputs['department_id'] = $inputs['department'];
            unset($inputs['department']);

            $inputs['designation_id'] = $inputs['designation'];
            unset($inputs['designation']);

            $status = isset($inputs['status']) ? 1 : 0;
            $inputs = $inputs + [
                'status'            => $status,
                'created_by'        => authUserId(),
                'hospital_id'       => loggedInHospitalId()
            ];

            $registerId = (new StaffRegistration)->store($inputs);

            $name = ($inputs['last_name'] != '') ? $inputs['first_name'] .' '. $inputs['last_name'] : $inputs['first_name'];

            if ($inputs['password'] != "")
            {
                $userInputs = [
                    'hospital_id' => loggedInHospitalId(),
                    'role_id'     => $inputs['role_id'],
                    'staff_id'    => $registerId,
                    'name'        => $name,
                    'username'    => $inputs['user_name'],
                    'email'       => $inputs['email'],
                    'user_type'   => 3,
                    'password'    => \Hash::make($inputs['password']),
                ];
                $userId = (new User)->store($userInputs);
                (new StaffRegistration)->store(['user_id' => $userId], $registerId);
            }

            if($request->hasFile('image') && $registerId > 0) {
                $imageName = fileUploader('image', $registerId);
                $update = ['image'  => $imageName];
                (new StaffRegistration)->store($update, $registerId);
            }

            \DB::commit();
            $route = route('staff.index');
            return validationResponse(true, 201, lang('messages.created', lang('staff.staff')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().'-@@@@-'.lang('messages.server_error'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffRegistration  $staffRegistration
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = StaffRegistration::find($id);
        if (!$result) {
            abort(404);
        }
        $departmentService = (new Department)->getDepartmentService();
        $designationService = (new Designation)->getDesignationService();
        $roleService = (new Role)->getRoleService();

        $user = User::find($result->user_id);
        return view('admin.staff.edit', compact('result', 'roleService', 'departmentService', 'designationService', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffRegistration  $staffRegistration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $result = StaffRegistration::find($id);

        if (!$result) {
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('staff.staff'))));
        }

        $inputs = $request->except('image');
        $validator = (new StaffRegistration)->validateStaff($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();

            $inputs['contact_number'] = $inputs['mobile'];
            unset($inputs['mobile']);

            $inputs['dob'] = ($inputs['dob']!= '')? dateFormat('Y-m-d', $inputs['dob']) : null;

            $inputs['do_joining'] = ($inputs['do_joining']!= '')?
                convertToUtc($inputs['do_joining'].Date('H:i:s'), 'Y-m-d H:i:s') : null;

            /*$inputs['do_relieving'] = ($inputs['do_relieving']!= '')?
                convertToUtc($inputs['do_relieving'].Date('H:i:s'), 'Y-m-d H:i:s') : null;*/

            $inputs['do_retirement'] = ($inputs['do_retirement']!= '')?
                convertToUtc($inputs['do_retirement'].Date('H:i:s'), 'Y-m-d H:i:s') : null;

            $age = $inputs['age'];
            unset($inputs['age']);

            $inputs['role_id'] = $inputs['role'];
            unset($inputs['role']);

            $inputs['department_id'] = $inputs['department'];
            unset($inputs['department']);

            $inputs['designation_id'] = $inputs['designation'];
            unset($inputs['designation']);

            $status = isset($inputs['status']) ? 1 : 0;

            $prevImage = $result->image;

            $inputs = $inputs + [
                'status'            => $status,
                'updated_by'        => authUserId(),
            ];

            (new StaffRegistration)->store($inputs, $id);

            $name = ($inputs['last_name'] != '') ? $inputs['first_name'] .' '. $inputs['last_name'] : $inputs['first_name'];

            if (isset($inputs['password']) && $inputs['password'] != "") {
                $user = [
                    'staff_id'    => $id,
                    'role_id'     => $inputs['role_id'],
                    'name'        => $name,
                    'username'    => $inputs['user_name'],
                    'email'       => $inputs['email'],
                    'user_type'   => 3,
                    'password'    => \Hash::make($inputs['password']),
                ];
                if ($result->user_id == "") {
                    $userId = (new User)->store($user);
                    (new StaffRegistration)->store(['user_id' => $userId], $result);
                } else {
                    (new User)->store($user, $result->user_id);
                }
            }

            if($request->hasFile('image') && $id > 0)
            {
                $imageName = fileUploader('image', $id);
                $update = ['image'  => $imageName];
                (new StaffRegistration)->store($update, $id);

                $fileExist = file_exists(ROOT . \Config::get('constants.UPLOADS') . $prevImage);
                if($prevImage && $fileExist) {
                    unlink(ROOT . \Config::get('constants.UPLOADS') . $prevImage);
                }
            }

            \DB::commit();

            $route = route('staff.index');
            return validationResponse(true, 201, lang('messages.updated', lang('staff.staff')), $route);
        } catch (\Exception $exception) {
            \DB::rollBack();

            return validationResponse(false, 207, $exception->getMessage().' '.$exception->getLine().'--'.lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffRegistration  $staffRegistration
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffRegistration $staffRegistration)
    {
        return "In Progress";
    }

    /**
     * Used to update staff active status.
     *
     * @param int $id
     * @return Response
     */
    public function staffToggle($id = null)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = StaffRegistration::find($id);

        try {
            // get the staff w.r.t id
            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('staff.staff')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function staffPaginate(Request $request, $pageNumber = null)
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

            $data = (new StaffRegistration)->getStaff($inputs, $start, $perPage);
            $totalStaff = (new StaffRegistration)->totalStaff($inputs);
            $total = $totalStaff->total;
        } else {

            $data = (new StaffRegistration)->getStaff($inputs, $start, $perPage);
            $totalStaff = (new StaffRegistration)->totalStaff($inputs);
            $total = $totalStaff->total;
        }

        return view('admin.staff.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
