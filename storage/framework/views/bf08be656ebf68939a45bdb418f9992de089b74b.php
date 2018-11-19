<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?><!-- Content Wrapper. Contains page content -->
<?php 
    $authSessionData = Session::get('auth');
    $logged_in_subject_dtype = $authSessionData['subject_dtype'];
 ?>
<style>
    .redBackground{
        background-color: #de9090 !important;
    }
</style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-bar-chart"></i>
                <?php echo e(__("authenticated.Draw List")); ?>

            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> <?php echo e(__("authenticated.Reports")); ?></li>
                <li class="active">
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "draw-list")); ?>">
                        <?php echo e(__("authenticated.Draw List")); ?>

                    </a>
                </li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="row">
                    <div class="col-md-12">
                        <button id="toggleBtn" class="btn btn-sm btn-primary pull-right" style="margin-top: 25px !important; margin-right: 15px !important;">
                            <span id="toggleSpan" class="fa fa-toggle-on"></span>
                            <?php echo e(__("authenticated.Toggle")); ?>

                        </button>
                    </div>
                </div>
                <div class="box-header" id="filterContainer">
                    <div class="row">
                        <div class="col-md-2" <?php  if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")) {  echo "style=\"display:none;\""; }  ?>>
                            <label class="control-label"><?php echo e(__('authenticated.Draw Model')); ?></label>
                            <select class="form-control" id="drawModels" name="drawModels">
                                <option value=""><?php echo e(trans("authenticated.All")); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo e(__('authenticated.Draw Status')); ?></label>
                            <select class="form-control" id="draw_status" name="draw_status"><?php echo e(__("authenticated.SCHEDULED")); ?>

                                <option value=""><?php echo e(trans("authenticated.All")); ?></option>
                                <option value="-1"><?php echo e(__("authenticated.SCHEDULED")); ?></option>
                                <option value="0"><?php echo e(__("authenticated.IN PROGRESS")); ?></option>
                                <option value="1"><?php echo e(__("authenticated.COMPLETED")); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo e(__('authenticated.Currency')); ?></label>
                            <select class="form-control" id="currency" name="currency">
                                <option value=""><?php echo e(trans("authenticated.All")); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2" style="display:none;">
                            <label class="control-label"><?php echo e(__('authenticated.Affiliate1')); ?></label>
                            <select class="form-control" id="affiliate" name="affiliate">
                                <option value=""><?php echo e(trans("authenticated.All")); ?></option>
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
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            <label class="control-label"><?php echo e(__('authenticated.Draw ID')); ?></label>
                            <input type="text" id="drawID" class="form-control" placeholder="<?php echo e(__('authenticated.Draw ID')); ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo e(__('authenticated.Draw SN')); ?></label>
                            <input type="text" id="drawSN" class="form-control" placeholder="<?php echo e(__('authenticated.Draw SN')); ?>">
                        </div>
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
                        <table style="width: 100%; font-size: 11px !important;" id="draw-list-report" class="table table-bordered table-hover table-striped pull-left">
                            <thead>
                            <tr class="bg-blue-active">
                                <th style="text-align: left;"><?php echo e(__("authenticated.Draw ID")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Draw SN")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Draw Model")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Super Draw Coefficient")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Date & Time")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Tickets for Draw")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Total Bet for Draw")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Win for Draw")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Currency")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Status")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Local JP Amount")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Global JP Amount")); ?></th>
                                <th style="text-align: left;"><?php echo e(__("authenticated.Star Double Up")); ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <script>
        $(document).ready(function(){
            $.fn.select2.defaults.set("theme", "bootstrap");

            $('#affiliate, #drawModels').select2({
                language: {
                    noResults: function (params) {
                        return "<?php echo e(trans("authenticated.No results found")); ?>";
                    }
                }
            });
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";

            $("#drawID").numeric();
            $("#drawSN").numeric();
            var height = "50vh";
            var reportData = [];

            var table;

            $('#fromDate').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true,
                todayBtn: "linked",
                endDate: '+0d',
                forceParse: true
            });
            $('#toDate').datepicker({
                format: 'dd-M-yyyy',
                autoclose: true,
                todayBtn: "linked",
                endDate: '+0d',
                forceParse: true
            });

            $("#toDate").datepicker("setDate", endDateFromSession);
            $("#fromDate").datepicker("setDate", "-1d");

            $(".startdate").on('click',function(){
                $('#fromDate').focus();
            });
            $(".enddate").on('click',function(){
                $('#toDate').focus();
            });

            function getReportData(){
                $("#drawModels").prop("disabled", true);
                $("#draw_status").prop("disabled", true);
                $("#currency").prop("disabled", true);
                $("#affiliate").prop("disabled", true);
                $("#fromDate").prop("disabled", true);
                $("#toDate").prop("disabled", true);
                $("#drawID").prop("disabled", true);
                $("#drawSN").prop("disabled", true);

                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/draw-list-report")); ?>",
                    "dataSrc": "result",
                    data: {
                        draw_model_id: $("#drawModels").val(),
                        affiliate_id: $("#affiliate").val(),
                        currency: $("#currency").val(),
                        date_from: $("#fromDate").val(),
                        date_to: $("#toDate").val(),
                        draw_id: $("#drawID").val(),
                        draw_sn: $("#drawSN").val(),
                        draw_status: $("#draw_status").val(),
                        page_number: null,
                        number_of_results: null
                    },
                    success: function(data){
                        reportData = data.result;

                        generateReport(height, reportData);
                    },
                    complete: function(data){
                        $("#drawModels").prop("disabled", false);
                        $("#draw_status").prop("disabled", false);
                        $("#currency").prop("disabled", false);
                        $("#affiliate").prop("disabled", false);
                        $("#fromDate").prop("disabled", false);
                        $("#toDate").prop("disabled", false);
                        $("#drawID").prop("disabled", false);
                        $("#drawSN").prop("disabled", false);
                    }
                });
            }
            window.openDrawDetails = function(link){
                window.open(link, 'draw_details_window', 'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=950,height=600,top=100,left=100,resizable=yes');
            };

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
                    "paging": true,
                    pagingType: 'full_numbers',
                    "iDisplayLength": 10,
                    "lengthMenu": [[10, 25, 50, 500], [10, 25, 50, 500]],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    columns:[
                        {
                            data: function(row, type, val, meta){

                                return '<a class="noblockui bold-text underline" href="#" onClick=openDrawDetails("' + row.link + '"' + ')>' + row.draw_id + '</a>';
                            },
                            width: 50,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.order_num;
                            },
                            width: 60,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.draw_model;
                            },
                            width: 80,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                if(row.super_draw_coeficient != null){
                                    return row.super_draw_coeficient + "%";
                                }else{
                                    return row.super_draw_coeficient;
                                }
                            },
                            width: 150,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.draw_date_time_formated;
                            },
                            width: 80,
                            className: "text-center",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.number_of_tickets_for_draw;
                            },
                            width: 100,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.sum_bet_for_draw;
                            },
                            width: 120,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.sum_win_for_draw;
                            },
                            width: 90,
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
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.draw_status_formatted;
                            },
                            width: 60,
                            className: "text-center",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.local_jp_win_amount;
                            },
                            width: 100,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.global_jp_win_amount;
                            },
                            width: 100,
                            className: "text-right",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.stars;
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

            function listCurrencies(){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listCurrencies")); ?>",
                    global: false,
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var currencyDropdown = document.getElementById("currency");

                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                element.value = value.currency;
                                element.textContent = value.currency;

                                currencyDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }
            function listAffiliates(){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "list-affiliates")); ?>",
                    global: false,
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var affiliateDropdown = document.getElementById("affiliate");

                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                element.value = value.subject_id;
                                element.textContent = value.username;

                                affiliateDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function listDrawModels(){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listAllDrawModels")); ?>",
                    global: false,
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var drowModelDropdown = document.getElementById("drawModels");

                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                element.value = value.draw_model_id;
                                element.textContent = value.draw_model;

                                drowModelDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            $("#reloadBtn").on("click", function(){
                getReportData();
            });
            $("#drawModels, #draw_status, #currency, #affiliate").on("change", function(){
                getReportData();
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
                    }else{
                        $(this).removeClass("redBackground");
                        $("#fromDate").removeClass("redBackground");
                        getReportData();
                    }
                }
            });
            $("#fromDate").datepicker().on("changeDate", function(){
                var toDate = $("#toDate").val();
                var fromDate = $(this).val();

                var toDateObject = new Date(toDate);
                var fromDateObject = new Date(fromDate);

                if(fromDate === ""){
                    $(this).datepicker("setDate", "-1d");
                }else{
                    if(toDateObject < fromDateObject){
                        $(this).addClass("redBackground");
                        $("#toDate").addClass("redBackground");

                    }else{
                        $(this).removeClass("redBackground");
                        $("#toDate").removeClass("redBackground");
                        getReportData();
                    }
                }
            });

            $("#drawID").on("input", function(){
                if($(this).val() == "" && $("#drawSN").val() == ""){
                    $("#clearBtnContainer").hide();
                }else{
                    $("#clearBtnContainer").show();
                }
            });
            $("#drawSN").on("input", function(){
                if($(this).val() == "" && $("#drawID").val() == ""){
                    $("#clearBtnContainer").hide();
                }else{
                    $("#clearBtnContainer").show();
                }
            });

            $("#drawID, #drawSN").on("keypress", function(event) {
                if(event.which == 13 || event.keyCode == 13){
                    event.preventDefault();
                    $("#reloadBtn").trigger("click");
                }
            });

            $("#clearBtn").on("click", function(){
                $("#drawSN").val("");
                $("#drawID").val("");

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

            listCurrencies();
            listAffiliates();
            listDrawModels();
            getReportData();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>