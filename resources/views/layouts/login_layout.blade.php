<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ __("login.General Title") }}</title>
    <!-- Bootstrap 3.3.6 -->
    <link href="{{ url('adminlte/bootstrap/css/bootstrap.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <link href="{{ url('css/font-awesome/css/font-awesome.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ url('css/ionicons/css/ionicons.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Admin LTE Theme style -->
    <link href="{{ url('adminlte/dist/css/AdminLTE.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Backoffice custom theme -->
    <link href="{{ url('css/backoffice/backoffice-theme.css') }}" media="screen" rel="stylesheet" type="text/css" />

    <!--[if IE 9]>
    <link href="{{ url('adminlte/js/html5shiv.min.js') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ url('adminlte/js/respond.min.js') }}" media="screen" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!-- JQuery 2.2.3 -->
    <script type="text/javascript" src="{{ url('adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script type="text/javascript" src="{{ url('adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images/favicon.ico') }}"/>
    </head>
    <body class="hold-transition login-page" oncontextmenu="return false;">

    <!-- =============================================== -->

            @yield('content')

    <!-- =============================================== -->

</body>
</html>
