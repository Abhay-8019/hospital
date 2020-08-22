@extends('layouts.admin')
@section('content_header')
<section class="content-header">
    <h1>
        {!! lang('common.edit_heading', lang('building.building')) !!} #{!! $result->name !!}
        <small>{!! lang('common.record_update') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
        <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
        <li><a href="{!! route('building.index') !!}">{!! lang('building.building') !!}</a></li>
        <li class="active">{!! lang('common.edit_heading', lang('building.building')) !!}</li>
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
        {!! Form::model($result, array('route' => array('building.update', $result->id), 'method' => 'PATCH', 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
            <!-- previous building form id => building-form -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> &nbsp;
                        {!! lang('building.building_detail') !!}
                    </div>
                    <div class="panel-body">

                        <div class="row">
                           <div class="col-sm-6">
                               <div class="form-group required">
                                   {!! Form::label('building_code', lang('building.building_code'), array('class' => 'col-sm-3 control-label')) !!}

                                   <div class="col-sm-8">
                                       {!! Form::text('building_code', ($result->building_code) ? $result->building_code : null, array('class' => 'form-control', 'readonly')) !!}
                                   </div>
                               </div>

                               <div class="form-group required">
                                   {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}

                                   <div class="col-sm-8">
                                       {!! Form::text('name', ($result->name) ? $result->name : null, array('class' => 'form-control')) !!}
                                   </div>
                               </div>

                               <div class="form-group required">
                                   {!! Form::label('no_of_floors', lang('building.no_of_floors'), array('class' => 'col-sm-3 control-label')) !!}

                                   <div class="col-sm-8">
                                       {!! Form::text('no_of_floors', ($result->no_of_floors) ? $result->no_of_floors : null, array('class' => 'form-control')) !!}
                                   </div>
                               </div>

                               <div class="form-group">
                                   {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                   <div class="col-sm-5 margintop8">
                                       {!! Form::checkbox('status', '1', ($result->status == '1') ? true : false) !!}
                                   </div>
                               </div>
                           </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('location', lang('building.building_location'), array('class' => 'col-sm-3 control-label')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::textarea('location', ($result->location) ? $result->location : null, array('class' => 'form-control', 'rows' => 4, 'cols' => 50)) !!}
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