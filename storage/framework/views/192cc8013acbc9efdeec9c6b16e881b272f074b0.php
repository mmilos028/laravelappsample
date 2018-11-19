<?php
 //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>

    <style>
        .vertical-align-medium-button{
            padding-top: 22px !important;
        }
        .padding{
            display:inline-block !important;
            width:50% !important;
        }
    </style>

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
    function selectExcelExport(){
        var search_ticket_export_excel_url =
        "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/ticket/excel/search-tickets')); ?>"
            + "?" + "ticket_id=" + $("#ticket_id").val()
            + "&" + "report_start_date" + $("#report_start_date").val()
            + "&" + "report_end_date" + $("#report_end_date").val()
            + "&" + "draw_id=" + $("#draw_id").val()
            + "&" + "barcode=" + $("#barcode").val()
            + "&" + "player_name=" + $("#player_name").val()
            + "&" + "cashier_name=" + $("#cashier_name").val()
            + "&" + "ticket_status=" + $("#ticket_status").val()
        ;
        $("#search_tickets_export_excel").attr("href", search_ticket_export_excel_url);
    }
$(document).ready(function() {

    $.fn.select2.defaults.set("theme", "bootstrap");

    $('#cashier_name').select2({
        language: {
            noResults: function (params) {
                return "<?php echo e(trans("authenticated.No results found")); ?>";
            }
        }
    });
	
	var now = new Date();
    $.fn.datepicker.defaults.format = "dd-M-yyyy";
    $.fn.datepicker.defaults.allowDeselection = false;

	var currentTime = new Date();
	var startDateFrom = new Date(currentTime.getFullYear(), currentTime.getMonth() - parseInt('<?php echo Session::get('auth.report_date_months_in_past'); ?>'), 1);
	var startDateTo = new Date(currentTime.getFullYear(), currentTime.getMonth() +1, 0);

	var startdateDate;
	$("#report_start_date").datepicker({
        dateFormat: 'dd-M-yyyy',
        changeYear: true,
        changeMonth: true,
        showWeek: true,
        enableOnReadonly: true,
        keyboardNavigation: true,
        todayBtn: "linked",
        showOnFocus: true,
        todayHighlight: true,
        forceParse: true,
        autoclose: true,
		    startDate: startDateFrom, endDate: startDateTo, numberOfMonths: 1
	});

    var enddateDate;
	$("#report_end_date").datepicker({
		dateFormat: 'dd-M-yyyy',
        changeYear: true,
        changeMonth: true,
        showWeek: true,
        enableOnReadonly: true,
        keyboardNavigation: true,
        todayBtn: "linked",
        showOnFocus: true,
        todayHighlight: true,
        forceParse: true,
        autoclose: true,
		startDate: startDateFrom, numberOfMonths: 1
	});
	$("#report_end_date").change(function() {
		var date1 = $("#report_start_date").datepicker("getDate");
		var date2 = $("#report_end_date").datepicker("getDate");
		if(date2 < date1){
			$("#report_end_date").val($("#report_start_date").val());
		}
	});
    $("#report_start_date").change(function(){
    	var date1 = $("#report_start_date").datepicker("getDate");
        var date2 = $("#report_end_date").datepicker("getDate");
        if(date2 < date1){
            $("#report_start_date").val($("#report_end_date").val());
        }
    });


    // Save date picked
    $("#report_start_date").on('show', function () {
        startdateDate = $(this).val();
    });
    // Replace with previous date if no date is picked or if same date is picked to avoide toggle error
    $("#report_start_date").on('hide', function () {
        if ($(this).val() === '' || $(this).val() === null) {
            $(this).val(startdateDate).datepicker('update');
        }
    });

    // Save date picked
    $("#report_end_date").on('show', function () {
        enddateDate = $(this).val();
    });
    // Replace with previous date if no date is picked or if same date is picked to avoide toggle error
    $("#report_end_date").on('hide', function () {
        if ($(this).val() === '' || $(this).val() === null) {
            $(this).val(enddateDate).datepicker('update');
        }
    });

    $("#generate_report").attr("disabled", "disabled").addClass('disabled'); //set button disabled as default

    $(".startdate").on('click',function(){
          $('#report_start_date').focus();
    });
    $(".enddate").on('click',function(){
          $('#report_end_date').focus();
    });

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

    $("#resetBtn").on("click",function(){
        $('#ticket_status').prop('selectedIndex',0);
        $('#cashier_name').prop('selectedIndex',0);

        $('#ticket_id').val("");
        $('#draw_id').val("");
        $('#barcode').val("");
        $('#player_name').val("");
    });

    $("#ticket_id").numeric({ negative: false });
    $("#draw_id").numeric({ negative: false });
    $("#barcode").numeric({ negative: false });

    var search_ticket_export_excel_url =
        "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/ticket/excel/search-tickets')); ?>"
            + "?" + "ticket_id=" + $("#ticket_id").val()
            + "&" + "draw_id=" + $("#draw_id").val()
        ;
    $("#search_tickets_export_excel").attr("href", search_ticket_export_excel_url);
});
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-search"></i>
            <?php echo e(__("authenticated.Search Tickets")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-search"></i> <?php echo e(__("authenticated.Ticket")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets")); ?>" title="<?php echo e(__('authenticated.Search Tickets')); ?>">
                    <?php echo e(__("authenticated.Search Tickets")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'ticket/search-tickets'), 'method'=>'POST',
            'class' => 'row-border' ]); ?>

            <div class="box-body">

                <table class="table">
                    <tr>
                      <td>
                          <div class="">
                            <div class="row">
                                <div class="col-md-2">
                                  <?php echo Form::label('ticket_id', trans('authenticated.Ticket ID / Barcode') . ':', array('class' => 'control-label')); ?>

                                  <?php echo Form::text('ticket_id', $ticket_id,
                                          array(
												'autofocus',
                                                'class'=>'form-control',
                                                'placeholder'=>trans('authenticated.Ticket ID / Barcode')
                                          )
                                      ); ?>

                                </div>
                                <div class="col-md-3 vertical-align-medium-button">
                                  <?php echo Form::button('<i class="fa fa-search"></i> ' . trans('authenticated.Search'),
                                        array(
                                            'class'=>'btn btn-primary pull-left',
                                            'type'=>'submit',
                                            'value' => 'generate_report_search_ticket_id',
                                            'name'=>'generate_report_search_ticket_id'
                                            )
                                        ); ?>

                                </div>

                                <div class="col-md-3">

                                </div>
                                <div class="col-md-3 vertical-align-medium-button">

                                </div>
                            </div>
                              <hr style="border: 1px solid black;"/>
                            <div class="row">
                                <div class="col-md-2">
                                  <?php echo Form::label('draw_id', trans('authenticated.Draw ID') . ':', array('class' => 'control-label')); ?>

                                  <?php echo Form::text('draw_id', $ticket_draw_id,
                                          array(
                                                'class'=>'form-control',
                                                'placeholder'=>trans('authenticated.Draw ID')
                                          )
                                      ); ?>

                                </div>
                                <div class="col-md-2" style="display: none !important;">
                                    <?php echo Form::label('barcode', trans('authenticated.Barcode') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::text('barcode', $ticket_barcode,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Barcode')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('ticket_status', trans('authenticated.Select Ticket Status') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::select('ticket_status', $list_ticket_statuses,
                                            $ticket_status,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Select Ticket Status')
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
                                <div class="col-md-2">
                                  <?php echo Form::label('player_name', trans('authenticated.Player') . ':', array('class' => 'control-label')); ?>

                                  <?php echo Form::text('player_name',
                                          $player_name,
                                          array(
                                                'class'=>'form-control',
                                                'placeholder'=>trans('authenticated.Player')
                                          )
                                      ); ?>

                                </div>
                                <div class="col-md-2">
                                    <div class="startdate">
                                        <div class="required">
                                            <?php echo Form::label('report_start_date', trans('authenticated.Start Date') . ':', array('class' => 'control-label label-break-line')); ?>

                                            <div class="input-group date">
                                                <?php echo Form::text('report_start_date', $report_start_date,
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
                                    <div class="date enddate">
                                        <div class="">
                                            <?php echo Form::label('report_end_date', trans('authenticated.End Date') . ':', array('class' => 'control-label label-break-line')); ?>

                                            <div class="input-group date">
                                                <?php echo Form::text('report_end_date', $report_end_date,
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
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <div class="btn-group" style="padding-top: 23px !important; width: 100% !important;">
                                        <?php echo Form::button('<i class="fa fa-search"></i> ' . trans('authenticated.Search'),
                                            array(
                                                'class'=>'btn btn-primary padding',
                                                'type'=>'submit',
                                                'value' => 'generate_report',
                                                'name'=>'generate_report'
                                                )
                                            ); ?>

                                        <button id="actionBtn2" type="button" class="btn btn-primary dropdown-toggle padding" data-toggle="dropdown" onClick="selectExcelExport()">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <?php echo Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Reset'),
										        array(
											    'class'=>'btn btn-default btn-block',
											    'type'=>'button',
											    "id" => "resetBtn",
											    /*'name'=>'clear_form',
											    'value'=>'clear_form'*/
											    )
										        ); ?>

                                                <?php echo Form::hidden('large_tag', 'large_tag');; ?>

                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <?php echo Form::button('<i class="fa fa-compress"></i> ' . trans('authenticated.Small'),
										        array(
											        'class'=>'btn btn-default btn-block',
											        'type'=>'submit',
											        'name'=>'small',
											        'value'=>'small'
											    )
										        ); ?>

                                            </li>
                                            <?php if(!env('HIDE_EXPORT_TO_EXCEL')): ?>
                                                <li class="divider"></li>
                                                <li>
                                                    <a id="search_tickets_export_excel" class="btn btn-default btn-block"
                                                       href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/excel/search-tickets")); ?>" target="_blank">
                                                        <i class="fa fa-file-excel-o"></i>
                                                        <?php echo e(__("authenticated.Export To Excel")); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
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
								<th width="80"><?php echo e(__("authenticated.Ticket ID")); ?></th>
                                <th width="80"><?php echo e(__("authenticated.Draw ID")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Barcode")); ?></th>
                                <th width="80"><?php echo e(__("authenticated.Bet")); ?></th>
                                <th width="80"><?php echo e(__("authenticated.Win")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Ticket Status")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Date & Time")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Cashier")); ?></th>
                                <th width="150"><?php echo e(__("authenticated.Player Username")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Payed Out")); ?></th>
                                <th width="80"><?php echo e(__("authenticated.Repeat")); ?></th>
								<th width="100"><?php echo e(__("authenticated.City")); ?></th>
								<th width="100"><?php echo e(__("authenticated.Address")); ?></th>
								<th width="150"><?php echo e(__("authenticated.Commercial Address")); ?></th>
								<th width="100"><?php echo e(__("authenticated.Language")); ?></th>
								<th width="100"><?php echo e(__("authenticated.Ticket Printed")); ?></th>
								<th width="200"><?php echo e(__("authenticated.Number Of Ticket Printed")); ?></th>
								<th width="100"><?php echo e(__("authenticated.Jackpot Code")); ?></th>
								<th width="100"><?php echo e(__("authenticated.Jackpot Win")); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $__currentLoopData = $list_tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                //dd($ticket)
                                 ?>
							<tr>
								<td width="80" class="align-left" title="<?php echo e(__("authenticated.Ticket ID")); ?>">
                                    <a href="" onclick="window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket->serial_number}")); ?>')" class="bold-text" title="<?php echo e(__("authenticated.View Ticket Details")); ?>">
									    <?php echo e($ticket->serial_number); ?>

                                    </a>
								</td>
                                <td width="80" class="align-right" title="<?php echo e(__("authenticated.Draw ID")); ?>">
									<?php echo e($ticket->draw_id); ?>

								</td>
                                <td width="100" class="align-right" title="<?php echo e(__("authenticated.Barcode")); ?>">
                                    <?php echo e($ticket->barcode); ?>

                                </td>
                                <td width="80" class="align-right" title="<?php echo e(__("authenticated.Bet")); ?>">
                                    <?php echo e(NumberHelper::format_double($ticket->sum_bet)); ?>

                                </td>
                                <td width="80" class="align-right" title="<?php echo e(__("authenticated.Win")); ?>">
                                    <?php echo e(NumberHelper::format_double($ticket->sum_win)); ?>

                                </td>
                                <td width="100" class="align-left" title="<?php echo e(__("authenticated.Ticket Status")); ?>">
                                    <?php echo $__env->make('layouts.shared.ticket_status',
								        ["ticket_status" => $ticket->ticket_status]
								    , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </td>
                                <td width="100" class="align-left" title="<?php echo e(__("authenticated.Date & Time")); ?>">
									<?php echo e($ticket->rec_tmstp_formated); ?>

								</td>
								<td width="100" title="<?php echo e(__("authenticated.Cashier")); ?>">
									<?php echo e($ticket->cashier); ?>

								</td>
								<td width="150" class="align-left" title="<?php echo e(__("authenticated.Player Username")); ?>">
									<?php echo e($ticket->player_username); ?>

								</td>
								<td width="100" class="align-center" title="<?php echo e(__("authenticated.Payed Out")); ?>">
                                    <?php echo $__env->make('layouts.shared.status_yes_no',
										["status" => $ticket->payed_out]
									, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
								</td>
                                <td width="80" class="align-right" title="<?php echo e(__("authenticated.Repeat")); ?>">
                                    <?php echo e($ticket->ticket_repeat_no); ?>

                                </td>
								<td width="100" title="<?php echo e(__("authenticated.City")); ?>">
									<?php echo e($ticket->city); ?>

								</td>
								<td width="100" title="<?php echo e(__("authenticated.Address")); ?>">
									<?php echo e($ticket->address); ?>

								</td>
								<td width="150" title="<?php echo e(__("authenticated.Commercial Address")); ?>">
									<?php echo e($ticket->commercial_address); ?>

								</td>
								<td width="100" title="<?php echo e(__("authenticated.Language")); ?>">
									<?php echo $__env->make('layouts.shared.language',
                                      ["language" => $ticket->language]
                                      , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
								</td>
								<td width="100" class="align-center" title="<?php echo e(__("authenticated.Ticket Printed")); ?>">
									<?php echo $__env->make('layouts.shared.status_yes_no',
									["status" => $ticket->ticket_printed]
									, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
								</td>
								<td width="200" class="align-right" title="<?php echo e(__("authenticated.Number Of Ticket Printed")); ?>">
									<?php echo e(NumberHelper::format_integer($ticket->no_of_printings)); ?>

								</td>
								<td width="100" title="<?php echo e(__("authenticated.Jackpot Code")); ?>">
                                    <?php echo e(__("authenticated.Local")); ?>:
									<?php echo e($ticket->local_jp_code); ?> <br />
                                    <?php echo e(__("authenticated.Global")); ?>:
                                    <?php echo e($ticket->global_jp_code); ?>

								</td>
								<td width="100" class="align-right" title="<?php echo e(__("authenticated.Jackpot Win")); ?>">
									<?php echo e(NumberHelper::format_double($ticket->jackpot_win)); ?>

								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>

					</table>
				</div>
            </div>
            <?php echo Form::close(); ?>

        </div>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>