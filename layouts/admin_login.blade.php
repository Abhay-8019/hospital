<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
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
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') !!}
    <!-- Ionicons -->
    <!-- Ionicons -->
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css') !!}
    <!-- Theme style -->
    {!! Html::style('assets/dist/css/AdminLTE.min.css') !!}
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->

    {!! Html::style('assets/dist/css/skins/_all-skins.min.css') !!}
    <!-- iCheck -->
    {!! Html::style('assets/plugins/iCheck/flat/blue.css') !!}

    <!-- Custom CSS -->
    {!! Html::style('assets/css/template.css') !!} <!-- Old Css -->

    <!-- bootstrap wysihtml5 - text editor -->
    {!! Html::style('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page login-bg">

    @yield('content')

    @yield('script')

    <!-- jQuery 2.2.3 -->
    {!! Html::script('assets/plugins/jQuery/jquery-2.2.3.min.js') !!}
    <!-- Bootstrap 3.3.7 -->
    {!! Html::script('assets/bootstrap/js/bootstrap.min.js') !!}
</body>
</html>