
<?php
 //dd(get_defined_vars());
    $main_table_width = 1350;
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

	<style>
        #list-login-history thead{
            width: 100%;
            display: block;
            table-layout:fixed;

            padding-right: 40px;
        }
        #list-login-history tbody{
            width: 100%;
            display: block;

            padding-right: 25px;

            height: 65vh;
            overflow-y: scroll;
            overflow-x: hidden;
            -ms-overflow-y: scroll;
            -ms-overflow-x: hidden;
        }

        table.dataTable thead th {
            padding: 8px 10px;
        }
    </style>

<script type="text/javascript">
	function calculateWidths(){
        var tableWidth = [];
        $("#list-login-history > thead > tr.bg-blue-active > th").each(function(index, value) {
            tableWidth.push(value.width);
        });

        $("#list-login-history > tbody > tr").each(function(index, value){
            $(this).find("td").each(function(index2, value2) {
                $(this).attr("width", tableWidth[index2]);
            });
        });
    }

    $(document).ready(function() {
        var table = $('#list-login-history').DataTable(
            {
                //responsive: true,
                paging: false,
                //lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                colReorder: true,
                stateSave: '{{ Session::get('auth.table_state_save') }}',
                stateDuration: '{{ Session::get('auth.table_state_duration') }}'
            }
        );

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        $('#list-login-history tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#list-login-history tfoot tr').appendTo('#list-login-history thead');

        table.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        document.getElementById('list-login-history_wrapper').removeChild(
            document.getElementById('list-login-history_wrapper').childNodes[0]
        );

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
            todayBtn: true,
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
            todayBtn: true,
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

        $("#startdate").on('click',function(){
              $('#report_start_date').focus();
        });
        $("#enddate").on('click',function(){
              $('#report_end_date').focus();
        });
		
		//top scrollbar 
		var topScrollbar = document.getElementById('topScrollbar');
		var topScrollbar_div = document.getElementById('topScrollbar-div');
		var tableResponsive = document.getElementsByClassName('table-responsive');
		tableResponsive = tableResponsive[0];
		
		topScrollbar.style = "width: 320px; border: none; overflow-x: scroll; overflow-y:hidden;height: 20px;";
		topScrollbar_div.style = "width:1500px; height: 20px;";
		
		topScrollbar.onscroll = function() {
		  tableResponsive.scrollLeft = topScrollbar.scrollLeft;
		};
		tableResponsive.onscroll = function() {
		  topScrollbar.scrollLeft = tableResponsive.scrollLeft;
		};

		$(window).load(function(){
            calculateWidths();
        });

        $(window).resize(function(){
            calculateWidths();
        });

    } );
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-bar-chart"></i>
            {{ __("authenticated.List Login History") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
			<li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Users") }}</li>
            <li> 
				<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/list-terminals") }}" class="noblockui">
				{{ __("authenticated.List Terminals") }}
				</a>
			</li>
			<li> 
				<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/details/user_id/{$user_id}") }}" class="noblockui">
				{{ __("authenticated.Account Details") }}
				</a>
			</li>
            <li>
                <span class="bold-text">{{ $username }}</span>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/report/list-login-history/user_id/{$user_id}") }}" title="{{ __('authenticated.List Login History') }}">
                    {{ __("authenticated.List Login History") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-body">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'terminal/report/list-login-history/user_id/' . $user_id), 'method'=>'POST', 'class' => 'form-inline row-border' ]) !!}
                <table class="table">
                    <tr>
                        <td class="pull-left">                            
                        </td>
                        <td class="pull-right">

							<div id="startdate" class="input-group date">
                                {!!
                                    Form::text('report_start_date', $report_start_date,
                                        array(
                                            'id' => 'report_start_date',
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

                            <div id="enddate" class="input-group date">
                                {!!
                                    Form::text('report_end_date', $report_end_date,
                                        array(
                                            'id' => 'report_end_date',
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

							{!!
                                Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                array(
                                    'class'=>'btn btn-primary',
                                    'type'=>'submit',
                                    'name'=>'generate_report'
                                    )
                                )
                            !!}

                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}
				<div id="topScrollbar">
					<div id="topScrollbar-div">
					</div>
				</div>
				<div class="table-responsive">
					<table style="width: <?php echo $main_table_width?>px;" id="list-login-history" class="table table-bordered table-hover table-striped pull-left">
						<thead>
							<tr class="bg-blue-active">
                                <th width="100">{{ __("authenticated.Session ID") }}</th>
								<th width="200">{{ __("authenticated.Start Date/Time") }}</th>
                                <th width="200">{{ __("authenticated.End Date/Time") }}</th>
                                <th width="100">{{ __("authenticated.Duration") }}</th>
                                <th width="150">{{ __("authenticated.IP") }}</th>
                                <th width="200">{{ __("authenticated.City") }}</th>
                                <th width="200">{{ __("authenticated.Country") }}</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
                                <th width="100"></th>
								<th width="200"></th>
                                <th width="200"></th>
								<th width="100"></th>
								<th width="150"></th>
								<th width="200"></th>
								<th width="200"></th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($list_report as $report)
							<tr>
                                <td width="100" class="align-right" title="{{ __("authenticated.Session ID") }}">
                                    {{ $report->session_id }}
								</td>
								<td width="200" title="{{ __("authenticated.Start Date/Time") }}">
                                    {{ $report->start_time_formated }}
								</td>
                                <td width="200" title="{{ __("authenticated.End Date/Time") }}">
                                    {{ $report->end_time_formated }}
								</td>
								<td width="100" title="{{ __("authenticated.Duration") }}">
									{{ $report->duration }}
								</td>
								<td width="150" class="align-left" title="{{ __("authenticated.IP") }}">
								  {{ $report->ip_address }}
								</td>
                                <td width="200" class="align-left" title="{{ __("authenticated.City") }}">
								  {{ $report->city }}
								</td>
								<td width="200" class="align-left" title="{{ __("authenticated.Country") }}">
								  {{ $report->country }}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
            </div>
        </div>

    </section>
</div>
@endsection
