@extends('layouts.admin')
@section('content_header')
	<section class="content-header">
		<div class="pull-right">
			<a class="btn btn-danger btn-xs" href="{!! route('user.create') !!}">
				<i class="fa fa-plus-circle"></i> {!! lang('common.create_heading', lang('user.user')) !!}
			</a>
		</div>
		<h1>
			{!! lang('user.user_detail') !!}
			<small>{!! lang('common.list_record') !!}</small>
		</h1>
		<ol class="breadcrumb hidden">
			<li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
			<li class="active">{!! lang('user.user') !!}</li>
			<li><a href="{!! route('user.create') !!}">{!! lang('common.create_heading', lang('user.user')) !!}</a></li>
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
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-external-link-square"></i> &nbsp;
					{!! lang('user.users_list') !!}
				</div>
				<div class="panel-body">
					<form id="serachable" action="{{ route('user.action') }}" method="post">
					<div class="col-md-3 text-right pull-right padding0 marginbottom10">
						{!! lang('common.per_page') !!}: {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!}
					</div>
					<div class="col-md-3 padding0 marginbottom10">
						{!! Form::hidden('page', 'search') !!}
						{!! Form::hidden('_token', csrf_token()) !!}
						{{--{!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search User by name')) !!}--}}
					</div>
					<table id="paginate-load" data-route="{{ route('user.paginate') }}" class="table table-hover clearfix margin0 col-md-12 padding0">
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
