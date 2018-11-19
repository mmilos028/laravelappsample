<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?><!-- Content Wrapper. Contains page content -->
<style>
    .redBackground{
        background-color: #de9090 !important;
    }
</style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-bar-chart"></i>
                <?php echo e(__("authenticated.List Affiliate Monthly Summary Report")); ?>

                <button id="showContextualMessage" class="btn btn-primary"><strong class="fa fa-question-circle"></strong></button>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> <?php echo e(__("authenticated.Reports")); ?></li>
                <li class="active">
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "report/affiliate-monthly-summary-report")); ?>">
                        <?php echo e(__("authenticated.List Affiliate Monthly Summary Report")); ?>

                    </a>
                </li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header" id="filterContainer">
                    <div class="row">
                        <div id="clearBtnContainer" class="col-md-2" style="display: none;">
                            <button id="clearBtn" class="btn btn-sm btn-primary" style="margin-top: 25px !important;">
                                <span class="fa fa-refresh"></span>
                                <?php echo e(__("authenticated.Clear")); ?>

                            </button>
                        </div>
                        <div class="col-md-6 pull-right">
                            <button id="reloadBtn" class="btn btn-sm btn-primary pull-right" style="margin-top: 25px !important;">
                                <span class="fa fa-refresh"></span>
                                <?php echo e(__("authenticated.Generate")); ?>

                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div id="tableContainer">
                        <table style="width: 700px; font-size: 11px !important;" id="draw-list-report" class="table table-bordered table-hover table-striped pull-left">
                            <thead>
                            <tr class="bg-blue-active">
                                <th style="text-align: left;"><?php echo e(__("authenticated.Affiliate Name")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Currency")); ?></th>
                                <th style="text-align: right;"><?php echo e(__("authenticated.Cash IN")); ?></th>
                                <th style="text-align: right;"><?php echo e(__("authenticated.Cash OUT")); ?></th>
                                <th style="text-align: right;"><?php echo e(__("authenticated.Difference")); ?></th>
                            </tr>
                            </thead>
                        </table>
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
                        <strong><?php echo e(trans("authenticated.This report shows profit overview per affiliate for actual month.")); ?></strong>
                        <br><br>
                        <?php echo e(trans("authenticated.Data is retrieved per each affiliate.")); ?>

                    </p>
                </div>
                <div class="modal-footer">
                    <button id="closeContextualMessageModal" type="button" data-dismiss = "modal" class="btn btn-default pull-right"><?php echo e(trans("authenticated.Close")); ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $.fn.select2.defaults.set("theme", "bootstrap");

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

            var height = "50vh";
            var reportData = [];

            var table;

            function getReportData(){

                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/list-affiliate-monthly-summary-report")); ?>",
                    "dataSrc": "result",
                    data: {
                        page_number: null,
                        number_of_results: null
                    },
                    success: function(data){
                        reportData = data.result;

                        generateReport(height, reportData);
                    },
                    complete: function(data){
                        $("#showContextualMessage").addClass("animated shake");
                    }
                });
            }

            function generateReport(height, data){
                if(table){
                    table.destroy();
                }
                table = $('#draw-list-report').DataTable( {
                    initComplete: function (settings, json) {
                        $("#draw-list-report_length").addClass("pull-right");
                        $("#draw-list-report_filter").addClass("pull-left");
                    },
                    "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                    "order": [],
                    scrollY: height,
                    scrollX: true,
                    select: true,
                    colReorder: true,
                    stateSave: false,
                    "deferRender": true,
                    "processing": false,
                    "serverSide": false,
                    searching: true,
                    data: data,
                    "paging": false,
                    "iDisplayLength": 10,
                    "lengthMenu": [[10, 25, 50, 500], [10, 25, 50, 500]],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    columns:[
                        {
                            data: function(row, type, val, meta){

                                return row.affiliate_name;
                            },
                            width: 150,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.currency;
                            },
                            width: 100,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.cash_in;
                            },
                            width: 150,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                return row.cash_out;
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
                            width: 150,
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

            $("#reloadBtn").on("click", function(){
                getReportData();
            });

            $("#clearBtn").on("click", function(){

                $("#clearBtnContainer").hide();
            });

            $("#toggleBtn").on("click", function(){
                if($('#toggleSpan').is(".fa.fa-toggle-on")){
                    $("#filterContainer").hide(500, function () {
                        $('#toggleSpan').switchClass( "fa-toggle-on", "fa-toggle-off", 500, afterComplete1);
                    });
                }else{
                    afterComplete2(customCallback);
                }
            });

            function afterComplete1(){
                height = "70vh";
                generateReport(height, reportData);
            }
            function afterComplete2(callback){
                height = "50vh";
                generateReport(height, reportData);
                callback();
            }
            function  customCallback(){
                $("#filterContainer").show(500, function () {
                    $('#toggleSpan').switchClass( "fa-toggle-off", "fa-toggle-on", 500);
                });
            }

            getReportData();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>