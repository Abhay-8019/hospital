@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('room.room_detail') !!}
            <small>{!! lang('common.list_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
            <li class="active">{!! lang('room.room') !!}</li>
            <li class="hidden"><a href="{!! route('room.create') !!}">{!! lang('common.create_heading', lang('room.room')) !!}</a></li>
        </ol>
    </section>
@stop
@section('content')
    <div id="page-wrapper">
        {{-- for message rendering --}}
        @include('layouts.messages')

        <div class="row">

            <div class="row">
                <div class="col-md-12 padding0">
                    {!! Form::open(array('method' => 'POST', 'route' => array('room.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
                            <!-- previous room form id => room-form -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i> &nbsp;
                                {!! lang('room.room_detail') !!}
                            </div>
                            <div class="panel-body">
                                <div class="row">

                                        <div class="form-group">
                                            {!! Form::label('room_code', lang('room.room_code'), array('class' => 'col-sm-1 control-label')) !!}

                                            <div class="col-sm-1">
                                                {!! Form::text('room_code', $roomCode, array('class' => 'form-control', 'readonly')) !!}
                                            </div>

                                            {!! Form::label('room_name', lang('room.room_name'), array('class' => 'col-sm-1 control-label')) !!}

                                            <div class="col-sm-1">
                                                {!! Form::text('room_name', null, array('class' => 'form-control')) !!}
                                            </div>

                                            {!! Form::label('room_charges', lang('room.room_charges'), array('class' => 'col-sm-1 control-label')) !!}

                                            <div class="col-sm-1">
                                                {!! Form::text('room_charges', null, array('class' => 'form-control')) !!}
                                            </div>

                                            {!! Form::label('floor_id', lang('room.floor'), array('class' => 'col-sm-1 control-label')) !!}
                                            <div class="col-sm-2">
                                                {!! Form::select('floor_id', $floorName, null, array('class' => 'form-control select2 padding0')) !!}
                                            </div>

                                            {!! Form::label('room_type', lang('room.room_type'), array('class' => 'col-sm-1 control-label')) !!}
                                            <div class="col-sm-2">
                                                {!! Form::select('room_type', $roomType, null, array('class' => 'form-control select2 padding0')) !!}
                                            </div>
                                        </div>
                                    <div class="form-group">
                                            {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-1 control-label')) !!}
                                            <div class="col-sm-1 margintop8">
                                                {!! Form::checkbox('status', '1', true) !!}
                                            </div>
                                        </div>

                                        <div class="col-sm-11 margintop20 clearfix text-center">
                                            <div class="form-group">
                                            {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                </div>
                            </div>
                        <!-- end: TEXT FIELDS PANEL -->
                        </div>
                    {!! Form::close() !!}
                    </div>
                </div>

                <div class="col-md-12">
                <!-- start: BASIC TABLE PANEL -->
                <div class="panel panel-default" style="position: static;">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> &nbsp;
                        {!! lang('room.room_list') !!}
                    </div>
                    <div class="panel-body">
                        <form id="serachable" action="{{ route('room.action') }}" method="post">
                            <div class="col-md-3 text-right pull-right padding0 marginbottom10">
                                {!! lang('common.per_page') !!}: {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!}
                            </div>
                            <div class="col-md-3 padding0 marginbottom10">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                                {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search room by name')) !!}
                            </div>
                            <table id="paginate-load" data-route="{{ route('room.paginate') }}" class="table table-hover clearfix margin0 col-md-12 padding0">
                            </table>
                        </form>
                    </div>
                </div>
                <!-- end: BASIC TABLE PANEL -->
            </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
@stop