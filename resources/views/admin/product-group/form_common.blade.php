<?php
$route = (isset($isAjax)) ? 'ajaxSaveModal' : 'ajaxSave';
$hidAjax = (isset($isAjax)) ? 1 : 0;
$currentRoute = explode('.', \Request::route()->getName());
$routeAction = end($currentRoute);
?>
@if($routeAction == 'create' || $hidAjax)
    {!! Form::open(array('method' => 'POST', 'route' => array('product-group.store'),  'id' => $route, 'class' => 'form-horizontal', 'data-dropdown'=>'product-group')) !!}
@endif
@if($routeAction == 'edit')
    {!! Form::model($result, array('route' => array('product-group.update', $result->id), 'method' => 'PATCH', 'id' => $route, 'class' => 'form-horizontal')) !!}
@endif
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-external-link-square"></i> &nbsp;
            {!! lang('product_group.product_group_detail') !!}
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('code', lang('product_group.code'), array('class' => 'col-sm-3 control-label')) !!}

                        <div class="col-sm-6">
                            {!! Form::text('code', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group hidden">
                        {!! Form::label('description', lang('common.description'), array('class' => 'col-sm-3 control-label')) !!}

                        <div class="col-sm-6">
                            {!! Form::textarea('description', null, array('class' => 'form-control', 'size' => '3x3')) !!}
                        </div>
                    </div>

                    <div class="form-group <?php echo (isset($isAjax)) ? 'hidden' : '' ?>">
                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-5 margintop8">
                            {!! Form::checkbox('status', 1, (isset($result) && $result->status == 1) ? true : false) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 margintop20 clearfix text-center">
                <div class="form-group">
                    {!! Form::hidden('isAjax', $hidAjax) !!}
                    @if($routeAction == 'create')
                        {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary btn-lg')) !!}
                    @else
                        {!! Form::submit(lang('common.update'), array('class' => 'btn btn-primary btn-lg')) !!}
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
{!! Form::close() !!}