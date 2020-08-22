@extends('layouts.admin')
@section('content_header')
<section class="content-header">
    <h1>
        {!! lang('common.edit_heading', lang('staff.staff')) !!} #{!! $result->name !!}
        <small>{!! lang('common.record_update') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
        <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i>{!! lang('common.dashboard') !!}</a></li>
        <li><a href="{!! route('staff.index') !!}">{!! lang('staff.staff') !!}</a></li>
        <li class="active">{!! lang('common.edit_heading', lang('staff.staff')) !!}</li>
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
        {!! Form::model($result, array('route' => array('staff.update', $result->id), 'method' => 'PATCH', 'id' => 'ajaxSave', 'class' => 'form-horizontal')) !!}
            <!-- previous staff form id => staff-form -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> &nbsp;
                        {!! lang('staff.staff_detail') !!}
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    {!! Form::label('register_number', lang('staff.register_number'), array('class' => 'col-sm-4 control-label paddingleft0')) !!}

                                    <div class="col-sm-7">
                                        {!! Form::text('register_number', $result->register_number, array('class' => 'form-control', 'readonly')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('gender', lang('common.gender'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-7">
                                        <?php $genderArr = lang('common.genderArray'); ?>
                                        {!! Form::select('gender', $genderArr, ($result->gender)? $result->gender : null, array('class' => 'form-control select2 padding0')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('blood_group', lang('common.blood_group'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-7">
                                        <?php $bloodGroupArr = lang('common.bloodGroupArr'); ?>
                                        {!! Form::select('blood_group', $bloodGroupArr, ($result->blood_group)? $result->blood_group : null, array('class' => 'form-control select2 padding0')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('role', lang('staff.role'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::select('role', $roleService, ($result->role_id)? $result->role_id : null, array('class' => 'form-control select2 padding0')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('department', lang('staff.department'), array('class' => 'col-sm-4 control-label paddingleft0')) !!}

                                    <div class="col-sm-7">
                                        {!! Form::select('department', $departmentService, ($result->department_id)? $result->department_id : null, array('id' => 'department', 'class' => 'form-control select2 padding0')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('do_joining', lang('staff.do_joining'), array('class' => 'col-sm-4 control-label paddingleft0')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('do_joining', ($result->do_joining)? convertToLocal($result->do_joining, 'd-m-Y') : null, array('id' => 'do_joining', 'class' => 'form-control date-picker', 'placeholder' => 'Date Of Joining')) !!}
                                    </div>
                                </div>

                                <div class="form-group ">
                                    {!! Form::label('user_name', lang('common.user_name'), array('class' => 'col-sm-4 control-label paddingleft0')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('user_name', (isset($user->username))? $user->username : null, array('class' => 'form-control', 'placeholder' => 'User Name')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('status', lang('common.active') . '&nbsp;', array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-5 margintop8">
                                        {!! Form::checkbox('status', '1', ($result->status == 1)? true : false) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4 paddingleft0">
                                <div class="form-group required">
                                    {!! Form::label('first_name', lang('staff.first_name'), array('class' => 'col-sm-4 control-label')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::text('first_name', ($result->first_name)? $result->first_name : null, array('class' => 'form-control', 'placeholder' => 'First Name')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('dob', lang('staff.dob'), array('class' => 'col-sm-4 control-label paddingleft0')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::text('dob', ($result->dob)? convertToLocal($result->dob, 'd-m-Y') : null, array('id' => 'dob', 'class' => 'form-control date-picker', 'placeholder' => 'Date Of Birth', 'data-input' => 'age')) !!}
                                        {!! Form::hidden('age', null, array('id' => 'age', 'class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('address', lang('common.address'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('address', ($result->address)? $result->address : null, array('class' => 'form-control', 'rows' => 3, 'cols' => 50, 'placeholder' => 'Address')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('designation', lang('staff.designation'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('designation', $designationService, ($result->designation_id)? $result->designation_id : null, array('class' => 'form-control select2 padding0')) !!}
                                    </div>
                                </div>

                                <div class="form-group margintop24">
                                    {!! Form::label('do_retirement', lang('staff.do_retirement'), array('class' => 'col-sm-4 control-label paddingleft0')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('do_retirement', ($result->do_retirement)? convertToLocal($result->do_retirement, 'd-m-Y') : null, array('id' => 'do_retirement', 'class' => 'form-control date-picker', 'placeholder' => 'Date Of Retirement')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password', lang('common.password'), array('class' => 'col-sm-4 control-label paddingleft0')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('last_name', lang('staff.last_name'), array('class' => 'col-sm-3 control-label')) !!}

                                    <div class="col-sm-8">
                                        {!! Form::text('last_name', ($result->last_name)? $result->last_name : null, array('class' => 'form-control', 'placeholder' => 'Last Name')) !!}
                                    </div>
                                </div>

                                <?php
                                    $labelText = lang('common.choose_image');
                                    $filePath = ($result->image != '')? \Config::get('constants.UPLOADS').$result->image : null;
                                    $fileName = ($result->image != '')? getFileName($result->image, '_', true) : null;

                                    $folder = ROOT .  \Config::get('constants.UPLOADS');
                                ?>
                                <div class="form-group">
                                    {!! Form::label('image', lang('staff.upload_photo'), array('class' => 'col-sm-3 control-label paddingleft0')) !!}
                                    <div class="col-sm-8 imageDiv">
                                        @if(file_exists($folder . $result->image) &&  $result->image)
                                            {!! Html::image($filePath, $fileName, ['class' => 'showImage img-responsive thumbnail']) !!}
                                        @else
                                            <img class='showImage img-responsive thumbnail' src="" alt="">
                                        @endif
                                        {!! Form::label('image', (file_exists($folder . $result->image) && $fileName != '')? $fileName : $labelText, array('class' => 'col-sm-4 control-label', 'id' => 'img-label')) !!}
                                        {!! Form::file('image', null) !!}
                                    </div>
                                </div>

                                <div class="form-group margintop39 required">
                                    {!! Form::label('email', lang('common.email'), array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('email', ($result->email)? $result->email : null, array('class' => 'form-control', 'placeholder' => 'Email')) !!}
                                    </div>
                                </div>

                                <div class="form-group required">
                                    {!! Form::label('mobile', lang('common.mobile'), array('class' => 'col-sm-3 control-label paddingleft0')) !!}
                                    <div class="col-sm-8 z-index0">
                                        <div class="input-group">
                                            <span class="input-group-addon">{!! lang('common.isd_code_india') !!}</span>
                                            {!! Form::text('mobile', ($result->contact_number)? $result->contact_number : null, array('class' => 'form-control', 'maxlength' => '10', 'placeholder' => 'Mobile Number')) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 clearfix">
                                <strong>{!! lang('staff.emergency_details') !!}</strong> :-
                                <hr/>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group required">
                                    {!! Form::label('e_name', lang('staff.e_name'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('e_name', ($result->e_name)? $result->e_name : null, ['class' => 'form-control', 'placeholder' => 'Name Of The Person']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 paddingleft0">

                                <div class="form-group required">
                                    {!! Form::label('e_contact_number', lang('staff.e_contact_number'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8 z-index0">
                                        <div class="input-group">
                                            <span class="input-group-addon">{!! lang('common.isd_code_india') !!}</span>
                                            {!! Form::text('e_contact_number', ($result->e_contact_number)? $result->e_contact_number : null, ['class' => 'form-control', 'maxlength' => '10', 'placeholder' => 'Mobile Number']) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group required">
                                    {!! Form::label('relationship', lang('staff.relationship'), array('class' => 'col-sm-3 control-label paddingleft3')) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('relationship', ($result->relationship)? $result->relationship : null, ['class' => 'form-control', 'placeholder' => 'Relation With Person']) !!}
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-12 clearfix margintop10">
                                <strong>{!! lang('staff.reference_details') !!}</strong> :-
                                <hr/>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    {!! Form::label('reference_person', lang('staff.reference_person'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-7">
                                        {!! Form::text('reference_person', ($result->reference_person)? $result->reference_person : null, ['class' => 'form-control', 'placeholder' => 'Reference Person']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4 paddingleft0">

                                <div class="form-group">
                                    {!! Form::label('reference_contact', lang('staff.reference_contact'), array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">{!! lang('common.isd_code_india') !!}</span>
                                            {!! Form::text('reference_contact', ($result->reference_contact)? $result->reference_contact : null, ['class' => 'form-control', 'maxlength' => '10', 'placeholder' => 'Mobile Number']) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">&nbsp;</div>

                            <div class="col-md-12 clearfix margintop10">
                                <strong>{!! lang('staff.previous_qualication_details') !!}</strong> :-
                                <hr/>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    {!! Form::label('q_name', lang('staff.q_name'), array('class' => 'col-md-4 control-label')) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('q_name', ($result->q_name)? $result->q_name : null, ['class' => 'form-control', 'placeholder' => 'Institute Name']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4 paddingleft0">

                                <div class="form-group">
                                    {!! Form::label('q_address', lang('staff.q_address'), array('class' => 'col-md-4 control-label')) !!}
                                    <div class="col-md-8">
                                        {!! Form::textarea('q_address', ($result->q_address)? $result->q_address : null, ['class' => 'form-control', 'rows' => 3, 'cols' => 50, 'placeholder' => 'Institute Address']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    {!! Form::label('qualification', lang('staff.qualification'), array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('qualification', ($result->qualification)? $result->qualification : null, ['class' => 'form-control', 'placeholder' => 'Qualification']) !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-11 margintop20 clearfix text-center">
                                <div class="form-group">
                                    {!! Form::submit(lang('common.update'), array('class' => 'btn btn-primary')) !!}
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
        $(document).ready(function() {
            var datePicker = $('#dob').datepicker({
                showButtonPanel: false,
                dateFormat: "dd-mm-yy",
                dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                changeYear: true,
                changeMonth: true,
                yearRange: '1960:' + new Date().getFullYear(),
                defaultDate: new Date()
            });

            $(datePicker).on('change', function(){
                var thisVal = $(this).val();
                var target = $(this).data('input');
                if(thisVal != '')
                {
                    var route = "{!! route('calculate-age') !!}";
                    calculateAge(thisVal, route, target);
                }
            });

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

        });
    </script>
@stop