@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('specialization.specialization_detail') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('specialization.index') !!}">{!! lang('specialization.specializations') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('specialization.specialization')) !!}</li>
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
                {!! Form::open(array('method' => 'POST', 'route' => array('specialization.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
                        <!-- previous floor form id => floor-form -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('specialization.specialization_detail') !!}
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group required">
                                        {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-5 margintop8">
                                            {!! Form::checkbox('status', '1', true) !!}
                                        </div>
                                    </div>
                                </div>

                                </div>

                                <div class="col-sm-11 margintop20 clearfix text-center">
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

