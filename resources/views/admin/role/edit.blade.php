@extends('layouts.admin')
@section('content_header')
<section class="content-header">
    <h1>
        {!! lang('common.edit_heading', lang('role.role')) !!} #{!! $role->name !!}
        <small>{!! lang('common.record_update') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
        <li><a href="{!! route('role.index') !!}">{!! lang('role.role') !!}</a></li>
        <li class="active">{!! lang('common.edit_heading', lang('role.role')) !!}</li>
    </ol>
</section>
@stop
@section('content')
<div id="page-wrapper">
    <!-- start: PAGE CONTENT -->
    
    {{-- for message rendering --}}
    @include('layouts.messages')
    <div class="row">
        <div class="col-md-12 padding0">
        {!! Form::model($role, array('route' => array('role.update', $role->id), 'method' => 'PATCH', 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
            <!-- previous role form id => role-form -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> &nbsp;
                        {!! lang('role.role_detail') !!}
                    </div>
                    <div class="panel-body">

                        <div class="row">
                           <div class="col-sm-6">

                               <div class="form-group">
                                   {!! Form::label('code', lang('common.code'), array('class' => 'col-sm-3 control-label')) !!}
                                   <div class="col-sm-8">
                                       {!! Form::text('code', null, array('class' => 'form-control')) !!}
                                   </div>
                               </div>

                               <div class="form-group">
                                   {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-3 control-label')) !!}
                                   <div class="col-sm-8">
                                       {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                   </div>
                               </div>

                               <div class="form-group">
                                   {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                   <div class="col-sm-5 margintop8">
                                       {!! Form::checkbox('status', '1', ($role->status == '1') ? true : false) !!}
                                   </div>
                               </div>
                           </div>

                            @if(isset($tree) && count($tree) > 0)
                                <div class="col-md-6 uac-scroll">
                                    <ul id="tree">
                                        @foreach ($tree as $key => $value)
                                            <li>
                                                @if (array_key_exists('child', $value))
                                                    <i class="cursorPointer fa @if(!in_array($value['id'], $detail))fa-plus ulclose @else fa-minus ulopen @endif collapsee"></i>
                                                    <a href="javascript:void(0)" class="collapsee @if(!in_array($value['id'], $detail))ulclose @else ulopen @endif">
                                                        {!! $value['name'] !!}
                                                    </a>
                                                @else
                                                    <?php $checked = (in_array($value['id'], $detail))? 'checked="checked"' : '';  ?>
                                                    <input type="checkbox" name="section[]" value="{!! $value['id'] !!}" {!! $checked !!} id="{!! $value['name'] !!}"/>
                                                    {!! Form::label($value['name'], $value['name']) !!}
                                                @endif
                                            </li>
                                            @if (array_key_exists('child', $value))
                                                <ul class="@if(!in_array($value['id'], $detail)) hidden @endif">
                                                    @foreach ($value['child'] as $keyDrop => $valueDrop)
                                                        <li>
                                                            @if (array_key_exists('child', $valueDrop))
                                                                <i class="cursorPointer fa @if(!in_array($valueDrop['id'], $detail)) fa-plus ulclose @else fa-minus ulopen @endif collapsee"></i>
                                                                <a href="javascript:void(0)" class="collapsee @if(!in_array($valueDrop['id'], $detail))ulclose @else ulopen @endif">
                                                                    {!! $valueDrop['name'] !!}
                                                                </a>
                                                            @else
                                                                <?php $checked = (in_array($valueDrop['id'], $detail))? 'checked="checked"' : ''; ?>
                                                                <input type="checkbox" name="section[]" value="{!! $value['id'].','.$valueDrop['id'] !!}" id="{!! $valueDrop['name'] !!}" {!! $checked !!}/>
                                                                {!! Form::label($valueDrop['name'], $valueDrop['name']) !!}
                                                            @endif
                                                        </li>
                                                        @if (array_key_exists('child', $valueDrop))
                                                            <ul class="@if(!in_array($valueDrop['id'], $detail)) hidden @endif">
                                                                <?php  $checked = ''; ?>
                                                                @foreach ($valueDrop['child'] as $keyThirdDrop => $valueThirdDrop)
                                                                    <li>
                                                                        <label>
                                                                            <input type="checkbox" name="section[]"
                                                                                   @if(!in_array($valueThirdDrop['id'], $detail))  @else checked="checked" @endif
                                                                                   value="{!! $value['id'].','.$valueDrop['id'].','.$valueThirdDrop['id'] !!}" />
                                                                            {!! $valueThirdDrop['name'] !!}
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="col-sm-11 margintop20 clearfix text-center">
                                <div class="form-group">
                                    {!! Form::hidden('permission_id', (isset($userPermissions) && is_object($userPermissions))? $userPermissions->permission_id : null) !!}
                                    {!! Form::submit(lang('common.update'), array('class' => 'btn btn-primary btn-lg')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: TEXT FIELDS PANEL -->
            </div>
            {!! Form::close() !!}
        </div>    
    </div>
</div>
<!-- /#page-wrapper -->
@stop
@section('script')
    <script>
        $('#tree').checktree();
        $('i.collapsee').on('click', function() {
            if($(this).hasClass('ulclose')) {
                $(this).removeClass('ulclose').addClass('ulopen');
                $(this).parent().next('ul').removeClass('hidden');
                $(this).removeClass('fa-plus').addClass('fa-minus');
                $(this).next('a').removeClass('ulclose').addClass('ulopen');
            } else {
                $(this).removeClass('ulopen').addClass('ulclose');
                $(this).parent().next('ul').addClass('hidden');
                $(this).removeClass('fa-minus').addClass('fa-plus');
                $(this).next('a').removeClass('ulopen').addClass('ulclose');
            }
        });
        $('a.collapsee').on('click', function() {
            if($(this).hasClass('ulclose')) {
                $(this).removeClass('ulclose').addClass('ulopen');
                $(this).parent().next('ul').removeClass('hidden');
                $(this).siblings('i').removeClass('fa-plus').addClass('fa-minus');
                $(this).siblings('i').removeClass('fa-plus').addClass('fa-minus').removeClass('ulclose').addClass('ulopen');
            } else {
                $(this).removeClass('ulopen').addClass('ulclose');
                $(this).parent().next('ul').addClass('hidden');
                $(this).siblings('i').removeClass('fa-minus').addClass('fa-plus');
                $(this).siblings('i').removeClass('fa-minus').addClass('fa-plus').removeClass('ulopen').addClass('ulclose');
            }
        });
    </script>
@stop