
@extends( 'layouts.window_details_layout' )

@section('content')

    <section class="content">
      @php
      $i=0;
      @endphp
      @foreach($list_report as $report)
        @php
          $i++;
        @endphp
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-ticket"></i> {{ __('authenticated.Draw Details') }}</h4>
                @if($i==1)
                <span class="pull-right">
                  <button class="btn btn-sm btn-success" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/ticket-draw-details/ticket_serial_number/{$ticket_serial_number}/draw_serial_number/{$draw_serial_number}/draw_id/{$draw_id}") }}', 'ticket_draw_details_window',
                          'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=850,height=600,top=100,left=100,resizable=yes').focus()">
                      <i class="fa fa-refresh"></i>
                      {{ __("authenticated.Refresh") }}
                  </button>
                  <button class="btn btn-sm btn-danger" onClick="window.close('ticket_draw_details_window')">
                      <i class="fa fa-close"></i>
                      {{ __("authenticated.Close") }}
                  </button>
                </span>
                @endif
              </div>
              <div class="widget-content">
                <div class="row">
                  <div class="col-xs-12">
                    <table class="table table-striped table-bordered table-highlight-head">
                      <tbody>
                        <tr>
                          <td width="300">
                            <span class="bold-text">{{ __('authenticated.Serial Number') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $report->serial_number }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Created By') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $report->created_by }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Created Date & Time') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $report->ticket_rec_tmstp }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Currency') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $report->currency }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Stars Double Up') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $report->stars }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Draw Serial Number') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $report->draw_serial_numer }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="bold-text">{{ __('authenticated.Draw Date & Time') }}</span>
                          </td>
                          <td>
                            <span class="details-info-text"> {{ $report->draw_date_time }}</span>
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
      @endforeach

      @foreach($draw_result as $draw)
          @php
          // dd($draw)
          @endphp
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="widget box" style="margin-top:20px;">
                <div class="widget-header">
                  <span class="pull-left">
                    <h4>
                    {{ __("authenticated.Draw") }}: {{ $draw->order_num }}
                      &nbsp;&nbsp;&nbsp;&nbsp;
                    {{ __("authenticated.Created") }}: {{ $draw->date_time }}
                    </h4>
                  </span>
                </div>
                <div class="widget-content">
                  <div class="row">
                    <div class="col-xs-12">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td width="300">
                              <span class="bold-text">{{ __('authenticated.Status') }} </span>
                            </td>
                            <td>
                              <span class="details-info-text">
                              @include('layouts.shared.draw_status',
                                  ["draw_status" => $draw->draw_status]
                              )
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Numbers') }} </span>
                            </td>
                            <td>
                              <span class="details-info-text"> {{ $draw->chosen_numbers }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Global Jackpot Code') }} </span>
                            </td>
                            <td>
                              @if(isset($draw->global_jackpot_code))
                                <span class="details-info-text"> {{ $draw->global_jackpot_code }} </span>
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Local Jackpot Code') }} </span>
                            </td>
                            <td>
                              @if(isset($draw->local_jackpot_code))
                              <span class="details-info-text"> {{ $draw->local_jackpot_code }} </span>
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Stars') }} </span>
                            </td>
                            <td>
                              <span class="details-info-text"> {{ $draw->stars }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Draw Model') }}</span>
                            </td>
                            <td>
                              <span class="details-info-text"> {{ $draw->draw_model }} </span>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Win To Pay Out') }}</span>
                            </td>
                            <td>
                              @if(isset($draw->win_to_pay_out))
                                <span class="width-120 text-right details-info-text">
                                  {{ NumberHelper::format_double($draw->win_to_pay_out) }}
                                </span>
                              @endif
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
        @endforeach
    </section>
@endsection
