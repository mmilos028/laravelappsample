<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <style>
        td { font-size: 11px; }

        td.details-control {
            background: url('<?php echo e(asset('images/details_open.png')); ?>') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('<?php echo e(asset('images/details_close.png')); ?>') no-repeat center center;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-bar-chart"></i>
                <?php echo e(__("authenticated.History Of Preferred Tickets")); ?>

                <button id="showContextualMessage" class="btn btn-primary"><strong class="fa fa-question-circle"></strong></button>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-bar-chart"></i> <?php echo e(__("authenticated.Reports")); ?></li>
                <li class="active"><?php echo e(__("authenticated.History Of Preferred Tickets")); ?></li>
            </ol>
        </section>

        <section class="content">

        <div class="box">
            <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'report/history-of-preferred-tickets'), 'method'=>'POST',
            'class' => 'row-border' ]); ?>

            <div class="box-body">

                <table class="table">
                    <tr>
                      <td>
                          <div class="">
                            <div class="row">
                                <div class="col-md-2">
                                  <?php echo Form::label('ticket_id', trans('authenticated.Ticket ID') . ':', array('class' => 'control-label')); ?>

                                  <?php echo Form::text('ticket_id', $ticket_id,
                                          array(
												'autofocus',
                                                'class'=>'form-control',
                                                'placeholder'=>trans('authenticated.Ticket ID')
                                          )
                                      ); ?>

                                </div>
                                <div class="col-md-2">
                                  <?php echo Form::label('ticket_barcode', trans('authenticated.Ticket Barcode') . ':', array('class' => 'control-label')); ?>

                                  <?php echo Form::text('ticket_barcode', $ticket_barcode,
                                          array(
												'autofocus',
                                                'class'=>'form-control',
                                                'placeholder'=>trans('authenticated.Ticket Barcode')
                                          )
                                      ); ?>

                                </div>
                                <div class="col-md-1">
                                  <?php echo Form::label('draw_id', trans('authenticated.Draw ID') . ':', array('class' => 'control-label')); ?>

                                  <?php echo Form::text('draw_id', $ticket_draw_id,
                                          array(
                                                'class'=>'form-control',
                                                'placeholder'=>trans('authenticated.Draw ID')
                                          )
                                      ); ?>

                                </div>
                                <div class="col-md-2" style="display: none !important;">
                                    <?php echo Form::label('ticket_barcode', trans('authenticated.Barcode') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::text('ticket_barcode', $ticket_barcode,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Barcode')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('cashier_name', trans('authenticated.Select Cashier') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::select('cashier_name', $list_cashiers,
                                            $cashier_name,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Select Cashier')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-1">
                                  <?php echo Form::label('player_name', trans('authenticated.Player') . ':', array('class' => 'control-label')); ?>

                                  <?php echo Form::text('player_name',
                                          $player_name,
                                          array(
                                                'class'=>'form-control',
                                                'placeholder'=>trans('authenticated.Player')
                                          )
                                      ); ?>

                                </div>
                                <div class="col-md-1">
                                  <?php echo Form::label('preferred_by', trans('authenticated.Preferred By') . ':', array('class' => 'control-label')); ?>

                                  <?php echo Form::select('preferred_by', $list_preferred_types,
                                            $preferred_by,
                                            array(
                                            'class'=>'form-control',
                                            'placeholder'=>trans('authenticated.Select Preferred Type')
                                        )
                                    ); ?>

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
                                <div class="col-md-1 vertical-align-button">
                                    <?php echo Form::button('<i class="fa fa-search"></i> ' . trans('authenticated.Search'),
                                        array(
                                            'class'=>'btn btn-primary btn-block',
                                            'type'=>'submit',
                                            'value' => 'generate_report',
                                            'name'=>'generate_report'
                                            )
                                        ); ?>

                                </div>
                            </div>
                          </div>
                      </td>
                    </tr>
                </table>
                <hr>
				<div class="">
					<table style="width: 100%;" id="search-tickets" class="table table-bordered table-hover table-striped pull-left">
						<thead>
							<tr class="bg-blue-active">
								<th width="80"><?php echo e(__("authenticated.Date & Time")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Preferred By")); ?></th>
                                <th width="80"><?php echo e(__("authenticated.Ticket ID")); ?></th>
                                <th width="80"><?php echo e(__("authenticated.Draw ID")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Location")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Cashier")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Player")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Deposit")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Win")); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $__currentLoopData = $list_tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                //dd($ticket)
                                 ?>
							<tr>
                                <td width="80" class="align-left" title="<?php echo e(__("authenticated.Date & Time")); ?>">
                                    <?php echo e($ticket->preferred_tmstp_formated); ?>

								</td>
                                <td width="100" class="align-left" title="<?php echo e(__("authenticated.Preferred By")); ?>">
									<?php echo e($ticket->s_preferred_by); ?>

								</td>
                                <td width="80" class="align-right" title="<?php echo e(__("authenticated.Ticket ID")); ?>">
                                    <a href="" onclick="window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket->ticket_id}")); ?>')" class="bold-text" title="<?php echo e(__("authenticated.View Ticket Details")); ?>">
                                        <?php echo e($ticket->ticket_id); ?>

                                    </a>
                                </td>
                                <td width="80" class="align-right" title="<?php echo e(__("authenticated.Draw ID")); ?>">
                                    <a class="noblockui bold-text underline" href="" onClick="window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/draw-details/draw_id/{$ticket->draw_id}")); ?>', 'draw_details_window', 'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=950,height=600,top=100,left=100,resizable=yes')">
                                        <?php echo e($ticket->draw_id); ?>

                                    </a>
                                </td>
                                <td width="100" class="align-left" title="<?php echo e(__("authenticated.Location")); ?>">
                                    <?php echo e($ticket->location); ?>

                                </td>
                                <td width="100" class="align-left" title="<?php echo e(__("authenticated.Player")); ?>">
                                    <?php echo e($ticket->cashier); ?>

                                </td>
                                <td width="100" class="align-left" title="<?php echo e(__("authenticated.Player")); ?>">
                                    <?php echo e($ticket->player); ?>

                                </td>
                                <td width="100" class="align-right" title="<?php echo e(__("authenticated.Deposit")); ?>">
									<?php echo e(NumberHelper::format_double($ticket->sum_bet)); ?>

								</td>
								<td width="100" class="align-right" title="<?php echo e(__("authenticated.Win")); ?>">
									<?php echo e(NumberHelper::format_double($ticket->sum_win)); ?>

								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>

					</table>
				</div>
            </div>
            <?php echo Form::close(); ?>

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
                            <strong><?php echo e(trans("authenticated.This report shows history of preferred tickets for selected filters.")); ?></strong>
                            <br><br>
                            <?php echo e(trans("authenticated.Data is retrieved for selected filters above report.")); ?>

                        </p>
                    </div>
                    <div class="modal-footer">
                        <button id="closeContextualMessageModal" type="button" data-dismiss = "modal" class="btn btn-default pull-right"><?php echo e(trans("authenticated.Close")); ?></button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>

    </section>
    <script type="text/javascript">
        function calculateWidths(){
            var tableWidth = [];
            $("#search-tickets > thead > tr.bg-blue-active > th").each(function(index, value) {
                tableWidth.push(value.width);
            });

            $("#search-tickets > tbody > tr").each(function(index, value){
                $(this).find("td").each(function(index2, value2) {
                    $(this).attr("width", tableWidth[index2]);
                });
            });
        }
        $(document).ready(function(){

            $.fn.select2.defaults.set("theme", "bootstrap");

            $('#cashier_name').select2({
                language: {
                    noResults: function (params) {
                        return "<?php echo e(trans("authenticated.No results found")); ?>";
                    }
                }
            });

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

            $(".startdate").on('click',function(){
                $('#fromDate').focus();
            });
            $(".enddate").on('click',function(){
                $('#toDate').focus();
            });

            $("#reportReload").on("click", function(e){
                listLoginHistoryTableFull.ajax.reload();
            });

            $("#ticket_id").numeric({ negative: false });
            $("#draw_id").numeric({ negative: false });
            $("#ticket_barcode").numeric({ negative: false });

            var table = $('#search-tickets').DataTable({
                initComplete: function (settings, json) {
                    $("#search-tickets_length").addClass("pull-right");
                    $("#search-tickets_filter").addClass("pull-left");
                },
                scrollX: true,
                scrollY: "50vh",
                "order": [],
                "searching": false,
                "deferRender": true,
                "processing": true,
                responsive: false,
                ordering: true,
                info: true,
                autoWidth: false,
                colReorder: true,
                "paging": true,
                pagingType: 'simple_numbers',
                "iDisplayLength": 100,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                lengthChange: true,
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
                "dom": '<"clear"><"top"fl>rt<"bottom"ip><"clear">',
                stateSave: '<?php echo e(Session::get('auth.table_state_save')); ?>',
                stateDuration: '<?php echo e(Session::get('auth.table_state_duration')); ?>',
                language: {
                    "lengthMenu": "Show _MENU_ entries"
                }
            });

            new $.fn.dataTable.ColReorder( table, {
                // options
            } );

            document.getElementById('search-tickets_wrapper').removeChild(
                document.getElementById('search-tickets_wrapper').childNodes[0]
            );

            $(window).load(function(){
                calculateWidths();
            });

            $(window).resize(function(){
                calculateWidths();
            });

        });
    </script>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>