<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendorCode  = (new Vendor)->getVendorCode();
        return view('admin.vendor.create', compact('vendorCode'));
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
        $message = '';

        if(isset($inputs['std_code']) && $inputs['std_code'] != '' && $inputs['company_phone'] == '') {
            $message = lang('vendor.please_fill_phone_no_along_std_code');
            return validationResponse(false, 207, $message);
        }else if(isset($inputs['company_phone']) && $inputs['company_phone'] != '' && $inputs['std_code'] == '') {
            $message = lang('vendor.please_fill_std_code_along_phone_no');
            return validationResponse(false, 207, $message);
        }

        $validator = (new Vendor)->validateVendor($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $companyPhoneNo = $inputs['std_code'].'-'.$inputs['company_phone'];
            unset($inputs['std_code']); unset($inputs['company_phone']);

            $status = isset($inputs['status']) ? 1 : 0;
            $inputs = $inputs + [
                    'hospital_id'          => loggedInHospitalId(),
                    'status'               => $status,
                    'company_phone'        => $companyPhoneNo,
                    'created_by'           => authUserId(),
                ];
            (new Vendor)->store($inputs);
            \DB::commit();
            $route   = route('vendor.index');
            $message = lang('messages.created', lang('vendor.vendor'));
            return validationResponse(true, 201, $message, $route);
        } catch (\Exception $e) {
            \DB::rollBack();
            return validationResponse(false, 207, $e->getMessage().' '.$e->getLine().' '.$e->getFile().'  '. lang('messages.server_error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $result = $vendor;
        if(!$result)
        {
            abort(404);
        }
        if($result->hospital_id != loggedInHospitalId()) {
            abort(401);
        }

        $number = explode('-', $result->company_phone, 2);


        $stdCode = (!empty($number[0])) ? $number[0] : '';
        $companyPhone = (!empty($number[1])) ? $number[1] : '';

        return view('admin.vendor.edit', compact('result',  'stdCode', 'companyPhone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $inputs = $request->all();
        $message = '';
        $vendorId = $vendor->id;

        if(isset($inputs['std_code']) && $inputs['std_code'] != '' && $inputs['company_phone'] == '') {
            $message = lang('vendor.please_fill_phone_no_along_std_code');
            return validationResponse(false, 207, $message);
        }else if(isset($inputs['company_phone']) && $inputs['company_phone'] != '' && $inputs['std_code'] == '') {
            $message = lang('vendor.please_fill_std_code_along_phone_no');
            return validationResponse(false, 207, $message);
        }

        $validator = (new Vendor)->validateVendor($inputs, $vendorId);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);

            $companyPhoneNo = $inputs['std_code'].'-'.$inputs['company_phone'];
            unset($inputs['std_code']); unset($inputs['company_phone']);

            $status = isset($inputs['status']) ? 1 : 0;
            $inputs = $inputs + [
                    'status'               => $status,
                    'company_phone'        => $companyPhoneNo,
                    'updated_by'           => authUserId(),
                ];
            (new Vendor)->store($inputs, $vendorId);
            \DB::commit();
            $route   = route('vendor.index');
            $message = lang('messages.updated', lang('vendor.vendor'));
            return validationResponse(true, 201, $message, $route);
        } catch (\Exception $e) {
            \DB::rollBack();
            return validationResponse(false, 207, $e->getMessage().' '.$e->getLine().' '.$e->getFile().'  '. lang('messages.server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        return "In progress";
    }

    /**
     * Used to update role active status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AddEvent $addEvent
     * @return Response
     */
    public function vendorToggle($id)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = Vendor::find($id);
        if (!$result) {
            return validationResponse(false, 207, lang('messages.invalid_id', string_manip(lang('vendor.vendor'))));
        }

        try {
            // get the role w.r.t id

            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('vendor.vendor')));
        }
    }

    /**
     * Used to load more records and render to view.
     *
     * @param int $pageNumber
     *
     * @return Response
     */
    public function vendorPaginate(Request $request, $pageNumber = null)
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

            $data = (new Vendor)->getVendors($inputs, $start, $perPage);
            $totalVendor = (new Vendor)->totalVendors($inputs);
            $total = $totalVendor->total;
        } else {

            $data = (new Vendor)->getVendors($inputs, $start, $perPage);
            $totalVendor = (new Vendor)->totalVendors($inputs);
            $total = $totalVendor->total;
        }
        return view('admin.vendor.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
