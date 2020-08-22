<?php

namespace App\Http\Controllers;

use App\Category;
use App\Vendor;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $categoryCode = (new category)->getCategoeyCode();
        $vendorName = (new vendor)->getVendorService();
        return view('admin.category.create',compact('vendorName','categoryCode'));
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

        $vendorId = $inputs['vendor_id'];
        unset($inputs['vendor_id']);

        $inputs['vendor_name'] = $vendorId;

        $validator = (new Category)->validateCategory($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();
            unset($inputs['_token']);
            unset($inputs['vendor_name']);

            $inputs = $inputs + [
                    'vendor_id'  => $vendorId,
                    'company_id' => loggedIncompanyId(),
                    'created_by' => authUserId()
                ];
            (new Category)->store($inputs);
            \DB::commit();

            $route = route('category.index');
            return validationResponse(true, 201, lang('messages.created', lang('category.category')), $route);
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
    public function edit(Category $category)
    {
        $result = $category;
        if (!$result) {
            abort(404);
        }
        $vendorName = (new Vendor)->getVendorService();
        return view('admin.category.edit', compact('result','vendorName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $result = $category;
        if (!$result) {
            return validationResponse(false, 206, lang('messages.invalid_id', string_manip(lang('category.category'))));
        }
        $id = $result->id;

        $inputs = $request->all();

        $vendorId = $inputs['vendor_id'];
        unset($inputs['vendor_id']);

        $inputs['vendor_name'] = $vendorId;

        $validator = (new Category)->validateCategory($inputs, $id);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }

        try {
            \DB::beginTransaction();
            unset($inputs['vendor_name']);

            $inputs = $inputs + [
                    'vendor_id'  => $vendorId,
                    'status' => isset($inputs['status']) ? 1 : 0,
                    'updated_by' => authUserId()
                ];
            (new Category)->store($inputs, $id);

            \DB::commit();

            $route = route('category.index');
            return validationResponse(true, 201, lang('messages.updated', lang('category.category')), $route);
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

    public function categoryToggle($id = null)
    {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = Category::find($id);

        try {
            // get the floor w.r.t id
            $result->update(['status' => !$result->status]);
            $response = ['status' => 1, 'data' => (int)$result->status . '.gif'];
            // return json response
            return json_encode($response);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('category.category')));
        }
    }

    public function categoryPaginate(Request $request, $pageNumber = null)
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

            $data = (new Category)->getCategory($inputs, $start, $perPage);
            $totalCategory = (new Category)->totalCategory($inputs);
            $total = $totalCategory->total;
        } else {
            $data = (new Category)->getCategory($inputs, $start, $perPage);
            $totalCategory = (new Category)->totalCategory($inputs);
            $total = $totalCategory->total;
        }

        return view('admin.category.load_data', compact('data', 'total', 'page', 'perPage'));
    }
}
