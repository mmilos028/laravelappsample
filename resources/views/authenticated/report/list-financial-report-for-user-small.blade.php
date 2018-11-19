
@extends( 'layouts.subreport_layout' )

@section('content')

        <div class="table-responsive" style="padding: 0;">
                <table style="width: 1110px;" class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-light-blue-active">
							<th width="150">{{ __("authenticated.Number Of Tickets") }}</th>
							<th width="150">{{ __("authenticated.Number Of Wins") }}</th>
							<th width="200">{{ __("authenticated.Deposit Total") }}</th>
							<th width="150">{{ __("authenticated.Withdraw Total") }}</th>
							<th width="150">{{ __("authenticated.Combinations") }}</th>
							<th width="150">{{ __("authenticated.Netto") }}</th>
							<th width="150">{{ __("authenticated.Currency") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_report as $report)
	                        <tr>
                                <td class="align-right" title="{{ __("authenticated.Number Of Tickets") }}">
                                    {{ NumberHelper::format_integer($report->number_of_tickets) }}
                                </td>
	                            <td class="align-right" title="{{ __("authenticated.Number Of Wins") }}">
	                                {{ NumberHelper::format_integer($report->number_of_wins) }}
	                            </td>
	                            <td class="align-right" title="{{ __("authenticated.Deposit Total") }}">
	                                {{ NumberHelper::format_double($report->deposit_total) }}
	                            </td>
	                            <td class="align-right" title="{{ __("authenticated.Withdraw Total") }}">
									{{ NumberHelper::format_double($report->withdraw_total) }}
	                            </td>
	                            <td title="{{ __("authenticated.Combinations") }}">
									{{ $report->combinations }}
	                            </td>
	                            <td class="align-right" title="{{ __("authenticated.Netto") }}">
	    							{{ NumberHelper::format_double($report->netto) }}
	                            </td>
								<td class="align-right" title="{{ __("authenticated.Number Of Ticket Printed") }}">
									{{ NumberHelper::format_integer($report->no_of_printings) }}
								</td>
								<td title="{{ __("authenticated.Currency") }}">
	                                {{ $report->currency }}
	                            </td>
	                        </tr>
	                    @endforeach
                    </tbody>

                </table>
        </div>

@endsection
