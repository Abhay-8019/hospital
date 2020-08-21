<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>:: {!! Config::get('app.appname') . ' - ' .  Config::get('app.slogan') !!} ::</title>
    <!-- Bootstrap Core CSS -->
    {!! HTML::style('assets/css/bootstrap.min.css') !!}
    
    <!-- Custom CSS -->
    {!! HTML::style('assets/css/style.css') !!}
    
    <!-- Custom Fonts -->
    {!! HTML::style('assets/components/font-awesome/css/font-awesome.min.css') !!}
    
    <!-- jQuery -->
    {!! HTML::script('assets/js/jquery.min.js') !!}
    <!-- Bootstrap Core JavaScript -->
    {!! HTML::script('assets/js/bootstrap.min.js') !!}    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="login-page">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        {{--<p class="text-center margin0">{!! HTML::image(asset('assets/images/96x96.png'), ucwords(Config::get('app.appname'))) !!}</p>--}}
                    </div>
                    <div class="panel-body">
                        <h3 class="panel-title clearfix"> <p> Sign in to {!! ucwords(Config::get('app.appname')) !!} </p></h3>
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                <button data-dismiss="alert" class="close">
                                    &times;
                                </button>
                                <i class="fa fa-times-circle"></i> &nbsp;
                                {!! Session::get('error') !!}
                            </div>
                        @endif
                        {!! Form::open(['url' => 'login', 'class' => 'form-login', 'method'=>'post']) !!}
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="email" type="text" autofocus autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block">
									Login <i class="fa fa-arrow-circle-right"></i>
								</button>
                            </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> 
 	<!-- Custom Theme JavaScript -->
    {!! HTML::script('assets/js/main.js') !!}       
</body>
</html>