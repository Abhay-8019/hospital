@extends('layouts.admin')

@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('common.edit_heading', lang('tax.tax')) !!} #{!! $result->name !!}
            <small>{!! lang('common.record_update') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('tax.index') !!}">{!! lang('tax.tax') !!}</a></li>
            <li class="active">{!! lang('common.edit_heading', lang('tax.tax')) !!}</li>
        </ol>
    </section>
@stop

@section('content')
<div id="page-wrapper">
    {{-- for message rendering --}}
    @include('layouts.messages')
    <div class="row">
        <div class="col-md-12 padding0">
        {!! Form::model($result, array('route' => array('tax.update', $result->id), 'method' => 'PATCH', 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> &nbsp;
                        {!! lang('tax.tax_detail') !!}
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('cgst', lang('tax.cgst'), array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('cgst_rate', $cgst, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('sgst', lang('tax.sgst'), array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('sgst_rate', $sgst, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('igst', lang('tax.igst'), array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('igst_rate', $igst, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('status', lang('tax.tax_type') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-8 margintop8">
                                    @foreach(taxType() as $typeId => $typeName)
                                        {!! Form::radio('tax_type', $typeId, ($typeId == $result->tax_type) ? true : false) !!}
                                        {!! $typeName !!} &nbsp;&nbsp;&nbsp;
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-5 margintop8">
                                     {!! Form::checkbox('status', 1, ($result->status == 1) ? true : false) !!}
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="col-sm-12 margintop20 clearfix text-center">
                            <div class="form-group">
                                {!! Form::submit(lang('common.update'), array('class' => 'btn btn-primary btn-lg')) !!}
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