@extends('layouts.admin')

@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('products.product') !!}
            <small>{!! lang('common.add_record') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('products.index') !!}">{!! lang('products.products') !!}</a></li>
            <li class="active">{!! lang('common.create_heading', lang('products.product')) !!}</li>
        </ol>
    </section>
@stop

@section('content')
    <div id="page-wrapper">
        {{-- for message rendering --}}
        @include('layouts.messages')
        <div class="row">
            <div class="col-md-12 padding0">
                @include('admin.products.form_common')
            </div>
        </div>
    </div>
@stop