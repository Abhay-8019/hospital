@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('common.edit_heading', lang('event_type.event_type')) !!} #{!! $result->event_type !!}
            <small>{!! lang('common.record_update') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
            <li><a href="{!! route('event_type.index') !!}">{!! lang('event_type.event_type') !!}</a></li>
            <li class="active">{!! lang('common.edit_heading', lang('event_type.event_type')) !!}</li>
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
                {!! Form::model($result, array('route' => array('event_type.update', $result->id), 'method' => 'PATCH', 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
                        <!-- previous building form id => building-form -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('event_type.event_type_detail') !!}
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group required">
                                        {!! Form::label('event_type', lang('event_type.event_type'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('event_type', ($result->event_type) ? $result->event_type : null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-5 margintop8">
                                            {!! Form::checkbox('status', '1', ($result->status == '1') ? true : false) !!}
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