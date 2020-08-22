@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <div class="pull-right">
            <a class="btn btn-danger btn-xs" href="{!! route('financial-year.create') !!}">
                <i class="fa fa-plus-circle"></i> {!! lang('common.create_heading', lang('financial_year.financial_year')) !!}
            </a>
        </div>
        <h1>
            {!! lang('financial_year.financial_years') !!}
            <small>{!! lang('common.list_record') !!}</small>
        </h1>
    </section>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{-- for message rendering --}}
            @include('layouts.messages')
            <!-- start: BASIC TABLE PANEL -->
            <div class="panel panel-default" style="position: static;">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> &nbsp;
                    {!! lang('financial_year.financial_years_list') !!}
                </div>
                <div class="panel-body">
                    <form id="serachable" action="{{ route('financial-year.action') }}" method="post">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right pull-right padding0 marginbottom10">
                            {!! lang('common.per_page') !!}: {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 padding0 marginbottom10">
                            {!! Form::hidden('page', 'search') !!}
                            {!! Form::hidden('_token', csrf_token()) !!}
                            {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => lang('common.search_heading', lang('financial_year.financial_year')))) !!}
                        </div>
                        <table id="paginate-load" data-route="{{ route('financial-year.paginate') }}" class="table table-responsive table-hover clearfix margin0 col-md-12 padding0 table-fullbox">
                        </table>
                    </form>
                </div>
            </div>
            <!-- end: BASIC TABLE PANEL -->
        </div>
    </div>
@stop
