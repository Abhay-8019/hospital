@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('financial_year.financial_year_detail') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('financial-year.index') !!}">{!! lang('financial_year.financial_year') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('financial_year.financial_year')) !!}</li>
        </ol>
    </section>
@stop
@section('content')
<!-- start: PAGE HEADER -->
@include('layouts.messages')
<div class="row clearfix">
    <div class="col-md-12">
    <!-- start: BASIC TABLE PANEL -->
    {!! Form::open(array('method' => 'POST', 'route' => array('financial-year.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-external-link-square"></i> &nbsp;
            {!! lang('financial_year.financial_year') !!}
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('from_date', lang('financial_year.from_date'), array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('from_date', null, array('class' => 'form-control date-picker')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('to_date', lang('financial_year.to_date'), array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('to_date', null, array('class' => 'form-control date-picker')) !!}
                        </div>
                    </div>
                    <div class="form-group hidden">
                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 col-xs-3 control-label')) !!}
                        <div class="col-sm-5 col-xs-5 margintop5">
                            {!! Form::checkbox('status', '1', true) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 margintop20 clearfix text-center">
                <div class="form-group">
                    {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary btn-lg')) !!}
                </div>
            </div>

        </div>
    </div>
    <!-- end: TEXT FIELDS PANEL -->
    {!! Form::close() !!}
    </div>
</div>
@stop

