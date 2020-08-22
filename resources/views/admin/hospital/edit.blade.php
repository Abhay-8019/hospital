@extends('layouts.admin')
@section('content_header')
    <section class="content-header">
        <div class="pull-right">
            <a href="javascript:void(0)" class="btn btn-danger btn-xs _back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a>
        </div>
        <h1>
            {!! lang('common.edit_heading', lang('hospital.hospital')) !!} #{!! $result->name !!}
            <small>{!! lang('common.record_update') !!}</small>
        </h1>
        <ol class="breadcrumb hidden">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
            <li><a href="{!! route('hospital.index') !!}">{!! lang('hospital.hospital') !!}</a></li>
            <li class="active">{!! lang('common.edit_heading', lang('hospital.hospital')) !!}</li>
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
                {!! Form::model($result, array('route' => array('hospital.update', $result->id), 'method' => 'PATCH', 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
                        <!-- previous floor form id => floor-form -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> &nbsp;
                            {!! lang('hospital.hospital_detail') !!}
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        {!! Form::label('hospital_code', lang('hospital.hospital_code'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-2 padding0 paddingleft15">
                                            {!! Form::text('hospital_code',null, array('class'=>'form-control', 'readonly', 'placeholder' => 'Hospital Code')) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::text('hospital_name', null, array('class' => 'form-control', 'placeholder' => 'Hospital Name')) !!}
                                        </div>
                                    </div>


                                    <div class="form-group hidden">
                                        {!! Form::label('hospital_buildings', lang('hospital.hospital_buildings'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('hospital_building', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>


                                    <div class="form-group required">
                                        {!! Form::label('contact_person', lang('hospital.contact_person'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('contact_person', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('tin_number', lang('hospital.tin_number'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('tin_number', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('gst_number', lang('hospital.gst_number'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('gst_number', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('email', lang('hospital.email'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'example@gmail.com')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('mobile', lang('hospital.mobile1'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">{!! lang('common.isd_code_india') !!}</span>
                                                {!! Form::text('mobile', null, array('class' => 'form-control', 'maxlength' => 10,'placeholder' => 'Contact No')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('phone', lang('hospital.phone'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            <div class="col-sm-4 padding0">
                                                {!! Form::text('std_code', null, array('class' => 'form-control', 'min' => 1, 'maxlength' => 4, 'placeholder' => 'STD CODE')) !!}
                                            </div>
                                            <div class="col-sm-8 paddingright0">
                                                {!! Form::text('alternate_contact_no', null, array('class' => 'form-control', 'placeholder' => 'Phone Number', 'min' => 1, 'maxlength' => 7)) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('website', lang('hospital.website'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'example.com')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-3 margintop8">
                                            {!! Form::checkbox('status', '1', true) !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <?php
                                        $labelText = lang('common.choose_image');
                                        $filePath = ($result->hospital_logo != '')? \Config::get('constants.UPLOADS').$result->hospital_logo : null;
                                        $fileName = ($result->hospital_logo != '')? getFileName($result->hospital_logo, '_', true) : null;

                                        $folder = ROOT .  \Config::get('constants.UPLOADS');
                                    ?>
                                    <div class="form-group">
                                        {!! Form::label('image', lang('hospital.hospital_logo'), array('class' => 'col-sm-3 control-label paddingleft0')) !!}
                                        <div class="col-sm-8 imageDiv">
                                            @if(file_exists($folder . $result->hospital_logo) &&  $result->hospital_logo)
                                                {!! Html::image($filePath, $fileName, ['class' => 'showImage img-responsive thumbnail']) !!}
                                            @else
                                                <img class='showImage img-responsive thumbnail' src="" alt="">
                                            @endif
                                            {!! Form::label('image', (file_exists($folder . $result->hospital_logo) && $fileName != '')? $fileName : $labelText, array('class' => 'col-sm-4 control-label', 'id' => 'img-label')) !!}
                                            {!! Form::file('image', null) !!}
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        {!! Form::label('mobile1', lang('hospital.mobile2'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">{!! lang('common.isd_code_india') !!}</span>
                                                {!! Form::text('mobile1', ($result->mobile1)? $result->mobile1 : null, array('class' => 'form-control', 'maxlength' => 10,'placeholder' => 'Contact No')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        {!! Form::label('email1', lang('hospital.email1'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('email1', ($result->email1)? $result->email1 : null, array('class' => 'form-control', 'placeholder' => 'example123@gmail.com')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('permanent_address', lang('hospital.permanent_address'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::textarea('permanent_address', null, array('class' => 'form-control', 'size' => '5x4')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('country', lang('hospital.country'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('country', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('state', lang('hospital.state'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::select('state', $state, ($result->state_id)? $result->state_id : null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        {!! Form::label('correspondence_address', lang('hospital.correspondence_address'), array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::textarea('correspondence_address', null, array('class' => 'form-control', 'size' => '5x4')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('city', lang('hospital.city'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('city', null, array('class'=>'form-control', 'placeholder' => 'City')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('pincode', lang('hospital.pincode'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('pincode', null, array('class'=>'form-control', 'maxlength'=> 6, 'placeholder' => 'Pin Code')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        {!! Form::label('timezone', lang('hospital.timezone'), array('class' => 'col-sm-3 control-label')) !!}

                                        <div class="col-sm-8">
                                            {!! Form::text('timezone', ($result->timezone)? $result->timezone : null, array('class'=>'form-control', 'maxlength'=> 6, 'placeholder' => 'TimeZone')) !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-11 margintop20 clearfix text-center">
                                <div class="form-group">
                                    {!! Form::submit(lang('common.save'), array('class' => 'btn btn-primary')) !!}
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

        $('#image').on('change',function(){
            var filename = 'No File Selected';
            if($(this)[0].files[0])
            {
                filename = $(this)[0].files[0]['name'];

                var fileExtension = filename.substr(filename.lastIndexOf('.') + 1);
                fileExtension = fileExtension.toLowerCase();
                var validExtension = ['jpg', 'jpeg', 'png', 'gif'];

                if($.inArray(fileExtension, validExtension) >= 0){
                    $('#img-label').css('border', '1px dashed #ccc');
                }else {
                    filename = 'No File Selected';
                    $('#member_image').val('');
                    $('#img-label').css('border', '1px dashed red');
                    alert('Please select an image');
                }
            }
            readURL(this);
            $('#img-label').text(filename);
        });

        function readURL(input) {

            var html = '', src = '', alt = '';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                $(".backDrop").fadeIn( 100, "linear" );
                $(".loader").fadeIn( 100, "linear" );

                reader.onload = function (e) {
                    src = e.target.result;
                    $('.showImage').attr('src', src).attr('alt', alt);

                    setTimeout(function(){
                        $(".backDrop").fadeOut( 100, "linear" );
                        $(".loader").fadeOut( 100, "linear" );
                    }, 200);
                };
                reader.readAsDataURL(input.files[0]);
            }else{
                $('.showImage').attr('src', src).attr('alt', alt);
            }
        }
    </script>
@stop