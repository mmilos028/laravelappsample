

<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

	<style>
        #list-player-tickets thead{
            width: 100%;
            display: block;
            table-layout:fixed;

            padding-right: 40px;
        }
        #list-player-tickets tbody{
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
        $("#list-player-tickets > thead > tr.bg-blue-active > th").each(function(index, value) {
            tableWidth.push(value.width);
        });

        $("#list-player-tickets > tbody > tr").each(function(index, value){
            $(this).find("td").each(function(index2, value2) {
                $(this).attr("width", tableWidth[index2]);
            });
        });
    }

    $(document).ready(function() {
        var table = $('#list-player-tickets').DataTable(
            {
                "order": [],
                "ordering": true,
                "searching": true,
                "deferRender": true,
                "processing": true,
                responsive: false,
                info: true,
                autoWidth: false,
                colReorder: true,
                "paging": true,
                pagingType: 'simple_numbers',
                "iDisplayLength": 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
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

        $('#list-player-tickets tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#list-player-tickets tfoot tr').appendTo('#list-player-tickets thead');

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

        document.getElementById('list-player-tickets_wrapper').removeChild(
            document.getElementById('list-player-tickets_wrapper').childNodes[0]
        );
		
		//top scrollbar 
		var topScrollbar = document.getElementById('topScrollbar');
		var topScrollbar_div = document.getElementById('topScrollbar-div');
		var tableResponsive = document.getElementsByClassName('table-responsive');
		tableResponsive = tableResponsive[0];
		
		topScrollbar.style = "width: 320px; border: none; overflow-x: scroll; overflow-y:hidden;height: 20px;";
		topScrollbar_div.style = "width:1800px; height: 20px;";
		
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
            {{ __("authenticated.List Player Tickets") }}            &nbsp;
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
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/report/list-player-tickets/user_id/{$user_id}") }}" title="{{ __('authenticated.List Player Tickets') }}">
                    {{ __("authenticated.List Player Tickets") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-left">                            
                        </td>
                        <td class="pull-right">
                        {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'terminal/report/list-player-tickets/user_id/' . $user_id), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
							{!!
                                Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                array(
                                    'class'=>'btn btn-primary  pull-left',
                                    'type'=>'submit',
                                    'name'=>'generate_report'
                                    )
                                )
                            !!}
                        {!! Form::close() !!}
                        </td>
                    </tr>
                </table>
				<div id="topScrollbar">
					<div id="topScrollbar-div">
					</div>
				</div>
				<div class="table-responsive">
					<table style="width: 1290px;" id="list-player-tickets" class="table table-bordered table-hover table-striped pull-left">
						<thead>
							<tr class="bg-blue-active">
								<th width="100">{{ __("authenticated.Serial Number") }}</th>
                                <th width="150">{{ __("authenticated.Barcode") }}</th>
                                <th width="100">{{ __("authenticated.Payed Out") }}</th>
                                <th width="150">{{ __("authenticated.Ticket Status") }}</th>
                                <th width="100">{{ __("authenticated.Ticket Printed") }}</th>
                                <th width="150">{{ __("authenticated.Combination Type") }}</th>
                                <th width="150">{{ __("authenticated.Combination Value") }}</th>
                                <th width="150">{{ __("authenticated.Jackpot Code") }}</th>
                                <th width="100">{{ __("authenticated.Bet") }}</th>
                                <th width="100">{{ __("authenticated.Win") }}</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
                                <th width="100"></th>
                                <th width="150"></th>
                                <th width="100"></th>
                                <th width="150"></th>
                                <th width="100"></th>
                                <th width="150"></th>
                                <th width="150"></th>
                                <th width="150"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                            </tr>
						</tfoot>
						<tbody>
							@foreach ($list_tickets as $ticket)
							<tr>
								<td width="100" title="{{ __("authenticated.Serial Number") }}">
								  <a class="bold-text" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket->serial_number}") }}" title="{{ __("authenticated.View Ticket Details") }}">
                                        {{ $ticket->serial_number }}
                                    </a>
								</td>
								<td width="150" title="{{ __("authenticated.Barcode") }}">
								  {{ $ticket->barcode }}
								</td>
								<td width="100" class="align-center" title="{{ __("authenticated.Payed Out") }}">
									@if ($ticket->payed_out == "1")
										<span class="label label-success">
											{{ __ ("authenticated.Yes") }}
										</span>
									@else
										<span class="label label-danger">
											{{ __ ("authenticated.No") }}
										</span>
									@endif
								</td>
								<td width="100" class="align-left" title="{{ __("authenticated.Ticket Status") }}">
								  @include('layouts.shared.ticket_status',
										["ticket_status" => $ticket->ticket_status]
									)
								</td>
								<td width="150" class="align-center" title="{{ __("authenticated.Ticket Printed") }}">
								  @include('layouts.shared.status_yes_no',
									["status" => $ticket->ticket_printed]
									)
								</td>
								<td width="150" class="align-left">
								  {{ $ticket->combination_type }}
								</td>
								<td width="150" class="align-left">
								  {{ $ticket->combination_value }}  
								</td>
                                <td width="150" class="align-left">
                                  @if(isset($ticket->local_jp_code))
                                    {{ __("authenticated.Local") }}:
                                    {{ $ticket->local_jp_code }}
                                  @endif
                                  @if(isset($ticket->global_jp_code))
                                  {{ __("authenticated.Global") }}:
                                  {{ $ticket->global_jp_code }}
                                  @endif
                                </td>
								<td width="100" class="align-right">
								  {{ NumberHelper::format_double($ticket->bet) }}
								</td>
								<td width="100" class="align-right">
								  {{ NumberHelper::format_double($ticket->win) }}
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
