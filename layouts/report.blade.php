<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
    <title>:: {!! Config::get('app.appname') !!} :: Invoice</title>


    <style type="text/css">
        body { background:none; font-family: Arial; font-size:11px; -webkit-print-color-adjust:exact; margin: 0; }
        .notesDiv h2 {
            text-align: center; border-bottom: 1px solid; border-width: 0px 0px 1px; margin: 0 0 1em;
            font-size: 22px; letter-spacing: 15px;
        }
        .notesDiv a { text-decoration: none !important; cursor: pointer !important; }
        .border0 {border: none !important;}
        .clearfix {clear: both !important;}
        .positionFixed {position: fixed !important;}
        .fontBold {font-weight: bold !important;}
        .width50{width: 50% !important;}
        .border-spacing0 {border-spacing: 0px !important;}
        .td-serial-no {background-color: #f9f9f9 !important; vertical-align: middle !important; text-align: center !important;}
        /*************************style for margin and paddings***************************/
        .paddingLeft0 {padding-left: 0px !important;}
        .paddingRight0 {padding-right: 0px !important;}
        .marginbottom0 {margin-bottom: 0px !important;}
        .company_detail p { margin: 0 0 0.25em !important;}
        .padding0 {padding: 0px !important;}
        .padding10-0 {padding: 10px 0px !important;}
        .marginbottom6 {margin: 0px 0 6px 0 !important;}
        .panel_default_radius { border-radius: 0px 0px 4px 4px !important; }

        @media all { .page-break, .hide  { display: none; }}
        @page { page-break-inside: avoid; page-break-after: always; }
        @media print {
            .PageBreak30 { page-break-before: always;  }
            table { page-break-inside:auto;}
            .hide {display: block;}

            a[href]:after {
                content: none !important;
            }
            .padding10-0 {padding: 10px 0px !important;}
            .panel_default_radius { border-radius: 4px !important; }
        }
    </style>
    {!! Html::style('assets/css/bootstrap.min.css') !!}
    <!-- Font Awesome -->
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') !!}
    <!-- Ionicons -->
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css') !!}
</head>
<body onload="window.print();" @yield('body_style', '')>
    <div class="container" id="report-container" style="margin-top : 10px !important;">
        <div class="content-wrapper">
            <div id="page-wrapper">
                {{-- for message rendering --}}
                @include('layouts.messages')
                <div class=""><!-- row -->
                    <div class="@yield('class', 'col-md-12') padding0">
                        @yield('company_detail')
                        <div class="col-md-12 clearfix">
                            <div class="panel panel-default @yield('panel_default', '')">
                                <div class="panel-heading text-center" style="background-color: #f5f5f5 !important;">&nbsp;
                                    @yield('heading')
                                </div>
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('script')
    {!! Html::script('assets/js/jquery.min.js') !!}
</body>
</html>