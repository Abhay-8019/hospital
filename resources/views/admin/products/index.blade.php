@extends('layouts.admin')

@section('content_header')
	<section class="content-header">
		<div class="pull-right">
			<a class="btn btn-danger btn-xs" href="{!! route('products.create') !!}">
				<i class="fa fa-plus-circle"></i> {!! lang('common.create_heading', lang('products.product')) !!}
			</a>
		</div>
		<h1>
			{!! lang('products.products') !!}
			<small>{!! lang('common.list_record') !!}</small>
		</h1>
	</section>
@stop

@section('content')
<div id="page-wrapper">
	{{-- for message rendering --}}
    @include('layouts.messages')
	<div class="col-md-12 padding0">
		{!! Form::open(array('method' => 'POST',
			'route' => array('products.paginate'), 'id' => 'ajaxForm')) !!}
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					{!! Form::label('product_group', lang('products.product_group'), array('class' => 'control-label')) !!}
					{!! Form::select('product_group', $groups, (isset($inputs['product_group'])) ? $inputs['product_group'] : '', array('class' => 'form-control padding0 select2')) !!}
				</div>
			</div>

			<div class="col-sm-3 margintop20">
				<div class="form-group">
					{!! Form::hidden('form-search', 1) !!}
					{!! Form::submit(lang('common.filter'), array('class' => 'btn btn-primary')) !!}
					<a href="{!! route('products.index') !!}" class="btn btn-primary"> {!! lang('common.reset_filter') !!}</a>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
    <div class="row">
    	<div class="col-md-12">
			<!-- start: BASIC TABLE PANEL -->
			<div class="panel panel-default" style="position: static;">
				<div class="panel-heading">
					<i class="fa fa-external-link-square"></i> &nbsp;
					{!! lang('products.product_list') !!}
					<div class="pull-right hidden">
						<a href="{!! route('products.upload-excel') !!}" class="btn btn-success btn-xs" title="Import Excel"><i class="fa fa-cloud-upload"></i></a>
						<a href="{!! route('products.generate-excel') !!}" class="btn btn-success btn-xs" title="Export Excel"><i class="fa fa-cloud-download"></i></a>
					</div>
				</div>
				<div class="panel-body">
					<form action="{{ route('products.action') }}" method="post">
					<div class="col-md-3 text-right pull-right padding0 marginbottom10">
						{!! lang('common.per_page') !!}: {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!}
					</div>
					<div class="col-md-3 padding0 marginbottom10">
						{!! Form::hidden('page', 'search') !!}
						{!! Form::hidden('page-no', session('p_page', 1), ['id' => 'page-no']) !!}
						{!! Form::hidden('_token', csrf_token()) !!}
						{!! Form::text('keyword', null, array('class' => 'form-control  live-search', 'placeholder' => lang('common.search_heading', lang('products.product')))) !!}
					</div>
					<table id="paginate-load" data-route="{{ route('products.paginate') }}" class="table table-responsive table-hover clearfix margin0 col-md-12 padding0">
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
