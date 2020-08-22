<?php
$currentRoute = explode('.', \Request::route()->getName());
$routeAction = end($currentRoute);
?>
@if($routeAction == 'create')
    {!! Form::open(array('method' => 'POST', 'route' => array('products.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
@endif

@if($routeAction == 'edit')
    {!! Form::model($result, array('route' => array('products.update', $result->id), 'method' => 'PATCH', 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
@endif
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-external-link-square"></i> &nbsp;
            {!! lang('products.product_detail') !!}
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        {!! Form::label('product_code', lang('products.product_code'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('product_code', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('product_name', lang('products.product_name'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('product_name', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('hsn_code', lang('hsn_code.hsn_code'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::select('hsn_code', $hsnCode , isset($result->hsn_id) ? $result->hsn_id : null, array('class' => 'form-control select2', 'id'=>'hsn_code')) !!}
                        </div>
                        <div class="col-sm-1 hidden">
                            <a href="javascript:void(0);" class="btn btn-primary pull-right dEdit" data-title="{!! lang('hsn_code.add_hsn_code') !!}" data-route="{{ route('hsn-code.hsn-modal') }}" data-setting=""><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="form-group" id="product-group">
                        {!! Form::label('product_group', lang('products.product_group'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::select('product_group', $groups, isset($result->product_group_id) ? $result->product_group_id : null, array('class' => 'form-control select2','id'=>'product-group')) !!}
                        </div>
                        <div class="col-sm-1 hidden">
                            <a href="javascript:void(0);" class="btn btn-primary pull-right  dEdit" data-title="{!! lang('product_group.add_product_group') !!}" data-route="{{ route('product-group.product-group-modal') }}" data-setting=""><i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('unit', lang('products.unit'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::select('unit', $unit, isset($result->unit_id) ? $result->unit_id : null, array('class' => 'form-control select2', 'id' => 'unit')) !!}
                        </div>
                        <div class="col-sm-1 hidden">
                            <a href="javascript:void(0);" class="btn btn-primary pull-right  dEdit" data-title="{!! lang('unit.add_unit') !!}" data-route="{{ route('unit.unit-modal') }}" data-setting=""><i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    <div class="form-group hidden">
                        {!! Form::label('discount', lang('products.discount') . '&nbsp;', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('discount', isset($result->discount) ? $result->discount : null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::checkbox('status', '1', true) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        {!! Form::label('cost', lang('products.mrp') . '&nbsp;', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::text('cost',  isset($result->cost) ? $result->cost : null, array('class' => 'form-control', 'placeholder'=>'Optional')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('tax_group', lang('products.tax_group'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-7">
                            {!! Form::select('tax_group', $tax, isset($result->tax_id) ? $result->tax_id : null, array('class' => 'form-control select2')) !!}
                        </div>
                        <div class="col-sm-1 hidden">
                            <a href="javascript:void(0);" class="btn btn-primary pull-right dEdit" data-title="{!! lang('tax.add_tax') !!}" data-route="{{ route('tax.tax-modal') }}" data-setting=""><i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    <div class="form-group hidden">
                        {!! Form::label('minimum_level', lang('products.minimum_level'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('minimum_level', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group hidden">
                        {!! Form::label('reorder_level', lang('products.reorder_level'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('reorder_level', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group hidden">
                        {!! Form::label('maximum_level', lang('products.maximum_level'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('maximum_level', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group hidden">
                        {!! Form::label('alternate_quantity', lang('products.alternate_quantity'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('alternate_quantity', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label('description', lang('products.description'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::textarea('description', isset($result->product_description) ? $result->product_description : null, array('class' => 'form-control', 'size' => '5x3')) !!}
                        </div>
                    </div>

                    <div class="form-group hidden">
                        {!! Form::label('opening_balance', lang('products.opening_balance'), array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!! Form::text('opening_balance', isset($result->opening_balance) ? $result->opening_balance : 0, array('class' => 'form-control', 'size' => '5x3')) !!}
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 margintop10 clearfix text-center">
                    <div class="form-group">
                        {{--{!! Form::hidden('tab', 1) !!}--}}
                        {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary btn-lg')) !!}
                    </div>
                </div>

            </div>
        </div>
        <!-- end: TEXT FIELDS PANEL -->
    </div>
    {!! Form::close() !!}
</div>
{!! Form::close() !!}