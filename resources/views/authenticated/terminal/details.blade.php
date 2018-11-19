
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<style>
  div.wrapperr {
    overflow: auto !important;
    width: 100% !important;
  }
  #detailsTable{
    table-layout:fixed !important;
    border-collapse: collapse !important;
  }
  #detailsTable tbody{
    overflow-y: auto !important;
    height:80vh !important;
    display:block !important;
    width: 450px !important;
  }
  #detailsTable td {
    width:150px !important;
    word-break: break-all !important;
  }
</style>
<div class="content-wrapper">
    <section class="content-header">
      @include('layouts.desktop_layout.header_navigation_second')
        <h1>
            <i class="fa fa-user"></i>
            {{ __("authenticated.Account Details") }}
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i>{{ __("authenticated.Users") }}</li>
            <li>
            <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/terminal/list-terminals') }}" title="{{ __('authenticated.List Terminals') }}">
                {{ __("authenticated.List Terminals") }}
            </a>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/details/user_id/{$user_id}") }}" title="{{ __('authenticated.Account Details') }}">
                    {{ __("authenticated.Account Details") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        @include('layouts.shared.form_messages')

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-5">
              <div class="widget box" style="margin-top:20px;">
                <div class="widget-header">
                  <h4><i class="fa fa-user"></i> {{ __('authenticated.Account Details') }}</h4>
                  <span class="pull-right">
                    @if($subject_type == config("constants.SELF_SERVICE_TERMINAL"))

                    @else
                      <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/change-password/user_id/{$user_id}") }}">
                      <button class="btn btn-sm btn-primary">
                        <i class="fa fa-key"></i>
                        {{ __("authenticated.Change Password") }}
                      </button>
                    </a>
                    @endif
                  </span>
                </div>
                <div class="widget-content wrapperr">
                  <div class="pull-left">
                    @if($subject_state == 1)
                      <label id="connectedStatus" class="label label-success">
                        <span class="fa fa-link"></span>
                        {{trans("authenticated.Connected")}}
                      </label>
                    @else
                      <label id="disconnectedStatus" class="label label-danger">
                        <span class="fa fa-unlink"></span>
                        {{trans("authenticated.Disconnected")}}
                      </label>
                    @endif
                  </div>
                  @php
                    //dd($user);
                  @endphp
                  <table id="detailsTable" class="table table-striped table-bordered table-highlight-head">
                    <tbody>
                      <tr>
                        <td>
                          @if($subject_type == config("constants.SELF_SERVICE_TERMINAL") || $subject_type == config("constants.TERMINAL_TV"))
                            <span class="">{{ __('authenticated.MAC Address') }}</span>
                          @else
                            <span class="">{{ __('authenticated.Username') }}</span>
                          @endif
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['username'] }}</span>
                        </td>
                        <td>
                          @if($subject_type == config("constants.SELF_SERVICE_TERMINAL") || $subject_type == config("constants.TERMINAL_TV"))
                            <span class="pull-right">
                              @if($subject_state == 1)
                                <button style="display: none;" id="connectTerminal" class="btn btn-sm btn-primary"><span class="fa fa-link">&nbsp;</span>{{trans("authenticated.Connect")}}</button>
                                <button id="disconnectTerminal" class="btn btn-sm btn-danger"><span class="fa fa-unlink">&nbsp;</span>{{trans("authenticated.Disconnect")}}</button>
                              @else
                                <button id="connectTerminal" class="btn btn-sm btn-primary"><span class="fa fa-link">&nbsp;</span>{{trans("authenticated.Connect")}}</button>
                                <button style="display: none;" id="disconnectTerminal" class="btn btn-sm btn-danger"><span class="fa fa-unlink">&nbsp;</span>{{trans("authenticated.Disconnect")}}</button>
                              @endif
                          </span>
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Role') }}</span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['subject_dtype_bo_name'] }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Parent') }}</span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['parent_username'] }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Mobile Phone') }}</span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['mobile_phone'] }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">
                            {{ __('authenticated.Email') }}
                          </span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['email'] }}</span>
                        </td>
                        <td>
                          @if(strlen($user['email']) != 0)
                            <span class="pull-right">
                            <a href="mailto:{{ $user['email'] }}" class="btn btn-sm btn-primary noblockui">
                              <i class="fa fa-envelope"></i>
                              {{ __('authenticated.Email') }}
                            </a>
                          </span>
                          @endif
                        </td>
                      </tr>
                      <tr>
                        @if($subject_type == config("constants.SELF_SERVICE_TERMINAL"))
                          <td>
                            <span class="">{{ __('authenticated.Terminal Name') }}</span>
                          </td>
                        @else
                          <td>
                            <span class="">{{ __('authenticated.First Name') }}</span>
                          </td>
                        @endif
                        <td>
                          <span class="bold-text"> {{ $user['first_name'] }}</span>
                        </td>
                      </tr>
                      @if($subject_type == config("constants.SELF_SERVICE_TERMINAL"))

                      @else
                        <tr>
                          <td>
                            <span class="">{{ __('authenticated.Last Name') }}</span>
                          </td>
                          <td>
                            <span class="bold-text"> {{ $user['last_name'] }}</span>
                          </td>
                        </tr>
                      @endif
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Address') }}</span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['address'] }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Address 2') }}</span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['commercial_address'] }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Post Code') }}</span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['post_code'] }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.City') }}</span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['city'] }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Country') }}</span>
                        </td>
                        <td>
                          <span class="bold-text"> {{ $user['country_name'] }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Language') }}</span>
                        </td>
                        <td>
                          <span class="bold-text">
                             @include('layouts.shared.language',
                              ["language" => $user['language']]
                              )
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Account Status') }}</span>
                        </td>
                        <td>
                            @if ($user['active'] == 1)
                                <span class="label label-success">{{ __("authenticated.Active") }}</span>
                            @else
                                <span class="label label-danger">{{ __("authenticated.Inactive") }}</span>
                            @endif
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Currency') }}</span>
                        </td>
                        <td>
                            <span class="bold-text">
                              {{ $user['currency'] }}
                            </span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Account Balance') }}</span>
                        </td>
                        <td>
                          <span class="width-120 text-left bold-text">
                            {{ NumberHelper::format_double($user['credits']) }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Account Created') }}</span>
                        </td>
                        <td>
                          <span class="bold-text">
                            {{ $user['registration_date'] }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Account Created By') }}</span>
                        </td>
                        <td>
                          <span class="bold-text">
                            {{ $user['created_by'] }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="">{{ __('authenticated.Last Activity') }}</span>
                        </td>
                        <td>
                          <span class="bold-text">
                            {{ $user['last_activity'] }}
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-5">
              <div class="row">
                @foreach($terminal_keys_codes as $tkc)
                <div class="col-md-12">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-wrench"></i> {{ __('authenticated.Details') }}</h4>
                    </div>
                    <div class="widget-content">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Service Code') }}</span>
                            </td>
                            <td>
                                <span class="bold-text"> {{ $tkc->service_code }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">
                                {{ __('authenticated.Valid Time') }}:
                                </span>
                            </td>
                            <td>
                              <span class="bold-text">
                                {{ $tkc->valid_until_formated }}
                                </span>
                            </td>
                            <td>
                              @if( strtotime($tkc->valid_until_formated) < strtotime('now'))
                                <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/create-new-code/user_id/{$user_id}") }}">
                                  {{ __('authenticated.Create New Code') }}
                                </a>
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Is Registered') }}</span>
                            </td>
                            <td>
                              @include('layouts.shared.status_yes_no',
                              ["status" => $tkc->is_registered]
                              )
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">{{ __('authenticated.Status') }}</span>
                            </td>
                            <td>
                              @include('layouts.shared.subject_state',
                              ["status" =>  $tkc->subject_state ]
                              )
                            </td>
                            <td>
                              @if($tkc->is_registered == 1)
                                <button id="deactivateTerminal" class="btn btn-danger">{{trans("authenticated.Deactivate")}}</button>
                              @else

                              @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
    </section>
</div>
<div class="modal fade" id="deactivateTerminalModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans("authenticated.Confirmation")}}</h4>
      </div>
      <div class="modal-body">
        <p id="deactivateTerminalModalMessage">{{trans("authenticated.You are going to deactivate terminal")}} <label class="label label-danger">{{$user['username']}}</label>.<br><br>{{trans("authenticated.Are you sure ?")}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{trans("authenticated.Cancel")}}</button>
        <button id="deactivateTerminalModalBtn" type="button" class="btn btn-danger pull-right" data-dismiss="modal">{{trans("authenticated.Deactivate")}}</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
<div class="modal fade" id="disconnectTerminalModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans("authenticated.Confirmation")}}</h4>
      </div>
      <div class="modal-body">
        <p id="disconnectTerminalModalMessage">{{trans("authenticated.You are going to deactivate terminal")}} <label class="label label-danger">{{$user['username']}}</label>.<br><br>{{trans("authenticated.Are you sure ?")}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{trans("authenticated.Cancel")}}</button>
        <button id="disconnectTerminalModalBtn" type="button" class="btn btn-danger pull-right" data-dismiss="modal"><span class="fa fa-unlink">&nbsp;</span>{{trans("authenticated.Disconnect")}}</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
<div class="modal fade" id="connectTerminalModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans("authenticated.Confirmation")}}</h4>
      </div>
      <div class="modal-body">
        <div id="alertFailConnectTerminal" class="alert alert-danger" style="display:none"></div>
        <div>
          <strong>{{trans("authenticated.You are going to connect terminal")}} <label class="label label-primary">{{$user['username']}}</label>.</strong>
        </div>
        <br>
        <form id="connectTerminalForm" class="form-horizontal">
          <div class="form-group">
            <label for="name" class="col-md-3 control-label">{{__ ("authenticated.Parent")}}:</label>
            <div class="col-md-4">
              <input disabled class="form-control" placeholder="{{__ ("authenticated.Parent")}}" value="{{$user["parent_username"]}}" name="parent_model" type="text" id="parent_model">
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-md-3 control-label">{{__ ("authenticated.Role")}}:</label>
            <div class="col-md-4">
              <input disabled class="form-control" placeholder="{{__ ("authenticated.Role")}}" value="{{$user["subject_dtype_bo_name"]}}" name="role_modal" type="text" id="role_modal">
            </div>
          </div>
          <div class="form-group required">
            <label for="name" class="col-md-3 control-label">{{__ ("authenticated.Mac Address")}}:</label>
            <div class="col-md-4">
              <input class="form-control" placeholder="{{__ ("authenticated.Mac Address")}}" name="mac_address" type="text" id="mac_address">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{trans("authenticated.Cancel")}}</button>
        <button id="connectTerminalModalBtn" type="button" class="btn btn-primary pull-right"><span class="fa fa-link">&nbsp;</span>{{trans("authenticated.Connect")}}</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  <script>
    $(document).ready(function(){
        $("#deactivateTerminal").on("click", function(){
            $("#deactivateTerminalModal").modal({
                //backdrop:'static',
                keyboard:false,
                show:true
            });
        });
        $("#disconnectTerminal").on("click", function(){
            $("#disconnectTerminalModal").modal({
                //backdrop:'static',
                keyboard:false,
                show:true
            });
        });
        $("#connectTerminal").on("click", function(){
            $("#connectTerminalModal").modal({
                //backdrop:'static',
                keyboard:false,
                show:true
            });
        });
        $("#connectTerminalModal").on("hidden.bs.modal", function(){
            $("#alertFailConnectTerminal").hide();
        });

        $("#mac_address").on("keypress", function(e){
            var key = e.which || e.keyCode;

            if (key === 13) {
                connectTerminal();
            }
        });

        function connectTerminal(){
            var user_id = "{{$user_id}}";
            var mac_address = $("#mac_address").val();

            $.ajax({
                method: "GET",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "connectTerminalAjax") }}",
                dataType: "json",
                data: {
                    subject_id: user_id,
                    mac_address: mac_address
                },
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "{{OK}}"){
                        location.reload();
                    }else{
                        var message = data.message;

                        $("#alertFailConnectTerminal").empty();

                        jQuery('#alertFailConnectTerminal').append('<p>'+message+'</p>');
                        $("html, body").animate({ scrollTop: 0 }, "fast");

                        $("#alertFailConnectTerminal").show();
                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        }

        $("#connectTerminalModalBtn").on("click", function(){
            connectTerminal();
        });
        $("#disconnectTerminalModalBtn").on("click", function(){
            var user_id = "{{$user_id}}";
            var mac_address = "{{$user['username']}}";

            $.ajax({
                method: "GET",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "deactivateTerminalAjax") }}",
                dataType: "json",
                data: {
                    subject_id: user_id,
                    mac_address: mac_address
                },
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "{{OK}}"){
                        location.reload();
                    }else{
                        location.reload();
                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        });
        $("#deactivateTerminalModalBtn").on("click", function(){
            $.ajax({
                method: "GET",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "disconnectTerminalAjax") }}",
                dataType: "json",
                data: {
                    service_code: "{{$tkc->service_code}}"
                },
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "{{OK}}"){
                        location.reload();
                    }else{
                        location.reload();
                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        });
    });
  </script>
@endsection
