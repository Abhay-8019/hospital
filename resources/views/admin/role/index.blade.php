@extends('layouts.admin')
@section('content_header')
	<section class="content-header">
		<div class="pull-right">
			<a class="btn btn-danger btn-xs" href="{!! route('role.create') !!}">
				<i class="fa fa-plus-circle"></i> {!! lang('common.create_heading', lang('role.role')) !!}
			</a>
		</div>
		<h1>
			{!! lang('role.roles') !!}
			<small>{!! lang('common.list_record') !!}</small>
		</h1>
		<ol class="breadcrumb hidden">
			<li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
			<li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
			<li class="active">{!! lang('role.role') !!}</li>
			<li><a href="{!! route('role.create') !!}">{!! lang('common.create_heading', lang('role.role')) !!}</a></li>
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
		<div class="panel panel-danger" style="position: static;">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i> &nbsp;
				{!! lang('role.roles_list') !!}
			</div>
			<div class="panel-body">
				<form id="serachable" action="{{ route('role.action') }}" method="post">
				<div class="col-md-3 text-right pull-right padding0 marginbottom10">
					{!! lang('common.per_page') !!}: {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!}
				</div>
				<div class="col-md-3 padding0 marginbottom10">
					{!! Form::hidden('page', 'search') !!}
					{!! Form::hidden('_token', csrf_token()) !!}
					{!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search role by name')) !!}
				</div>
				<table id="paginate-load" data-route="{{ route('role.paginate') }}" class="table table-hover clearfix margin0 col-md-12 padding0">
				</table>
				</form>
			</div>
		</div>
		<!-- end: BASIC TABLE PANEL -->
	   </div>	
	</div>	
</div>
<!-- /#page-wrapper -->
@stop
