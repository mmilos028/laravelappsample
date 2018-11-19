
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-ticket"></i>
            {{ __("authenticated.Ticket Details") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-ticket"></i> {{ __("authenticated.Ticket") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details/ticket_id/{$ticket_id}") }}" title="{{ __('authenticated.Ticket Details') }}">
                    {{ __("authenticated.Ticket Details") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">
            <div class="col-md-12">
              <div class="row">
                @php $i = 0; @endphp
				@foreach ($ticket_result as $ticket)

                <div class="col-md-6">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-ticket"></i> {{ __('authenticated.Ticket Details') }}</h4>
                      @if ($i==0)
					  <span class="pull-right">
                        <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket->serial_number}") }}">
                          <button class="btn btn-sm btn-primary">
                            <i class="fa fa-refresh"></i>
                            {{ __("authenticated.Refresh") }}
                          </button>
                        </a>
                        @if(!env('HIDE_EXPORT_TO_EXCEL'))
						<a target="_blank" class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/excel/ticket-details/ticket_serial_number/{$ticket->serial_number}") }}">
                          <button class="btn btn-sm btn-primary">
                            <i class="fa fa-file-excel-o"></i>
                            {{ __("authenticated.Export To Excel") }}
                          </button>
                        </a>
                        @endif

                        <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets") }}">
                          <button class="btn btn-sm btn-primary">
                            <i class="fa fa-chevron-left"></i>
                            {{ __("authenticated.Back") }}
                          </button>
                        </a>
                      </span>
                      @endif
                    </div>
                    <div class="widget-content">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td width="300">
                              <span class="bold-text">{{ __('authenticated.Serial Number') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text">
                                {{ $ticket->serial_number }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Ticket Created') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text">
                                {{ $ticket->rec_tmstp }}
                              </span>
                            </td>
                          </tr>
						  <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Created By') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text">
                                {{ $ticket->created_by }}
                              </span>
                            </td>
                          </tr>
						  <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Barcode') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text">
                                {{ $ticket->barcode }}
                              </span>
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
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.First Draw ID / SN') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text">
                                {{ $ticket->draw_id }}&nbsp;/&nbsp;{{ $ticket->first_draw_sn }}
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.First Draw') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text">
                                {{ $ticket->first_draw_date_time }}
                              </span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                  @php $i++; @endphp
				@endforeach

                <div class="col-md-6">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-tag"></i> {{ __('authenticated.Combinations Result') }}</h4>
                    </div>
                    <div class="widget-content">
						@foreach($combinations_result as $cr)
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td width="300">
                              <span class="bold-text">{{ __('authenticated.Combination Type') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text"> {{ __( $cr->combination_type_name ) }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
								<span class="bold-text">{{ __('authenticated.Combination Value') }}</span>
                            </td>
                            <td>
								<span class="details-info-text"> {{ __( $cr->combination_value ) }} </span>
                            </td>
                          </tr>
						  <tr>
                            <td>
								<span class="bold-text">{{ __('authenticated.Bet') }}</span>
                            </td>
                            <td>
								<span class="width-120 text-right details-info-text"> {{ NumberHelper::format_double($cr->bet) }} </span>
                            </td>
                          </tr>
						  <tr>
                            <td>
								<span class="bold-text">{{ __('authenticated.Possible Win') }}</span>
                            </td>
                            <td>
								<span class="width-120 text-right details-info-text"> {{ NumberHelper::format_double($cr->possible_win) }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Maximal Payout') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text"> {{ $cr->possible_win }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Currency') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text"> {{ $cr->currency }} </span>
                            </td>
                          </tr>
						  <tr>
                            <td>
								<span class="bold-text">{{ __('authenticated.Ticket Status') }}</span>
                            </td>
                            <td>
                                <span class="details-info-text">
								@include('layouts.shared.ticket_status',
								["ticket_status" => $ticket->ticket_status]
								)
                                </span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
					  @endforeach
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-tag"></i> {{ __('authenticated.Bet Details') }}</h4>
              </div>
              <div class="widget-content">

                <table class="table table-striped table-bordered table-highlight-head">
                  <tbody>
                    <tr>
                      <td width="300">
                        <span class="bold-text">{{ __('authenticated.Bet Per Draw') }}</span>
                      </td>
                      <td>
                        <span class="bold-text details-info-text">
                          @if(isset($ticket->bet_per_draw))
                            <span class="width-120 text-right">
                            {{ NumberHelper::format_double($ticket->bet_per_draw) }}
                            </span>
                          @endif
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">{{ __('authenticated.No Of Repeat Draws') }}</span>
                      </td>
                      <td>
                        @if (isset($ticket->repeat_draws))
                          <span class="width-120 text-right details-info-text">
                            {{ NumberHelper::format_integer($ticket->repeat_draws) }}
                          </span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">{{ __('authenticated.Total Bet per ticket') }}</span>
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
                        <span class="bold-text">{{ __('authenticated.Jackpot Win') }}</span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          @if (isset($ticket->jackpot_win))
                            {{ NumberHelper::format_double($ticket->jackpot_win) }}
                          @endif
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="bold-text">{{ __('authenticated.Win To Pay Out') }}</span>
                      </td>
                      <td>
                        <span class="width-120 text-right details-info-text">
                          @if (isset($ticket->win_to_pay_out))
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
                        <span>
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
                        <span>
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
                          <td width="200">
                            <span class="bold-text">{{ __('authenticated.Parent Entity') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->player_parent_name }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td width="200">
                            <span class="bold-text">{{ __('authenticated.First Name') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->player_first_name }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td width="200">
                            <span class="bold-text">{{ __('authenticated.Last Name') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->player_last_name }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td width="200">
                            <span class="bold-text">{{ __('authenticated.Mobile Phone') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $ticket->player_mobile_phone }} </span>
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
                            <span class="width-100">&nbsp;</span>
                            <span class="pull-center">
                              <a href="mailto:{{ $ticket->email }}" class="btn btn-sm btn-primary noblockui">
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
                        <tr>
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
    </section>
</div>
@endsection
