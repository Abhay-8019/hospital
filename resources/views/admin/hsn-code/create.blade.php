@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('hsn_code.hsn_code') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('hsn-code.index') !!}">{!! lang('hsn_code.hsn_codes') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('hsn_code.hsn_code')) !!}</li>
        </ol>
    </section>
@stop
@section('content')
<div id="page-wrapper">
    {{-- for message rendering --}}
    @include('layouts.messages')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-md-12 col-sm-12 padding0">
            @include('admin.hsn-code.form_common')
        </div>
    </div>
</div>
@stop