
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.With Barcode") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> {{ __("authenticated.Ticket") }}</li>
            <li>{{ __("authenticated.Check Ticket Details") }}</li>
            <li class="active">{{ __("authenticated.With Barcode") }}</li>
        </ol>
    </section>

    <section class="content">

        <div class="box table-responsive">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'ticket/check-ticket-details-with-barcode'), 'method'=>'POST', 'class' => 'form-inline row-border' ]) !!}
            <div class="box-body">
                <table class="table">
                    <tr>
                      <td class="align-right">
						{!! Form::label('barcode', trans('authenticated.Barcode') . ':', array('class' => 'control-label')) !!}
						{!!
						  Form::text('barcode', $barcode,
							  array(
									'autofocus',
									'class'=>'form-control',
									'placeholder'=>trans('authenticated.Barcode')
							  )
						  )
						!!}
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
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="bg-blue-active">
                            <th width="80">{{ __("authenticated.Actions") }}</th>
							<th width="120">{{ __("authenticated.Serial Number") }}</th>
							<th width="120">{{ __("authenticated.Barcode") }}</th>
							<th width="130">{{ __("authenticated.Cashier") }}</th>
							<th width="150">{{ __("authenticated.Player Username") }}</th>
							<th width="80">{{ __("authenticated.Payed Out") }}</th>
							<th width="100">{{ __("authenticated.Ticket Status") }}</th>
							<th width="120">{{ __("authenticated.City") }}</th>
							<th width="120">{{ __("authenticated.Address") }}</th>
							<th width="150">{{ __("authenticated.Commercial Address") }}</th>
							<th width="80">{{ __("authenticated.Language") }}</th>
							<th width="100">{{ __("authenticated.Ticket Printed") }}</th>
							<th width="100">{{ __("authenticated.Number Of Ticket Printed") }}</th>
							<th width="120">{{ __("authenticated.Jackpot Name") }}</th>
							<th width="120">{{ __("authenticated.Jackpot Win") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_tickets as $ticket)
	                        <tr>
								<td class="align-center" title="{{ __("authenticated.Actions") }}">
	                                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details/ticket_id/{$ticket->ticket_id}") }}" class="btn btn-primary" title="{{ __("authenticated.View Ticket Details") }}">
										<i class="fa fa-info"></i>
									</a>
	                            </td>
	                            <td class="align-left" title="{{ __("authenticated.Serial Number") }}">
	                                {{ $ticket->serial_number }}
	                            </td>
	                            <td class="align-right" title="{{ __("authenticated.Barcode") }}">
	                                {{ $ticket->barcode }}
	                            </td>
	                            <td title="{{ __("authenticated.Cashier") }}">
	                                {{ $ticket->cashier }}
	                            </td>
	                            <td class="align-left" title="{{ __("authenticated.Player Username") }}">
	                                {{ $ticket->player_username }}
	                            </td>
	                            <td class="align-center" title="{{ __("authenticated.Payed Out") }}">
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
	                            <td class="align-left" title="{{ __("authenticated.Ticket Status") }}">
									@include('layouts.shared.ticket_status',
										["ticket_status" => $ticket->ticket_status]
									)
	                            </td>
	                            <td title="{{ __("authenticated.City") }}">
	                                {{ $ticket->city }}
	                            </td>
	                            <td title="{{ __("authenticated.Address") }}">
	                                {{ $ticket->address }}
	                            </td>
	                            <td title="{{ __("authenticated.Commercial Address") }}">
	                                {{ $ticket->commercial_address }}
	                            </td>
	                            <td title="{{ __("authenticated.Language") }}">
	                                {{ __( "language." . $ticket->language ) }}
	                            </td>
	                            <td class="align-center" title="{{ __("authenticated.Ticket Printed") }}">
	    							@include('layouts.shared.status_yes_no',
									["status" => $ticket->ticket_printed]
									)
	                            </td>
								<td class="align-right" title="{{ __("authenticated.Number Of Ticket Printed") }}">
									{{ NumberHelper::format_integer($ticket->no_of_printings) }}
								</td>
								<td title="{{ __("authenticated.Jackpot Name") }}">
	                                {{ $ticket->jackpot }}
	                            </td>
								<td class="align-right" title="{{ __("authenticated.Jackpot Win") }}">
	                                {{ NumberHelper::format_double($ticket->jackpot_win) }}
	                            </td>
	                        </tr>
	                    @endforeach
                    </tbody>

                </table>
            </div>
            {!! Form::close() !!}
        </div>

    </section>
</div>
@endsection
