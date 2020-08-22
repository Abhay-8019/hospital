@extends('layouts.admin')

@section('content_header')
	<section class="content-header">
		<div class="pull-right">
			<a class="btn btn-danger btn-xs" href="{!! route('product-group.create') !!}">
				<i class="fa fa-plus-circle"></i> {!! lang('common.create_heading', lang('product_group.product_group')) !!}
			</a>
		</div>
		<h1>
			{!! lang('product_group.product_groups') !!}
			<small>{!! lang('common.list_record') !!}</small>
		</h1>
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
				<div class="panel-heading">
					<i class="fa fa-external-link-square"></i> &nbsp;
					{!! lang('product_group.product_groups_list') !!}
				</div>
				<div class="panel-body">
					<div class="col-md-3 text-right pull-right padding0 marginbottom10">
						{!! lang('common.per_page') !!}: {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!}
					</div>
					<div class="col-md-3 padding0 marginbottom10">
						{!! Form::hidden('page', 'search') !!}
						{!! Form::hidden('_token', csrf_token()) !!}
						{!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => lang('common.search_heading', lang('product_group.product_group')))) !!}
					</div>
					<table id="paginate-load" data-route="{{ route('product-group.paginate') }}" class="table table-responsive table-hover clearfix margin0 col-md-12 padding0">
					</table>
				</div>
			</div>
			<!-- end: BASIC TABLE PANEL -->
		</div>	
	</div>
</div>
<!-- /#page-wrapper -->
@stop
