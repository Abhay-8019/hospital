@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('common.edit_heading', lang('vendor.vendor')) !!} #{!! $result->company_name !!}
            <small>{!! lang('common.record_update') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
            <li><a href="{!! route('vendor.index') !!}">{!! lang('vendor.vendor') !!}</a></li>
            <li class="active">{!! lang('common.edit_heading', lang('vendor.vendor')) !!}</li>
        </ol>
    </section>
@stop
@section('content')
    <div id="page-wrapper">
        <!-- start: PAGE CONTENT -->

        {{-- for message rendering --}}
        @include('layouts.messages')
        <div class="row">
            <div class="col-md-12 padding0">
                {!! Form::model($result, array('route' => array('vendor.update', $result->id), 'method' => 'PATCH', 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
                        <!-- previous vendor form id => vendor-form -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('vendor.vendor_detail') !!}
                        </div>
                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group required">
                                        {!! Form::label('vendor_code', lang('vendor.vendor_code'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('vendor_code', ($result->vendor_code)? $result->vendor_code : null, array('class' => 'form-control', 'readonly')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('contact_number', lang('vendor.contact_number'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">{!! lang('common.isd_code_india') !!}</span>
                                                {!! Form::text('contact_number', ($result->contact_number)? $result->contact_number : null, array('class' => 'form-control', 'placeholder' => 'Enter Mobile Number', 'maxlength' => 10)) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('country', lang('patient.country'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('country', ($result->country)? $result->country : null, array('class' => 'form-control', 'placeholder' => 'Country')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('city', lang('patient.city'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('city', ($result->city)? $result->city : null, array('class' => 'form-control', 'placeholder' => 'City')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-5 margintop8">
                                            {!! Form::checkbox('status', '1', ($result->status == 1)? true : false) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group required">
                                        {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('name', ($result->name)? $result->name : null, array('class' => 'form-control', 'placeholder' => 'Full Name')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        {!! Form::label('email', lang('vendor.email'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('email', ($result->email)? $result->email : null, array('class' => 'form-control', 'placeholder' => 'Email Address')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('state', lang('patient.state'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('state', ($result->state)? $result->state : null, array('class' => 'form-control', 'placeholder' => 'State')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('zip_code', lang('patient.zip_code'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('zip_code', ($result->zip_code)? $result->zip_code : null, array('class' => 'form-control', 'placeholder' => 'Area Zip Code', 'maxlength' => 6)) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 clearfix">
                                    <strong>{!! lang('common.company_details') !!}</strong> :-
                                    <hr/>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group required">
                                        {!! Form::label('company_name', lang('common.company_name'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('company_name', ($result->company_name)? $result->company_name : null, array('class' => 'form-control', 'placeholder' => 'Company Name')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('company_phone', lang('vendor.phone_number'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            <div class="col-sm-4 padding0">
                                                {!! Form::text('std_code', ($stdCode)? $stdCode : null, array('class' => 'form-control', 'min' => 1, 'maxlength' => 4, 'placeholder' => 'STD CODE')) !!}
                                            </div>
                                            <div class="col-sm-8 paddingright0">
                                                {!! Form::text('company_phone', ($companyPhone)? $companyPhone : null, array('class' => 'form-control', 'placeholder' => 'Phone Number', 'min' => 1, 'maxlength' => 7)) !!}
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-5">
                                    <div class="form-group required">
                                        {!! Form::label('company_address', lang('common.company_address'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::textarea('company_address', ($result->company_address)? $result->company_address : null, array('class' => 'form-control', 'placeholder' => 'Company Address', 'rows' => 3, 'cols' => 50)) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('mobile', lang('vendor.mobile'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">{!! lang('common.isd_code_india') !!}</span>
                                                {!! Form::text('mobile', ($result->mobile)? $result->mobile : null, array('class' => 'form-control', 'placeholder' => 'Enter Mobile Number', 'maxlength' => 10)) !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12 clearfix">
                                    <strong>{!! lang('common.bank_details') !!}</strong> :-
                                    <hr/>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group required">
                                        {!! Form::label('bank_name', lang('common.bank_name'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('bank_name', ($result->bank_name)? $result->bank_name : null, array('class' => 'form-control', 'placeholder' => 'Bank Name')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('account_number', lang('common.account_number'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('account_number', ($result->account_number)? $result->account_number : null, array('class' => 'form-control', 'placeholder' => 'Account Number', 'min' => 1)) !!}
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-5">
                                    <div class="form-group required">
                                        {!! Form::label('branch_name', lang('common.branch_name'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('branch_name', ($result->branch_name)? $result->branch_name : null, array('class' => 'form-control', 'placeholder' => 'Branch Address')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('ifsc_code', lang('common.ifsc_code'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('ifsc_code', ($result->ifsc_code)? $result->ifsc_code : null, array('class' => 'form-control', 'placeholder' => 'IFSC Code')) !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-11 margintop20 clearfix text-center">
                                    <div class="form-group">
                                        {!! Form::submit(lang('common.update'), array('class' => 'btn btn-primary')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
@stop