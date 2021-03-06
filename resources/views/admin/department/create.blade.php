@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('department.department_detail') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('department.index') !!}">{!! lang('department.departments') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('department.department')) !!}</li>
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
            {!! Form::open(array('method' => 'POST', 'route' => array('department.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
            <!-- department-form -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> &nbsp;
                        {!! lang('department.department_detail') !!}
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    {!! Form::label('code', lang('common.code'), array('class' => 'col-sm-3 control-label')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::text('code', $departmentCode, array('class' => 'form-control', 'readonly')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Department Name')) !!}
                                    </div>
                                </div>

                                <div class="form-group required hide">
                                    {!! Form::label('head_name', lang('department.head_name'), array('class' => 'col-sm-3 control-label')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::text('head_name', null, array('class' => 'form-control', 'placeholder' => 'Head Name')) !!}
                                    </div>
                                </div>

                                <div class="form-group hide">
                                    {!! Form::label('address', lang('department.address'), array('class' => 'col-sm-3 control-label')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::textarea('address', null, array('class' => 'form-control', 'address' => '5x6', 'cols' => 50, 'rows' => 4, 'placeholder' => 'Head Address')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-5 margintop8">
                                        {!! Form::checkbox('status', '1', true) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">

                                <div class="form-group required hide">
                                    {!! Form::label('floor_id', lang('department.floor_name'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('floor_id', $floorName, null, array('class' => 'form-control select2 padding0')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('description', lang('common.description'), array('class' => 'col-sm-4 control-label')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::textarea('description', null, array('class' => 'form-control', 'department' => '5x6', 'cols' => 50, 'rows' => 4, 'placeholder' => 'Department Description')) !!}
                                    </div>
                                </div>

                                <div class="form-group required hide">
                                    {!! Form::label('contact_number', lang('department.head_contact'), array('class' => 'col-sm-4 control-label')) !!}

                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">{!! lang('common.isd_code_india') !!}</span>
                                            {!! Form::text('contact_number', null, array('class' => 'form-control', 'placeholder' => 'Head Contact Number')) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-10 margintop20 clearfix text-center">
                            <div class="form-group">
                                {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary btn-lg')) !!}
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