
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <style>
        .dratagrid-header{
            height: 40px;
        }
        .datagrid-row{
            height: 40px !important;
        }
        .datagrid-cell{
            height: auto !important;
        }
        .padding{
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-tree"></i>
                {{ __("authenticated.Structure View") }}
                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-tree"></i> {{ __("authenticated.Structure Entity") }}</li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/list-users-tree") }}" title="{{ __('authenticated.Structure View') }}">
                        {{ __("authenticated.Structure View") }}
                    </a>
                </li>
            </ol>
        </section>

        <section class="content">
            <script type="text/javascript">
                function reload(){
                    var node = $('#tree1').treegrid('getSelected');
                    if (node) {
                        $('#tree1').treegrid('reload', node.code);
                    }
                    else {
                        $('#tree1').treegrid('reload');
                    }
                }
                function collapseAll(){
                    var node = $('#tree1').treegrid('getSelected');
                    if(node != "<?php echo ALL; ?>"){
                        if (node){
                            $('#tree1').treegrid('collapseAll', node.code);
                        }
                        else{
                            $('#tree1').treegrid('collapseAll');
                        }
                    }
                }
                function expandAll(){
                    var node = $('#tree1').treegrid('getSelected');
                    if (node)$('#tree1').treegrid('expandAll', node.code);
                    else $('#tree1').treegrid('expandAll');
                }
                function collapseNotRoot(){
                    var root = $("#tree1").treegrid('getRoot');
                    $('#tree1').treegrid('collapseAll');
                    if(root !== null){
                        $('#tree1').treegrid('expand', root.id);
                    }
                }
            </script>

            <div class="box">
                <div class="box-body">
                    <div class="row">
                        @if($agent->isDesktop())
                            <div class="col-md-1 col-xs-2 padding">
                                <button id="reloadTreeBtn" class="btn btn-block btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Reload") }}">
                                    <span class = "fa fa-refresh"></span>
                                </button>
                            </div>
                            <div class="col-md-1 col-xs-2 padding" style="display: none;">
                                <button id="collapseToRootBtn" class="btn btn-block btn-primary" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Home") }}" onclick="collapseAll()">
                                    <span class = "fa fa-home"></span>
                                </button>
                            </div>
                            <div class="col-md-1 col-xs-2 padding">
                                <button id="showDirectTreeBtn" class="btn btn-block btn-primary" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Direct") }}" onclick="collapseNotRoot()">
                                    <span class = "fa fa-home"></span>
                                </button>
                            </div>
                            <div class="col-md-1 col-xs-2 padding">
                                <button id="expandTreeBtn" class="btn btn-block btn-primary" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.All") }}" onclick="expandAll()">
                                    <span class = "fa fa-bars"></span>
                                </button>
                            </div>
                            <div class="col-md-2 col-xs-2 padding" id="showTerminalsContainer">
                                <button id="showTerminalsBtn" class="btn btn-block btn-primary" onclick="showTerminals()" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Show Cashier, TV and Self-Service Terminal") }}">
                                    <span class = "fa fa-plus"></span>
                                    {{ __("authenticated.Show Terminals") }}
                                </button>
                            </div>
                            <div class="col-md-2 col-xs-2 padding" id="hideTerminalsContainer" style="display: none;">
                                <button id="hideTerminalsBtn" class="btn btn-block btn-primary" onclick="hideTerminals()" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Hide Cashier, TV and Self-Service Terminal") }}">
                                    <span class = "fa fa-minus"></span>
                                    {{ __("authenticated.Hide Terminals") }}
                                </button>
                            </div>
                        @else
                            <div class="col-md-1 col-xs-2 padding">
                                <button id="reloadTreeBtn" class="btn btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Reload") }}">
                                    <span class = "fa fa-refresh"></span>
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
                            <div class="col-md-2 col-xs-2 padding" id="showTerminalsContainer">
                                <button id="showTerminalsBtn" class="btn btn-primary" onclick="showTerminals()" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Show Cashier, TV and Self-Service Terminal") }}">
                                    <span class = "fa fa-plus"></span>
                                    {{ __("authenticated.Show Terminals") }}
                                </button>
                            </div>
                            <div class="col-md-2 col-xs-2 padding" id="hideTerminalsContainer" style="display: none;">
                                <button id="hideTerminalsBtn" class="btn btn-primary" onclick="hideTerminals()" data-toggle="tooltip" data-placement="top" title="{{ __("authenticated.Hide Cashier, TV and Self-Service Terminal") }}">
                                    <span class = "fa fa-minus"></span>
                                    {{ __("authenticated.Hide Terminals") }}
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="row table-responsive">
                        <table id="tree1" class="easyui-treegrid" style="width:800px;height:700px">
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function(){
            var collapseToRoot = true;
            var showTerminals = -1;

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

            window.showTerminals = function(){
                var node = $('#tree1').treegrid('getSelected');
                showTerminals = 1;

                $('#tree1').treegrid('options').url = '{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getSubjectTree") }}?showTerminals=' + showTerminals;

                if (node) {
                    $('#tree1').treegrid('reload', node.code);
                }else {
                    $('#tree1').treegrid('reload');
                }

                $("#showTerminalsContainer").hide();
                $("#hideTerminalsContainer").show();
            };

            window.hideTerminals = function(){
                var node = $('#tree1').treegrid('getSelected');
                showTerminals = -1;

                $('#tree1').treegrid('options').url = '{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getSubjectTree") }}?showTerminals=' + showTerminals;

                if (node) {
                    $('#tree1').treegrid('reload', node.code);
                }else {
                    $('#tree1').treegrid('reload');
                }

                $("#showTerminalsContainer").show();
                $("#hideTerminalsContainer").hide();
            };

            var tree = $('#tree1').treegrid({
                method: 'GET',
                url: '{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getSubjectTree") }}?showTerminals=' + showTerminals,
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
                onClickRow: function(row){

                },
                onLoadSuccess: function() {
                    if(collapseToRoot){
                        collapseNotRoot();
                        collapseToRoot = false;
                    }
                },
                columns:[[
                    {title: "{{ __("authenticated.Username") }}",field:'name',width:300},
                    {title: "{{ __("authenticated.Role") }}",field:'subject_type_name_colourful',width:200},
                    {title: "{{ __("authenticated.Action") }}",field:'action_column',width:150, align:"center"}
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
                    field:'action_column',
                    type:'label'
                }
            ]);

            $("#tree1").treegrid('resize', {width: "99%", height: "100%"});
            $( window ).resize(function() {
                $("#tree1").treegrid('resize', {width: "99%", height: "100%"});
            });
        });
    </script>
@endsection
