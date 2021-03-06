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
        <script type="text/javascript">
            var notify;

            function pingValidSession(){
                $.ajax(
                    {
                        type: "POST",
                        data: "ping=1",
                        dataType: "json",
                        global: false,
                        url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/session-validation/ping-session') }}",
                        async: true,
                        success: function (data) {
                            if(!data.valid_session){
                               window.location = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/auth/logout') }}";
                            }else{

                            }

                        },
                        error: function (data) {
                            window.location = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/auth/logout') }}";
                        }
                    }
                );
            }
            setInterval("pingValidSession()", 60000);

             function pingSessionTime(){
                 $.ajax(
                     {
                         type: "get",
                         dataType: "json",
                         global: false,
                         url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'getSessionRemainingTime') }}",
                         async: true,
                         success: function (data) {
                             if(data.time < 120){
                                 if(data.time <= 1){
                                     window.location = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/auth/logout') }}";
                                 }else{
                                     if ($("#sessionTimeModal").data('bs.modal') && $("#sessionTimeModal").data('bs.modal').isShown){

                                     }else{
                                         $('.modal').modal('hide');
                                         $("#sessionTimeModal").modal({
                                             //backdrop:'static',
                                             keyboard:false,
                                             show:true
                                         });
                                     }
                                 }
                             }
                         },
                         error: function (req, textStatus, errorThrown) {

                         }
                     }
                 );
             }

             setInterval("pingSessionTime()", 60000);

            function generateNotification(title, message){

                if (typeof notify !== 'undefined') {
                    notify.close();
                }

                notify = $.notify({
                    // options
                    icon: 'glyphicon glyphicon-info-sign',
                    title: title,
                    message: message
                    /*url: 'https://github.com/mouse0270/bootstrap-notify',
                    target: '_blank'*/
                },{
                    // settings
                    element: 'body',
                    position: 'absolute',
                    type: "default",
                    allow_dismiss: true,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 5000,
                    timer: 1000,
                    url_target: '_blank',
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    },
                    onShow: null,
                    onShown: null,
                    onClose: null,
                    onClosed: null,
                    icon_type: 'class',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert" style="background-color: #3c8dbc !important; color: white">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
                });
            }
        </script>
</head>
<body class="skin-blue fixed sidebar-mini layout-top-nav sidebar-collapse" @if (Config::get('ENABLE_RIGHT_CLICK_ON_PAGE')) oncontextmenu="return false;" @endif>
<div class="wrapper">

    <div id="loadingPage" style="display: none;">
	    <h2> {{ __('authenticated.Page Loading Message') }} </h2>
	    <img alt="" src="{{ url('images/progressbar-loader.gif') }}"/>
    </div>

    @include('layouts.desktop_layout.header')

  <!-- =============================================== -->

    {{--@include('layouts.desktop_layout.left_sidebar_menu')--}}

  <!-- =============================================== -->
        @yield('content')
  <!-- =============================================== -->

    @include('layouts.desktop_layout.footer')
</div>
<div class="modal fade" id="sessionTimeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{__ ("authenticated.Wake Up !")}}</h4>
            </div>
            <div class="modal-body">
                <p id="sessionTimeModalMessage">{{__ ("authenticated.You have been inactive for too long. Your session will expire in about a minute, unless you extend it or be active.")}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{__ ("authenticated.Cancel")}}</button>
                <button id="sessionTimeModalExtendBtn" type="button" class="btn btn-primary pull-right">{{__ ("authenticated.Extend")}}</button>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function(){
        $("#sessionTimeModalExtendBtn").on("click", function(){
            validateSession();
        });
        function validateSession(){
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'validateSessionModal') }}",
                success: function (data) {
                    if(data.status == "OK"){
                        $('#sessionTimeModal').modal('hide');
                    }else{

                    }
                },
                error: function (data) {

                }
            });
        }
    });
</script>
</html>
