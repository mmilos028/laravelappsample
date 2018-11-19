
@php
$table_width = 1600;
@endphp

@extends( 'layouts.subreport_layout' )

@section('content')

        <div style="padding: 0; width: <?php echo $table_width; ?>px;">
			<table style="width: <?php echo $table_width; ?>px;" class="table table-bordered table-striped">
				<thead style="padding: 0px; width: <?php echo $table_width; ?>px;">
					<tr class="bg-light-blue-active">
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
						<th width="100">{{ __("authenticated.First Draw SN") }}</th>
						<th width="150">{{ __("authenticated.Draw Date & Time") }}</th>
						<th width="100">{{ __("authenticated.Draw Details") }}</th>
					</tr>
				</thead>
				<tbody style="height: auto; padding: 0px; overflow-y: hidden; width: <?php echo $table_width; ?>px;">
					@php ($i = 0)
					@foreach ($list_report as $report)
						@php
						//dd($report)
						@endphp
						<tr style="width: <?php echo $table_width; ?>px;">
							<td width="100" class="align-left" title="{{ __("authenticated.Ticket SN") }}">
								<a href="#" class="noblockui bold-text" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$report->serial_number}") }}', 'ticket_draw_details_window').focus()">
								{{ $report->serial_number}}
								</a>
							</td>
							<td width="100" class="align-left" title="{{ __("authenticated.Created By") }}">
								{{ $report->created_by }}
							</td>
							<td width="150" title="{{ __("authenticated.Created Date & Time") }}">
								{{ $report->ticket_rec_tmstp }}
							</td>
							<td width="100" class="align-left" title="{{ __("authenticated.Ticket Status") }}">
								@include('layouts.shared.ticket_status',
									["ticket_status" => $report->ticket_status]
								)
							</td>
							<td width="100" class="align-right" title="{{ __("authenticated.Bet per Draw") }}">
								{{ NumberHelper::format_double($report->bet_per_draw) }}
							</td>
							<td width="100" class="align-right" title="{{ __("authenticated.Bet per Ticket") }}">
								{{ NumberHelper::format_double($report->bet_per_ticket) }}
							</td>
							<td width="100" class="align-right" title="{{ __("authenticated.Possible Win") }}">
								{{ NumberHelper::format_double($report->possible_win) }}
							</td>
							<td width="100" class="align-right" title="{{ __("authenticated.Executed Win") }}">
								{{ NumberHelper::format_double($report->executed_win) }}
							</td>
							<td width="100" title="{{ __("authenticated.Currency") }}">
								{{ $report->currency }}
							</td>
							<td width="100" title="{{ __("authenticated.Combinations") }}">
								{{ $report->combination_type_name }}
							</td>
							<td width="100" title="{{ __("authenticated.Jackpot Code") }}">
								{{ __('authenticated.Local') }}:
								{{ $report->local_jp_code }} <br />
								{{ __('authenticated.Global') }}:
								{{ $report->global_jp_code }}
							</td>
							<td width="100" class="align-right" title="{{ __("authenticated.Ticket Repeat") }}">
								{{ NumberHelper::format_integer($report->ticket_repeat) }}
							</td>
							<td width="100" title="{{ __("authenticated.First Draw SN") }}">
								{{ $report->first_draw_sn }}
							</td>
							<td width="150" class="align-left" title="{{ __("authenticated.Draw Date & Time") }}">
								{{ $report->draw_date_time }}
							</td>
							<td width="100" class="align-left" title="{{ __("authenticated.Draw Details") }}">
								<button class="btn btn-success" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/draw-details/draw_id/{$report->draw_id}") }}', 'draw_details_window',
										'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=900,height=600,top=100,left=100,resizable=yes').focus()">
									<i class="fa fa-info"></i>
								</button>
							</td>
						</tr>
					@endforeach
				</tbody>

			</table>
        </div>

@endsection
