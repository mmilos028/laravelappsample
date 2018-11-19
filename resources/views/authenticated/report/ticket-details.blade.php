
@extends( 'layouts.window_details_layout' )

@section('content')

    <section class="content">

      <div class="col-md-12">
        <div class="row">
          @php
          $i=0;
          @endphp
          @foreach ($ticket_result as $ticket)
            @php
              $i++;
            @endphp
          <div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-ticket"></i> {{ __('authenticated.Ticket Details') }}</h4>
                @if($i==1)
                <span class="pull-right">
                  <button class="btn btn-sm btn-success" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/ticket-details/ticket_serial_number/{$ticket_serial_number}") }}', 'ticket_details_window',
                          'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=850,height=600,top=100,left=100,resizable=yes').focus()">
                      <i class="fa fa-refresh"></i>
                      {{ __("authenticated.Refresh") }}
                  </button>
                  <button class="btn btn-sm btn-danger" onClick="window.close('ticket_details_window')">
                      <i class="fa fa-close"></i>
                      {{ __("authenticated.Close") }}
                  </button>
                </span>
                @endif
              </div>
              <div class="widget-content">
                <div class="row">
                  <div class="col-xs-6">
                    <table class="table table-striped table-bordered table-highlight-head">
                      <tbody>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Serial Number') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->serial_number }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Ticket Created') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->rec_tmstp }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Created By') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->created_by }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Barcode') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->barcode }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Jackpot Code') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text">
                              {{ __('authenticated.Local') }}:
                              {{ $ticket->local_jp_code }}
                              {{ __('authenticated.Global') }}:
                              {{ $ticket->global_jp_code }}
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-xs-6">
                    <table class="table table-striped table-bordered table-highlight-head">
                      <tbody>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.First Draw SN') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->first_draw_sn }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.First Draw') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->first_draw_date_time }}</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach


          <div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-tag"></i> {{ __('authenticated.Ticket Choice') }}</h4>
              </div>
              <div class="widget-content">
                <table class="table table-striped table-bordered table-highlight-head">
                  <thead>
                      <tr class="bg-blue-active">
                          <th width="100">{{ __('authenticated.Combination Type') }}</th>
                          <th width="100">{{ __('authenticated.Choice') }}</th>
                          <th width="100">{{ __('authenticated.Bet') }}</th>
                          <th width="100">{{ __('authenticated.Possible Win') }}</th>
                          <th width="100">{{ __('authenticated.Currency') }}</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach($combinations_result as $cr)
                    <tr>
                      <td>
                          {{ $cr->combination_type_name }}
                      </td>
                      <td>
                          {{ $cr->combination_value }}
                      </td>
                      <td class="align-right">
                          {{ NumberHelper::format_double($cr->bet) }}
                      </td>
                      <td class="align-right">
                          {{ NumberHelper::format_double($cr->possible_win) }}
                      </td>
                      <td>
                          {{ $cr->currency }}
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-tag"></i> {{ __('authenticated.Bet Details') }}</h4>
                <span class="pull-right">
                  <button class="btn btn-sm btn-primary" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/ticket-draw-details/ticket_serial_number/{$ticket_serial_number}/draw_serial_number/{$ticket->order_num}/draw_id/{$ticket->draw_id}") }}', 'ticket_draw_details_window',
                          'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=850,height=600,top=100,left=100,resizable=yes').focus()">
                      <i class="fa fa-bar-chart"></i>
                      {{ __("authenticated.Draw Details") }}
                  </button>
                </span>
              </div>
              <div class="widget-content">

                <table class="table table-striped table-bordered table-highlight-head">
                  <tbody>
                    <tr>
                      <td width="300">
                        <span class="bold-text">
                          {{ __('authenticated.Bet Per Draw') }}
                        </span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          @if(isset($ticket->bet_per_draw))
                            {{ NumberHelper::format_double($ticket->bet_per_draw) }}
                          @endif
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">
                          {{ __('authenticated.No Of Repeat Draws') }}
                        </span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          @if(isset($ticket->repeat_draws))
                            {{ NumberHelper::format_integer($ticket->repeat_draws) }}
                          @endif
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">
                          {{ __('authenticated.Total Bet per ticket') }}
                        </span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          @if(isset($ticket->bet_per_ticket))
                          {{ NumberHelper::format_double($ticket->bet_per_ticket) }}
                          @endif
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">
                          {{ __('authenticated.Jackpot Win') }}
                        </span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          {{ NumberHelper::format_double($ticket->jackpot_win) }}
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">{{ __('authenticated.Win To Pay Out') }}</span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          @if(isset($ticket->win_to_pay_out))
                            {{ NumberHelper::format_double($ticket->win_to_pay_out) }}
                          @endif
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">{{ __('authenticated.Ticket Status') }}</span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          @include('layouts.shared.ticket_status',
                              ["ticket_status" => $ticket->ticket_status]
                          )
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">{{ __('authenticated.Ticket Printed') }}</span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          @include('layouts.shared.status_yes_no',
                              ["status" => $ticket->ticket_printed]
                          )
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

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
                        <tr>
                          <td width="200">
                            <span class="bold-text">{{ __('authenticated.Player Username') }}</span>
                          </td>
                          <td>
                            <span class="red-caption-text bold-text"> {{ $ticket->player_username }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">
                            {{ __('authenticated.Email') }}
                            </span>
                          </td>
                          <td style="padding:3px 0 0 5px;">
                            <span class="details-info-text"> {{ $ticket->email }}</span>
                            @if(strlen($ticket->email) != 0)
                            <span class="pull-right">
                              <a href="mailto:{{ $ticket->email }}" class="btn btn-sm btn-primary noblockui">
                                <i class="fa fa-envelope"></i>
                                {{ __('authenticated.Email') }}
                              </a>
                            </span>
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Address') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->address }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Address 2') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->commercial_address }}</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-sm-6">
                    <table width="600" class="table table-striped table-bordered table-highlight-head">
                      <tbody>
                        <tr>
                          <td width="200">
                            <span class="bold-text">{{ __('authenticated.Post Code') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->post_code }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.City') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->city }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Country') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->country }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Language') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text">
                              @include('layouts.shared.language',
                                  ["language" => $ticket->language]
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

        </div>
      </div>

    </section>
@endsection
