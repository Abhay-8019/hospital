@extends('layouts.admin')

@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('user.user') !!} #{!! $user->username !!}
            <small>{!! lang('common.record_update') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
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
                {!! Form::open(array('route' => array('password.update'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('common.change_password') !!}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        {!! Form::label('user_name', lang('common.user_name'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! \Auth::user()->username !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('email', lang('common.email'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! \Auth::user()->email !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('old_password', lang('common.old_password'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-6">
                                            {!! Form::password('password', array('class' => 'form-control' )) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('new_password', lang('common.new_password'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-6">
                                            {!! Form::password('new_password', array('class' => 'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('confirm_password', lang('common.confirm_password'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-6">
                                            {!! Form::password('confirm_password', array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 margintop10 text-center">
                                    <div class="form-group marginright15">
                                        {!! Form::submit(lang('common.change_password'), array('class' => 'btn btn-primary btn-lg')) !!}
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
    </div>
@stop