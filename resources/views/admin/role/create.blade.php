@extends('layouts.admin')
@section('content_header')
<section class="content-header">
    <h1>
        {!! lang('role.role_detail') !!}
        <small>{!! lang('common.add_record') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
        <li><a href="{!! route('role.index') !!}">{!! lang('role.role') !!}</a></li>
        <li class="active">{!! lang('common.create_heading', lang('role.role')) !!}</li>
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
            {!! Form::open(array('method' => 'POST', 'route' => array('role.store'), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
            <!-- previous role form id => role-form -->
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> &nbsp;
                        {!! lang('role.role_detail') !!}
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
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
                                        {!! Form::checkbox('status', '1', true) !!}
                                    </div>
                                </div>
                            </div>
                            @if(isset($tree) && count($tree) > 0)
                                <div class="col-md-6 uac-scroll">
                                <ul id="tree">
                                    @foreach ($tree as $key => $value)
                                        <li>
                                            @if (array_key_exists('child', $value))
                                                <i class="fa fa-plus collapsee ulclose cursorPointer"></i>
                                                <a href="javascript:void(0)" class="collapsee ulclose">
                                                    {!! $value['name'] !!}
                                                </a>
                                            @else
                                                <input type="checkbox" name="section[]" value="{!! $value['id'] !!}" id="{!! $value['name'] !!}"/>
                                                {!! Form::label($value['name'], $value['name']) !!}
                                            @endif
                                        </li>

                                        @if (array_key_exists('child', $value))
                                            <ul class="hidden">
                                                @foreach ($value['child'] as $keyDrop => $valueDrop)
                                                    <li>
                                                        @if (array_key_exists('child', $valueDrop))
                                                            <i class="fa fa-plus collapsee ulclose cursorPointer"></i>
                                                            <a href="javascript:void(0)" class="collapsee ulclose">
                                                                {!! $valueDrop['name'] !!}
                                                            </a>
                                                        @else
                                                            <input type="checkbox" name="section[]" value="{!! $value['id'].','.$valueDrop['id'] !!}" id="{!! $valueDrop['name'] !!}"/>
                                                            {!! Form::label($valueDrop['name'], $valueDrop['name']) !!}
                                                        @endif
                                                    </li>
                                                    @if (array_key_exists('child', $valueDrop))
                                                        <ul class="hidden">
                                                            @foreach ($valueDrop['child'] as $keyThirdDrop => $valueThirdDrop)
                                                                <li>
                                                                    <label>
                                                                        <input type="checkbox" name="section[]" value="{!! $value['id'].','.$valueDrop['id'].','.$valueThirdDrop['id'] !!}" />
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
                                    {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary btn-lg')) !!}
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
    <script type="text/javascript">
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
                $(this).siblings('i').removeClass('fa-plus').addClass('fa-minus').removeClass('ulclose').addClass('ulopen');
            } else {
                $(this).removeClass('ulopen').addClass('ulclose');
                $(this).parent().next('ul').addClass('hidden');
                $(this).siblings('i').removeClass('fa-minus').addClass('fa-plus').removeClass('ulopen').addClass('ulclose');
            }
        });
    </script>
@stop
