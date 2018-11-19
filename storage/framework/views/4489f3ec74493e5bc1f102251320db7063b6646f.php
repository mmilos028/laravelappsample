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
            <i class="fa fa-cog"></i>
            <?php echo e(__("Entity List - Parameter Setup")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> <?php echo e(__("authenticated.Administration")); ?></li>
            <li><?php echo e(__("authenticated.Parameter Setup")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/list-entities")); ?>">
                    <?php echo e(__("Entity List - Parameter Setup")); ?>

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
                    <div class="col-md-1 col-xs-3 col-sm-2 padding">
                        <button id="reloadTreeBtn" class="btn btn-block btn-sm btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Reload")); ?>">
                            <span class = "fa fa-refresh"></span>
                        </button>
                    </div>
                    <div class="col-md-1 padding" style="display: none;">
                        <button id="collapseToRootBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Home")); ?>" onclick="collapseAll()">
                            <span class = "fa fa-home"></span>
                        </button>
                    </div>
                    <div class="col-md-1 col-xs-3 col-sm-2 padding">
                        <button id="showDirectTreeBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Direct")); ?>" onclick="collapseNotRoot()">
                            <span class = "fa fa-home"></span>
                        </button>
                    </div>
                    <div class="col-md-1 col-xs-3 col-sm-2 padding">
                        <button id="expandTreeBtn" class="btn btn-block btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.All")); ?>" onclick="expandAll()">
                            <span class = "fa fa-bars"></span>
                        </button>
                    </div>
                </div>
                <div class="row table-responsive">
                    <table id="tree1" class="easyui-treegrid" style="width:800px;height:700px">
                    </table>
                </div>
            </div>
        </div>

        <script type="text/javascript">
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

                var tree = $('#tree1').treegrid({
                    method: 'GET',
                    url: '<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/get-structure-entity-tree-for-parameter-setup")); ?>',
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
                        //console.log('sdadasdasd');
                    },
                    onLoadSuccess: function() {
                        if(collapseToRoot){
                            collapseNotRoot();
                            collapseToRoot = false;
                        }
                    },
                    columns:[[
                        {title: "<?php echo e(__("authenticated.Username")); ?>",field:'name',width:300},
                        {title: "<?php echo e(__("authenticated.Entity Type")); ?>",field:'subject_type_name_colourful',width:200},
                        {title: "<?php echo e(__("authenticated.Parent")); ?>",field:'true_parent_name',width:200},
                        {title: "<?php echo e(__("authenticated.Currency")); ?>",field:'currency',width:100},
                        {title: "<?php echo e(__("authenticated.Draw Model")); ?>",field:'draw_model',width:200},
                        {title: "<?php echo e(__("authenticated.Control / Free")); ?>",field:'control_free',width:100, align: "center"},
                        {title: "<?php echo e(__("authenticated.Action")); ?>",field:'action_column',width:100, align:"center"}
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
                        field:'true_parent_name',
                        type:'text'

                    },
                    {
                        field:'currency',
                        type:'text'
                    },
                    {
                        field:'draw_model',
                        type:'text'

                    },
                    {
                        field:'control_free',
                        type:'text'
                    },
                    {
                        field:'action_column',
                        type:'label'
                    }
                ]);

                function collapseAll(){
                    $('#tree1').treegrid('collapseAll');
                }
                function expandAll(){
                    $('#tree1').treegrid('expandAll');
                }
                function convert(rows){
                    return rows;
                }

                $("#tree1").treegrid('resize', {width: "99%", height: "100%"});
                $( window ).resize(function() {
                    $("#tree1").treegrid('resize', {width: "99%", height: "100%"});
                });

                $("#tree1").treegrid("fixRowHeight");
            });
        </script>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>