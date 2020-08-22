<?php
$route = (isset($isAjax)) ? 'ajaxSaveModal' : 'ajaxSave';
$hidAjax = (isset($isAjax)) ? 1 : 0;
$currentRoute = explode('.', \Request::route()->getName());
$routeAction = end($currentRoute);
?>
@if($routeAction == 'create' || $hidAjax)
    {!! Form::open(array('method' => 'POST', 'route' => array('hsn-code.store'),  'id' => $route, 'class' => 'form-horizontal', 'data-dropdown'=>'hsn-code')) !!}
@endif
@if($routeAction == 'edit')
    {!! Form::model($result, array('route' => array('hsn-code.update', $result->id), 'method' => 'PATCH', 'id' => $route, 'class' => 'form-horizontal')) !!}
@endif
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">

            <i class="fa fa-external-link-square"></i> &nbsp;
            {!! lang('hsn_code.hsn_code_detail') !!}
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('hsn_code', lang('hsn_code.hsn_code'), array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!! Form::text('hsn_code', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group <?php echo (isset($isAjax)) ? 'hidden' : '' ?>">
                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-6">
                            {!! Form::checkbox('status', 1, (isset($result) && $result->status == 1) ? true : false) !!}
                        </div>
                    </div>
                    <div class="col-sm-12 margintop10 clearfix text-center">
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
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
{!! Form::close() !!}