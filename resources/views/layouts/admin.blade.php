<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
    <title>:: {!! Config::get('app.appname') . ' - ' .  Config::get('app.slogan') !!} :: Admin Panel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    {!! Html::style('assets/bootstrap/css/bootstrap.min.css') !!}
    <!-- Font Awesome -->
    {!! Html::style('assets/components/font-awesome/css/font-awesome.min.css') !!}
   {{-- <!-- Ionicons -->
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css') !!}--}}
    <!-- Theme style -->
    {!! Html::style('assets/dist/css/AdminLTE.css') !!}
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->

    {!! Html::style('assets/dist/css/skins/_all-skins.min.css') !!}
    <!-- iCheck -->
    {!! Html::style('assets/plugins/iCheck/flat/blue.css') !!}

    <!-- Morris chart -->
    {{--{!! Html::style('assets/plugins/morris/morris.css') !!}--}}

    <!-- jvectormap -->
    {!! Html::style('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') !!}

    <!-- Date Picker -->
    {!! Html::style('assets/plugins/datepicker/datepicker3.css') !!}

    <!-- Daterange picker -->
    {!! Html::style('assets/plugins/daterangepicker/daterangepicker.css') !!}

    <!-- bootstrap wysihtml5 - text editor -->
    {!! Html::style('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Custom CSS -->
    {!! Html::style('assets/css/template.css') !!} <!-- Old Css -->

    <!-- Jquery UI -->
    {!! Html::style('assets/css/jquery-ui.css') !!}   <!-- Old Css -->
    {!! Html::style('assets/css/jquery-ui-timepicker.css') !!}   <!-- Old Css -->
    <!-- Select2 CSS -->
    {!! Html::style('assets/components/select2/select2.full.css') !!} <!-- Old Css -->
    {!! Html::style('assets/css/fSelect.css') !!} <!-- Old Css -->

    <!-- jQuery -->
    {!! Html::script('assets/js/jquery.min.js') !!}   <!-- Old Css -->
    {!! Html::script("assets/js/jquery-checktree.js") !!}   <!-- Old Css -->


{{--
    <!-- MetisMenu CSS -->
    {!! Html::style('assets/components/metis-menu/metisMenu.min.css') !!} <!-- Old Css -->
    <!-- Custom CSS -->
    {!! Html::style('assets/css/style.css') !!} <!-- Old Css -->
    <!-- Dropzone uploader -->
    {!! Html::style('assets/components/dropzone/downloads/css/dropzone.css') !!} <!-- Old Css -->
    --}}
</head>
<body class="hold-transition skin-red sidebar-mini sidebar-collapse">

    <div id="wrapper" class="wrapper">
        <header class="main-header sticky">
            <!-- Logo -->
            <a href="{!! route('dashboard') !!}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                   {!! Html::image(asset('assets/images/doc+.png'), null, ['width' => 40]) !!}
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                   {!! Html::image(asset('assets/images/doc+.png'), null, ['width' => 40]) !!}
                </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="javascript:void(0);" class="sidebar-toggle" @if(authUser()) data-toggle="offcanvasdd" @endif role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="appname">{!! Config::get('app.appname') !!}</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu hide">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    {!! Html::image(asset('assets/dist/img/avatar5.png'), ucwords('User Image'), ['class' => 'img-circle']) !!}
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    {!! Html::image(asset('assets/dist/img/user3-128x128.jpg'), ucwords('User Image'), ['class' => 'img-circle']) !!}
                                                </div>
                                                <h4>
                                                    AdminLTE Design Team
                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    {!! Html::image(asset('assets/dist/img/user4-128x128.jpg'), ucwords('User Image'), ['class' => 'img-circle']) !!}
                                                </div>
                                                <h4>
                                                    Developers
                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    {!! Html::image(asset('assets/dist/img/user3-128x128.jpg'), ucwords('User Image'), ['class' => 'img-circle']) !!}
                                                </div>
                                                <h4>
                                                    Sales Department
                                                    <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    {!! Html::image(asset('assets/dist/img/user4-128x128.jpg'), ucwords('User Image'), ['class' => 'img-circle']) !!}
                                                </div>
                                                <h4>
                                                    Reviewers
                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>z
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu hide">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-red"></i> 5 new members joined
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-user text-red"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu hide">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-flag-o"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Some task I need to do
                                                    <small class="pull-right">60%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Make beautiful transitions
                                                    <small class="pull-right">80%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        @if(authUser())
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                            <a href="javascript:void(0);" class="dropdown-toggle inline-block paddingtop10 paddingbottom10" data-toggle="dropdown">
                                <div class="profile-thumb inline-block">
                                    {!! Html::image(asset('assets/dist/img/avatar5.png'), \Auth::user()->username, ['class' => 'user-image']) !!}
                                </div>
                                <span class="hidden-xs inline-block">
                                     @if (\Auth::check())
                                        {!! lang('master.welcome') !!},
                                        {!! \Auth::user()->username !!} &nbsp;
                                         <i class="fa fa-angle-right"> &nbsp; </i>
                                    @endif &nbsp;
                                </span>
                            </a>
                            <ul class="dropdown-menu user-profile-dropdown">
                                <!-- Menu Footer-->
                                <li class="user-dropdown">
                                    <a href="{!! route('password.change') !!}">
                                        <i class="fa fa-edit"></i> Change Password
                                    </a>
                                </li>
                               {{-- @if(!isAdmin())
                                <li class="user-dropdown">
                                    <a href="{!! route('company.edit', loggedInHospitalId()) !!}" class="btn btn-flat text-left">
                                        <i class="fa fa-user fa-fw"></i>
                                        {!! lang('common.company_profile') !!}
                                    </a>
                                </li>
                                @endif--}}
                                <li class="user-dropdown hide">
                                    <a href="#" ><i class="fa fa-cog"></i>Setting</a>
                                </li>

                                <li class="user-dropdown hide">
                                    <a href="#"> <i class="fa fa-edit"></i> Change Password</a>
                                </li>
                                <li class="user-dropdown">
                                    <a href="{!! route('logout') !!}" class="btn  btn-flat"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out fa-fw"></i>
                                        {!! lang('common.logout') !!}
                                    </a>

                                    <form id="logout-form" action="{!! route('logout') !!}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <!-- Control Sidebar Toggle Button -->
                        <li class="hide">
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            @if(authUser())
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    @include('layouts.sidebar')  
                </section>
                <!-- /.sidebar -->
            @endif
        </aside>
        <!--  page content part -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('content_header')
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
    </div>

    <!--processing-->
    <div class="loader">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <p class='text-center'>

                        {!! Html::image('/assets/images/preload.gif', 'processing', ['class' => 'processing', 'width' => 40]) !!}

                    </p>
                    <p class='text-center message'>Loading...</p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- end processing -->
    <div class="backDrop"> </div>

    <!-- Modal Start for editing all-->
    <div class="modal fade" id="dynamicEdit" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formTitle"> </h4>
                </div>
                <div id="dataResult" class="modal-body clearfix">
                    ...
                </div>
            </div>
        </div>
    </div>
    <!-- Modal editing End-->
    <footer class="main-footer text-center">
        <strong>{!! lang('common.copyright') !!}
            <a href="http://reflexins.com">{!! lang('common.elite') !!}</a>.
         {!! lang('common.all_rights') !!}
        {!! lang('common.reserved') !!}.
        </strong>
    </footer>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark hide">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-warning pull-right">50%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Back End Framework
                                <span class="label label-primary pull-right">68%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Allow mail redirect
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Other sets of options are available
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Allow the user to show his name in blog posts
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg hide"></div>

    @yield('script')

    <script type="text/javascript">
        $(document).ready(function(){
            var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

            var monthNames = [
                "January", "February", "March",
                "April", "May", "June", "July",
                "August", "September", "October",
                "November", "December"
            ];


            var date = new Date();
            var dayIndex = date.getDay();
            var day = date.getDate();
            var month = date.getMonth();
            month = monthNames[month];
            weekday = weekday[dayIndex];
            var year = date.getFullYear();
            var time = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
            //console.log(day +'  '+ month +'  '+ year);
            $("#currentDay").text(day);
            $("#currentMonth").text(month +' '+ day);
            $("#currentYear").text(year);
            $("#currentWeekday").text(weekday);
            $("#currentTime").text(time);
        });
    </script>
    <!-- jQuery 2.2.3 -->
    {!! Html::script('assets/plugins/jQuery/jquery-2.2.3.min.js') !!}
    <!-- jQuery UI 1.11.4 -->
    {!! Html::script('//code.jquery.com/ui/1.11.4/jquery-ui.min.js') !!}
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    {!! Html::script('assets/bootstrap/js/bootstrap.min.js') !!}
    <!-- Morris.js charts -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js') !!}
    {{--{!! Html::script('assets/plugins/morris/morris.min.js') !!}--}}

    <!-- Sparkline -->
    {!! Html::script('assets/plugins/sparkline/jquery.sparkline.min.js') !!}
    <!-- jvectormap -->
    {!! Html::script('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') !!}
    {!! Html::script('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') !!}
    <!-- jQuery Knob Chart -->
    {!! Html::script('assets/plugins/knob/jquery.knob.js') !!}
    <!-- daterangepicker -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js') !!}
    {!! Html::script('assets/plugins/daterangepicker/daterangepicker.js') !!}
    <!-- datepicker -->
    {!! Html::script('assets/plugins/datepicker/bootstrap-datepicker.js') !!}
    <!-- Bootstrap WYSIHTML5 -->
    {!! Html::script('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') !!}
    <!-- Slimscroll -->
    {!! Html::script('assets/plugins/slimScroll/jquery.slimscroll.min.js') !!}
    <!-- FastClick -->
    {!! Html::script('assets/plugins/fastclick/fastclick.js') !!}
    <!-- AdminLTE App -->
    {!! Html::script('assets/dist/js/app.js') !!}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{--{!! Html::script('assets/dist/js/pages/dashboard.js') !!}--}}
    <!-- AdminLTE for demo purposes -->
    {!! Html::script('assets/dist/js/demo.js') !!}
    {!! Html::script('assets/js/jquery-ui.js') !!}   <!-- Old Css -->
    {!! Html::script('assets/js/jquery-ui-timepicker.js') !!}   <!-- Old Css -->
    <!-- Select2 JavaScript -->
    {!! Html::script('assets/components/select2/select2.full.js') !!} <!-- Old js -->
    {!! Html::script('assets/js/fSelect.js') !!} <!-- Old js -->
    <!-- Jquery Form JavaScript -->
    {!! Html::script('assets/js/jquery.form.js') !!} <!-- Old js -->
    {!! Html::script('assets/js/commonModal.js') !!} <!-- Old js -->
    <!-- Input Mask JavaScript -->
    {!! Html::script('assets/components/input-mask/jquery.inputmask.js') !!} <!-- Old js -->
    {!! Html::script('assets/components/input-mask/jquery.inputmask.date.extensions.js') !!} <!-- Old js -->

    <!-- Custom JavaScript -->
    {!! Html::script('assets/js/template.js') !!}<!-- Old js -->

    {{--<!-- Metis Menu Plugin JavaScript -->
    {!! Html::script('assets/components/metis-menu/metisMenu.js') !!} <!-- Old js -->
    <!-- Main Theme JavaScript -->
    {!! Html::script('assets/js/main.js') !!} <!-- Old js -->
    --}}
    <script type="text/javascript">
        var activeurl = window.location;
        if($('a[href="'+activeurl+'"]').parent('li').parent('ul').parent('li'))
            $('a[href="'+activeurl+'"]').parent('li').parent('ul').parent('li').parent('ul').parent('li').parent('ul').addClass('in');
            $('a[href="'+activeurl+'"]').parent('li').parent('ul').parent('li').parent('ul').parent('li').parent('ul').parent('li').addClass('active');


            $('a[href="'+activeurl+'"]').parent('li').parent('ul').parent('li').parent('ul').addClass('in');
            $('a[href="'+activeurl+'"]').parent('li').parent('ul').parent('li').parent('ul').parent('li').addClass('active');

        $(window).scroll(function()
        {
            var sticky = $('.sticky');
            // Use the wrapper's top
            if (sticky.parent().position().top - $(window).scrollTop() < 0) {
                if (!sticky.data('fixed')) {
                    sticky.css({
                        'position': 'fixed',
                        'width': '100%',
                        'top': '0'
                    });
                    sticky.data('fixed', true)
                }
            } else if (sticky.data('fixed')) {
                sticky.css({
                    'position': 'relative',
                    'top': 'auto'
                });
                sticky.data('fixed', false)
            }
        });
    </script>

</body>
</html>