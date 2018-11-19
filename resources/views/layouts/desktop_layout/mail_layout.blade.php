<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noarchive" />

    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ __("authenticated.General Title") }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, user-scalable=yes" name="viewport">

    <link rel="stylesheet" href="{{ url('css/backoffice/animate.min.css') }}">
    <!-- Bootstrap 3.3.6 -->
    <link href="{{ url('adminlte/bootstrap/css/bootstrap.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <link href="{{ url('css/font-awesome/css/font-awesome.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ url('css/ionicons/css/ionicons.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Admin LTE Theme style -->
    <link href="{{ url('adminlte/dist/css/AdminLTE.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Admin LTE skin blue -->
    <link href="{{ url('adminlte/dist/css/skins/skin-blue.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Admin LTE all skins -->
    <link href="{{ url('adminlte/dist/css/skins/_all-skins.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Backoffice styles -->
    <link href="{{ url('css/backoffice/backoffice_styles.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!-- Backoffice custom theme -->
    <link rel="stylesheet" href="{{ url('css/backoffice/backoffice-desktop.css') }}" type="text/css">
    <link href="{{ url('css/backoffice/backoffice-theme.css') }}" media="screen" rel="stylesheet" type="text/css" />

    <!-- Datepicker theme -->
    <link href="{{ url('adminlte/plugins/datepicker/datepicker3.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ url('adminlte/plugins/daterangepicker/daterangepicker.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ url('adminlte/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <!--[if IE 9]>
    <link href="{{ url('adminlte/js/html5shiv.min.js') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ url('adminlte/js/respond.min.js') }}" media="screen" rel="stylesheet" type="text/css" />
    <![endif]-->

    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}" />
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}" />
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables/extensions/FixedHeader/css/dataTables.fixedHeader.css') }}" />

    <!-- JQUERY EASYUI -->
    <link rel="stylesheet" href="{{ url('js/jquery.easyui/themes/bootstrap/easyui.css') }}" />
    <link rel="stylesheet" href="{{ url('js/jquery.easyui/themes/icon.css') }}" />
    <link rel="stylesheet" href="{{ url('css/backoffice/table_fix.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/backoffice/additional-bootstrap-buttons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/backoffice/desktop_layout_fix.css') }}" type="text/css" />

    <!-- SELECT2 -->
    <link rel="stylesheet" href="{{ url('adminlte/plugins/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ url('css/select2-bootstrap-theme/dist/select2-bootstrap.css') }}" />
    <link href="{{asset('vendors/pnotify/dist/pnotify.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/pnotify/dist/pnotify.buttons.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/pnotify/dist/pnotify.nonblock.css')}}" rel="stylesheet">

    <!-- JQuery 2.2.3 -->
    <script type="text/javascript" src="{{ url('adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery-ui/jquery-ui.js') }}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script type="text/javascript" src="{{ url('adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Slimscroll -->
    <script type="text/javascript" src="{{ url('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Fastclick -->
    <script type="text/javascript" src="{{ url('adminlte/plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- Select -->
    <script type="text/javascript" src="{{ url('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Bootstrap datepicker -->
    <script type="text/javascript" src="{{ url('adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- JQuery numeric library -->
    <script type="text/javascript" src="{{ url('js/jquery.numeric.js') }}"></script>
    <!-- Mask input fields -->
    <script type="text/javascript" src="{{ url('js/mask.js') }}"></script>
    <!-- Admin LTE app.js -->
    <script type="text/javascript" src="{{ url('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- JQuery block UI -->
    <script type="text/javascript" src="{{ url('js/jquery.blockUI.js') }}"></script>
    <!-- Block interface desktop code -->
    <script type="text/javascript" src="{{ url('js/backoffice/desktop/block_interface.js') }}"></script>

    <script type="text/javascript" src="{{ url('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('adminlte/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('adminlte/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('adminlte/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.min.js') }}"></script>

    <script type="text/javascript" src="{{ url('adminlte/plugins/moment/min/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('adminlte/plugins/transition.js') }}"></script>
    <script type="text/javascript" src="{{ url('adminlte/plugins/collapse.js') }}"></script>
    <script type="text/javascript" src="{{ url('adminlte/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- JQUERY EASYUI -->
    <script type="text/javascript" src="{{ url('js/jquery.easyui/jquery.easyui.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.easyui/datagrid-filter.js') }}"></script>

    <script type="text/javascript" src="{{ url('js/backoffice/desktop/filter-input-text.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/structure_entity_controller_account_details_link_js.js') }}"></script>
    <script src="{{asset('vendors/bootstrap-notifications/bootstrap-notify.min.js')}}"></script>

    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images/favicon.ico') }}"/>
    <style>
        @media (min-width: 768px) {
            .modal-xl {
                width: 90%;
                /*max-width:1200px;*/
            }
        }
        .btn{
            border-radius: 4px !important;
        }
    </style>
</head>
<body class="skin-blue fixed sidebar-mini layout-top-nav sidebar-collapse" @if (Config::get('ENABLE_RIGHT_CLICK_ON_PAGE')) oncontextmenu="return false;" @endif>
<div class="wrapper">

@yield('content')

</div>
</body>
</html>
