@extends('layouts.admin')
@section('content_header')
    <section class="content-header">

        <h1>
            {!! lang('user.user_detail') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('user.index') !!}">{!! lang('user.user') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('user.user')) !!}</li>
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
            {!! Form::open(array('method' => 'POST', 'route' => array('user.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>
                        {!! lang('user.user_detail') !!}
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('username', lang('user.username'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('username', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                @if(isSuperAdmin())
                                <div class="form-group">
                                    {!! Form::label('hospital', lang('user.hospital'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('hospital_id', $hospital, null, array('class' => 'form-control select2')) !!}
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        <label class="checkbox col-sm-4">
                                            {!! Form::checkbox('status', '1', true) !!}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">

                                <div class="form-group">
                                    {!! Form::label('email', lang('user.email'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('email', null, array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password', lang('user.password'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::password('password', array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('role', lang('user.role'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('role', $role , null, array('class' => 'form-control select2')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-11 margintop5 clearfix text-center">
                                <div class="form-group">
                                    {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary btn-lg')) !!}
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
