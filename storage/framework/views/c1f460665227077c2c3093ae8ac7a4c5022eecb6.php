<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
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
        .padding{
            padding: 20px 5px 5px 15px !important;
        }
        .redBackground{
            background-color: #de9090 !important;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-bar-chart"></i><?php echo e(__("authenticated.Collector Transactions")); ?>&nbsp;<button id="showContextualMessage" class="btn btn-primary"><strong class="fa fa-question-circle"></strong></button></h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> <?php echo e(__("authenticated.Reports")); ?></li>
                <li class="active"><?php echo e(__("authenticated.Collector Transactions")); ?></li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-7">
                            <?php if($agent->isDesktop()): ?>
                                <div class="row">
                                    <div class="col-md-1 padding">
                                        <button id="reloadTreeBtn" class="btn btn-block btn-sm btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Reload")); ?>">
                                            <span class = "fa fa-refresh"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 padding">
                                        <button id="toggleTreeGrid" class="btn btn-block btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Toggle")); ?>" disabled>
                                            <span id="toggleSpan" class = "fa fa-toggle-on"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 padding" style="display: none;">
                                        <button id="collapseToRootBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Home")); ?>" onclick="collapseAll()">
                                            <span class = "fa fa-home"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 padding">
                                        <button id="showDirectTreeBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Direct")); ?>" onclick="collapseNotRoot()">
                                            <span class = "fa fa-home"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 padding">
                                        <button id="expandTreeBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.All")); ?>" onclick="expandAll()">
                                            <span class = "fa fa-bars"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group date startdate">
                                <div class="">
                                    <?php echo Form::label('fromDate', trans('authenticated.Start Date') . ':', array('class' => 'control-label label-break-line')); ?>

                                    <div class="input-group date">
                                        <?php echo Form::text('fromDate', $report_start_date,
                                                array(
                                                      'class'=>'form-control',
                                                      'readonly'=>'readonly',
                                                      'size' => 12,
                                                      'placeholder'=>trans('authenticated.Start Date')
                                                )
                                            ); ?>

                                        <div class="input-group-addon"><span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group date enddate">
                                <div class="">
                                    <?php echo Form::label('toDate', trans('authenticated.End Date') . ':', array('class' => 'control-label label-break-line')); ?>

                                    <div class="input-group date">
                                        <?php echo Form::text('toDate', $report_end_date,
                                                array(
                                                      'class'=>'form-control',
                                                      'readonly'=>'readonly',
                                                      'size' => 12,
                                                      'placeholder'=>trans('authenticated.End Date')
                                                )
                                            ); ?>

                                        <div class="input-group-addon"><span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($agent->isDesktop()): ?>
                            <div class="col-md-1" align="right" style="padding-top: 22px;">
                                <button style="display: none;" id="longReport" class="btn btn-primary"><span class="fa fa-expand">&nbsp;</span><?php echo e(__('authenticated.Long')); ?></button>
                                <button style="display: none;" id="shortReport" class="btn btn-primary"><span class="fa fa-compress">&nbsp;</span><?php echo e(__('authenticated.Short')); ?></button>
                            </div>
                        <?php endif; ?>
                        <?php if($agent->isMobile()): ?>
                            <div class="row" style="padding-left: 20px !important;">
                                <br>
                                <div class="col-md-2 col-xs-2">
                                    <button id="reloadTreeBtn" class="btn btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Reload")); ?>">
                                        <span class = "fa fa-refresh"></span>
                                    </button>
                                </div>
                                <div class="col-md-1 col-xs-2">
                                    <button id="toggleTreeGrid" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Toggle")); ?>" disabled>
                                        <span id="toggleSpan" class = "fa fa-toggle-on"></span>
                                    </button>
                                </div>
                                <div class="col-md-1 col-xs-2" style="display: none;">
                                    <button id="collapseToRootBtn" class="btn btn-block btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Home")); ?>" onclick="collapseAll()">
                                        <span class = "fa fa-home"></span>
                                    </button>
                                </div>
                                <div class="col-md-1 col-xs-2">
                                    <button id="showDirectTreeBtn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Direct")); ?>" onclick="collapseNotRoot()">
                                        <span class = "fa fa-home"></span>
                                    </button>
                                </div>
                                <div class="col-md-1 col-xs-2">
                                    <button id="expandTreeBtn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.All")); ?>" onclick="expandAll()">
                                        <span class = "fa fa-bars"></span>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
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
                                    <p><?php echo e(__ ("authenticated.Select Subject.")); ?></p>
                                </div>
                            </div>
                            <?php if($agent->isMobile()): ?>
                                <div class="col-md-1" align="right" style="padding-top: 22px;">
                                    <button style="display: none;" id="longReport" class="btn btn-primary"><span class="fa fa-expand">&nbsp;</span><?php echo e(__('authenticated.Long')); ?></button>
                                    <button style="display: none;" id="shortReport" class="btn btn-primary"><span class="fa fa-compress">&nbsp;</span><?php echo e(__('authenticated.Short')); ?></button>
                                </div>
                                <br>
                            <?php endif; ?>
                            <div id="reportContainer" style="display: none;">
                                <div class="row" id="fullReportContainer">
                                    <table id="fullReport" class="table table-bordered dataTable pull-left" style="width: 100%; font-size: 13px !important;">
                                        <thead>
                                        <tr id="tableHeader" class="bg-blue-active headerFontXL">
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.No. Of Transactions")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Total Collected")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Total Withdraw")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Difference")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Currency")); ?></th>
                                        </thead>
                                    </table>
                                </div>
                                <hr>
                                <div class="row" id="transactionReportContainer">
                                    <table id="transactionReport" class="table table-bordered dataTable pull-left" style="width: 100%; font-size: 13px !important;">
                                        <thead>
                                        <tr id="tableHeader2" class="bg-blue-active labelXS">
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Datum & Time")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Transaction ID")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.From User")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.From Entity")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.To User")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.To Entity")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Amount")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Currency")); ?></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
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
                    <h4 class="modal-title"><?php echo e(trans("authenticated.Contextual Message")); ?></h4>
                </div>
                <div class="modal-body bg-info">
                    <p id="modal-body-p">
                        <strong><?php echo e(trans("authenticated.This report shows collector transactions.")); ?></strong>
                        <br><br>
                        <?php echo e(trans("authenticated.Data is retrieved per subject, for selected period, and is displayed in 2 tables. Bottom table represents list of transactions for selected subject and period. Upper table represents total values of transactions for selected subject and period, where the total is divided by days within the selected period.")); ?>

                    </p>
                </div>
                <div class="modal-footer">
                    <button id="closeContextualMessageModal" type="button" data-dismiss = "modal" class="btn btn-default pull-right"><?php echo e(trans("authenticated.Close")); ?></button>
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
            var transactionReportTable;
            var fullReportTable;
            var ignoreCall = false;
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";
            var validDate = true;
            var tableHeight = "40vh";
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

            $('#fromDate').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true,
                todayBtn: "linked",
                endDate: '+0d'
            });
            $('#toDate').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true,
                todayBtn: "linked",
                endDate: '+0d'
            });
            $("#toDate").datepicker("setDate", endDateFromSession);
            $("#fromDate").datepicker("setDate", startDateFromSession);

            $(".startdate").on('click',function(){
                $('#fromDate').focus();
            });
            $(".enddate").on('click',function(){
                $('#toDate').focus();
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
                        if(selected_subject_id){
                            if(!ignoreCall){
                                loadReport(selected_subject_id, fromDate, toDate);
                            }
                        }
                    }
                }
            });
            $("#fromDate").datepicker().on("changeDate", function(){
                var fromDate = $(this).val();
                var toDate = $("#toDate").val();

                var toDateObject = new Date(toDate);
                var fromDateObject = new Date(fromDate);

                if(fromDate === ""){
                    $(this).datepicker("setDate", startDateFromSession);
                }else{
                    if(toDateObject < fromDateObject){
                        $(this).addClass("redBackground");
                        $("#toDate").addClass("redBackground");
                        validDate = false;
                    }else{
                        $(this).removeClass("redBackground");
                        $("#toDate").removeClass("redBackground");
                        validDate = true;
                        if(selected_subject_id){
                            if(!ignoreCall){
                                loadReport(selected_subject_id, fromDate, toDate);
                            }
                        }
                    }
                }
            });

            $("#longReport").on("click", function(e){
                $("#fullReportContainer").show();
                $("#compressedReportContainer").hide();

                $(this).hide();
                $("#shortReport").show();
            });

            $("#shortReport").on("click", function(e){

                $("#fullReportContainer").hide();
                $("#compressedReportContainer").show();

                $(this).hide();
                $("#longReport").show();
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
                url: '<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/financial-report-get-subject-tree-users")); ?>?listType=' + "2",
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
                            $("#messageModalMessage").html("<?php echo e(__ ('authenticated.Subject is non existent in this subject tree.')); ?>");
                            $("#messageModal").modal({
                                //backdrop:'static',
                                keyboard:false,
                                show:true
                            });
                        }else{
                            selected_subject_id = properties.id;
                            var selected_subject_type_id = properties.subject_type_id;

                            var fromDate = sessionStorage.getItem("automaticSelectFromDate");
                            var toDate = sessionStorage.getItem("automaticSelectToDate");

                            ignoreCall = true;
                            $("#fromDate").datepicker("setDate", fromDate);
                            ignoreCall = false;
                            $("#toDate").datepicker("setDate", toDate);

                            /*$("#longReport").show();
                            $("#shortReport").hide();
                            $("#tableHeader").removeClass("headerFont").addClass("headerFontXL");*/

                            document.getElementById("reportContainer").style.display = "inline";
                            document.getElementById("infoBox").style.display = "none";

                            //loadReport(selected_subject_id, fromDate, toDate);

                            sessionStorage.setItem("automaticSelect", "no");
                            $("#toggleTreeGrid").prop("disabled", false);
                        }
                    }else{
                        if(collapseToRoot){
                            collapseNotRoot();
                            collapseToRoot = false;
                        }
                    }
                },
                onClickRow: function(row){
                    if(validDate){
                        selected_subject_id = row.id;
                        var selected_subject_type_id = row.subject_type_id;

                        var fromDate = document.getElementById("fromDate").value;
                        var toDate = document.getElementById("toDate").value;

                        ignoreCall = false;

                        loadReport(selected_subject_id, fromDate, toDate);
                        $("#toggleTreeGrid").prop("disabled", false);
                    }else{
                        selected_subject_id = row.id;
                    }
                },
                columns:[[
                    {title:'<?php echo e(__("authenticated.Username")); ?>',field:'name',width:"200"},
                    {title:'<?php echo e(__("authenticated.Role")); ?>',field:'subject_type_name',width:"200"}
                ]]
            });

            tree.treegrid('enableFilter', [
                {
                    field:'name',
                    type:'text'

                },
                {
                    field:'subject_type_name',
                    type:'text'
                }
            ]);

            window.showDetails = function(url){
                window.open(url);
            };

            function getReportData(selected_subject_id, fromDate, toDate){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "collectorTransactionReportAjax")); ?>",
                    data:{
                        subject_id: selected_subject_id,
                        start_date: fromDate,
                        end_date: toDate
                    },
                    "dataSrc": "result",
                    success: function(data){
                        generateReport(selected_subject_id, fromDate, toDate, data.result, data.result2);
                    }
                });
            }

            function loadReport(selected_subject_id, fromDate, toDate){
                document.getElementById("reportContainer").style.display = "inline";
                document.getElementById("infoBox").style.display = "none";

                getReportData(selected_subject_id, fromDate, toDate);

                /*$("#longReport").show();
                $("#shortReport").hide();
                $("#tableHeader").removeClass("headerFont").addClass("headerFontXL");*/

                <?php if($agent->isMobile()): ?>
                $("html, body").animate({ scrollTop: $(document).height() }, 1000);
                <?php endif; ?>
            }

            function generateFullReport(data){
                if(fullReportTable){
                    fullReportTable.destroy();
                }
                fullReportTable = $('#fullReport').DataTable( {
                    initComplete: function (settings, json) {
                        $("#fullReport_length").addClass("pull-right");
                        $("#fullReport_filter").addClass("pull-left");
                    },
                    "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                    "order": [],
                    scrollY: tableHeight,
                    scrollX: true,
                    select: true,
                    colReorder: true,
                    stateSave: false,
                    "deferRender": true,
                    "processing": true,
                    "serverSide": false,
                    searching: false,
                    data: data,
                    "paging": false,
                    pagingType: 'full',
                    "iDisplayLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    columns:[
                        {
                            data: function(row, type, val, meta){
                                return row.no_of_transactions;
                            },
                            width: 150,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.total_collected;
                            },
                            width: 150,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.total_withdraw;
                            },
                            width: 150,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.difference;
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
                            width: 100,
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

            function generateReport(selected_subject_id, fromDate, toDate, data, data2){
                if(transactionReportTable){
                    transactionReportTable.destroy();
                }
                transactionReportTable = $('#transactionReport').DataTable( {
                    initComplete: function (settings, json) {
                        $("#transactionReport_length").addClass("pull-right");
                        $("#transactionReport_filter").addClass("pull-left");
                        generateFullReport(data2);
                    },
                    "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                    "order": [],
                    scrollY: tableHeight,
                    scrollX: true,
                    select: true,
                    colReorder: true,
                    stateSave: false,
                    "deferRender": true,
                    "processing": true,
                    "serverSide": false,
                    searching: true,
                    data: data,
                    "paging": true,
                    pagingType: 'full',
                    "iDisplayLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    columns:[
                        {
                            data: function(row, type, val, meta){

                                return row.date_formatted;
                            },
                            width: 100,
                            className: "text-center",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.transaction_id;
                            },
                            width: 80,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var id = row.subject_id_for;
                                var subject_username = row.subject_name_for;
                                var url = row.url_from_user;

                                if(id == "<?php echo e(config('constants.ROOT_MASTER_ID')); ?>" || id == "<?php echo e(config('constants.LUCKY_SIX_ID')); ?>"){
                                    return subject_username;
                                }else{
                                    return "<button style='white-space: normal; text-align: left;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + subject_username + "</button>";

                                }
                            },
                            width: 100,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var id = row.from_entity_id;
                                var subject_username = row.from_entity;
                                var url = row.url_from_entity;

                                if(id == "<?php echo e(config('constants.ROOT_MASTER_ID')); ?>" || id == "<?php echo e(config('constants.LUCKY_SIX_ID')); ?>"){
                                    return subject_username;
                                }else{
                                    return "<button style='white-space: normal; text-align: left;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + subject_username + "</button>";

                                }
                            },
                            width: 80,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var id = row.subject_id_to;
                                var subject_username = row.subject_name_to;
                                var url = row.url_to_user;

                                if(id == "<?php echo e(config('constants.ROOT_MASTER_ID')); ?>" || id == "<?php echo e(config('constants.LUCKY_SIX_ID')); ?>"){
                                    return subject_username;
                                }else{
                                    return "<button style='white-space: normal; text-align: left;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + subject_username + "</button>";

                                }
                            },
                            width: 50,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var id = row.to_entity_id;
                                var subject_username = row.to_entity;
                                var url = row.url_to_entity;

                                if(id == "<?php echo e(config('constants.ROOT_MASTER_ID')); ?>" || id == "<?php echo e(config('constants.LUCKY_SIX_ID')); ?>"){
                                    return subject_username;
                                }else{
                                    return "<button style='white-space: normal; text-align: left;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + subject_username + "</button>";

                                }
                            },
                            width: 60,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.amount_formatted;
                            },
                            width: 80,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.currency;
                            },
                            width: 60,
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
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>