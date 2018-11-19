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
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-bar-chart"></i>
                <?php echo e(__("authenticated.All Cashier Terminal Codes")); ?>

                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> <?php echo e(__("authenticated.Administration")); ?></li>
                <li class="active"><?php echo e(__("authenticated.All Cashier Terminal Codes")); ?></li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-11 col-sm-10 col-xs-8">

                        </div>
                        <div class="col-md-1 col-sm-2 col-xs-4">
                            <button id="reloadTreeBtn" class="btn btn-block btn-sm btn-primary" onclick="reload()" data-toggle="tooltip" data-placement="top" title="<?php echo e(__("authenticated.Reload")); ?>">
                                <span class = "fa fa-refresh"></span>
                                <?php echo e(__("authenticated.Reload")); ?>

                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="report" class="table table-bordered dataTable pull-left" style="width: 100%; font-size: 11px !important;">
                                <thead>
                                <tr id="tableHeader" class="bg-blue-active headerFontXL">
                                    <th style="text-align: left;"><?php echo e(__ ("authenticated.Terminal")); ?></th>
                                    <th style="text-align: left;"><?php echo e(__ ("authenticated.Parent")); ?></th>
                                    <th style="text-align: left;"><?php echo e(__ ("authenticated.Service Code")); ?></th>
                                    <th style="text-align: left;"><?php echo e(__ ("authenticated.Valid Until")); ?></th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function(){
            var financialReportTable;

            LINKS.init(["<?php echo e(config('constants.ROLE_CLIENT')); ?>", "<?php echo e(config('constants.ROLE_ADMINISTRATOR')); ?>", "<?php echo e(config('constants.ROLE_LOCATION')); ?>",
                "<?php echo e(config('constants.TERMINAL_SALES')); ?>", "<?php echo e(config('constants.ROLE_OPERATER')); ?>", "<?php echo e(config('constants.ROLE_CASHIER_TERMINAL')); ?>",
                "<?php echo e(config('constants.ROLE_SUPPORT')); ?>", "<?php echo e(config('constants.ROLE_SUPPORT_SYSTEM')); ?>", "<?php echo e(config('constants.ROLE_SUPPORT')); ?>"]);

            window.reload = function (){
                financialReportTable.ajax.reload();
            };

            financialReportTable = $('#report').DataTable( {
                initComplete: function (settings, json) {
                    $("#report_length").addClass("pull-right");
                    $("#report_filter").addClass("pull-left");
                },
                "dom": '<"top"fl>rt<"bottom"ip><"clear">',
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
                ajax: {
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "allMachineKeysAndCodesReportAjax")); ?>",
                    "dataSrc": "result"
                },
                "paging": true,
                pagingType: 'full_numbers',
                "iDisplayLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
                columns:[
                    {
                        data: function(row){
                            return '<a class="underline-text bold-text" href="' + row.link + '">' + row.terminal_name + '</a>';

                            //return LINKS.returnLink(row.subject_dtype, row.terminal_name);
                        },
                        width: 100,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: "parent_name",
                        width: 100,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: "service_code",
                        width: 100,
                        className: "text-left",
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: "valid_until",
                        width: 100,
                        className: "text-center",
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
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>