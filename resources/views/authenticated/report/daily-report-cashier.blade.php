
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <style>
        .labelXS{
            font-size: 11px !important;
        }
        /*input:not(.datagrid-editable-input) {
            text-align: right;
        }*/
        .padding{
            padding: 20px 5px 5px 15px !important;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-bar-chart"></i>
                {{ __("authenticated.Daily Report") }}
                <button id="showContextualMessage" class="btn btn-primary"><strong class="fa fa-question-circle"></strong></button>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Reports") }}</li>
                <li class="active">{{ __("authenticated.Daily Report") }}</li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-1 col-xs-2 padding">
                                        <button id="reloadTreeBtn" class="btn btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Reload") }}">
                                            <span class = "fa fa-refresh"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 col-xs-2 padding">
                                        <button id="toggleTreeGrid" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Toggle") }}" disabled>
                                            <span id="toggleSpan" class = "fa fa-toggle-on"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 col-xs-2 padding" style="display: none;">
                                        <button id="collapseToRootBtn" class="btn primary" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Home") }}" onclick="collapseAll()">
                                            <span class = "fa fa-home"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 col-xs-2 padding">
                                        <button id="showDirectTreeBtn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Direct") }}" onclick="collapseNotRoot()">
                                            <span class = "fa fa-home"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 col-xs-2 padding">
                                        <button id="expandTreeBtn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.All") }}" onclick="expandAll()">
                                            <span class = "fa fa-bars"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @if($agent->isDesktop())
                                <div class="col-md-4">
                                    <div class="input-group date startdate">
                                        <div class="">
                                            {!! Form::label('reportDate', trans('authenticated.For Date') . ':', array('class' => 'control-label label-break-line')) !!}
                                            <div class="input-group date">
                                                {!!
                                                    Form::text('reportDate', $report_end_date,
                                                        array(
                                                              'class'=>'form-control',
                                                              'readonly'=>'readonly',
                                                              'size' => 12,
                                                              'placeholder'=>trans('authenticated.For Date')
                                                        )
                                                    )
                                                !!}
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4" id="treeGridContainer">
                            <table id="tree1" class="easyui-treegrid" style="width:100%;height:700px">
                            </table>
                        </div>
                        <div id="tablesContainer" class="col-md-8 animate">
                            <div class="jumbotron" id="infoBox" align="center">
                                <div class="container">
                                    <p>{{__('authenticated.This report is possible only for Locations and Cashiers.')}}</p>
                                </div>
                            </div>
                            @if($agent->isMobile())
                                <div class="row">
                                    <br>
                                    <div class="col-md-4">
                                        <div class="input-group date startdate">
                                            <div class="">
                                                {!! Form::label('reportDate', trans('authenticated.For Date') . ':', array('class' => 'control-label label-break-line')) !!}
                                                <div class="input-group date">
                                                    {!!
                                                        Form::text('reportDate', $report_end_date,
                                                            array(
                                                                  'class'=>'form-control',
                                                                  'readonly'=>'readonly',
                                                                  'size' => 12,
                                                                  'placeholder'=>trans('authenticated.For Date')
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
                            @endif
                            <div class="col-md-6" id="locationContainer" style="display: none;">
                                <h2 class="text-light-blue">{{__('authenticated.Location')}} &nbsp;<strong id="locationName"></strong></h2>
                                <form id="locationReport" class="form-horizontal row-border">
                                    <div style="margin-top:78px;">

                                    </div>
                                    <div class="row">
                                       <div class="col-md-5">
                                           <div class="form-group">
                                               <label for="number_of_deposits_location" class="control-label labelXS">{{__('authenticated.Number Of Deposits')}}:</label>
                                               <input disabled class="form-control" name="number_of_deposits_location" type="text" id="number_of_deposits_location">
                                           </div>
                                       </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deposit_total_location" class="control-label labelXS">{{__('authenticated.Deposit Total')}}:</label>
                                                <input disabled class="form-control" name="deposit_total_location" type="text" id="deposit_total_location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_cashiers_deposits_location" class="control-label labelXS">{{__('authenticated.Cashier Deposits')}}:</label>
                                                <input disabled class="form-control" name="number_of_cashiers_deposits_location" type="text" id="number_of_cashiers_deposits_location">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deposit_cashier_total_location" class="control-label labelXS">{{__('authenticated.Cashier Total Deposit')}}:</label>
                                                <input disabled class="form-control" name="deposit_cashier_total_location" type="text" id="deposit_cashier_total_location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_online_deposits_location" class="control-label labelXS">{{__('authenticated.Online Deposits')}}:</label>
                                                <input disabled class="form-control" name="number_of_online_deposits_location" type="text" id="number_of_online_deposits_location">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deposit_online_total_location" class="control-label labelXS">{{__('authenticated.Online Deposit Total')}}:</label>
                                                <input disabled class="form-control" name="deposit_online_total_location" type="text" id="deposit_online_total_location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_canceled_deposits_location" class="control-label labelXS">{{__('authenticated.Canceled Deposits')}}</label>
                                                <input disabled class="form-control" name="number_of_canceled_deposits_location" type="text" id="number_of_canceled_deposits_location">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deposit_canceled_total_location" class="control-label labelXS">{{__('authenticated.Canceled Deposit Total')}}:</label>
                                                <input disabled class="form-control" name="deposit_canceled_total_location" type="text" id="deposit_canceled_total_location">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_withdraws_location" class="control-label labelXS">{{__('authenticated.Number Of Withdraws')}}:</label>
                                                <input disabled class="form-control" name="number_of_withdraws_location" type="text" id="number_of_withdraws_location">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="withdraw_total_location" class="control-label labelXS">{{__('authenticated.Withdraw Total')}}:</label>
                                                <input disabled class="form-control" name="withdraw_total_location" type="text" id="withdraw_total_location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_cashier_withdraws_location" class="control-label labelXS">{{__('authenticated.Cashier Withdraws')}}:</label>
                                                <input disabled class="form-control" name="number_of_cashier_withdraws_location" type="text" id="number_of_cashier_withdraws_location">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="withdraw_cashier_total_location" class="control-label labelXS">{{__('authenticated.Cashier Withdraw Total')}}:</label>
                                                <input disabled class="form-control" name="withdraw_cashier_total_location" type="text" id="withdraw_cashier_total_location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_online_withdraws_location" class="control-label labelXS">{{__('authenticated.Online Withdraws')}}:</label>
                                                <input disabled class="form-control" name="number_of_online_withdraws_location" type="text" id="number_of_online_withdraws_location">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="withdraw_online_total_location" class="control-label labelXS">{{__('authenticated.Online Withdraw Total')}}:</label>
                                                <input disabled class="form-control" name="withdraw_online_total_location" type="text" id="withdraw_online_total_location">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6" id="cashierContainer" style="display: none;">
                                <h2 class="text-light-blue">{{__('authenticated.Cashier')}} &nbsp;<strong id="cashierName"></strong></h2>
                                <form id="cashierReport" class="form-horizontal row-border">
                                    <div class="row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="start_balance_cashier" class="control-label labelXS">{{__('authenticated.Start Balance')}}:</label>
                                                <input disabled class="form-control" name="start_balance_cashier" type="text" id="start_balance_cashier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_deposits_cashier" class="control-label labelXS">{{__('authenticated.Number Of Deposits')}}:</label>
                                                <input disabled class="form-control" name="number_of_deposits_cashier" type="text" id="number_of_deposits_cashier">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deposit_total_cashier" class="control-label labelXS">{{__('authenticated.Deposit Total')}}:</label>
                                                <input disabled class="form-control" name="deposit_total_cashier" type="text" id="deposit_total_cashier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_cashiers_deposits_cashier" class="control-label labelXS">{{__('authenticated.Cashier Deposits')}}:</label>
                                                <input disabled class="form-control" name="number_of_cashiers_deposits_cashier" type="text" id="number_of_cashiers_deposits_cashier">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deposit_cashier_total_cashier" class="control-label labelXS">{{__('authenticated.Cashier Deposit Total')}}:</label>
                                                <input disabled class="form-control" name="deposit_cashier_total_cashier" type="text" id="deposit_cashier_total_cashier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_online_deposits_cashier" class="control-label labelXS">{{__('authenticated.Online Deposits')}}:</label>
                                                <input disabled class="form-control" name="number_of_online_deposits_cashier" type="text" id="number_of_online_deposits_cashier">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deposit_online_total_cashier" class="control-label labelXS">{{__('authenticated.Online Deposit Total')}}:</label>
                                                <input disabled class="form-control" name="deposit_online_total_cashier" type="text" id="deposit_online_total_cashier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_canceled_deposits_cashier" class="control-label labelXS">{{__('authenticated.Canceled Deposits')}}:</label>
                                                <input disabled class="form-control" name="number_of_canceled_deposits_cashier" type="text" id="number_of_canceled_deposits_cashier">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="deposit_canceled_total_cashier" class="control-label labelXS">{{__('authenticated.Canceled Deposit Total')}}:</label>
                                                <input disabled class="form-control" name="deposit_canceled_total_cashier" type="text" id="deposit_canceled_total_cashier">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_withdraws_cashier" class="control-label labelXS">{{__('authenticated.Number Of Withdraws')}}:</label>
                                                <input disabled class="form-control" name="number_of_withdraws_cashier" type="text" id="number_of_withdraws_cashier">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="withdraw_total_cashier" class="control-label labelXS">{{__('authenticated.Withdraw Total')}}:</label>
                                                <input disabled class="form-control" name="withdraw_total_cashier" type="text" id="withdraw_total_cashier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_cashier_withdraws_cashier" class="control-label labelXS">{{__('authenticated.Cashier Withdraws')}}:</label>
                                                <input disabled class="form-control" name="number_of_cashier_withdraws_cashier" type="text" id="number_of_cashier_withdraws_cashier">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="withdraw_cashier_total_cashier" class="control-label labelXS">{{__('authenticated.Cashier Withdraw Total')}}:</label>
                                                <input disabled class="form-control" name="withdraw_cashier_total_cashier" type="text" id="withdraw_cashier_total_cashier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="number_of_online_withdraws_cashier" class="control-label labelXS">{{__('authenticated.Online Withdraws')}}:</label>
                                                <input disabled class="form-control" name="number_of_online_withdraws_cashier" type="text" id="number_of_online_withdraws_cashier">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="withdraw_online_total_cashier" class="control-label labelXS">{{__('authenticated.Online Withdraw Total')}}:</label>
                                                <input disabled class="form-control" name="withdraw_online_total_cashier" type="text" id="withdraw_online_total_cashier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="end_balance_cashier" class="control-label labelXS">{{__('authenticated.End Balance')}}:</label>
                                                <input disabled class="form-control" name="end_balance_cashier" type="text" id="end_balance_cashier">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                        <strong>{{trans("authenticated.This report shows cashier and location totals.")}}</strong>
                        <br><br>
                        {{trans("authenticated.Data is retrieved for selected subject and selected day.")}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button id="closeContextualMessageModal" type="button" data-dismiss = "modal" class="btn btn-default pull-right">{{trans("authenticated.Close")}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="messageModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Server Message</h4>
                </div>
                <div class="modal-body">
                    <p id="messageModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Ok</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <script>
        $(document).ready(function(){
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

            var selected_subject_id;
            var selected_subject_type_id;
            var selected_subject_username;
            var collapseToRoot = true;

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

            $('#reportDate').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true,
                todayBtn: "linked",
                setDate: new Date()
            });
            $("#reportDate").datepicker("setDate", new Date());

            $(".startdate").on('click',function(){
                $('#reportDate').focus();
            });

            $("#reportDate").datepicker().on("changeDate", function(){
                var reportDate = $(this).val();

                var reportDateObject = new Date(reportDate);

                if(reportDate === ""){
                    $(this).datepicker("setDate", new Date());
                }else{
                    if(selected_subject_id) {
                        generateReport(selected_subject_id, reportDate, selected_subject_type_id, selected_subject_username);
                    }
                }
            });

            $("#messageModal").on("hidden.bs.modal", function(e){
                sessionStorage.setItem("automaticSelect", "no");
            });


            $('#toggleTreeGrid').click(function(){
                if($('#tablesContainer').is(".col-md-8")){
                    $("#toggleTreeGrid,#reloadTreeBtn,#collapseToRootBtn,#expandTreeBtn,#showDirectTreeBtn").prop("disabled", true);
                    function afterComplete1(){
                        $("#reloadTreeBtn,#collapseToRootBtn,#expandTreeBtn,#showDirectTreeBtn").prop("disabled", true);
                        $("#toggleTreeGrid").prop("disabled", false);
                        $('#toggleSpan').switchClass( "fa-toggle-on", "fa-toggle-off", 500);
                    }

                    $('#treeGridContainer').toggle(200, function(){
                        $('#tablesContainer').switchClass( "col-md-8", "col-md-12", 200, afterComplete1);
                    });
                }else if($('#tablesContainer').is(".col-md-12")){
                    $("#toggleTreeGrid,#reloadTreeBtn,#collapseToRootBtn,#expandTreeBtn,#showDirectTreeBtn").prop("disabled", true);
                    $('#tablesContainer').switchClass( "col-md-12", "col-md-8", 200, afterComplete2);

                    function afterComplete2(){
                        $('#treeGridContainer').toggle(200, function(){
                            $("#toggleTreeGrid,#reloadTreeBtn,#collapseToRootBtn,#expandTreeBtn,#showDirectTreeBtn").prop("disabled", false);
                            $('#toggleSpan').switchClass( "fa-toggle-off", "fa-toggle-on", 500);
                        });
                    }

                }
            });

            window.reload = function (){
                var node = $('#tree1').treegrid('getSelected');
                if (node) {
                    $('#tree1').treegrid('reload', node.code);
                }
                else {
                    $('#tree1').treegrid('reload');
                }
            };
            window.collapseAll = function(){
                var node = $('#tree1').treegrid('getSelected');
                if(node != "<?php echo ALL; ?>"){
                    if (node){
                        $('#tree1').treegrid('collapseAll', node.code);
                    }
                    else{
                        $('#tree1').treegrid('collapseAll');
                    }
                }
            };
            window.expandAll = function(){
                var node = $('#tree1').treegrid('getSelected');
                if (node)$('#tree1').treegrid('expandAll', node.code);
                else $('#tree1').treegrid('expandAll');
            };
            window.collapseNotRoot = function(){
                var root = $("#tree1").treegrid('getRoot');
                $('#tree1').treegrid('collapseAll');
                if(root !== null){
                    $('#tree1').treegrid('expand', root.id);
                }
            };

            var tree = $('#tree1').treegrid({
                method: 'GET',
                url: '{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/financial-report-get-subject-tree-users") }}?listType=' + "6",
                //data: "result",
                loadFilter: function(rows){
                    var data = rows[0];

                    var opts = $(this).treegrid('options');
                    var originalData = $(this).treegrid('getData');
                    if (originalData){
                        setState(data);
                    }
                    return data;

                    function setState(data){
                        for(var i=0; i<data.length; i++){
                            var node = data[i];
                            var originalNode = findNode(node[opts.idField], originalData);
                            if (originalNode){
                                node.state = originalNode.state;
                            }
                            if (node.children){
                                setState(node.children);
                            }
                        }
                    }

                    function findNode(id, data){
                        var cc = [data];
                        while(cc.length){
                            var c = cc.shift();
                            for(var i=0; i<c.length; i++){
                                var node = c[i];
                                if (node[opts.idField] == id){
                                    return node;
                                } else if (node['children']){
                                    cc.push(node['children']);
                                }
                            }
                        }
                        return null;
                    }
                },
                remoteFilter: true,
                filterIncludingChild: true,
                filterDelay: 500,
                pagination: false,
                lines: false,
                idField:'id',
                treeField:'name',
                rownumbers: true,
                autoRowHeight: false,
                animate: true,
                collapsible: true,
                fitColumns: false,
                skipAutoSizeColumns: false,
                loadMsg: '<?php echo __("Loading, please wait ..."); ?>',
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
                onLoadSuccess: function() {
                    var automaticSelect = sessionStorage.getItem("automaticSelect");
                    $("#showContextualMessage").addClass("animated shake");

                    if(automaticSelect == "yes"){
                        var automaticSelectId = sessionStorage.getItem("automaticSelectId");

                        $('#tree1').treegrid('select', automaticSelectId);
                        var properties = $('#tree1').treegrid('getSelected');

                        if(properties === null){
                            $("#messageModalMessage").html("{{__ ('authenticated.Subject is non existent in this subject tree.')}}");
                            $("#messageModal").modal({
                                //backdrop:'static',
                                keyboard:false,
                                show:true
                            });
                        }else{
                            selected_subject_id = properties.id;
                            selected_subject_username = properties.name;

                            selected_subject_type_id = properties.subject_type_id;

                            var date = document.getElementById("reportDate").value;

                            document.getElementById("locationReport").reset();
                            document.getElementById("cashierReport").reset();

                            @if($agent->isMobile())
                            $("html, body").animate({ scrollTop: $("#reportDate").offset().top -100}, 1000);
                            @endif

                            if(selected_subject_type_id == "{{config('constants.LOCATION_TYPE_ID')}}" || selected_subject_type_id == "{{config('constants.CASHIER_TYPE_ID')}}" || selected_subject_type_id == "{{config('constants.SHIFT_CASHIER_TYPE_ID')}}"){
                                document.getElementById("infoBox").style.display = "none";

                                if(selected_subject_type_id == "{{config('constants.LOCATION_TYPE_ID')}}"){
                                    document.getElementById("locationContainer").style.display = "inline";
                                    document.getElementById("cashierContainer").style.display = "none";
                                }else if(selected_subject_type_id == "{{config('constants.CASHIER_TYPE_ID')}}" || selected_subject_type_id == "{{config('constants.SHIFT_CASHIER_TYPE_ID')}}"){
                                    document.getElementById("locationContainer").style.display = "inline";
                                    document.getElementById("cashierContainer").style.display = "inline";
                                }

                                generateReport(selected_subject_id, date, selected_subject_type_id, selected_subject_username);
                                $("#toggleTreeGrid").prop("disabled", false);
                            }else{
                                document.getElementById("infoBox").style.display = "block";
                                document.getElementById("locationContainer").style.display = "none";
                                document.getElementById("cashierContainer").style.display = "none";
                                $("#toggleTreeGrid").prop("disabled", true);
                            }
                        }
                    }else{
                        if(collapseToRoot){
                            collapseNotRoot();
                            collapseToRoot = false;
                        }
                    }
                },
                onClickRow: function(row){
                    selected_subject_id = row.id;
                    selected_subject_username = row.name;

                    selected_subject_type_id = row.subject_type_id;

                    var date = document.getElementById("reportDate").value;

                    document.getElementById("locationReport").reset();
                    document.getElementById("cashierReport").reset();

                    @if($agent->isMobile())
                    $("html, body").animate({ scrollTop: $("#reportDate").offset().top -100}, 1000);
                    @endif

                    if(selected_subject_type_id == "{{config('constants.LOCATION_TYPE_ID')}}" || selected_subject_type_id == "{{config('constants.CASHIER_TYPE_ID')}}" || selected_subject_type_id == "{{config('constants.SHIFT_CASHIER_TYPE_ID')}}"){
                        document.getElementById("infoBox").style.display = "none";

                        if(selected_subject_type_id == "{{config('constants.LOCATION_TYPE_ID')}}"){
                            document.getElementById("locationContainer").style.display = "inline";
                            document.getElementById("cashierContainer").style.display = "none";
                        }else if(selected_subject_type_id == "{{config('constants.CASHIER_TYPE_ID')}}" || selected_subject_type_id == "{{config('constants.SHIFT_CASHIER_TYPE_ID')}}"){
                            document.getElementById("locationContainer").style.display = "inline";
                            document.getElementById("cashierContainer").style.display = "inline";
                        }

                        generateReport(selected_subject_id, date, selected_subject_type_id, selected_subject_username);
                        $("#toggleTreeGrid").prop("disabled", false);
                    }else{
                        document.getElementById("infoBox").style.display = "block";
                        document.getElementById("locationContainer").style.display = "none";
                        document.getElementById("cashierContainer").style.display = "none";
                        $("#toggleTreeGrid").prop("disabled", true);
                    }
                },
                columns:[[
                    {title:'{{ __("authenticated.Username") }}',field:'name',width:"200"},
                    {title:'{{ __("authenticated.Role") }}',field:'subject_type_name',width:"200"}
                ]]
            });

            tree.treegrid('enableFilter', [
                {
                    field:'name',
                    type:'text',
                    id: "usernameFilter"

                },
                {
                    field:'subject_type_name',
                    type:'text'
                }
            ]);

            /*$("#reportDate").on("changeDate", function(){
                var date = $(this).val();
                if(selected_subject_id){
                    generateReport(selected_subject_id, date, selected_subject_type_id, selected_subject_username);
                }
            });*/

            function generateReport(subject_id, date, selected_subject_type_id, selected_subject_username){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "cashierDailyReportAjax") }}",
                    dataType: "json",
                    data: {
                        subject_id: subject_id,
                        date: date
                    },
                    success: function(data){
                        var cashierResult = data.cashier;
                        var locationResult = data.location;
                        var location_name = data.location_name;
                        var start_credits = data.start_credits;
                        var start_credits_formatted = data.start_credits_formatted;
                        var end_credits = data.end_credits;
                        var end_credits_formatted = data.end_credits_formatted;
                        var currency = data.currency;

                        //location
                        $("#start_balance_location").val("/");
                        $("#end_balance_location").val("/");

                        $("#number_of_deposits_location").val(locationResult[0].no_of_deposits);
                        $("#deposit_total_location").val(locationResult[0].sum_deposits_formatted);

                        $("#number_of_cashiers_deposits_location").val(locationResult[0].no_of_cashier_deposits);
                        $("#deposit_cashier_total_location").val(locationResult[0].sum_cashier_deposits_formatted);

                        $("#number_of_online_deposits_location").val(locationResult[0].no_of_online_deposits);
                        $("#deposit_online_total_location").val(locationResult[0].sum_of_online_deposits_formatted);

                        $("#number_of_canceled_deposits_location").val(locationResult[0].no_of_deactivated_tickets);
                        $("#deposit_canceled_total_location").val(locationResult[0].sum_canceled_deposits_formatted);

                        $("#number_of_withdraws_location").val(locationResult[0].no_of_payed_out_tickets);
                        $("#withdraw_total_location").val(locationResult[0].sum_of_payed_out_tickets_formatted);

                        $("#number_of_cashier_withdraws_location").val(locationResult[0].no_of_payed_out_tickets_cashier);
                        $("#withdraw_cashier_total_location").val(locationResult[0].sum_of_payed_out_tickets_cashier_formatted);

                        $("#number_of_online_withdraws_location").val(locationResult[0].no_of_payed_out_tickets_online);
                        $("#withdraw_online_total_location").val(locationResult[0].sum_of_payed_out_tickets_online_formatted);

                        //cashier
                        $("#start_balance_cashier").val(start_credits_formatted);
                        $("#end_balance_cashier").val(end_credits_formatted);

                        if(selected_subject_type_id == "{{config('constants.LOCATION_TYPE_ID')}}"){
                            $("#locationName").text("- " + selected_subject_username + " (" + currency + ")");
                        }else if(selected_subject_type_id == "{{config('constants.CASHIER_TYPE_ID')}}" || selected_subject_type_id == "{{config('constants.SHIFT_CASHIER_TYPE_ID')}}"){
                            $("#cashierName").text("- " + selected_subject_username + " (" + currency + ")");
                            if(location_name != undefined) {
                                $("#locationName").text("- " + location_name);
                            }else{
                                $("#locationName").text("");
                            }
                        }
                        //console.log(cashierResult[0]);

                        $("#number_of_deposits_cashier").val(cashierResult[0].no_of_deposits);
                        $("#deposit_total_cashier").val(cashierResult[0].sum_deposits_formatted);

                        $("#number_of_cashiers_deposits_cashier").val(cashierResult[0].no_of_cashier_deposits);
                        $("#deposit_cashier_total_cashier").val(cashierResult[0].sum_cashier_deposits_formatted);

                        $("#number_of_online_deposits_cashier").val(cashierResult[0].no_of_online_deposits);
                        $("#deposit_online_total_cashier").val(cashierResult[0].sum_of_online_deposits_formatted);

                        $("#number_of_canceled_deposits_cashier").val(cashierResult[0].no_of_deactivated_tickets);
                        $("#deposit_canceled_total_cashier").val(cashierResult[0].sum_canceled_deposits_formatted);

                        $("#number_of_withdraws_cashier").val(cashierResult[0].no_of_payed_out_tickets);
                        $("#withdraw_total_cashier").val(cashierResult[0].sum_of_payed_out_tickets_formatted);

                        $("#number_of_cashier_withdraws_cashier").val(cashierResult[0].no_of_payed_out_tickets_cashier);
                        $("#withdraw_cashier_total_cashier").val(cashierResult[0].sum_of_payed_out_tickets_cashier_formatted);

                        $("#number_of_online_withdraws_cashier").val(cashierResult[0].no_of_payed_out_tickets_online);
                        $("#withdraw_online_total_cashier").val(cashierResult[0].sum_of_payed_out_tickets_online_formatted);
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }
        });
    </script>
@endsection
