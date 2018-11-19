
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <style>
        .labelXS{
            font-size: 11px !important;
        }
        .headerFont{
            font-size: 8px !important;
        }
        .headerFontXL{
            font-size: 13px !important;
        }
        .none{
            display: none;
        }

        td { font-size: 11px; }

        .btn-xs{
            padding: 0px 0px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-bar-chart"></i>
                {{ __("authenticated.List Deactivated Terminals") }}
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Users") }}</li>
                <li class="active">{{ __("authenticated.List Deactivated Terminals") }}</li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-11 col-xs-8">
                            @if(!env('HIDE_EXPORT_TO_EXCEL'))
                            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'terminal/list-deactivated-terminals-excel'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                            <button class="btn btn-sm btn-primary pull-right" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Export To Excel") }}">
                                <span class = "fa fa-file-excel-o"></span>
                                {{ __("authenticated.Export To Excel") }}
                            </button>
                            {!! Form::close() !!}
                            @endif
                        </div>
                        <div class="col-md-1 col-xs-4">
                            <button id="reloadTreeBtn" class="btn btn-block btn-sm btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Reload") }}">
                                <span class = "fa fa-refresh"></span>
                                {{ __("authenticated.Reload") }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="report" class="table table-bordered dataTable pull-left" style="width: 100%; font-size: 11px !important;">
                                <thead>
                                <tr id="tableHeader" class="bg-blue-active headerFontXL">
                                    <th style="text-align: left;">{{__ ("authenticated.Terminal")}}</th>
                                    <th style="text-align: left;">{{__ ("authenticated.Parent")}}</th>
                                    <th style="text-align: left;">{{__ ("authenticated.User Type")}}</th>
                                    <th style="text-align: left;">{{__ ("authenticated.Registration Date")}}</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function(){
            var financialReportTable;

            LINKS.init(["{{config('constants.ROLE_CLIENT')}}", "{{config('constants.ROLE_ADMINISTRATOR')}}", "{{config('constants.ROLE_LOCATION')}}",
                "{{config('constants.TERMINAL_SALES')}}", "{{config('constants.ROLE_OPERATER')}}", "{{config('constants.ROLE_CASHIER_TERMINAL')}}",
                "{{config('constants.ROLE_SUPPORT')}}", "{{config('constants.ROLE_SUPPORT_SYSTEM')}}", "{{config('constants.ROLE_SUPPORT')}}"]);

            window.reload = function (){
                financialReportTable.ajax.reload();
            };

            financialReportTable = $('#report').DataTable( {
                initComplete: function (settings, json) {
                    $("#report_length").addClass("pull-right");
                    $("#report_filter").addClass("pull-left");
                },
                "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                "order": [],
                scrollY: "60vh",
                scrollX: true,
                select: true,
                colReorder: true,
                stateSave: false,
                "deferRender": true,
                "processing": true,
                "serverSide": false,
                searching: true,
                ajax: {
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listDisconnectedTerminals") }}",
                    "dataSrc": "result"
                },
                "paging": true,
                pagingType: 'full_numbers',
                "iDisplayLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
                columns:[
                    {
                        data: function(row){
                            return '<a class="underline-text bold-text" href="' + row.link + '">' + row.username + '</a>';
                        },
                        width: 100,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: "parent_username",
                        width: 100,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: "subject_dtype_bo_name",
                        width: 100,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: "registration_date",
                        width: 150,
                        className: "text-center",
                        bSearchable: true,
                        sortable: true
                    }
                ],
                "language": {
                    "zeroRecords": "<?php echo __("No records available."); ?>",
                    "info": "<?php echo __("Showing _START_ to _END_ of _MAX_ entries."); ?>",
                    "lengthMenu": "<?php echo __("Showing _MENU_ entries"); ?>",
                    "search": "<?php echo __("Search"); ?>",
                    "infoEmpty": "<?php echo __("No records available."); ?>",
                    "infoFiltered": "<?php echo __("filtered from _MAX_ total records"); ?>",
                    "paginate": {
                        "first": "<?php echo __("First") ?>",
                        "last": "<?php echo __("Last") ?>",
                        "previous": "<?php echo __("Previous") ?>",
                        "next": "<?php echo __("Next") ?>"
                    }
                }
            } );
        });
    </script>
@endsection
