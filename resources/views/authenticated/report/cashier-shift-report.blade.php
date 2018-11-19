<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
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
                {{ __("authenticated.Cashier Shift Report") }}
                <button id="showContextualMessage" class="btn btn-primary"><strong class="fa fa-question-circle"></strong></button>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Reports") }}</li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "cashier-shift-report") }}">
                        {{ __("authenticated.Cashier Shift Report") }}
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
                        <button id="reportReload" class="btn btn-sm btn-primary pull-right" style="margin-top: 25px !important; margin-right: 15px !important;">
                            <span class="fa fa-refresh">&nbsp;</span>
                            {{trans("authenticated.Reload")}}
                        </button>
                    </div>
                </div>
                <div class="box-header" id="filterContainer">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="affiliate" class="control-label">{{__('authenticated.Shift Cashier')}}</label>
                            <select class="form-control" id="affiliate" name="affiliate">
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
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div id="tableContainer">
                        <table style="width: 1300px;" id="list-shift-cashier-report" class="table table-bordered table-hover table-striped pull-left">
                            <thead>
                            <tr class="bg-blue-active">
                                <th style="text-align: left; width: 200px;">{{ __("authenticated.Cashier") }}</th>
                                <th style="text-align: left; width: 200px;">{{ __("authenticated.Location") }}</th>
                                <th style="text-align: right; width: 150px;">{{ __("authenticated.Shift Number") }}</th>
                                <th style="text-align: right; width: 150px;">{{ __("authenticated.Start Date") }}</th>
                                <th style="text-align: right; width: 150px;">{{ __("authenticated.Start Balance") }}</th>
                                <th style="text-align: right; width: 150px;">{{ __("authenticated.End Date") }}</th>
                                <th style="text-align: right; width: 150px;">{{ __("authenticated.End Balance") }}</th>
                                <th style="text-align: left; width: 150px;">{{ __("authenticated.Currency") }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <div class="modal fade animated zoomIn" id="contextualMessageModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans("authenticated.Contextual Message")}}</h4>
                </div>
                <div class="modal-body bg-info">
                    <p id="modal-body-p">
                        <strong>{{trans("authenticated.This report shows shift report for selected shift cashier and selected date.")}}</strong>
                        <br><br>
                        {{trans("authenticated.Data is retrieved for selected shift cashier.")}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button id="closeContextualMessageModal" type="button" data-dismiss = "modal" class="btn btn-default pull-right">{{trans("authenticated.Close")}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
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
        var tableCounter = 1;

        $("#showContextualMessage").on("click", function(e){
            $("#contextualMessageModal").modal({
                //backdrop:false,
                keyboard:false,
                show:true
            });
        });

        $("#contextualMessageModal").on("hide.bs.modal", function(e){
            $("#contextualMessageModal").removeClass("zoomIn", function(){
                $("#contextualMessageModal").addClass("zoomOut", function(){
                });
            });
        });

        $("#contextualMessageModal").on("hidden.bs.modal", function(e){
            $("#contextualMessageModal").removeClass("zoomOut");
            $("#contextualMessageModal").addClass("zoomIn");
        });

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

        $(".startdate").on('click',function(){
            $('#fromDate').focus();
        });
        $(".enddate").on('click',function(){
            $('#toDate').focus();
        });

        $("#toDate").datepicker("setDate", endDateFromSession);
        $("#fromDate").datepicker("setDate", "-1d");
        function getReportData(){
            generateReport(height, []);
        }

        $("#reportReload").on("click", function(){
            getReportData();
        });

        function generateReport(height, data){
            var counter = 0;
            if(table){
                table.destroy();
            }
            table = $('#list-shift-cashier-report').DataTable( {
                "initComplete": function(settings, json) {
                    $("#list-shift-cashier-report_length").addClass("pull-right");
                    $("#list-shift-cashier-report_filter").addClass("pull-left");
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
                "serverSide": true,
                searching: true,
                ajax: {
                    "url": "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/list-cashier-shift-report") }}",
                    "data": function(d){
                        d.affiliate_id = $("#affiliate").val();
                        d.report_start_date = $("#fromDate").val();
                        d.report_end_date = $("#toDate").val();
                    },
                    global: false
                },
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
                        data: function(row, type, val, meta){
                            if(row && row.cashier_username) {
                                return row.cashier_username;
                            }else {
                                return "";
                            }
                        },
                        width: 200,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            if(row && row.location_username) {
                                return row.location_username;
                            }else{
                                return "";
                            }
                        },
                        width: 200,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            if(row && row.shift_number) {
                                return row.shift_number;
                            }else {
                                return "";
                            }
                        },
                        width: 150,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            if(row && row.shift_start_date) {
                                return row.shift_start_date;
                            }else{
                                return "";
                            }
                        },
                        width: 150,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            if(row && row.start_balance) {
                                return row.start_balance;
                            }else {
                                return "";
                            }
                        },
                        width: 150,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            if(row && row.shift_end_date) {
                                return row.shift_end_date;
                            }else{
                                return "";
                            }
                        },
                        width: 150,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            if(row && row.end_balance) {
                                return row.end_balance;
                            }else {
                                return "";
                            }
                        },
                        width: 150,
                        className: "text-right",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            if(row && row.currency) {
                                return row.currency;
                            }else {
                                return "";
                            }
                        },
                        width: 150,
                        className: "text-left",
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

        function listShiftCashiers(){
            $.ajax({
                method: "GET",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "list-shift-cashiers") }}",
                global: false,
                dataType: "json",
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
                    getReportData();
                    $("#showContextualMessage").addClass("animated shake");
                },
                error: function(data){

                }
            });
        }

        $("#reloadBtn").on("click", function(){
            getReportData();
        });

        $("#affiliate").on("change", function(){
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

        listShiftCashiers();
    })
</script>
@endsection
