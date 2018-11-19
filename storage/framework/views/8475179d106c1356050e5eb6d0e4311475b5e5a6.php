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
        td{
            font-size: 11px;
        }
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
            <h1>
                <i class="fa fa-bar-chart"></i>
                <?php echo e(__("authenticated.Player Liability")); ?>

                <button id="showContextualMessage" class="btn btn-primary"><strong class="fa fa-question-circle"></strong></button>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> <?php echo e(__("authenticated.Reports")); ?></li>
                <li class="active"><?php echo e(__("authenticated.Player Liability")); ?></li>
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
                        <div class="col-md-4"></div>
                        <?php if($agent->isDesktop()): ?>
                            <div class="col-md-1" align="right" style="padding-top: 22px;">
                                <button style="display: none;" id="longReport" class="btn btn-primary"><span class="fa fa-expand">&nbsp;</span><?php echo e(__('authenticated.Long')); ?></button>
                                <button style="display: none;" id="shortReport" class="btn btn-primary"><span class="fa fa-compress">&nbsp;</span><?php echo e(__('authenticated.Short')); ?></button>
                            </div>
                        <?php endif; ?>
                        <?php if($agent->isMobile()): ?>
                            <div class="row" style="padding-left: 20px !important;">
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
                        <div class="col-md-8 animate" id="tablesContainer">
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
                                <div class="row" id="compressedReportContainer">
                                    <table id="compressedReport" class="table table-bordered dataTable pull-left" style="width: 100%; font-size: 13px !important;">
                                        <thead>
                                        <tr id="tableHeader" class="bg-blue-active headerFontXL">
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Username")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.First Name")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Last Name")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Actual Balance")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Currency")); ?></th>
                                        </thead>
                                    </table>
                                </div>
                                <div class="row" style="display: none;" id="fullReportContainer">
                                    <table id="fullReport" class="table table-bordered dataTable pull-left" style="width: 100%; font-size: 13px !important;">
                                        <thead>
                                        <tr id="tableHeader" class="bg-blue-active labelXS">
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Username")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.First Name")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Last Name")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Actual Balance")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Currency")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Deposits")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Withdraws")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Ticket Total")); ?></th>
                                            <th style="text-align: left;"><?php echo e(__ ("authenticated.Win")); ?></th>
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
                        <strong><?php echo e(trans("authenticated.This report shows player current totals.")); ?></strong>
                        <br><br>
                        <?php echo e(trans("authenticated.Data is retrieved for selected subject.")); ?>

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
            var compresedReportTable;
            var fullReportTable;
            var transactionsReportTable;
            var ignoreCall = false;
            var shortLongButtonShown = false;
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";
            var validDate = true;
            var collapseToRoot = true;

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
                                loadReport(selected_subject_id);
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
                    $(this).datepicker("setDate", endDateFromSession);
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
                                loadReport(selected_subject_id);
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
                url: '<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/financial-report-get-subject-tree-users")); ?>?listType=' + "5",
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

                            if(shortLongButtonShown){

                            }else{
                                $("#longReport").show();
                                $("#shortReport").hide();
                                $("#tableHeader").removeClass("headerFont").addClass("headerFontXL");
                            }

                            document.getElementById("reportContainer").style.display = "inline";
                            document.getElementById("infoBox").style.display = "none";

                            loadReport(selected_subject_id);

                            sessionStorage.setItem("automaticSelect", "no");
                            shortLongButtonShown = true;
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

                        ignoreCall = false;

                        loadReport(selected_subject_id);
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

            function loadReport(selected_subject_id){
                document.getElementById("reportContainer").style.display = "inline";
                document.getElementById("infoBox").style.display = "none";

                getReportData(selected_subject_id);

                if(shortLongButtonShown){

                }else{
                    $("#longReport").show();
                    $("#shortReport").hide();
                    $("#tableHeader").removeClass("headerFont").addClass("headerFontXL");
                }

                <?php if($agent->isMobile()): ?>
                $("html, body").animate({ scrollTop: $(document).height() }, 1000);
                <?php endif; ?>

                shortLongButtonShown = true;
            }

            window.showDetails = function(url){
                window.open(url);
            };

            function getReportData(selected_subject_id){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "playerLiabilityAjax")); ?>",
                    data:{
                        subject_id: selected_subject_id
                    },
                    "dataSrc": "result",
                    success: function(data){
                        generateReport(selected_subject_id, data.result);
                    }
                });
            }

            function generateLongReport(data){
                if(fullReportTable){
                    fullReportTable.destroy();
                }
                fullReportTable = $('#fullReport').DataTable( {
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
                    data: data,
                    "paging": false,
                    pagingType: 'full',
                    "iDisplayLength": -1,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    columns:[
                        {
                            data: function(row, type, val, meta){
                                var ord = row.ord;
                                var url = row.url;
                                var username = row.username;

                                if(ord == 2){
                                    return "<strong>" + username + "</strong>";
                                }else{
                                    return "<button style='white-space: normal; text-align: left;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + username + "</button>";
                                }
                            },
                            width: 70,
                            className: "text-left",
                            bSearchable: true,
                            sortable: false
                        },
                        {
                            data: "first_name",
                            width: 70,
                            className: "text-left",
                            bSearchable: true,
                            sortable: false
                        },
                        {
                            data: "last_name",
                            width: 60,
                            className: "text-left",
                            bSearchable: true,
                            sortable: false
                        },
                        {
                            data: function(row, type, val, meta){
                                var url = row.playerTransactionsUrl;
                                var actual_balance_formatted = row.actual_balance_formatted;
                                var ord = row.ord;

                                if(ord == 2){
                                    return "<strong>" + actual_balance_formatted + "</strong>";
                                }else{
                                    return "<button style='white-space: normal; text-align: right;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + actual_balance_formatted + "</button>";
                                }
                            },
                            width: 85,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var ord = row.ord;
                                var currency = row.currency;

                                if(ord == 2){
                                    return "<strong>" + currency + "</strong>";
                                }else{
                                    return currency;
                                }
                            },
                            width: 60,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var ord = row.ord;
                                var total_deposits_formatted = row.total_deposits_formatted;

                                if(ord == 2){
                                    return "<strong>" + total_deposits_formatted + "</strong>";
                                }else{
                                    return total_deposits_formatted;
                                }
                            },
                            width: 50,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var ord = row.ord;
                                var total_withdraws_formatted = row.total_withdraws_formatted;

                                if(ord == 2){
                                    return "<strong>" + total_withdraws_formatted + "</strong>";
                                }else{
                                    return total_withdraws_formatted;
                                }
                            },
                            width: 70,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var url = row.playerTicketsUrl;
                                var total_tickets_formatted = row.total_tickets_formatted;
                                var ord = row.ord;

                                if(ord == 2){
                                    return "<strong>" + total_tickets_formatted + "</strong>";
                                }else{
                                    return "<button style='white-space: normal; text-align: right;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + total_tickets_formatted + "</button>";
                                }
                            },
                            width: 70,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var url = row.playerTicketsUrl;
                                var total_win_formatted = row.total_win_formatted;
                                var ord = row.ord;

                                if(ord == 2){
                                    return "<strong>" + total_win_formatted + "</strong>";
                                }else{
                                    return "<button style='white-space: normal; text-align: right;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + total_win_formatted + "</button>";
                                }
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
                } );
            }

            function generateReport(selected_subject_id, data){
                if(compresedReportTable){
                    compresedReportTable.destroy();
                }
                compresedReportTable = $('#compressedReport').DataTable( {
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
                    data: data,
                    initComplete: function (settings, json) {
                        generateLongReport(data);
                    },
                    "paging": false,
                    pagingType: 'full',
                    "iDisplayLength": -1,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    columns:[
                        {
                            data: function(row, type, val, meta){
                                var ord = row.ord;
                                var url = row.url;
                                var username = row.username;

                                if(ord == 2){
                                    return "<strong>" + username + "</strong>";
                                }else{
                                    return "<button style='white-space: normal; text-align: left;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + username + "</button>";
                                }
                            },
                            width: 150,
                            //width: "15%",
                            className: "text-left",
                            bSearchable: true,
                            sortable: false
                        },
                        {
                            data: "first_name",
                            width: 100,
                            //width: "15%",
                            className: "text-left",
                            bSearchable: true,
                            sortable: false
                        },
                        {
                            data: "last_name",
                            width: 100,
                            //width: "15%",
                            className: "text-left",
                            bSearchable: true,
                            sortable: false
                        },
                        {
                            data: function(row, type, val, meta){
                                var url = row.playerTransactionsUrl;
                                var actual_balance_formatted = row.actual_balance_formatted;
                                var ord = row.ord;

                                if(ord == 2){
                                    return "<strong>" + actual_balance_formatted + "</strong>";
                                }else{
                                    return "<button style='white-space: normal; text-align: right;' class='btn btn-block btn-default btn-xs' onclick=showDetails('" + url + "')>" + actual_balance_formatted + "</button>";
                                }
                            },
                            width: 100,
                            //width: "15%",
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var ord = row.ord;
                                var currency = row.currency;

                                if(ord == 2){
                                    return "<strong>" + currency + "</strong>";
                                }else{
                                    return currency;
                                }
                            },
                            width: 100,
                            //width: "15%",
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