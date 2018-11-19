
@extends( 'layouts.window_details_layout' )

@section('content')
<style>
  div.wrapperr {
    overflow: auto !important;
    width: 100% !important;
  }
  .helpTable tbody tr:nth-child(even) {background: #FFF}
  .helpTable tbody tr:nth-child(odd) {background: #CCC}

  #payTable tbody tr td:nth-child(2) {border-right: 1px solid black;}
  #payTable tbody tr td:nth-child(4) {border-right: 1px solid black;}
  /*#payTable thead tr td:nth-child(even) {border-right: 1px solid black;}*/
</style>
    <section class="content">
      @foreach($draw_result as $draw)
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-ticket"></i>
                  {{ __('authenticated.Draw Details') }}
                  <button id="showContextualMessage" class="btn btn-primary animated shake"><strong class="fa fa-question-circle"></strong></button>
                </h4>
                <span class="pull-right">
                  <button class="btn btn-sm btn-primary" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/draw-details/draw_id/{$draw_id}") }}', 'draw_details_window',
                          'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=800,height=600,top=100,left=100,resizable=yes').focus()">
                      <i class="fa fa-refresh"></i>
                      {{ __("authenticated.Refresh") }}
                  </button>
                  <button class="btn btn-sm btn-danger" onClick="window.close()">
                      <i class="fa fa-close"></i>
                      {{ __("authenticated.Close") }}
                  </button>
                </span>
              </div>
              <div class="widget-content">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="wrapperr">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Draw ID') }}: </span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $draw["draw_id"] }} </span>
                            <span> {{ $draw->draw_id }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Serial Number') }}: </span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $draw["order_num"]}} </span>
                            <span> {{ $draw->order_num }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Draw Model') }}:</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $draw["draw_model"] }} </span>
                            <span> {{ $draw->draw_model }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Created') }}: </span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $draw["date_time_formated"] }} </span>
                            <span> {{ $draw->date_time_formated }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Status') }}: </span>
                          </td>
                          <td>
                            <span class="bold-text">
                            <span>
                            @include('layouts.shared.draw_status',
                                ["draw_status" => $draw["draw_status"]]
                            )
                            </span>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Super Draw') }}:</span>
                          </td>
                          <td>
                             @php
                                echo $draw["super_draw_yes_no"];
                             @endphp
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Chosen Numbers') }}: </span>
                          </td>
                          <td>
                            <span class="bold-text">
                              @php
                                $i = 0;
                                $array_count = count($draw["chosen_numbers_array"]);
                                foreach($draw["chosen_numbers_array"] as $element){
                                  if($i == ($array_count-1)){
                                    echo $element;
                                  }else{
                                    echo $element.",";
                                  }
                                    $i++;
                                }
                                $i = 0;
                              @endphp
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Chosen Numbers (with colors)') }}: </span>
                          </td>
                          <td>
                            <span class="bold-text">
                              @php
                                $i = 0;
                                $array_count = count($draw["chosen_numbers_colorful_array"]);
                                foreach($draw["chosen_numbers_colorful_array"] as $element){
                                  if($i == ($array_count-1)){
                                    echo $element;
                                  }else{
                                    echo $element.",";
                                  }
                                    $i++;
                                }
                                $i = 0;
                              @endphp
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Star Double Up') }}: </span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $draw["stars"] }} </span>
                            <span> {{ $draw->stars }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Currency') }}:</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $draw["currency"] }} </span>
                            <span> {{ $draw->currency }} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Sum of First 5') }} ({{NUMBER_SUM_LIMIT}}):</span>
                          </td>
                          <td>
                            <span class="bold-text">
                              {{$draw["first_five_numbers_sum"]}} ({{$draw["first_five_numbers_sum_flag"]}})
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.First Ball') }} ({{NUMBER_LIMIT}}):</span>
                          </td>
                          <td>
                            @if(($draw['first_ball']) != "")
                            <span class="bold-text">
                              {{ $draw["first_ball"] }}
                              (<span style="color: {{ $draw["first_ball_color"] }};">
                                {{ $draw["first_ball_color_name"] }}
                              </span>,
                              {{$draw["first_ball_flag"]}}, {{$draw["first_ball_odd_even_flag"]}}
                              )
                            </span>
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Most (Even/Odd)') }}:</span>
                          </td>
                          <td>
                            <span class="bold-text">{{ $draw["more_even_odd"] }}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Most of First 5 (Even/Odd)') }}:</span>
                          </td>
                          <td>
                            <span class="bold-text">
                              {{$draw["more_even_odd_first_five"]}}
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Frequent Colors') }}:</span>
                          </td>
                          <td>
                            <span class="bold-text">
                              @foreach ($draw["colors_array"] as $r)

                                <span style="color: {{$r["color"]}};">{{$r["color_name"]}} x {{$r["number"]}} ({{trans("authenticated.Last Ball")." ".$r["last_ball"]}})</span>

                              @endforeach

                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Last Ball') }} ({{NUMBER_LIMIT}}):</span>
                          </td>
                          <td>
                            @if(($draw['last_ball']) != "")
                            <span class="bold-text">
                              {{ $draw["last_ball"] }}
                              (<span style="color: {{ $draw["last_ball_color"] }};">{{ $draw["last_ball_color_name"] }}</span>, {{$draw["last_ball_flag"]}},
                              {{$draw["last_ball_odd_even_flag"]}})
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
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="fa fa-ticket"></i>
                  {{ __('authenticated.Draw JP Winning Codes') }}
                </h4>
              </div>
              <div class="widget-content">
                <div class="wrapperr">
                  <table class="table table-striped table-bordered table-highlight-head">
                    <thead>
                    <tr>
                      <th>{{trans("authenticated.Username")}}</th>
                      <th>{{trans("authenticated.Global Code")}}</th>
                      <th>{{trans("authenticated.Local Code")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jp_codes_result as $code)
                      <tr>
                        <td>
                          <span> {{ $code->aff_name }} </span>
                        </td>
                        <td>
                          <span> {{ $code->jp_global_winning_code }} </span>
                        </td>
                        <td>
                          <span> {{ $code->jp_local_winning_code }} </span>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      @endforeach
    </section>
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
    })
  </script>
@endsection
