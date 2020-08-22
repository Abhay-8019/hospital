@extends('layouts.admin')
@section('content_header')
	<section class="content-header">
		<h1>
			{!! lang('menu.menu_detail') !!}
			<small>{!! lang('common.list_record') !!}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
			<li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
			<li class="active">{!! lang('menu.menu') !!}</li>
			<li><a href="{!! route('menu.create') !!}">{!! lang('common.create_heading', lang('menu.menu')) !!}</a></li>
		</ol>
	</section>
@stop
@section('content')
<div id="page-wrapper">
	{{-- for message rendering --}}
    @include('layouts.messages')
    <div class="row">
    	<div class="col-md-12">
		<!-- start: BASIC TABLE PANEL -->
		<div class="panel panel-default" style="position: static;">
			<div class="panel-heading base-panel-color">
				<i class="fa fa-external-link-square"></i> &nbsp;
				{!! lang('menu.menu_list') !!}
			</div>
			<div class="panel-body">
				<form action="{{ route('menu.action') }}" method="post">
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right pull-right padding0 marginbottom10">
					{!! lang('common.per_page') !!}: {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!}
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 padding0 marginbottom10">
					{!! Form::hidden('page', 'search') !!}
					{!! Form::hidden('_token', csrf_token()) !!}
					{!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search Menu by name')) !!}
				</div>
					<div class="table-responsive col-md-12 padding0">
						<table id="paginate-load" data-route="{{ route('menu.paginate') }}" class="table table-hover clearfix margin0 col-md-12 padding0">
							{{--data-sorting="{{ route('menu.sorter') }}"--}}
						</table>
					</div>
				</form>
			</div>
		</div>
		<!-- end: BASIC TABLE PANEL -->
		</div>	
	</div>
</div>
<!-- /#page-wrapper -->
@stop
