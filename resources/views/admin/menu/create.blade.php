@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('menu.menu_detail') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
            <li><a href="{!! route('menu.index') !!}">{!! lang('menu.menu') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('menu.menu')) !!}</li>
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
            {!! Form::open(array('method' => 'POST', 'route' => array('menu.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading base-panel-color">
                        <i class="fa fa-external-link-square"></i> &nbsp;
                        {!! lang('menu.menu_detail') !!}
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('display_name', lang('menu.display_name'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('display_name', null, array('class' => 'display_name form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('route_name', lang('menu.route_name'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('route_name', null, array('class' => 'route_name form-control')) !!}
                                </div>
                            </div>                           

                            <div class="form-group">
                                {!! Form::label('icon', lang('menu.icon'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('icon', null, array('class' => 'menuicon form-control')) !!}
                                </div>
                            </div>

                            
                            <div class="form-group">
                                {!! Form::label('parent_menu', lang('menu.parent_menu'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::select('parent_menu', $parentdata,'', array('class' => 'select2 parent_menu form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('depend_routes', lang('menu.depend_routes'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::textarea('dependent_routes', null, array('class' => 'depend_routes form-control', 'rows'=>'3')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <label class="checkbox col-sm-3">
                                        {!! Form::checkbox('status', '1', true) !!}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('order', lang('menu.order'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-3">
                                     {!! Form::text('order', null, array('class' => 'order form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('for_devs', lang('menu.for_devs'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <label class="checkbox col-sm-3">
                                        {!! Form::checkbox('for_devs', '1', false,array('class'=>'for_devs')) !!}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('is_in_menu', lang('menu.is_in_menu'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <label class="checkbox col-sm-3">
                                        {!! Form::checkbox('is_in_menu', '1', false,array('class'=>'is_in_menu')) !!}
                                    </label>
                                </div>
                           </div>
                           <div class="form-group">
                                {!! Form::label('quick_menu', lang('menu.quick_menu'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <label class="checkbox col-sm-3">
                                        {!! Form::checkbox('quick_menu', '1', false,array('class'=>'quick_menu')) !!}
                                    </label>
                                </div>
                           </div>
                           <div class="form-group">
                                {!! Form::label('is_common', lang('menu.is_common'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <label class="checkbox col-sm-3">
                                        {!! Form::checkbox('is_common', '1', false,array('class'=>'is_common')) !!}
                                    </label>
                                </div>
                           </div>
                           <div class="form-group">
                                {!! Form::label('has_child', lang('menu.has_child'), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <label class="checkbox col-sm-3">
                                        {!! Form::checkbox('has_child', '1', false,array('class'=>'has_child')) !!}
                                    </label>
                                </div>
                           </div>

                         </div>
                        <div class="col-sm-12 margintop10 clearfix text-center">
                            <div class="form-group">
                                {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary', 'id' => 'menu_submit')) !!}
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