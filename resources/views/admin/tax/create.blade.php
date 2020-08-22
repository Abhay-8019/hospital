@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('tax.tax') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('tax.index') !!}">{!! lang('tax.taxes') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('tax.tax')) !!}</li>
        </ol>
    </section>
@stop
@section('content')
<div id="page-wrapper">
    {{-- for message rendering --}}
    @include('layouts.messages')
    <div class="row">
        <div class="col-md-12 padding0">
            {!! Form::open(array('method' => 'POST', 'route' => array('tax.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
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
                                        {!! Form::text('cgst_rate', null, array('class' => 'form-control', 'id' => 'cgst_rate')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('sgst', lang('tax.sgst'), array('class' => 'col-sm-3 control-label')) !!}

                                    <div class="col-sm-6">
                                        {!! Form::text('sgst_rate', null, array('class' => 'form-control', 'id' => 'sgst_rate')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('igst', lang('tax.igst'), array('class' => 'col-sm-3 control-label')) !!}

                                    <div class="col-sm-6">
                                        {!! Form::text('igst_rate', null, array('class' => 'form-control', 'id' => 'igst_rate')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('status', lang('tax.tax_type') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-7 margintop8">
                                        @foreach(taxType() as $typeId => $typeName)
                                            {!! Form::radio('tax_type', $typeId, ($typeId == 0) ? true : false) !!}
                                            {!! $typeName !!} &nbsp;&nbsp;&nbsp;
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-5 margintop8">
                                         {!! Form::checkbox('status', 1, true) !!}
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
            </div>
            {!! Form::close() !!}
        </div>    
    </div>
</div>
<!-- /#page-wrapper -->
@stop