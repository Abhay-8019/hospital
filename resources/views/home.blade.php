@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('common.dashboard') !!}
        </h1>
    </section>
@stop
@section('content')
    <div id="page-wrapper">
        <!-- start: PAGE CONTENT -->
        {{-- for message rendering --}}
        @include('layouts.messages')
        <div class="row">
            <div class="col-md-12 padding0">
                <div class="col-md-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            {!! lang('common.dashboard') !!}                            
                        </div>
                        <div class="panel-body">
                            @if(isAdmin())
                                

                            @endif

                            <div class="row">
                                @if(isDoctor())
                                    <div class="col-md-6">
                                      
                                        <table class="table table-bordered">
                                           <!-- <tr>
                                                <th>{!! lang('common.id') !!}</th>
                                                <th>{!! lang('opd_master.visit_date') !!}</th>
                                                <th>{!! lang('patient.patient_code') !!}</th>
                                                <th>{!! lang('patient.first_name') !!}</th>
                                                <th>{!! lang('patient.age') !!} / {!! lang('patient.gender') !!}</th>

                                                
                                                <th>{!! lang('common.action') !!}</th>
                                            </tr>   -

                                            <?php
                                                $index = 1;
                                                $genderArr = lang('common.genderArray');
                                                $bloodGroupArr = lang('common.bloodGroupArr');

                                            ?>

                                            @if(count($pendingVisits) > 0)
                                                @foreach($pendingVisits as $detail)
                                                    <tr>
                                                        <td>{!! $index++ !!}</td>
                                                        <td> {!! $detail->visit_date !!} </td>
                                                        <td> {!! $detail->patient_code !!} </td>
                                                        <td>
                                                            {!! $detail->first_name !!}
                                                        </td>
                                                        <td>{!! $detail->age !!} @if($detail->age) @endif / @if($detail->gender != '') {!! $genderArr[$detail->gender] !!} @endif</td>
                                                        

                                                        <td> <a href="{!! route('patient.opd-visit-edit', $detail->id) !!}" class="btn btn-xs btn-info"><i class="fa fa-mail-forward"></i> View </a></td>
                                                    </tr>

                                                @endforeach                                                   
                                            @endif
                                        </table>-
                                    </div>

                                    <div class="col-md-6 paddingleft0">
                                        <h2 class="bg-green margin0 padding10"> :: Completed Patient Visit(s) </h2>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>{!! lang('common.id') !!}</th>
                                                <th>{!! lang('patient.patient_code') !!}</th>
                                                <th>{!! lang('patient.first_name') !!}</th>
                                                <th>{!! lang('patient.age') !!} / {!! lang('patient.gender') !!}</th>
                                                <th>{!! lang('common.action') !!}</th>
                                            </tr>

                                            <?php
                                                $index = 1;
                                                $genderArr = lang('common.genderArray');
                                                $bloodGroupArr = lang('common.bloodGroupArr');
                                            ?>
                                            @if(count($completedVisits) > 0)
                                                @foreach($completedVisits as $detail)
                                                    <tr>
                                                        <td>{!! $index++ !!}</td>
                                                        <td> {!! $detail->patient_code !!} </td>
                                                        <td>
                                                            {!! $detail->first_name !!}
                                                        </td>
                                                        <td>{!! $detail->age !!} @if($detail->age) @endif / @if($detail->gender != '') {!! $genderArr[$detail->gender] !!} @endif </td>
                                                        <td> <a href="{!! route('patient.opd-visit-print', $detail->id) !!}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> View </a></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        <!--     <tr>
                                                <td colspan="6">
                                                    <a href="{!! route('patient.daily-opd-list') !!}" class="btn btn-danger btn-block"> View All OPD(s)</a>
                                                </td>
                                            </tr> -->  -->
                                        </table>
                                    </div>
                                @endif

                                @if(isStaff())

<!--
                                    <?php
                                        $route = "report.patient-wise-visits";
                                        if($t == 2) {
                                            $route = "report.ipd-patients";
                                        }
                                    ?>
                                    <div class="col-md-12">
                                        <h2 class="bg-red margin0 padding10"> :: Patient Search </h2>
                                        <div class="col-md-12 padding0">
                                            {!! Form::open(array('method' => 'POST', 'route' => array($route), 'id' => 'ajaxForm')) !!}
                                            <div class="row margintop10">
                                                <div class="col-md-2 width150">
                                                    <div class="form-group">
                                                        
                                                        <div class="control-label">
                                                            {!! Form::radio('p_type', 1, ($t == 1) ? true : false, array('class' => 'p_type')) !!} OPD &nbsp; &nbsp; &nbsp;
                                                            {!! Form::radio('p_type', 2, ($t == 2) ? true : false, array('class' => 'p_type')) !!} IPD
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 width115 paddingleft0 opd_procedure @if($t != 1) hidden @endif">
                                                    <div class="form-group">
                                                        <!-- {!! Form::label('opd_number', lang('patient.opd_number'), array('class' => 'control-label')) !!} -->
                                                        {!! Form::text('opd_number', null, array('class' => 'form-control', 'placeholder' => lang('patient.opd_number'))) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-2 width115 paddingleft0 ipd_procedure @if($t != 2) hidden @endif">
                                                    <div class="form-group">
                                                    <!-- {!! Form::label('ipd_number', lang('ipd_master.ipd_number'), array('class' => 'control-label')) !!} -->
                                                        {!! Form::text('ipd_number', null, array('class' => 'form-control', 'placeholder' => lang('ipd_master.ipd_number'))) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-2 width150 paddingleft0">
                                                    <div class="form-group">
                                                        <!-- {!! Form::label('patient_code', lang('patient.patient_code'), array('class' => 'control-label')) !!} -->
                                                        {!! Form::text('patient_code', null, array('class' => 'form-control', 'placeholder' => lang('patient.patient_code'))) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-2 width150 paddingleft0">
                                                    <div class="form-group">
                                                       <!--  {!! Form::label('patient_name', lang('patient.first_name'), array('class' => 'control-label')) !!} -->
                                                        {!! Form::text('patient_name', null, array('class' => 'form-control', 'placeholder' => lang('patient.first_name'))) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-2 width115 date paddingleft0">
                                                    <div class="form-group">
                                                        {!! Form::text('from_date', null, array('class' => 'form-control date-picker from_date', 'placeholder' => lang('reports.from_date'))) !!}
                                                    </div>
                                                </div>


                                                <div class="col-md-2 width115 date paddingleft0">
                                                    <div class="form-group">
                                                        {!! Form::text('to_date', null, array('class' => 'form-control date-picker to_date', 'placeholder' =>  lang('reports.to_date'))) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-2 paddingleft0">
                                                    <div class="form-group">
                                                        {!! Form::hidden('form-search', 1) !!}
                                                        {!! Form::hidden('staff-search', 1) !!}
                                                        {!! Form::hidden('report_type', 1) !!}
                                                        {!! Form::submit(lang('reports.filter'), array('class' => 'btn btn-primary', 'title' => lang('reports.filter'))) !!}
                                                        <a href="{!! route("home") !!}" class="btn btn-primary" title="{!! lang('reports.reset_filter') !!}"> {!! lang('reports.reset_filter') !!}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            {!! Form::close() !!}
                                        </div>    -
                                    </div>

                                    <div class="col-md-12">
                                        <h2 class="bg-green margin0 padding10"> :: Search Results </h2>
                                        <div class="col-md-12 padding0">
                                            <table id="paginate-load" data-route="{{ route($route) }}" class="table table-responsive table-hover clearfix margin0 col-md-12 padding0 table-fullbox">
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end: TEXT FIELDS PANEL -->
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->

    <script>
        // Submit modal form with ajax
        $('body').on('change', '.p_type', function(event)
        {
            var val = $(this).val();
            if (val == 1) {
                /*$('.opd_procedure').removeClass('hidden');
                $('.ipd_procedure').addClass('hidden');*/
                window.location.href = "{!! route("home", ['t' => 1]) !!}";
            } else {
                /*$('.ipd_procedure').removeClass('hidden');
                $('.opd_procedure').addClass('hidden');*/
                window.location.href = "{!! route("home", ['t' => 2]) !!}";
            }
        });
    </script>
@stop
