<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')<!-- Content Wrapper. Contains page content -->
<style>
    td.details-control {
        background: url('{{asset('images/details_open.png')}}') no-repeat center center !important;
        cursor: pointer !important;
    }
    tr.shown td.details-control {
        background: url('{{asset('images/details_close.png')}}') no-repeat center center !important;
    }
    .redBackground{
        background-color: #de9090 !important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-bar-chart"></i>
            {{ __("authenticated.Ticket List") }}
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Reports") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "ticket-list") }}">
                    {{ __("authenticated.Ticket List") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="row">
                <div class="col-md-12">
                    <button id="toggleBtn" class="btn btn-sm btn-primary pull-right" style="margin-top: 25px !important; margin-right: 15px !important;">
                        <span id="toggleSpan" class="fa fa-toggle-on"></span>
                        {{ __("authenticated.Toggle") }}
                    </button>
                    <button id="reportReload" class="btn btn-sm btn-primary pull-right" style="margin-top: 25px !important; margin-right: 15px !important;"><span class="fa fa-refresh">&nbsp;</span>{{trans("authenticated.Reload")}}</button>
                </div>
            </div>
            <div class="box-header" id="filterContainer">
                <div class="row">
                    <div class="col-md-2">
                        <label for="affiliate" class="control-label">{{__('authenticated.Affiliate1')}}</label>
                        <select class="form-control" id="affiliate" name="affiliate">
                            <option value="">{{trans("authenticated.All")}}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="ticketStatus" class="control-label">{{__('authenticated.Ticket Status')}}</label>
                        <select class="form-control" id="ticketStatus" name="ticketStatus">
                            <option value="">{{trans("authenticated.All")}}</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <div class="input-group date startdate">
                            <div class="">
                                {!! Form::label('fromDate', trans('authenticated.Start Date') . ':', array('class' => 'control-label label-break-line')) !!}
                                <div class="input-group date">
                                    {!!
                                        Form::text('fromDate', $report_start_date,
                                            array(
                                                  'class'=>'form-control',
                                                  'readonly'=>'readonly',
                                                  'size' => 12,
                                                  'placeholder'=>trans('authenticated.Start Date')
                                            )
                                        )
                                    !!}
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="input-group date enddate">
                            <div class="">
                                {!! Form::label('toDate', trans('authenticated.End Date') . ':', array('class' => 'control-label label-break-line')) !!}
                                <div class="input-group date">
                                    {!!
                                        Form::text('toDate', $report_end_date,
                                            array(
                                                  'class'=>'form-control',
                                                  'readonly'=>'readonly',
                                                  'size' => 12,
                                                  'placeholder'=>trans('authenticated.End Date')
                                            )
                                        )
                                    !!}
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div id="tableContainer">
                    <table style="width: 100%; font-size: 11px !important;" id="ticket-list-report" class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                        <tr class="bg-blue-active">
                            <th style=""></th>
                            <th style="text-align: left;">{{ __("authenticated.Location") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Player") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Ticket SN") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Created By") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Created Date & Time") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Ticket Status") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Bet per Draw") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Bet per Ticket") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Possible Win") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Executed Win") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Currency") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Combinations") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Jackpot Code") }}</th>
                            <th style="text-align: left;">{{ __("authenticated.Ticket Repeat") }}</th>
                            <th width="100">{{ __("authenticated.First Draw SN") }}</th>
                            <th width="150">{{ __("authenticated.Draw Date & Time") }}</th>
                            <th width="100">{{ __("authenticated.Ticket Details") }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>
<script>
    $(document).ready(function(){
        $.fn.select2.defaults.set("theme", "bootstrap");

        $('#affiliate').select2({
            language: {
                noResults: function (params) {
                    return "{{trans("authenticated.No results found")}}";
                }
            }
        });
        var startDateFromSession = "{{session('auth.report_start_date')}}";
        var endDateFromSession = "{{session('auth.report_end_date')}}";
        var validDate = true;

        var height = "50vh";
        var reportData = [];

        var table;
        var nestedTable;
        var tableCounter = 1;

        $('#fromDate').datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            todayBtn: "linked",
            endDate: '+0d',
            forceParse: true
        });
        $('#toDate').datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            todayBtn: "linked",
            endDate: '+0d',
            forceParse: true
        });

        $("#toDate").datepicker("setDate", endDateFromSession);
        $("#fromDate").datepicker("setDate", "-1d");

        $(".startdate").on('click',function(){
            $('#fromDate').focus();
        });
        $(".enddate").on('click',function(){
            $('#toDate').focus();
        });

        function getReportData(){
            $("#ticketStatus").prop("disabled", true);
            $("#affiliate").prop("disabled", true);
            $("#fromDate").prop("disabled", true);
            $("#toDate").prop("disabled", true);

            $.ajax({
                method: "GET",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket-list-report") }}",
                "dataSrc": "result",
                data: {
                    affiliate_id: $("#affiliate").val(),
                    report_start_date: $("#fromDate").val(),
                    report_end_date: $("#toDate").val(),
                    ticket_status: $("#ticketStatus").val()
                },
                success: function(data){
                    reportData = data.result;

                    generateReport(height, reportData);
                },
                complete: function(data){
                    $("#ticketStatus").prop("disabled", false);
                    $("#affiliate").prop("disabled", false);
                    $("#fromDate").prop("disabled", false);
                    $("#toDate").prop("disabled", false);
                }
            });
        }

        $("#reportReload").on("click", function(){
            getReportData();
        });

        window.openDrawDetails = function(link){
            window.open(link, 'draw_details_window', 'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=950,height=600,top=100,left=100,resizable=yes');
        };

        window.openTicketDetails = function(link){
            window.open(link, 'draw_details_window');
        };

        $('#ticket-list-report').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            var row_data = row.data();
            var ticket_serial_number = row_data.serial_number;

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row

                row.child( format(tableCounter) ).show();
                tr.addClass('shown');

                nestedTable = $("#test"+tableCounter).DataTable({
                    "order": [],
                    responsive: false,
                    scrollY: "20vh",
                    scrollX: true,
                    select: true,
                    colReorder: true,
                    stateSave: false,
                    "deferRender": true,
                    "processing": false,
                    "serverSide": false,
                    searching: true,
                    ajax: {
                        method: "GET",
                        url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "ticketDetailsPerDrawAjax") }}",
                        data:{
                            ticket_serial_number: ticket_serial_number
                        },
                        "dataSrc": "result"
                    },
                    //data: reportData,
                    "paging": false,
                    pagingType: 'full_numbers',
                    "iDisplayLength": -1,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '{{trans("authenticated.All")}}']],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    "dom": 'ti',
                    columns:[
                        {
                            data: function(row, type, val, meta){
                                return '<a class="noblockui bold-text underline" href="#" onClick=openDrawDetails("' + row.link + '"' + ')>' + row.draw_id + '</a>';
                            },
                            width: 100,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.draw_date_time;
                            },
                            width: 100,
                            className: "text-center",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.bet_per_draw;
                            },
                            width: 100,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.bet_per_ticket;
                            },
                            width: 100,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.possible_win;
                            },
                            width: 100,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.executed_win;
                            },
                            width: 100,
                            className: "text-right",
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
                });
                tableCounter++;
            }
        } );

        function format ( table_id ) {
            // `d` is the original data object for the row
            return '<table id="test' + table_id + '" class="table table-bordered table-striped pull-left" style="width: 600px; font-size: 11px !important;">'+
                '<thead>' +
                '<tr class="">' +
                '<th style="text-align: left;">{{ __("authenticated.Draw ID") }}</th>' +
                '<th style="text-align: left;">{{ __("authenticated.Date & Time") }}</th>' +
                '<th style="text-align: left;">{{ __("authenticated.Bet Per Draw") }}</th>' +
                '<th style="text-align: left;">{{ __("authenticated.Bet Per Ticket") }}</th>' +
                '<th style="text-align: left;">{{ __("authenticated.Possible Win") }}</th>' +
                '<th style="text-align: left;">{{ __("authenticated.Executed Win") }}</th>' +
                '</tr>' +
                '</thead>'+
                '</table>';
        }

        window.showAllCombinations = function(oneCombinationId, moreCombinationsId, oneButtonId, moreButtonId){
            $("#"+oneCombinationId).hide();

            $("#"+moreCombinationsId).slideDown("fast", function(){
                $("#"+moreButtonId).hide();
                $("#"+oneButtonId).show();
            });
        };
        window.showOneCombination = function(oneCombinationId, moreCombinationsId, oneButtonId, moreButtonId){
            $("#"+moreCombinationsId).slideUp("fast", function(){
                $("#"+oneButtonId).hide();
                $("#"+oneCombinationId).show();
                $("#"+moreButtonId).show();
            });

        };

        function generateReport(height, data){
            var counter = 0;
            if(table){
                table.destroy();
            }
            table = $('#ticket-list-report').DataTable( {
                "initComplete": function(settings, json) {
                    $("#ticket-list-report_length").addClass("pull-right");
                    $("#ticket-list-report_filter").addClass("pull-left");
                },
                "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                "order": [],
                responsive: false,
                scrollY: height,
                scrollX: true,
                select: true,
                colReorder: true,
                stateSave: false,
                "deferRender": true,
                "processing": false,
                "serverSide": false,
                searching: true,
                data: data,
                "paging": true,
                pagingType: 'full_numbers',
                "iDisplayLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '{{trans("authenticated.All")}}']],
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
                columns:[
                    {
                        data: null,
                        className: 'details-control',
                        sortable: false,
                        width: 50,
                        defaultContent: ''
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.location_name;
                        },
                        width: 50,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.player_name;
                        },
                        width: 50,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            var output = '<a class="noblockui bold-text" href="' + row.link + '">' + row.serial_number + '</a>';
                            return output;
                        },
                        width: 60,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.created_by;
                        },
                        width: 60,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.rec_tmstp_formated;
                        },
                        width: 120,
                        className: "text-center",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.ticket_status;
                        },
                        width: 80,
                        className: "text-center",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.bet_per_draw;
                        },
                        width: 80,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.bet_per_ticket;
                        },
                        width: 80,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.possible_win;
                        },
                        width: 80,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.executed_win;
                        },
                        width: 100,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.currency;
                        },
                        width: 80,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            counter++;
                            var oneCombinationId = "oneCombination"+counter;
                            var moreCombinationsId = "moreCombinations"+counter;
                            var moreButtonId = "moreButton"+counter;
                            var oneButtonId = "oneButton"+counter;

                            var number_of_combinations = row.number_of_combinations;

                            if(number_of_combinations > 1){
                                return '<span style="display: none" id="'+moreCombinationsId+'">'+row.combination_type_name+'</span><span id="'+oneCombinationId+'">'+row.first_combination+
                                    '</span><br><button id="' + moreButtonId + '" class="btn btn-sm btn-primary" onclick="showAllCombinations('+ '\'' + oneCombinationId + '\',\'' + moreCombinationsId + '\',\'' + oneButtonId + '\',\'' + moreButtonId + '\'' +')"><span class="fa fa-chevron-down"></span></button>'
                                    +'<button style="display: none;" id="' + oneButtonId + '" class="btn btn-sm btn-primary" onclick="showOneCombination('+ '\'' + oneCombinationId + '\',\'' + moreCombinationsId + '\',\'' + oneButtonId + '\',\'' + moreButtonId + '\'' +')"><span class="fa fa-chevron-up"></span></button>';
                            }else{

                                return '<span id="'+oneCombinationId+'">'+row.first_combination+'</span>';
                            }
                        },
                        width: 80,
                        className: "text-center",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            var local = row.local_jp_code;
                            var global = row.global_jp_code;

                            var output = "{{trans('authenticated.Local')}}: " + local + "<br>" + "{{trans('authenticated.Global')}}: " + global;

                            return output;
                        },
                        width: 80,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.ticket_repeat;
                        },
                        width: 80,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.first_draw_sn;
                        },
                        width: 80,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            return row.draw_date_time_formated;
                        },
                        width: 100,
                        className: "text-center",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            var output = '<a class="btn btn-primary" href="' + row.link + '"><span class="fa fa-info"></span>' + '</a>';
                            return output;
                        },
                        width: 80,
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
        }

        function listAffiliates(){
            $.ajax({
                method: "GET",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "list-affiliates") }}",
                global: false,
                dataType: "json",
                //data: "result",
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "OK"){
                        var affiliateDropdown = document.getElementById("affiliate");

                        $.each(data.result, function(index, value){
                            var element = document.createElement('option');

                            element.value = value.subject_id;
                            element.textContent = value.username;

                            affiliateDropdown.appendChild(element);
                        });

                    }else if(data.status == -1){

                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        }

        function listTicketStatuses(){
            $.ajax({
                method: "GET",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "ticket-list-statuses") }}",
                global: false,
                dataType: "json",
                //data: "result",
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "OK"){
                        var ticketStatusesDropdown = document.getElementById("ticketStatus");

                        $.each(data.result, function(index, value){
                            var element = document.createElement('option');

                            element.value = index;
                            element.textContent = value;

                            ticketStatusesDropdown.appendChild(element);
                        });

                    }else if(data.status == -1){

                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        }

        $("#reloadBtn").on("click", function(){
            getReportData();
        });
        $("#ticketStatus, #affiliate").on("change", function(){
            getReportData();
        });
        $("#toDate").datepicker().on("changeDate", function(){
            var toDate = $(this).val();
            var fromDate = $("#fromDate").val();

            var toDateObject = new Date(toDate);
            var fromDateObject = new Date(fromDate);

            if(toDate === ""){
                $(this).datepicker("setDate", endDateFromSession);
            }else{
                if(toDateObject < fromDateObject){
                    $(this).addClass("redBackground");
                    $("#fromDate").addClass("redBackground");
                    validDate = false;
                }else{
                    $(this).removeClass("redBackground");
                    $("#fromDate").removeClass("redBackground");
                    validDate = true;
                    getReportData();
                }
            }
        });
        $("#fromDate").datepicker().on("changeDate", function(){
            var toDate = $("#toDate").val();
            var fromDate = $(this).val();

            var toDateObject = new Date(toDate);
            var fromDateObject = new Date(fromDate);

            if(fromDate === ""){
                $(this).datepicker("setDate", "-1d");
            }else{
                if(toDateObject < fromDateObject){
                    $(this).addClass("redBackground");
                    $("#toDate").addClass("redBackground");
                    validDate = false;
                }else{
                    $(this).removeClass("redBackground");
                    $("#toDate").removeClass("redBackground");
                    validDate = true;
                    getReportData();
                }
            }
        });

        $("#toggleBtn").on("click", function(){
            if($('#toggleSpan').is(".fa.fa-toggle-on")){
                $("#filterContainer").hide(500, function () {
                    $('#toggleSpan').switchClass( "fa-toggle-on", "fa-toggle-off", 500, afterComplete1);
                });
            }else{
                afterComplete2(customCallback);
            }
        });

        function afterComplete1(){
            height = "70vh";
            generateReport(height, reportData);
        }
        function afterComplete2(callback){
            height = "50vh";
            generateReport(height, reportData);
            callback();
        }
        function  customCallback(){
            $("#filterContainer").show(500, function () {
                $('#toggleSpan').switchClass( "fa-toggle-off", "fa-toggle-on", 500);
            });
        }

        listAffiliates();
        listTicketStatuses();
        getReportData();
    })
</script>
@endsection
