
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

  <style>
    div.wrapperr {
      overflow: auto !important;
      width: 100% !important;
    }
    .tableType1{
      /*width: 400px;*/
      table-layout: fixed !important;
      border-collapse: collapse !important;

    }
    .tableType1 tbody{
      display:block !important;
      width: 600px !important;
      height: 240px;
    }
    .tableType1 thead tr {
      display: block;
      width: 600px !important;
      background: lightgray !important;
    }
    .tableType1 thead {
      color: black;
    }
    .tableType1 th, .tableType1 td {
      padding: 5px;
      /*text-align: left;*/
      word-break: break-all !important;
      width: 250px !important;
    }
    tr.grayRow td{
      background: lightgray !important;
    }
    #drawResultTable{
      table-layout:fixed !important;
      border-collapse: collapse !important;
    }
    #drawResultTable tbody{
      overflow-y: scroll !important;
      height:240px !important;
      display:block !important;
      width: 600px !important;
    }
    #drawResultTable td {
      width:200px !important;
      word-break: break-all !important;
    }

    #winResultTable{
      table-layout:fixed !important;
      border-collapse: collapse !important;
    }
    #winResultTable tbody{
      overflow-y: scroll !important;
      height:240px !important;
      display:block !important;
      width: 700px !important;
    }
    #winResultTable thead{
      overflow-y: scroll !important;
      display:block !important;
      width: 700px !important;
    }
    #winResultTable td {
      /*width:200px !important;*/
      word-break: break-all !important;
    }

    .helpTable tbody tr:nth-child(even) {background: #FFF}
    .helpTable tbody tr:nth-child(odd) {background: #CCC}

    #payTable tbody tr td:nth-child(2) {border-right: 1px solid black;}
    #payTable tbody tr td:nth-child(4) {border-right: 1px solid black;}
    /*#payTable thead tr td:nth-child(even) {border-right: 1px solid black;}*/
  </style>

<div class="content-wrapper">
    <section class="content-header">
      @include('layouts.desktop_layout.header_navigation_second')
        <h1>
            <i class="fa fa-ticket"></i>
            {{ __("authenticated.Ticket Details") }}
          <button id="showContextualMessage" class="btn btn-primary animated shake"><strong class="fa fa-question-circle"></strong></button>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-ticket"></i> {{ __("authenticated.Ticket") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket_serial_number}") }}" title="{{ __('authenticated.Ticket Details') }}">
                    {{ __("authenticated.Ticket Details") }}
                </a>
            </li>
        </ol>
    </section>



    <section class="content">
            <div class="col-md-12">
              <div class="row">
                @include('layouts.shared.form_messages')
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-ticket"></i> {{ __('authenticated.Ticket Details') }}</h4>
                    </div>
                    <div class="widget-content">
                      <span class="pull-left">

                        @if($check_preferred_button_visibility == -2)
                          <span class="alert alert-error">
                          {{ __('authenticated.Draw started') }}
                          </span>
                        @elseif($check_preferred_button_visibility == -3)
                          <span class="alert alert-warning">
                            {{ __('authenticated.Parameters not set correctly') }}
                          </span>
                        @elseif($check_preferred_button_visibility == -99)
                          <span class="hidden">
                            {{ __('authenticated.General Error') }}
                          </span>
                        @elseif($check_preferred_button_visibility == 1)
                          <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenuControlPreferredTicket" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-tachometer"></i>
                              {{ __('authenticated.Control Preferred Ticket') }}
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuControlPreferredTicket">
                              <li><a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/control-preferred-ticket/ticket_serial_number/{$ticket_result[0]->serial_number}/barcode/{$ticket_result[0]->barcode}/status/1/parent_id/{$ticket_result[0]->parent_id}") }}">{{ __('authenticated.Control Preferred Ticket Small') }}</a></li>
                              <li><a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/control-preferred-ticket/ticket_serial_number/{$ticket_result[0]->serial_number}/barcode/{$ticket_result[0]->barcode}/status/2/parent_id/{$ticket_result[0]->parent_id}") }}">{{ __('authenticated.Control Preferred Ticket Medium') }}</a></li>
                              <li><a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/control-preferred-ticket/ticket_serial_number/{$ticket_result[0]->serial_number}/barcode/{$ticket_result[0]->barcode}/status/-1/parent_id/{$ticket_result[0]->parent_id}") }}">{{ __('authenticated.Control Preferred Ticket Off') }}</a></li>
                            </ul>
                          </div>
                        @elseif($check_preferred_button_visibility == 20000)
                          <span class="hidden">
                            &nbsp;
                          </span>
                        @else
                          <span class="alert alert-warning">
                            {{ __('authenticated.Unknown Error') }}
                          </span>
                        @endif

                      </span>

                      <span class="pull-right">
                        <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket_result[0]->serial_number}") }}">
                          <button class="btn btn-sm btn-primary">
                            <i class="fa fa-refresh"></i>
                            {{ __("authenticated.Refresh") }}
                          </button>
                        </a>
                        @if(!env('HIDE_EXPORT_TO_EXCEL'))
						<a target="_blank" class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/excel/ticket-details/ticket_serial_number/{$ticket_result[0]->serial_number}") }}">
                          <button class="btn btn-sm btn-primary">
                            <i class="fa fa-file-excel-o"></i>
                            {{ __("authenticated.Export To Excel") }}
                          </button>
                        </a>
                        @endif
                          <button id="backBtn" class="btn btn-sm btn-primary">
                            <i class="fa fa-chevron-left"></i>
                            {{ __("authenticated.Back") }}
                          </button>
                      </span>
                      <table class="table table-striped table-bordered table-highlight-head" style="height: 650px !important;">
                        <tbody>
                          <tr>
                            <td width="">
                              <span class="">{{ __('authenticated.Serial Number') }}</span>
                            </td>
                            <td>
                              <span class="bold-text">
                                {{ $ticket_result[0]->serial_number }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Barcode') }}</span>
                            </td>
                            <td>
                              <span class="bold-text">
                                {{ $ticket_result[0]->barcode }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Ticket Created') }}</span>
                            </td>
                            <td>
                              <span class="bold-text">
                                {{ $ticket_result[0]->rec_tmstp }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Created By') }}</span>
                            </td>
                            <td>
                              <span class="bold-text">
                                {{ $ticket_result[0]->created_by }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Jackpot Code') }}</span>
                            </td>
                            <td>
                              <span class="bold-text">
                                {{ __('authenticated.Local') }}:
                                {{ $ticket_result[0]->local_jp_code }}
                                {{ __('authenticated.Global') }}:
                                {{ $ticket_result[0]->global_jp_code }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.First Draw ID / SN') }}</span>
                            </td>
                            <td>
                              <span class="bold-text">
                                {{ $ticket_result[0]->first_draw_id }}&nbsp;/&nbsp;{{ $ticket_result[0]->first_draw_sn }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.First Draw') }}</span>
                            </td>
                            <td>
                              <span class="bold-text">
                                {{ $ticket_result[0]->first_draw_date_time }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.No Of Repeat Draws') }}</span>
                            </td>
                            <td>
                              @if (isset($ticket_result[0]->repeat_draws))
                                <span class="text-left bold-text">
                            {{ NumberHelper::format_integer($ticket_result[0]->repeat_draws) }}
                          </span>
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td width="300">
                              <span class="">{{ __('authenticated.Bet Per Draw') }}</span>
                            </td>
                            <td>
                        <span class="bold-text">
                            <span class="text-left bold-text">
                              {{ NumberHelper::format_double($ticket_result[0]->bet_per_draw) }}
                            </span>
                        </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Total Bet per ticket') }}</span>
                            </td>
                            <td>
                        <span class="text-left bold-text">
                          @if(isset($ticket_result[0]->bet_per_ticket))
                            {{ NumberHelper::format_double($ticket_result[0]->bet_per_ticket) }}
                          @endif
                        </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Possible Win') }}</span>
                            </td>
                            <td>
                              <span class="text-left bold-text"> {{ NumberHelper::format_double($ticket_result[0]->possible_win) }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Maximal Payout') }}</span>
                            </td>
                            <td>
                              <span class="text-left bold-text"> {{ NumberHelper::format_double($ticket_result[0]->maximal_payout) }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Currency') }}</span>
                            </td>
                            <td>
                              <span class="text-left bold-text"> {{ $ticket_result[0]->currency }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Ticket Status') }}</span>
                            </td>
                            <td align="">
                                <span class="text-left bold-text">
								@include('layouts.shared.ticket_status',
								["ticket_status" => $ticket_result[0]->ticket_status]
								)
                                </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Jackpot Win') }}</span>
                            </td>
                            <td>
                        <span class="text-left bold-text">
                          @if (isset($ticket_result[0]->jackpot_win))
                            {{ NumberHelper::format_double($ticket_result[0]->jackpot_win) }}
                          @endif
                        </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Win To Pay Out') }}</span>
                            </td>
                            <td>
                        <span class="text-left bold-text">
                          @if (isset($ticket_result[0]->win_to_pay_out))
                            {{ NumberHelper::format_double($ticket_result[0]->win_to_pay_out) }}
                          @endif
                        </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Paid Out Win') }}</span>
                            </td>
                            <td>
                        <span class="text-left bold-text">
                          @if (isset($ticket_result[0]->win_to_pay_out))
                            {{ NumberHelper::format_double($ticket_result[0]->win_paid_out) }}
                          @endif
                        </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="t">{{ __('authenticated.Ticket Printed') }}</span>
                            </td>
                            <td>
                              <span class="text-left bold-text">
                                @include('layouts.shared.status_yes_no',
                                    ["status" => $ticket_result[0]->ticket_printed]
                                )
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="t">{{ __('authenticated.Control Preferred Ticket') }}</span>
                            </td>
                            <td>
                              <span class="text-left bold-text">
                                @include('layouts.shared.preferred_ticket',
                                    ["status" => $ticket_result[0]->preferred_ticket]
                                )
                              </span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-tag"></i> {{ __('authenticated.Combinations Result') }} {{ __('authenticated.Per Draw') }} ({{ __('authenticated.Repeat') }}: {{$ticket_result[0]->repeat_draws}})</h4>
                    </div>
                    <div class="widget-content">
                      <div class="wrapperr">
                        <table class="table table-striped table-highlight-head tableType1">
                          <thead>
                          <tr>
                            <th width="250">{{ __('authenticated.Combination Type') }}</th>
                            <th width="250">{{ __('authenticated.Combination Value') }}</th>
                            <th width="250">{{ __('authenticated.Bet') }}</th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr style="background-color: lightgray;">
                            <td width="250">

                            </td>
                            <td width="250">
                              <span class="text-right text-bold"> {{ __('authenticated.Per Draw') }}: </span>
                            </td>
                            <td width="250" class="text-right">
                              <span class="text-bold"> {{NumberHelper::format_double($ticket_result[0]->bet_per_draw)}} </span>
                            </td>
                          </tr>
                          @foreach($combinations as $cr)
                            <tr>
                              <td width="250">
                                <span class="text-right"> {{ __( $cr['combination_type_name'] ) }} </span>
                              </td>
                              <td width="250">
                                <span class="text-right">
                                  @include('layouts.shared.combination_value',
                                    ["combination_value" => $cr["combination_value"], "combination_type_id" => $cr["combination_type_id"]]
							      )
                                </span>
                              </td>
                              <td width="250" class="text-right">
                                <span class="text-left"> {{ NumberHelper::format_double($cr["bet"]) }} </span>
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <hr>
                      <div class="widget box" style="margin-top:20px;">
                        <div class="widget-header">
                          <h4><i class="fa fa-tag"></i> {{ __('authenticated.Win Result') }} {{ __('authenticated.Per Ticket') }}</h4>
                        </div>
                        <div class="widget-content">
                          <div class="wrapperr">
                            <table id="winResultTable" class="table table-striped table-highlight-head">
                              <thead>
                              <tr>
                                <th width="200">{{ __('authenticated.Combination Type') }}</th>
                                <th width="200">{{ __('authenticated.Combination Value') }}</th>
                                <th width="100">{{ __('authenticated.Bet') }}</th>
                                <th width="100">{{ __('authenticated.Win') }}</th>
                                <th width="100">{{ __('authenticated.Draw') }}</th>
                              </tr>
                              </thead>
                              <tbody>
                              @foreach($win_result as $cr)
                                <tr>
                                  <td width="200">
                                    <span class="text-right"> {{ __( $cr['combination_type_name'] ) }} </span>
                                  </td>
                                  <td width="200">
                                    <span class="text-right">
                                      @include('layouts.shared.combination_value',
                                        ["combination_value" => $cr["combination_value"], "combination_type_id" => $cr["combination_type_id"]]
							          )
                                    </span>
                                  </td>
                                  <td width="100" class="text-right">
                                    <span> {{ $cr["bet"] }} </span>
                                  </td>
                                  <td width="100" class="text-right">
                                    <span> {{ $cr["win"] }} </span>
                                  </td>
                                  <td width="100" class="text-right">
                                    <span> {{ $cr["order_num"] }} </span>
                                  </td>
                                </tr>
                              @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="widget box" style="margin-top:20px !important;">
                      <div class="widget-header">
                        <h4><i class="fa fa-tag"></i> {{ __('authenticated.Draw Result') }}</h4>
                      </div>
                      @php $i = 0; @endphp
                      <div class="wrapperr">
                        <table id="drawResultTable" class="table table-striped table-bordered table-highlight-head">
                          <tbody style="height: 300px !important;">
                          @foreach ($draw_result as $ticket)
                            @php
                              //dd($ticket);
                            @endphp
                            @if ($i==0)

                            @endif
                            <!--<br><br>-->
                            <tr class="grayRow">
                              <td>
                                <span class="bold-text" style="color: #285F8F;">{{ __('authenticated.For Draw ID / SN') }}</span>
                              </td>
                              <td>
                                <span class="bold-text" style="color: #285F8F;">{{ $ticket["first_draw_id"] }}&nbsp;/&nbsp;{{ $ticket["first_draw_sn"] }}</span>
                              </td>
                              <td>
                                <button class="btn btn-primary" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/draw-details/draw_id/{$ticket['draw_id']}") }}', 'draw_details_window',
                                        'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=900,height=600,top=100,left=100,resizable=yes').focus()"><span class="fa fa-info">&nbsp;</span>{{trans("authenticated.Details")}}</button>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="">{{ __('authenticated.Draw Time') }}</span>
                              </td>
                              <td>
                              <span class="bold-text">
                                {{ $ticket["first_draw_date_time"] }}
                              </span>
                              </td>
                              <td>

                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="">{{ __('authenticated.JackPot Win') }}</span>
                              </td>
                              <td>
                                <span class="text-right bold-text"> {{ NumberHelper::format_double($ticket["jackpot_win"]) }} </span>
                              </td>
                              <td>

                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="">{{ __('authenticated.Draw Status') }}</span>
                              </td>
                              <td>
                                <span class="text-right bold-text">
								@include('layouts.shared.draw_status',
								["draw_status" => $ticket{"draw_status"}]
								)
                                </span>
                              </td>
                              <td>

                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="">{{ __('authenticated.Chosen Numbers') }}</span>
                              </td>
                              <td>
                              <span class="bold-text">
                                {{ $ticket["chosen_numbers"] }}
                              </span>
                              </td>
                              <td>

                              </td>
                            </tr>
                            @php $i++; @endphp
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
				
              </div>
            </div>

            <!--<div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-tag"></i> {{ __('authenticated.Bet Details') }}</h4>
              </div>
              <div class="widget-content">

                <table class="table table-striped table-bordered table-highlight-head">
                  <tbody>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Ticket Status') }}</span>
                      </td>
                      <td>
                        <span class="width-120 text-right bold-text">
                          @include('layouts.shared.ticket_status',
                              ["ticket_status" => $ticket->ticket_status]
                          )
                        </span>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>-->

          <div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-tag"></i> {{ __('authenticated.Player Details') }}</h4>
              </div>
              <div class="widget-content">
                <div class="row">
                  <div class="col-sm-6">
                    <table width="600" class="table table-striped table-bordered table-highlight-head">
                      <tbody>
                        @if(!empty($ticket_result[0]->player_id))
                          <tr>
                            <td width="200">
                              <span class="">{{ __('authenticated.Player Username') }}</span>
                            </td>
                            <td>
                              <span class="red-caption-text bold-text"> {{ $ticket_result[0]->player_username }} </span>
                            </td>
                          </tr>
                          @elseif(empty($ticket_result[0]->player_id))
                          <tr>
                            <td width="200">
                              <span class="">{{ __('authenticated.Cashier Username') }}</span>
                            </td>
                            <td>
                              <span class="red-caption-text bold-text"> {{ $ticket_result[0]->cashier_username }} </span>
                            </td>
                          </tr>
                          @endif
                        <tr>
                          <td width="200">
                            <span class="">{{ __('authenticated.Parent Entity') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->parent_entity_name }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td width="200">
                            <span class="">{{ __('authenticated.First Name') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->first_name }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td width="200">
                            <span class="">{{ __('authenticated.Last Name') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->last_name }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td width="200">
                            <span class="">{{ __('authenticated.Mobile Phone') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->mobile_phone }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">
                            {{ __('authenticated.Email') }}
                            </span>
                          </td>
                          <td style="padding:3px 0 0 5px;">
                            <span class="bold-text"> {{ $ticket_result[0]->email }}</span>
                            @if(strlen($ticket_result[0]->email) != 0)
                              <span class="width-100">&nbsp;</span>
                              <span class="pull-center">
                                <a href="mailto:{{ $ticket_result[0]->email }}" class="btn btn-sm btn-primary noblockui">
                                  <i class="fa fa-envelope"></i>
                                  {{ __('authenticated.Email') }}
                                </a>
                              </span>
                            @endif
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-sm-6">
                    <table width="600" class="table table-striped table-bordered table-highlight-head">
                      <tbody>
                         <tr>
                          <td>
                            <span class="">{{ __('authenticated.Address') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->address }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Address 2') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->commercial_address }}</span>
                          </td>
                        </tr>
                        <tr>
                        <tr>
                          <td width="200">
                            <span class="">{{ __('authenticated.Post Code') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->post_code }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.City') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->city }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Country') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $ticket_result[0]->country }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Language') }}</span>
                          </td>
                          <td>
                            <span class="bold-text">
                              @include('layouts.shared.language',
                                  ["language" => $ticket_result[0]->language]
                              )
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </section>
</div>
  <div class="modal zoomIn" id="contextualMessageModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" align="center">{{trans("authenticated.Win Table")}}</h4>
        </div>
        <div class="modal-body">
          @php $i = 0; @endphp
          <div class="wrapperr">
            <table id="payTable" class="table table-bordered table-highlight-head helpTable">
              <thead>
              <tr style="font-weight: bold !important;">
                <td width="100">{{trans("authenticated.Ball Order")}}</td>
                <td width="100">{{trans("authenticated.Coefficient")}}</td>
                <td width="100">{{trans("authenticated.Ball Order")}}</td>
                <td width="100">{{trans("authenticated.Coefficient")}}</td>
                <td width="100">{{trans("authenticated.Ball Order")}}</td>
                <td width="100">{{trans("authenticated.Coefficient")}}</td>
              </tr>
              </thead>
              <tbody style="max-height: 300px !important;">
              @foreach ($payTable as $row)
                <tr>
                  <td width="100" align="right">{{$row["ORDER_OF_DRAWN_BALL"]}}</td>
                  <td width="100" align="right">{{$row["QUOTA"]}}</td>
                  <td width="100" align="right">{{$row["ORDER_OF_DRAWN_BALL_2"]}}</td>
                  <td width="100" align="right">{{$row["QUOTA_2"]}}</td>
                  <td width="100" align="right">{{$row["ORDER_OF_DRAWN_BALL_3"]}}</td>
                  <td width="100" align="right">{{$row["QUOTA_3"]}}</td>
                </tr>
                @php $i++; @endphp
              @endforeach
              </tbody>
            </table>
          </div>

          @php $i = 0; @endphp
          <div class="wrapperr">
            <table id="coefficients" class="table table-bordered table-highlight-head helpTable">
              <thead>
              <tr style="font-weight: bold !important;">
                <td width="100">{{trans("authenticated.Name")}}</td>
                <td width="100">{{trans("authenticated.Coefficient")}}</td>
              </tr>
              </thead>
              <tbody style="max-height: 300px !important;">
              @foreach ($coefficients as $coefficient)
                <tr>
                  <td width="100" align="left">{{$coefficient["name"]}}</td>
                  <td width="100" align="right">{{$coefficient["value"]}}</td>
                </tr>
                @php $i++; @endphp
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button id="closeContextualMessageModal" type="button" data-dismiss = "modal" class="btn btn-default pull-right">
            <i class="fa fa-close"></i>
            {{trans("authenticated.Close")}}
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </div>
  <script>
    $(document).ready(function(){
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

        $("#backBtn").on("click", function(){
            var goBack = history.go(-1);

            if(goBack == null){
                window.close();
            }
        });

    });
  </script>
@endsection
