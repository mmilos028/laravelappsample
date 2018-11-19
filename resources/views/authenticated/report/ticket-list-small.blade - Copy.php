

<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

    <style>
        #ticket-list-report thead{
            width: 1600px;
            display: block;
            table-layout:fixed;
            padding-right: 40px;
        }
        #ticket-list-report tbody{
            width: 1600px;
            display: block;
            padding-right: 25px;
            overflow-y: scroll;
            overflow-x: hidden;
            -ms-overflow-y: scroll;
            -ms-overflow-x: hidden;
        }

        #ticket-list-report tbody{
            height: 65vh;
        }
        table.dataTable thead th {
            padding: 8px 10px;
        }
    </style>

<script type="text/javascript">
var tableWidth = [];
    function calculateWidthsMainTable(){
        $("#ticket-list-report > thead > tr.bg-blue-active > th").each(function(index, value) {
            tableWidth.push(value.width);
        });

        /*
        console.log('calculateWidths');
        var sum = 0;
        for(i=0;i<tableWidth.length;i++){
            sum+=parseInt(tableWidth[i]);
        }
        console.log("sum =  " + sum);
        */

        $("#ticket-list-report > tbody > tr").each(function(index, value){
            $(this).find("td").each(function(index2, value2) {
                $(this).attr("width", tableWidth[index2]);
            });
        });
    }

    function loadTicketDetailsPerDraw(num, ticket_serial_number, currency){

        $("#hidetable" + num).load(
            "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/ticket-details-per-draw") }}",
            {
                ticket_serial_number : ticket_serial_number,
                rowid: num,
                small: 'small'
            },
            function(response, status, xht) {
                if (status == "error") {
                    window.top.location = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/auth/logout") }}";
                }
            }
        );
    }

    function toggleTicketDetailsPerDraw(num, ticket_serial_number, currency) {

        if($("#hidethis" + num).css("display") == 'none'){
            $("#hidethis" + num).show();
            $("#hidelink" + num).html("<b>-</b>");
            loadTicketDetailsPerDraw(num, ticket_serial_number, currency);
        }else{
            $("#hidethis" + num).hide();
            $("#hidelink" + num).html("<b>+</b>");
        }
    }

    $(document).ready(function() {
        var table = $('#ticket-list-report').DataTable(
            {
                "order": [],
                "searching": true,
                "deferRender": true,
                "processing": true,
                responsive: false,
                ordering: false,
                info: true,
                autoWidth: false,
                colReorder: true,
                "paging": true,
                pagingType: 'simple_numbers',
                "iDisplayLength": 20,
                lengthMenu: [[20, 50, 100, -1], [10, 25, 50, 'All']],
                lengthChange: true,
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
                "dom": '<"clear"><"top"l>rt<"bottom"ip><"clear">',
                stateSave: '{{ Session::get('auth.table_state_save') }}',
                stateDuration: '{{ Session::get('auth.table_state_duration') }}',
                language: {
                    "lengthMenu": "Show _MENU_ entries"
                }
            }
        );

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        $('#ticket-list-report tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#ticket-list-report tfoot tr').appendTo('#ticket-list-report thead');

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
                $("#report_start_date").datepicker("setDate", date2);
                $("#report_end_date").datepicker("setDate", $("#report_start_date").val());
            }
            console.log(date1, date2);
            $("#report_start_date").datepicker("setEndDate", date2);
            $("#report_end_date").datepicker("setStartDate", date1);
        });
        $("#report_start_date").change(function(){
            var date1 = $("#report_start_date").datepicker("getDate");
            var date2 = $("#report_end_date").datepicker("getDate");
            console.log(date2 < date1);
            if(date2 < date1){
                $("#report_start_date").datepicker("setDate", $("#report_end_date").val());
                $("#report_end_date").datepicker("setDate", date1);
            }
            $("#report_start_date").datepicker("setEndDate", date2);
            $("#report_end_date").datepicker("setStartDate", date1);
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

        var topScrollbar = document.getElementById('topScrollbar');
        var topScrollbar_div = document.getElementById('topScrollbar-div');
        var tableResponsive = document.getElementsByClassName('table-responsive');
        tableResponsive = tableResponsive[0];

        topScrollbar.style = "width: 320px; border: none; overflow-x: scroll; overflow-y:hidden;height: 20px;";
        topScrollbar_div.style = "width:2200px; height: 20px;";

        topScrollbar.onscroll = function() {
          tableResponsive.scrollLeft = topScrollbar.scrollLeft;
        };
        tableResponsive.onscroll = function() {
          topScrollbar.scrollLeft = tableResponsive.scrollLeft;
        };

        $('tr[id^="hidethis"]').hide();

        $(window).load(function(){
            calculateWidthsMainTable();
        });

        $(window).resize(function(){
            calculateWidthsMainTable();
        });

    } );
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.Ticket List") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Reports") }}</li>
            <li class="active">{{ __("authenticated.Ticket List") }}</li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-body">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'report/ticket-list'), 'method'=>'POST', 'class' => 'form-inline row-border' ]) !!}
                <table class="table">
                    <tr>
                        <td class="pull-left">
                            {!!
                            Form::button('<i class="fa fa-expand"></i> ' . trans('authenticated.Large'),
                                array(
                                    'class'=>'btn btn-primary pull-left',
                                    'type'=>'submit',
                                    'name'=>'large',
                                    'value'=>'large'
                                    )
                                )
                            !!}
                        </td>
                        <td class="pull-right">
                            {!!
                                Form::select('affiliate_id', $list_filter_users,
                                    $affiliate_id,
                                    array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Select Affiliate')
                                    )
                                )
                            !!}

                            {!!
                                Form::select('ticket_status', $list_ticket_statuses,
                                    $ticket_status,
                                    array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Select Ticket Status')
                                    )
                                )
                            !!}

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
                <hr>
                <div class="table-responsive">
                    <table style="width: 1600px;font-size: 11px !important;" id="ticket-list-report" class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-blue-active">
                                <th width="100">{{ __("authenticated.Location") }}</th>
                                <th width="100">{{ __("authenticated.Player") }}</th>
                                <th width="50"></th>
                                <th width="100">{{ __("authenticated.Ticket SN") }}</th>
                                <th width="100">{{ __("authenticated.Created By") }}</th>
                                <th width="150">{{ __("authenticated.Created Date & Time") }}</th>
                                <th width="100">{{ __("authenticated.Ticket Status") }}</th>
                                <th width="100">{{ __("authenticated.Bet per Draw") }}</th>
                                <th width="100">{{ __("authenticated.Bet per Ticket") }}</th>
                                <th width="100">{{ __("authenticated.Possible Win") }}</th>
                                <th width="100">{{ __("authenticated.Executed Win") }}</th>
                                <th width="100">{{ __("authenticated.Currency") }}</th>
                                <th width="100">{{ __("authenticated.Combinations") }}</th>
                                <th width="100">{{ __("authenticated.Jackpot Code") }}</th>
                                <th width="100">{{ __("authenticated.Ticket Repeat") }}</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr class="">
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="50"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="150"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @php ($i = 0)
                            @foreach ($list_report as $report)
                            <tr>
                                <td width="100" title="{{ __("authenticated.Location") }}">
                                  {{ $report->location_name }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Player") }}">
                                  {{ $report->player_name }}
                                </td>
                                <td width="50" title="{{ __("authenticated.Actions") }}" class="align-center">
                                    <a class="noblockui" href="#" onClick="toggleTicketDetailsPerDraw('{{ $i }}', '{{ $report->serial_number }}', '{{ $report->currency }}');" href="javascript:void(0)" id="hidelink{{ $i }}" style="font-size: 14px; padding: 5px;">
                                        <span style="font-weight: bold;">+</span>
                                    </a>&nbsp;
                                </td>
                                <td width="100" title="{{ __("authenticated.Ticket SN") }}" class="align-left">
                                    <button class="noblockui btn btn-sm" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/ticket-details/ticket_serial_number/{$report->serial_number}") }}', 'ticket_details_window',
                                            'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=850,height=600,top=100,left=100,resizable=yes').focus()">
                                        {{ $report->serial_number }}
                                    </button>
                                </td>
                                <td width="100" title="{{ __("authenticated.Created By") }}" class="align-centera">
                                  {{ $report->created_by }}
                                </td>
                                <td width="150" title="{{ __("authenticated.Created Date & Time") }}" class="align-left">
                                  {{ $report->rec_tmstp_formated }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Ticket Status") }}">
                                    @include('layouts.shared.ticket_status',
									    ["ticket_status" => $report->ticket_status]
								    )
                                </td>
                                <td width="100" title="{{ __("authenticated.Bet per Draw") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->bet_per_draw) }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Bet per Ticket") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->bet_per_ticket) }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Possible Win") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->possible_win) }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Executed Win") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->executed_win) }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Currency") }}" class="align-left">
                                  {{ $report->currency }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Combinations") }}">
                                  {{ $report->combination_type_name }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Jackpot Code") }}">
                                    {{ __("authenticated.Local") }}:
                                    {{ $report->local_jp_code }} <br />
                                    {{ __("authenticated.Global") }}:
                                    {{ $report->global_jp_code }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Ticket Repeat") }}" class="align-right">
                                    {{ $report->ticket_repeat }}
                                </td>
                            </tr>
                            <tr id="hidethis{{$i}}" style="display: none; margin-bottom: 0; padding: 0; width: 1600px;">
                                <td width="100">&nbsp;</td>
                                <td width="100"> </td>
                                <td width="50"> </td>
                                <td colspan="12" style="width: 1250px; margin: 0; padding: 0;">
                                    <table id="hidetable{{$i}}" style="width: 1250px; margin: 0; padding: 0;"></table>
                                </td>
                            </tr>
                            @php ($i++)
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection
