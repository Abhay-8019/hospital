@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('category.category_detail') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
            <li><a href="{!! route('category.index') !!}">{!! lang('category.category') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('category.category')) !!}</li>
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
                {!! Form::open(array('method' => 'POST', 'route' => array('category.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('category.category') !!}
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group required">
                                        {!! Form::label('vendorName', lang('category.vendor_name'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::select('vendor_id', $vendorName,  null, array('class' => 'form-control')) !!}
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

                                        {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                        </div>

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

