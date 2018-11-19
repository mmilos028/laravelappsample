
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

        td.details-control {
            background: url('{{asset('images/details_open.png')}}') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('{{asset('images/details_close.png')}}') no-repeat center center;
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
                {{ __("authenticated.List Login History") }}
                <button id="showContextualMessage" class="btn btn-primary"><strong class="fa fa-question-circle"></strong></button>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Reports") }}</li>
                <li class="active">{{ __("authenticated.List Login History") }}</li>
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
                                        <button id="toggleTreeGrid" class="btn  btn-info" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Toggle") }}" disabled>
                                            <span id="toggleSpan" class = "fa fa-toggle-on"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-1 col-xs-2 padding" style="display: none;">
                                        <button id="collapseToRootBtn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Home") }}" onclick="collapseAll()">
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
                    <div class="row">
                        <div class="col-md-4" id="treeGridContainer">
                            <table id="tree1" class="easyui-treegrid" style="width:100%;height:700px">
                            </table>
                        </div>
                        <div class="col-md-8 animate" id="tablesContainer">
                            <div class="jumbotron" id="infoBox" align="center">
                                <div class="container">
                                    <p>{{__ ("authenticated.Select Subject.")}}</p>
                                </div>
                            </div>
                            <div id="listLoginHistoryContainer" style="display: none;">
                                <div class="row" id="fullReportContainer">
                                    <table id="listLoginHistoryFull" class="table table-bordered dataTable pull-left" style="width: 100%; font-size: 13px !important;">
                                        <thead>
                                        <tr id="tableHeader" class="bg-blue-active headerFontXL">
                                            <th style="text-align: left;">{{__ ("authenticated.Session ID")}}</th>
                                            <th style="text-align: left;">{{__ ("authenticated.Start Date/Time")}}</th>
                                            <th style="text-align: left;">{{__ ("authenticated.End Date/Time")}}</th>
                                            <th style="text-align: left;">{{__ ("authenticated.Duration")}}</th>
                                            <th style="text-align: left;">{{__ ("authenticated.IP")}}</th>
                                            <th style="text-align: left;">{{__ ("authenticated.City")}}</th>
                                            <th style="text-align: left;">{{__ ("authenticated.Country")}}</th>
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
                    <h4 class="modal-title">{{trans("authenticated.Contextual Message")}}</h4>
                </div>
                <div class="modal-body bg-info">
                    <p id="modal-body-p">
                        <strong>{{trans("authenticated.This report shows login session history for selected period.")}}</strong>
                        <br><br>
                        {{trans("authenticated.Data is retrieved for selected subject.")}}
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
            var listLoginHistoryTableFull;
            var ignoreCall = false;
            var collapseToRoot = true;
            var startDateFromSession = "{{session('auth.report_start_date')}}";
            var endDateFromSession = "{{session('auth.report_end_date')}}";

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
                                generateReport(selected_subject_id, fromDate, toDate);
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
                    }else{
                        $(this).removeClass("redBackground");
                        $("#toDate").removeClass("redBackground");
                        if(selected_subject_id){
                            if(!ignoreCall){
                                generateReport(selected_subject_id, fromDate, toDate);
                            }
                        }
                    }
                }
            });



            /*$("#toDate").datepicker().on("changeDate", function(){
                var toDate = $(this).val();
                var fromDate = $("#fromDate").val();
                if(selected_subject_id){
                    if(!ignoreCall){
                        generateReport(selected_subject_id, fromDate, toDate);
                    }
                }
            });
            $("#fromDate").datepicker().on("changeDate", function(){
                var fromDate = $(this).val();
                var toDate = $("#toDate").val();
                if(selected_subject_id){
                    if(!ignoreCall){
                        generateReport(selected_subject_id, fromDate, toDate);
                    }
                }
            });*/

            $("#reportReload").on("click", function(e){
                listLoginHistoryTableFull.ajax.reload();
            });

            var tree = $('#tree1').treegrid({
                method: 'GET',
                url: '{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getSubjectTreeUsers") }}',
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

                        selected_subject_id = properties.id;
                        var selected_subject_type_id = properties.subject_type_id;

                        var fromDate = sessionStorage.getItem("automaticSelectFromDate");
                        var toDate = sessionStorage.getItem("automaticSelectToDate");

                        ignoreCall = true;
                        $("#fromDate").datepicker("setDate", fromDate);
                        ignoreCall = false;
                        $("#toDate").datepicker("setDate", toDate);

                        document.getElementById("listLoginHistoryContainer").style.display = "inline";
                        document.getElementById("infoBox").style.display = "none";

                        sessionStorage.setItem("automaticSelect", "no");
                        $("#toggleTreeGrid").prop("disabled", false);
                    }else{
                        if(collapseToRoot){
                            collapseNotRoot();
                            collapseToRoot = false;
                        }
                    }
                },
                onClickRow: function(row){
                    selected_subject_id = row.id;
                    var selected_subject_type_id = row.subject_type_id;

                    var fromDate = document.getElementById("fromDate").value;
                    var toDate = document.getElementById("toDate").value;

                    ignoreCall = false;

                    loadReport(selected_subject_id, fromDate, toDate);
                    $("#toggleTreeGrid").prop("disabled", false);
                },
                columns:[[
                    {title:'{{ __("authenticated.Username") }}',field:'name',width:"200"},
                    {title:'{{ __("authenticated.Role") }}',field:'subject_type_name',width:"200"}
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


            //var node = $('#tree1').treegrid('getSelected');
            /*$('#tree1').treegrid('select', {id: 1});*/

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
                $('#tree1').treegrid('collapseAll');
            };
            window.expandAll = function(){
                $('#tree1').treegrid('expandAll');
            };
            window.collapseNotRoot = function(){
                var root = $("#tree1").treegrid('getRoot');
                $('#tree1').treegrid('collapseAll');
                if(root !== null){
                    $('#tree1').treegrid('expand', root.id);
                }
            };

            function loadReport(selected_subject_id, fromDate, toDate){
                document.getElementById("listLoginHistoryContainer").style.display = "inline";
                document.getElementById("infoBox").style.display = "none";

                generateReport(selected_subject_id, fromDate, toDate);

                @if($agent->isMobile())
                $("html, body").animate({ scrollTop: $(document).height() }, 1000);
                @endif
            }

            function generateReport(selected_subject_id, fromDate, toDate){
                if(listLoginHistoryTableFull){
                    listLoginHistoryTableFull.destroy();
                }
                listLoginHistoryTableFull = $('#listLoginHistoryFull').DataTable( {
                    initComplete: function (settings, json) {
                        $("#listLoginHistoryFull_length").addClass("pull-right");
                        $("#listLoginHistoryFull_filter").addClass("pull-left");
                    },
                    "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                    "order": [],
                    scrollY: "50vh",
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
                        url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listLoginHistory") }}",
                        data:{
                            subject_id: selected_subject_id,
                            start_date: fromDate,
                            end_date: toDate
                        },
                        "dataSrc": "result"
                    },
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
                            data: "session_id",
                            width: 80,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: "start_date_time",
                            width: 110,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: "end_date_time",
                            width: 110,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: "duration",
                            width: 80,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: "ip_address",
                            width: 100,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: "city",
                            width: 150,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: "country",
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
        });
    </script>
@endsection
