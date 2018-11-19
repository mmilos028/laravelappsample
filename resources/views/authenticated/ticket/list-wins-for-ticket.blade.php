
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-list"></i>
            {{ __("authenticated.List Wins For Ticket") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> {{ __("authenticated.Ticket") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/list-wins-for-ticket/ticket_id/{$ticket_id}") }}" title="{{ __('authenticated.List Wins For Ticket') }}">
                    {{ __("authenticated.List Wins For Ticket") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box table-responsive">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'ticket/list-wins-for-ticket/ticket_id/' . $ticket_id), 'method'=>'POST', 'class' => 'form-inline row-border' ]) !!}
            <div class="box-body">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <td colspan="11" class="align-right">
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
                        <tr class="bg-blue-active">
                            <th width="120">{{ __("authenticated.Serial Number") }}</th>
							<th width="120">{{ __("authenticated.Barcode") }}</th>
							<th width="80">{{ __("authenticated.Payed Out") }}</th>
							<th width="80">{{ __("authenticated.Ticket Status") }}</th>
							<th width="80">{{ __("authenticated.Ticket Printed") }}</th>
							<th width="120">{{ __("authenticated.Combination Type") }}</th>
							<th width="120">{{ __("authenticated.Combination Value") }}</th>
							<th width="80">{{ __("authenticated.Bet") }}</th>
							<th width="80">{{ __("authenticated.Win") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_wins_for_ticket as $ticket)
                        <tr>
                            <td>
                                {{ $ticket->serial_number }}
                            </td>
                            <td>
                                {{ $ticket->barcode }}
                            </td>                          
                            <td class="align-center">
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
                            <td class="align-left">
                                @include('layouts.shared.ticket_status',
									["ticket_status" => $ticket->ticket_status]
								)
                            </td>
							<td class="align-center">
                                @include('layouts.shared.status_yes_no',
								["status" => $ticket->ticket_printed]
								)
                            </td>
                            <td>
                                {{ $ticket->combination_type }}
                            </td>
                            <td class="align-right">
                                {{ $ticket->combination_value }}
                            </td>
                            <td class="align-right">
                                {{ NumberHelper::format_double($ticket->bet) }}
                            </td>
                            <td class="align-right">
                                {{ NumberHelper::format_double($ticket->win) }}
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
