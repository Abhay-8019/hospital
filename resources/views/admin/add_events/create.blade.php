@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('event.event_detail') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
            <li><a href="{!! route('add_events.index') !!}">{!! lang('event.add_events') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('event.add_events')) !!}</li>
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
                {!! Form::open(array('method' => 'POST', 'route' => array('add_events.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
                        <!-- previous add_events form id => add_events-form -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('event.event_detail') !!}
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group required">
                                        {!! Form::label('event_code', lang('event.event_code'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('event_code', $eventCode, array('class' => 'form-control', 'readonly')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('is_holiday', lang('event.is_holiday') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-5 margintop8">
                                            {!! Form::checkbox('is_holiday', '1', false, ['data-target' => 'event_type_div', 'data-target_input' => 'event_type']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('event_start', lang('event.event_start'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('event_start', null, array('class' => 'form-control date-time-picker')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('event_for', lang('event.event_for'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::select('event_for',  $eventFor, null, array('class' => 'form-control select2', 'data-target'  => 'department_div', 'data-target_input'  => 'department')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-5 margintop8">
                                            {!! Form::checkbox('status', '1', true) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('event_name', lang('event.event_name'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('event_name', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group event_type_div">
                                        {!! Form::label('event_type', lang('event.event_type'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::select('event_type',  $eventTypeService, null, array('class' => 'event_type form-control select2')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('event_end', lang('event.event_end'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('event_end', null, array('class' => 'form-control date-time-picker')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group department_div" style="display: none;">
                                        {!! Form::label('department', lang('event.department'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::select('department[]',  $departmentService, null, array('class' => 'department form-control select2 padding0', 'multiple', 'data-placeholder' => '-Select Department-')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('event_description', lang('event.event_description'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::textarea('event_description', null, array('class' => 'form-control', 'rows' => 3, 'cols' => 50)) !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-11 margintop20 clearfix text-center">
                                    <div class="form-group">
                                        {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary')) !!}
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
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".select2.department option[value='']").remove();


           $(document).on('click', '#is_holiday', function() {
               var target = $(this).data('target');
               var targetInput = $(this).data('target_input');
               if($(this).is(' :checked')) {
                   $('.' + targetInput).val('').trigger('change');
                   $('.' + target).fadeOut();
               }else {
                   $('.' + targetInput).val('').trigger('change');
                   $('.' + target).fadeIn();
               }
           });

           $(document).on('change', '#event_for', function() {
               var value = $(this).val();
               var target = $(this).data('target');
               var targetInput = $(this).data('target_input');
               if(value != '' && value > 1) {
                   $('.' + targetInput).val('').trigger('change');
                   $('.' + target).fadeIn();
               }else {
                   $('.' + targetInput).val('').trigger('change');
                   $('.' + target).fadeOut();
               }
           });
        });
    </script>
@stop