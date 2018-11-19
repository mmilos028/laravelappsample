
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{ __("authenticated.Financial Report") }}                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Reports") }}</li>
                <li class="active">{{ __("authenticated.Financial Report") }}</li>
            </ol>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-body">
                    <div class="row">
                      <table class="table">
                        <td class="pull-right form-inline row-border">

                          <div id="startdate" class="input-group date">
                              {!!
                                  Form::text('report_start_date', $report_start_date,
                                      array(
                                          'id' => 'report_start_date',
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

                          <div id="enddate" class="input-group date">
                              {!!
                                  Form::text('report_end_date', $report_end_date,
                                      array(
                                          'id' => 'report_end_date',
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

                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" onClick='loadFinancialReportForUser()'>
                              <i class="fa fa-refresh"></i>
                              {{ __("authenticated.Generate Report") }}
                            </button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="#" class="noblockui" onClick="loadFinancialReportForUserSmall()">
                                    <i class="fa fa-compress"></i>
                                    {{ __("authenticated.Small") }}
                                </a>
                              </li>
                              <li>
                                <a href="#" class="noblockui" onClick="loadFinancialReportForUserLarge()">
                                  <i class="fa fa-expand"></i>
                                  {{ __("authenticated.Large") }}
                                </a>
                              </li>
                            </ul>
                          </div>

                        </td>
                      </table>
                    </div>

                    <div class="row">
                      <div class="col-xs-4">
                        <div class="table-responsive">
                            <table id="treeUsers" class="easyui-treegrid" style="width:450px;height:600px">
                            </table>
                        </div>
                      </div>
                      <div class="col-xs-8">
                        <div class="row">
                          <div id="topScrollbar">
                              <div id="topScrollbar-div">
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="table-responsive financial_report_for_user_scrollable">
                            <table id="financial_report_for_user" style="width: 95%; margin: 0; padding: 0;"></table>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        var view_small_large = 'large';

        function loadFinancialReportForUser(){
            if(view_small_large == 'large') {
                loadFinancialReportForUserLarge();
            }else{
                loadFinancialReportForUserSmall();
            }
        }

        function loadFinancialReportForUserLarge(){

            view_small_large = 'large';

            var node = $('#treeUsers').treegrid("getSelected");
            if(node != null) {
                var user_id = node.id;
                var start_date = $("#report_start_date").val();
                var end_date = $("#report_end_date").val();

                $("#financial_report_for_user").load(
                    "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/list-financial-report-for-user") }}",
                    {
                        user_id: user_id,
                        report_start_date: start_date,
                        report_end_date: end_date
                    },
                    function (response, status, xht) {
                        if (status == "error") {
                            //window.top.location = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/auth/logout") }}";
                        }
                    });
            }
        }

        function loadFinancialReportForUserSmall(){

            view_small_large = 'small';

            var node = $('#treeUsers').treegrid("getSelected");
            if(node != null) {
                var user_id = node.id;
                var start_date = $("#report_start_date").val();
                var end_date = $("#report_end_date").val();

                $("#financial_report_for_user").load(
                    "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/list-financial-report-for-user-small") }}",
                    {
                        user_id: user_id,
                        report_start_date: start_date,
                        report_end_date: end_date
                    },
                    function (response, status, xht) {
                        if (status == "error") {
                            //window.top.location = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/auth/logout") }}";
                        }
                    });
            }
        }

        $(document).ready(function(){
            var now = new Date();
            $.fn.datepicker.defaults.format = "dd-M-yyyy";
            $.fn.datepicker.defaults.allowDeselection = false;

            var currentTime = new Date();
            var startDateFrom = new Date(currentTime.getFullYear(), currentTime.getMonth() - parseInt('<?php echo Session::get('auth.report_date_months_in_past'); ?>'), 1);
            var startDateTo = new Date(currentTime.getFullYear(), currentTime.getMonth() +1, 0);

            var startdateDate;
            $("#report_start_date").datepicker({
                dateFormat: 'dd-M-yyyy',
                changeYear: true,
                changeMonth: true,
                showWeek: true,
                enableOnReadonly: true,
                keyboardNavigation: true,
                todayBtn: true,
                showOnFocus: true,
                todayHighlight: true,
                forceParse: true,
                autoclose: true,
                    startDate: startDateFrom, endDate: startDateTo, numberOfMonths: 1
            });

            var enddateDate;
            $("#report_end_date").datepicker({
                dateFormat: 'dd-M-yyyy',
                changeYear: true,
                changeMonth: true,
                showWeek: true,
                enableOnReadonly: true,
                keyboardNavigation: true,
                todayBtn: true,
                showOnFocus: true,
                todayHighlight: true,
                forceParse: true,
                autoclose: true,
                startDate: startDateFrom, numberOfMonths: 1
            });
            $("#report_end_date").change(function() {
                var date1 = $("#report_start_date").datepicker("getDate");
                var date2 = $("#report_end_date").datepicker("getDate");
                if(date2 < date1){
                    $("#report_end_date").val($("#report_start_date").val());
                }
            });
            $("#report_start_date").change(function(){
                var date1 = $("#report_start_date").datepicker("getDate");
                var date2 = $("#report_end_date").datepicker("getDate");
                if(date2 < date1){
                    $("#report_start_date").val($("#report_end_date").val());
                }
            });

            // Save date picked
            $("#report_start_date").on('show', function () {
                startdateDate = $(this).val();
            });
            // Replace with previous date if no date is picked or if same date is picked to avoide toggle error
            $("#report_start_date").on('hide', function () {
                if ($(this).val() === '' || $(this).val() === null) {
                    $(this).val(startdateDate).datepicker('update');
                }
            });

            // Save date picked
            $("#report_end_date").on('show', function () {
                enddateDate = $(this).val();
            });
            // Replace with previous date if no date is picked or if same date is picked to avoide toggle error
            $("#report_end_date").on('hide', function () {
                if ($(this).val() === '' || $(this).val() === null) {
                    $(this).val(enddateDate).datepicker('update');
                }
            });

            $("#startdate").on('click',function(){
                  $('#report_start_date').focus();
            });
            $("#enddate").on('click',function(){
                  $('#report_end_date').focus();
            });

            var topScrollbar = document.getElementById('topScrollbar');
            var topScrollbar_div = document.getElementById('topScrollbar-div');
            var tableResponsive = document.getElementsByClassName('financial_report_for_user_scrollable');
            tableResponsive = tableResponsive[0];

            topScrollbar.style = "width: 320px; border: none; overflow-x: scroll; overflow-y:hidden;height: 20px;";
            topScrollbar_div.style = "width:1500px; height: 20px;";

            topScrollbar.onscroll = function() {
              tableResponsive.scrollLeft = topScrollbar.scrollLeft;
            };
            tableResponsive.onscroll = function() {
              topScrollbar.scrollLeft = tableResponsive.scrollLeft;
            };

            var origTreegrid_autoSizeColumn = $.fn.datagrid.methods['autoSizeColumn'];
            $.extend($.fn.treegrid.methods, {
                autoSizeColumn: function(jq, field) {
                    $.each(jq, function() {
                        var opts = $(this).treegrid('options');
                        if (!opts.skipAutoSizeColumns) {
                            var tg_jq = $(this);
                            if (field) origTreegrid_autoSizeColumn(tg_jq, field);
                            else origTreegrid_autoSizeColumn(tg_jq);
                        }
                    });
                }
            });

            $('#treeUsers').treegrid({
                method: 'GET',
                url: '{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getSubjectTreeUsers") }}',
                loadFilter: function(rows){
                    return convert(rows[0]);
                },

                pagination: false,
                lines: false,
                idField:'id',
                treeField:'name',
                rownumbers: false,
                autoRowHeight: false,
                animate: true,
                collapsible: true,
                fitColumns: false,
                skipAutoSizeColumns: false,
                loadMsg: '{{ __("authenticated.Page Loading Message") }}',
                onBeforeExpand: function() {
                    $(this).treegrid('options').skipAutoSizeColumns = true;
                },
                onBeforeCollapse: function() {
                    $(this).treegrid('options').skipAutoSizeColumns = true;
                },
                onExpand: function() {
                    $(this).treegrid('options').skipAutoSizeColumns = false;
                },
                onCollapse: function() {
                    $(this).treegrid('options').skipAutoSizeColumns = false;
                },
                onClickRow: function(row){

                },
                onLoadSuccess: function (row, data){
                    $('#treeUsers').treegrid("select", 1);
                },
                onSelect: function (row){
                    loadFinancialReportForUser();
                },
                columns:[[
                    {title:'{{ __("authenticated.Username") }}',field:'name',width:200},
                    //{title:'{{ __("authenticated.Parent Name") }}',field:'true_parent_name',width:100},
                    {title:'{{ __("authenticated.Role") }}',field:'subject_type_name',width:180}
                ]]
            });

            function collapseAll(){
                $('#treeUsers').treegrid('collapseAll');
            }
            function expandAll(){
                $('#treeUsers').treegrid('expandAll');
            }
            function convert(rows){
                return rows;
            }
        });
    </script>
@endsection
