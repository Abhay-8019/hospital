<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('dashboard');
Route::get('dashboard',   ['as' => 'home','uses' => 'HomeController@index']);
//Route::get('/dashboard', 'HomeController@index')->name('dashboard');
//Route::get('/', 'Auth\LoginController@showLoginForm')->name('dashboard');

Route::group(['middleware' => 'auth'], function ()
{
    // Change Password
    Route::any('password/change',   ['as' => 'password.change', 'uses' => 'CommonController@changePassword']);
    Route::any('password/update',   ['as' => 'password.update', 'uses' => 'CommonController@updatePassword']);

    Route::any('calculate-age',     ['as' => 'calculate-age', 'uses' => 'CommonController@calculateAge']);

    // User Routes
    Route::resource('user','UserController');

    Route::any('users/action',          ['as' => 'user.action',   'uses' => 'UserController@userAction']);
    Route::any('users/paginate',        ['as' => 'user.paginate', 'uses' => 'UserController@userPaginate']);
    Route::any('users/toggle/{id?}',    ['as' => 'user.toggle',   'uses' => 'UserController@userToggle']);
    Route::get('users/drop/{id?}',      ['as' => 'user.drop',     'uses' => 'UserController@drop']);


    // Role Routes
    Route::resource('role','RoleController');

    Route::any('role/edit-permission/{id?}',    ['as' => 'role.edit-permission',   'uses' => 'RoleController@editPermission']);
    Route::any('role/update-permission/{id?}',  ['as' => 'role.update-permission', 'uses' => 'RoleController@updatePermission']);
    Route::any('role/action',                   ['as' => 'role.action',            'uses' => 'RoleController@roleAction']);
    Route::any('role/paginate',                 ['as' => 'role.paginate',          'uses' => 'RoleController@rolePaginate']);
    Route::any('role/toggle/{id?}',             ['as' => 'role.toggle',            'uses' => 'RoleController@roleToggle']);
    Route::get('role/drop/{id?}',               ['as' => 'role.drop',              'uses' => 'RoleController@drop']);

    // Menu Routes
    Route::resource('menu','MenuController');

    Route::any('menu/action',       ['as' => 'menu.action',   'uses' => 'MenuController@menuAction']);
    Route::any('menu/paginate',     ['as' => 'menu.paginate', 'uses' => 'MenuController@menuPaginate']);
    Route::any('menu/toggle/{id?}', ['as' => 'menu.toggle',   'uses' => 'MenuController@menuToggle']);
    Route::get('menu/drop/{id?}',   ['as' => 'menu.drop',     'uses' => 'MenuController@drop']);


    // Department Routes
    Route::resource('department','DepartmentController');

    Route::any('department/action',       ['as' => 'department.action',   'uses' => 'DepartmentController@departmentAction']);
    Route::any('department/paginate',     ['as' => 'department.paginate', 'uses' => 'DepartmentController@departmentPaginate']);
    Route::any('department/toggle/{id?}', ['as' => 'department.toggle',   'uses' => 'DepartmentController@departmentToggle']);
    Route::get('department/drop/{id?}',   ['as' => 'department.drop',     'uses' => 'DepartmentController@drop']);

    // Floor Routes
    Route::resource('floor','FloorController');

    Route::any('floor/action',              ['as' => 'floor.action',       'uses' => 'FloorController@floorAction']);
    Route::any('floor/paginate',            ['as' => 'floor.paginate',     'uses' => 'FloorController@floorPaginate']);
    Route::any('floor/toggle/{id?}',        ['as' => 'floor.toggle',       'uses' => 'FloorController@floorToggle']);
    Route::get('floor/drop/{id?}',          ['as' => 'floor.drop',         'uses' => 'FloorController@drop']);
    Route::get('floor/add-room/{id?}',      ['as' => 'floor.add',          'uses' => 'FloorController@addFloor']);
    Route::any('floor/save-room/{id?}',     ['as' => 'floor.saveroom',     'uses' => 'FloorController@storeRoom']);

    

    // Building Routes --> old Name = Branch
    Route::resource('building','BuildingController');

    Route::any('building/action',                       ['as' => 'building.action',         'uses' => 'BuildingController@buildingAction']);
    Route::any('building/paginate',                     ['as' => 'building.paginate',       'uses' => 'BuildingController@buildingPaginate']);
    Route::any('building/toggle/{id?}',                 ['as' => 'building.toggle',         'uses' => 'BuildingController@buildingToggle']);
    Route::get('building/drop/{id?}',                   ['as' => 'building.drop',           'uses' => 'BuildingController@drop']);
    Route::get('building/add-floor/{id?}',              ['as' => 'building.add',            'uses' => 'BuildingController@addFloor']);
    Route::any('building/save-floor/{id?}',             ['as' => 'building.savefloor',      'uses' => 'BuildingController@storeFloor']);

    // Designations Routes
    Route::resource('designation','DesignationController');

    Route::any('designation/action',       ['as' => 'designation.action',   'uses' => 'DesignationController@designationAction']);
    Route::any('designation/paginate',     ['as' => 'designation.paginate', 'uses' => 'DesignationController@designationPaginate']);
    Route::any('designation/toggle/{id?}', ['as' => 'designation.toggle',   'uses' => 'DesignationController@designationToggle']);
    Route::get('designation/drop/{id?}',   ['as' => 'designation.drop',     'uses' => 'DesignationController@drop']);


    // Staff Registrations Routes
    Route::resource('staff','StaffRegistrationController');

    Route::any('staff/action',       ['as' => 'staff.action',   'uses' => 'StaffRegistrationController@staffAction']);
    Route::any('staff/paginate',     ['as' => 'staff.paginate', 'uses' => 'StaffRegistrationController@staffPaginate']);
    Route::any('staff/toggle/{id?}', ['as' => 'staff.toggle',   'uses' => 'StaffRegistrationController@staffToggle']);
    Route::get('staff/drop/{id?}',   ['as' => 'staff.drop',     'uses' => 'StaffRegistrationController@drop']);

    

    // Employee_Type Registration Routes
    Route::resource('employee-type','EmployeeTypeController');

    Route::any('employee-type/action',       ['as' => 'employee-type.action',    'uses' => 'EmployeeTypeController@EmployeeTypeAction']);
    Route::any('employee-type/paginate',     ['as' => 'employee-type.paginate',  'uses' => 'EmployeeTypeController@EmployeeTypePaginate']);
    Route::any('employee-type/toggle/{id?}', ['as' => 'employee-type.toggle',    'uses' => 'EmployeeTypeController@EmployeeTypeToggle']);
    Route::get('employee-type/drop/{id?}',   ['as' => 'employee-type.drop',      'uses' => 'EmployeeTypeController@drop']);

   
   
    // Specialization Registration Routes
    Route::resource('specialization','SpecializationController');

    Route::any('specialization/action',         ['as' => 'specialization.action',   'uses' => 'SpecializationController@specializationAction']);
    Route::any('specialization/paginate',       ['as' => 'specialization.paginate',  'uses' =>'SpecializationController@specializationPaginate']);
    Route::any('specialization/toggle/{id?}',   ['as' => 'specialization.toggle',   'uses' => 'SpecializationController@specializationToggle']);
    Route::get('specialization/drop/{id?}',     ['as' => 'specialization.drop',     'uses' => 'SpecializationController@drop']);

    

    // Event Type Routes
    Route::resource('event_type','EventTypeController');

    Route::any('event_type/action',         ['as' => 'event_type.action',   'uses' => 'EventTypeController@eventTypeAction']);
    Route::any('event_type/paginate',       ['as' => 'event_type.paginate', 'uses' => 'EventTypeController@eventTypePaginate']);
    Route::any('event_type/toggle/{id?}',   ['as' => 'event_type.toggle',   'uses' => 'EventTypeController@eventTypeToggle']);
    Route::get('event_type/drop/{id?}',     ['as' => 'event_type.drop',     'uses' => 'EventTypeController@drop']);

    // Add Event Routes
    Route::resource('add_events','AddEventController');

    Route::any('add_events/action',          ['as' => 'add_events.action',   'uses' => 'AddEventController@eventAction']);
    Route::any('add_events/paginate',        ['as' => 'add_events.paginate', 'uses' => 'AddEventController@eventPaginate']);
    Route::any('add_events/toggle/{id?}',    ['as' => 'add_events.toggle',   'uses' => 'AddEventController@eventToggle']);
    Route::get('add_events/drop/{id?}',      ['as' => 'add_events.drop',     'uses' => 'AddEventController@drop']);

    // Financial Year Routes
    Route::resource('financial-year','FinancialYearController');

    Route::any('financial-year/action',         ['as' => 'financial-year.action',   'uses' => 'FinancialYearController@financialYearAction']);
    Route::any('financial-year/paginate',       ['as' => 'financial-year.paginate', 'uses' => 'FinancialYearController@financialYearPaginate']);
    Route::any('financial-year/toggle/{id?}',   ['as' => 'financial-year.toggle',   'uses' => 'FinancialYearController@financialYearToggle']);
    Route::get('financial-year/drop/{id?}',     ['as' => 'financial-year.drop',     'uses' => 'FinancialYearController@drop']);

    // Vendor Routes
    Route::resource('vendor','VendorController');

    Route::any('vendor/action',         ['as' => 'vendor.action',   'uses' => 'VendorController@vendorAction']);
    Route::any('vendor/paginate',       ['as' => 'vendor.paginate', 'uses' => 'VendorController@vendorPaginate']);
    Route::any('vendor/toggle/{id?}',   ['as' => 'vendor.toggle',   'uses' => 'VendorController@vendorToggle']);
    Route::get('vendor/drop/{id?}',     ['as' => 'vendor.drop',     'uses' => 'VendorController@drop']);

    //Category Routes
    Route::resource('category','CategoryController');

    Route::any('category/action',           ['as' => 'category.action',    'uses' =>'CategoryController@categoryAction']);
    Route::any('category/paginate',         ['as' => 'category.paginate',  'uses' =>'CategoryController@categoryPaginate']);
    Route::any('category/toggle/{id?}',     ['as' => 'category.toggle',    'uses' =>'CategoryController@categoryToggle']);
    Route::any('category/drop/{id?}',       ['as' => 'category.drop',      'uses' =>'CategoryController@drop']);

     //Hospital Routes
    Route::resource('hospital','HospitalController');

    Route::any('hospital/action',           ['as' => 'hospital.action',    'uses' =>'HospitalController@hospital']);
    Route::any('hospital/paginate',         ['as' => 'hospital.paginate',  'uses' =>'HospitalController@hospitalPaginate']);
    Route::any('hospital/toggle/{id?}',     ['as' => 'hospital.toggle',    'uses' =>'HospitalController@hospitalToggle']);
    Route::any('hospital/drop/{id?}',       ['as' => 'hospital.drop',      'uses' =>'HospitalController@drop']);

    // HSN Code Routes
    Route::resource('hsn-code', 'HsnCodeController',
        ['names' => [
            'index'     => 'hsn-code.index',
            'create'    => 'hsn-code.create',
            'store'     => 'hsn-code.store',
            'edit'      => 'hsn-code.edit',
            'update'    => 'hsn-code.update',
            'drop'      => 'hsn-code.drop'
        ],
            'except' => ['show', 'destroy']
        ]);
    Route::any('hsn-code/paginate/{page?}', ['as' => 'hsn_code.paginate',
        'uses' => 'HsnCodeController@hsnCodePaginate']);

    Route::any('hsn-code/action', ['as' => 'hsn_code.action',
        'uses' => 'HsnCodeController@hsnCodeAction']);

    Route::any('hsn-code/toggle/{id?}', ['as' => 'hsn_code.toggle',
        'uses' => 'HsnCodeController@hsnCodeToggle']);

    Route::any('hsn-code/drop/{id?}', ['as' => 'hsn-code.drop',
        'uses' => 'HsnCodeController@drop']);

    Route::any('hsn-code/hsn-code-modal/', ['as' => 'hsn-code.hsn-modal',
        'uses' => 'HsnCodeController@hsnCodeModal']);

    Route::get('hsn-code/generate-excel', ['as' => 'hsn-code.generate-excel',
        'uses' => 'HsnCodeController@generateExcel']);

    Route::any('hsn-code/upload-excel', ['as' => 'hsn-code.upload-excel',
        'uses' => 'HsnCodeController@uploadExcel']);

    Route::any('hsn-code/download-sample-excel', ['as' => 'hsn-code.download-sample-excel',
        'uses' => 'HsnCodeController@downloadSampleExcel']);

    // Tax Routes
    Route::resource('tax-group', 'TaxController',
        ['names' => [
            'index'     => 'tax.index',
            'create'    => 'tax.create',
            'store'     => 'tax.store',
            'edit'      => 'tax.edit',
            'update'    => 'tax.update'
        ],
            'except' => ['show', 'destroy']
        ]);

    Route::any('tax-group/paginate/{page?}', ['as' => 'tax.paginate',
        'uses' => 'TaxController@taxPaginate']);

    Route::any('tax-group/action', ['as' => 'tax.action',
        'uses' => 'TaxController@taxAction']);

    Route::any('tax-group/toggle/{id?}', ['as' => 'tax.toggle',
        'uses' => 'TaxController@taxToggle']);

    Route::any('tax-group/drop/{id?}', ['as' => 'tax-group.drop',
        'uses' => 'TaxController@drop']);

    Route::any('tax-group/tax-modal', ['as' => 'tax.tax-modal',
        'uses' => 'TaxController@create']);

   
    
    // Financial Year Route
    Route::resource('financial-year','FinancialYearController', [
        'names' => [
            'index' => 'financial-year.index',
            'create' => 'financial-year.create',
            'store' => 'financial-year.store',
            'edit' => 'financial-year.edit',
            'update' => 'financial-year.update',
        ],
        'except' => ['show','destroy']
    ]);
    Route::any('financial-year/paginate/{page?}', ['as' => 'financial-year.paginate',
        'uses' => 'FinancialYearController@financialYearPaginate']);

    Route::any('financial-year/action', ['as' => 'financial-year.action',
        'uses' => 'FinancialYearController@action']);

    Route::any('financial-year/toggle/{id?}', ['as' => 'financial-year.toggle',
        'uses' => 'FinancialYearController@financialYearToggle']);

    Route::any('financial-year/drop/{id?}', ['as' => 'financial-year.drop',
        'uses' => 'FinancialYearController@drop']);

    });
