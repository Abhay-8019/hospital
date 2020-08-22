@extends('layouts.admin')

@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('common.edit_heading', lang('product_group.product_group')) !!} #{!! $result->name !!}
            <small>{!! lang('common.record_update') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('product-group.index') !!}">{!! lang('product_group.product_group') !!}</a></li>
            <li class="active">{!! lang('common.edit_heading', lang('product_group.product_group')) !!}</li>
        </ol>
    </section>
@stop

@section('content')
    <div id="page-wrapper">
        {{-- for message rendering --}}
        @include('layouts.messages')
        <div class="row">
            <div class="col-md-12 padding0">
                @include('admin.product-group.form_common')
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
@stop