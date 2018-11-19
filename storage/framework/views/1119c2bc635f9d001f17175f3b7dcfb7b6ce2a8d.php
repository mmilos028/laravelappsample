<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <style>
        .labelXS {
            font-size: 11px !important;
        }
        .headerFont {
            font-size: 8px !important;
        }
        .headerFontXL {
            font-size: 13px !important;
        }
        .none {
            display: none;
        }
        .dratagrid-header {
            height: 40px;
        }
        .datagrid-row {
            height: 40px !important;
        }
        .datagrid-cell {
            height: auto !important;
        }
        td {
            font-size: 11px;
        }
        #startBalanceHeader,
        #endBalanceHeader {
            text-align: left !important;
        }
        .btn-xs {
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
                <?php echo e(__("authenticated.Profit & Collected")); ?>

                <button id="showContextualMessage" class="btn btn-primary"><strong class="fa fa-question-circle"></strong></button>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> <?php echo e(__("authenticated.Reports")); ?></li>
                <li class="active"><?php echo e(__("authenticated.Profit & Collected")); ?></li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <?php if($agent->isDesktop()): ?>
                        <div class="row">
                            <div class="col-md-1 padding">
                                <button id="reloadTree" class="btn btn-block btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Reload")); ?>">
                                    <span class="fa fa-refresh"></span>
                                </button>
                            </div>
                            <div class="col-md-1 padding">
                                <button id="showDirectTreeBtn" class="btn btn-block btn-primary" onclick="collapseNotRoot()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Direct")); ?>">
                                    <span class="fa fa-home"></span>
                                </button>
                            </div>
                            <div class="col-md-1 padding">
                                <button id="expandTreeBtn" class="btn btn-block btn-primary" onclick="expandAll()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.All")); ?>">
                                    <span class="fa fa-bars"></span>
                                </button>
                            </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-2">
                                <label for="currency" class="control-label"><?php echo e(__('authenticated.Currency')); ?></label>
                                <select class="form-control" id="currency" name="currency">
                                </select>
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
                            <div class="col-md-2">
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
                        </div>
                    <?php elseif($agent->isMobile()): ?>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="currency" class="control-label"><?php echo e(__('authenticated.Currency')); ?></label>
                                <select class="form-control" id="currency" name="currency">
                                </select>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
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
                        </div>
                        <div class="row">
                            <div class="col-xs-4 padding">
                                <button id="reloadTree" class="btn btn-block btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Reload")); ?>">
                                    <span class="fa fa-refresh"></span>
                                </button>
                            </div>
                            <div class="col-xs-4 padding">
                                <button id="showDirectTreeBtn" class="btn btn-block btn-primary" onclick="collapseNotRoot()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Direct")); ?>">
                                    <span class="fa fa-home"></span>
                                </button>
                            </div>
                            <div class="col-xs-4 padding">
                                <button id="expandTreeBtn" class="btn btn-block btn-primary" onclick="expandAll()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.All")); ?>">
                                    <span class="fa fa-bars"></span>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tree1" class="easyui-treegrid" style="width:100%;height:700px">
                            </table>
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
                        <strong><?php echo e(trans("authenticated.This report shows totals for profit (ticket) transactions and collector transactions.")); ?></strong>
                        <br><br>
                        <?php echo e(trans("authenticated.Data is retrieved for selected period and represented as subject tree.")); ?>

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
        $(document).ready(function () {
            var origTreegrid_autoSizeColumn = $.fn.datagrid.methods['autoSizeColumn'];
            $.extend($.fn.treegrid.methods, {
                autoSizeColumn: function (jq, field) {
                    $.each(jq, function () {
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
            var currency = "<?php echo e(session("auth.currency")); ?>";
            var ignoreCall = false;
            var collapseToRoot = true;
            var reportData = [];

            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";

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
                setDate: new Date()
            });
            $('#toDate').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true,
                todayBtn: "linked",
                setDate: new Date()
            });
            $("#toDate").datepicker("setDate", endDateFromSession);
            $("#fromDate").datepicker("setDate", startDateFromSession);

            $(".startdate").on('click',function(){
                $('#fromDate').focus();
            });
            $(".enddate").on('click',function(){
                $('#toDate').focus();
            });

            function listCurrencies(start_date, end_date) {
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listCurrenciesForStartEndDateAjax")); ?>",
                    dataType: "json",
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    },
                    //"dataSrc": "result",
                    success: function (data) {
                        if (data.status == "OK") {
                            var currencyDropdown = document.getElementById("currency");
                            $("#currency").empty();

                            $.each(data.result, function (index, value) {
                                var element = document.createElement('option');

                                element.value = value.currency;
                                element.textContent = value.currency;

                                currencyDropdown.appendChild(element);
                            });

                        } else if (data.status == -1) {

                        }
                    },
                    complete: function (data) {
                        document.getElementById("currency").value = currency;
                    },
                    error: function (data) {

                    }
                });
            }

            listCurrencies(document.getElementById("fromDate").value, document.getElementById("toDate").value);

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
                    }else{
                        $(this).removeClass("redBackground");
                        $("#fromDate").removeClass("redBackground");
                        generateReport();
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
                    }else{
                        $(this).removeClass("redBackground");
                        $("#toDate").removeClass("redBackground");
                        generateReport();
                    }
                }
            });

            $("#currency").on("change", function () {
                generateReport();
            });

            $("#longReport").on("click", function (e) {
                $("#fullReportContainer").show();
                $("#compressedReportContainer").hide();

                $(this).hide();
                $("#shortReport").show();
            });

            $("#shortReport").on("click", function (e) {
                $("#fullReportContainer").hide();
                $("#compressedReportContainer").show();

                $(this).hide();
                $("#longReport").show();
            });

            $("#messageModal").on("hidden.bs.modal", function(e){
                sessionStorage.setItem("automaticSelect", "no");
            });

            window.collapseAll = function(){
                var node = $('#tree1').treegrid('getSelected');
                if(node != "<?php echo ALL; ?>"){
                    if (node){
                        $('#tree1').treegrid('collapseAll', node.code);
                    }else{
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
                url: '<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "transactionReportAjax")); ?>?from_date=' + document.getElementById("fromDate").value + '&&to_date=' + document.getElementById("toDate").value + '&&currency=' + currency,
                loadFilter: function (rows) {
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
                idField: 'id',
                treeField: 'name',
                rownumbers: true,
                autoRowHeight: false,
                animate: true,
                collapsible: true,
                fitColumns: false,
                skipAutoSizeColumns: false,
                loadMsg: '<?php echo __("Loading, please wait ..."); ?>',
                onBeforeExpand: function () {
                    $(this).treegrid('options').skipAutoSizeColumns = true;
                },
                onBeforeCollapse: function () {
                    $(this).treegrid('options').skipAutoSizeColumns = true;
                },
                onExpand: function () {
                    $(this).treegrid('options').skipAutoSizeColumns = false;
                },
                onCollapse: function () {
                    $(this).treegrid('options').skipAutoSizeColumns = false;
                },
                onLoadSuccess: function () {
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
                            selected_subject_type_id = properties.subject_type_id;
                        }
                    }else{
                        if(collapseToRoot){
                            collapseNotRoot();
                            collapseToRoot = false;
                        }

                    }
                },
                onClickRow: function (row) {
                    selected_subject_id = row.id;
                    selected_subject_type_id = row.subject_type_id;
                },
                columns: [[
                    {
                        title: '<?php echo e(__("authenticated.Username")); ?>',
                        field: 'name',
                        width: "200",
                        id: "usernameColumnHeader"
                    },
                    {
                        title: '<?php echo e(__("authenticated.Role")); ?>',
                        field: 'subject_type_name_colourful',
                        width: "200",
                        align: "left",
                        id: "roleColumnHeader"
                    },
                    {
                        title: '<?php echo e(__("authenticated.Profit For Period")); ?>',
                        field: 'profit_for_period',
                        width: "200",
                        align: "right",
                        id: "profitForPeriodHeader"
                    },
                    {
                        title: '<?php echo e(__("authenticated.Collected On Entity Level")); ?>',
                        field: 'collected_on_entity',
                        width: "200",
                        align: "right",
                        id: "collectedOnEntityHeaderHeader"
                    },
                    {
                        title: '<?php echo e(__("authenticated.Actual Player Liability")); ?>',
                        field: 'player_liability',
                        width: "200",
                        align: "right",
                        id: "playerLiabilityHeader"
                    },
                    {
                        title: '<?php echo e(__("authenticated.Actual Balance")); ?>',
                        field: 'actual_balance',
                        width: "200",
                        align: "right",
                        id: "actualBalanceHeader"
                    },
                    {
                        title: '<?php echo e(__("authenticated.Currency")); ?>',
                        field: 'currency',
                        width: "200",
                        align: "left",
                        id: "currencyHeader"
                    }
                ]]
            });

            tree.treegrid('enableFilter', [
                {
                    field:'name',
                    type:'text'

                },
                {
                    field:'subject_type_name_colourful',
                    type:'text'
                },
                {
                    field:'profit_for_period',
                    type:'label'
                },
                {
                    field:'collected_on_entity',
                    type:'label'
                },
                {
                    field:'player_liability',
                    type:'label'
                },
                {
                    field:'actual_balance',
                    type:'label'
                },
                {
                    field:'currency',
                    type:'label'
                }
            ]);

            function convert(rows) {
                return rows;
            }

            $("#reloadTree").on("click", function (e) {
                generateReport();
            });

            function generateReport() {
                /*$.ajax({
                    method: "GET",
                    url: "",
                    "dataSrc": "result",
                    data: {
                        from_date: $("#fromDate").val(),
                        to_date: $("#toDate").val(),
                        currency: $("#currency").val()
                    },
                    success: function(data){
                        reportData = data;
                    },
                    complete: function(data){
                        $('#tree1').treegrid('loadData', reportData);
                        console.log("sdadasda");
                    }
                });*/

                $('#tree1').treegrid('options').url = '<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "transactionReportAjax")); ?>?from_date=' + document.getElementById("fromDate").value + '&&to_date=' + document.getElementById("toDate").value + '&&currency=' + document.getElementById("currency").value;
                $('#tree1').treegrid('reload');
            }

            window.openExternalReport = function (id, url) {
                var fromDate = document.getElementById("fromDate").value;
                var toDate = document.getElementById("toDate").value;

                sessionStorage.setItem("automaticSelect", "yes");
                sessionStorage.setItem("automaticSelectId", id);
                sessionStorage.setItem("automaticSelectFromDate", fromDate);
                sessionStorage.setItem("automaticSelectToDate", toDate);

                window.open(url, '_blank');
            }

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>