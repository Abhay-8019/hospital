@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('building.add_heading', lang('building.building')) !!} #{!! $result->name !!}
            <small>{!! lang('common.record_update') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
            <li><a href="{!! route('building.index') !!}">{!! lang('building.building') !!}</a></li>
            <li class="active">{!! lang('building.add_heading', lang('building.building')) !!}</li>
        </ol>
    </section>
@stop
@section('content')
    <div id="page-wrapper">
        <!-- start: PAGE CONTENT -->

        {{-- for message rendering --}}
        @include('layouts.messages')
        <div class="row">
            <?php
            $floor = $result->no_of_floors;
            $buildingId = $result->id;
            ?>
            <div class="col-md-12 padding0">

                <div id="hiddenDiv" class="hidden">
                    <div class="form-group">
                        {!! Form::label('code', lang('floor.floor_code'), array('class' => 'col-sm-1 control-label')) !!}

                        <div class="col-sm-2">
                            {!! Form::text('code[]', null , array('class' => 'form-control')) !!}
                        </div>

                        {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-1 control-label')) !!}

                        <div class="col-sm-2">
                            {!! Form::text('name[]', null, array('class' => 'form-control')) !!}
                        </div>

                        {!! Form::label('total_rooms', lang('floor.total_rooms'), array('class' => 'col-sm-2 control-label')) !!}

                        <div class="col-sm-2">
                            {!! Form::text('total_rooms[]',null , array('class' => 'form-control')) !!}
                        </div>

                        <a href="#" class="remove_field"> <b> X </b> </a>

                    </div>
                </div>
                {!! Form::open(array('method' => 'POST', 'route' => array('building.savefloor', $result->id), 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('floor.floor_detail') !!}
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                {!! Form::hidden('building_id', $buildingId) !!}
                                {!! Form::hidden('no_of_floors', $floor) !!}
                                {{--@for($i=1;$i<=$floor;$i++)--}}
                                <div class="newDiv">
                                    <div class="form-group">
                                        {!! Form::label('code', lang('floor.floor_code'), array('class' => 'col-sm-1 control-label')) !!}

                                        <div class="col-sm-2">
                                            {!! Form::text('code[]', null , array('class' => 'form-control')) !!}
                                        </div>

                                        {!! Form::label('name', lang('common.name'), array('class' => 'col-sm-1 control-label')) !!}

                                        <div class="col-sm-2">
                                            {!! Form::text('name[]', null, array('class' => 'form-control')) !!}
                                        </div>

                                        {!! Form::label('total_rooms', lang('floor.total_rooms'), array('class' => 'col-sm-2 control-label')) !!}

                                        <div class="col-sm-2">
                                            {!! Form::text('total_rooms[]',null , array('class' => 'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::button(lang('common.add'), array('class' => 'btn btn-primary col-sm-1 addBtn')) !!}
                                        </div>

                                    </div>
                                    <div id="hiddenDiv"></div>
                                </div>
                              {{--  @endfor--}}
                                <div class="col-sm-11 margintop20 clearfix text-center">
                                    <div class="form-group">
                                        {!! Form::submit(lang('common.submit'), array('class' => 'btn btn-primary')) !!}
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
$(document).ready(function() {
var max_fields      = 50; //maximum input boxes allowed
var wrapper         = $(".newDiv"); //Fields wrapper
var add_button      = $(".addBtn"); //Add button Class

var x = 1; //initlal text box count
$(add_button).click(function(e){ //on add input button click
e.preventDefault();
    console.log();
if(x < max_fields) { //max input box allowed
    x++; //text box increment
    $(wrapper).append($('#hiddenDiv').html()); //add input box
}
});

$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
e.preventDefault();
    $(this).parent('div').remove();
    x--;
})
});
</script>
    @endsection

