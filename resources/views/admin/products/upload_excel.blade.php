@extends('layouts.admin-new')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-sm btn-default pull-right margintop10 _back" href="javascript:void(0)"> <i class="fa fa-arrow-left fa-fw"></i> {!! lang('common.back') !!} </a>
                <h1 class="page-header margintop10">{!! lang('products.upload_excel') !!}</h1>
            </div>
        </div>

        {{-- for message rendering --}}
        @include('layouts.messages')
        <div class="row">
            <div class="col-md-12 padding0">
                <div class="col-md-6">
                    <div class="panel panel-default import-tabs">
                        <div class="panel-heading">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <li class="active"><a href="#tab1" data-toggle="tab">{!! lang('common.import') !!}</a></li>
                                <li><a href="#tab2" data-toggle="tab">{!! lang('common.export') !!}</a></li>
                            </ul>
                            {{--<i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('products.product_detail') !!}--}}
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    {!! Form::open(array('method' => 'POST', 'route' => array('products.upload-excel'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 paddingleft8">
                                                    <small>Please checkout this sample file before import.</small>
                                                    <a href="{!! route('products.download-sample-excel') !!}" class="" target="_blank" title="Download Sample Export Excel">
                                                        {!! lang('products.download_product_sample') !!}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('file', lang('common.file'), array('class' => 'col-sm-4 control-label')) !!}
                                                <div class="col-sm-5 margintop10">
                                                    {!! Form::file('file', null, array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 margintop10 clearfix text-center">
                                        <div class="form-group">
                                            {!! Form::submit(lang('common.upload'), array('class' => 'btn btn-primary')) !!}
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <a href="{!! route('products.generate-excel') !!}" class="btn btn-primary" title="Export Excel">{!! lang('common.export') !!}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>

            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
@stop