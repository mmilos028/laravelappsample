<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <style>
        .dratagrid-header{
            height: 40px;
        }
        .datagrid-row{
            height: 40px !important;
        }
        .padding{
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-plus"></i>
                <i class="fa fa-tree"></i>
                <?php echo e(__("authenticated.Deposit - Structure View")); ?>

                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-plus"></i>
                    <i class="fa fa-tree"></i>
                    <?php echo e(__("authenticated.Credit Transfers")); ?>

                </li>
                <li class="active">
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/deposit-user-structure-view")); ?>" title="<?php echo e(__('authenticated.Deposit - Structure View')); ?>">
                        <?php echo e(__("authenticated.Deposit - Structure View")); ?>

                    </a>
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <?php if($agent->isDesktop()): ?>
                            <div class="col-md-1 padding">
                                <button id="reloadTreeBtn" class="btn btn-block btn-sm btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Reload")); ?>">
                                    <span class = "fa fa-refresh"></span>
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
                        <?php else: ?>
                            <div class="col-xs-3 padding">
                                <button id="reloadTreeBtn" class="btn btn-block btn-sm btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Reload")); ?>">
                                    <span class = "fa fa-refresh"></span>
                                </button>
                            </div>
                            <div class="col-xs-3 padding" style="display: none;">
                                <button id="collapseToRootBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Home")); ?>" onclick="collapseAll()">
                                    <span class = "fa fa-home"></span>
                                </button>
                            </div>
                            <div class="col-xs-3 padding">
                                <button id="showDirectTreeBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Direct")); ?>" onclick="collapseNotRoot()">
                                    <span class = "fa fa-home"></span>
                                </button>
                            </div>
                            <div class="col-xs-3 padding">
                                <button id="expandTreeBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.All")); ?>" onclick="expandAll()">
                                    <span class = "fa fa-bars"></span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="box-body">
                    <table id="tree1" class="easyui-treegrid table-responsive" style="width:800px;height:700px">
                    </table>

                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function(){
            var collapseToRoot = true;

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
                url: '<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/deposit-subject-tree")); ?>',
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
                autoRowHeight: true,
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
                    {title: "<?php echo e(__("authenticated.Username")); ?>",field:'name',width:400},
                    {title: "<?php echo e(__("authenticated.Role")); ?>", field:'subject_type_name', width:200},
                    {title: "<?php echo e(__("authenticated.Credits")); ?>", align: 'right', field:'credits_formatted',width:150},
                    {title: "<?php echo e(__("authenticated.Currency")); ?>",field:'currency',width:150},
                    {title: "<?php echo e(__("authenticated.Action")); ?>",field:'action_column',width:150, align:"center"}
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
                },
                {
                    field:'credits_formatted',
                    type:'label'
                },
                {
                    field:'currency',
                    type:'label'
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

            $("#tree1").treegrid("fixRowHeight");

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>