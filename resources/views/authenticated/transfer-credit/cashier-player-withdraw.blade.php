
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

    <script type="text/javascript">
        var transferAmount = 0;
        var transferAmountAllowedMax = 0;
        function inputGreaterThanAllowed(){
            $("#modalMessage").show();
        }

        function formatDoubleString(number){
            var result = parseFloat(number).toLocaleString("en-IN", {minimumFractionDigits: 2});
            return result;
        }

        function backspaceInput(){
            var amountText = $("#CREDIT_AMOUNT_HIDDEN").val();
            amountText = amountText.slice(0, -1);
            if(parseFloat(amountText) > transferAmountAllowedMax) {
                inputGreaterThanAllowed();
            }
            else {
                $("#CREDIT_AMOUNT").val(parseFloat(amountText));
                $("#CREDIT_AMOUNT_HIDDEN").val(amountText);
            }
        }
        function addInput(value){
            var amountText = $('#CREDIT_AMOUNT_HIDDEN').val();
            if(amountText == '0'){
                amountText = '';
            }
            amountText += value;
            if(parseFloat(amountText) > transferAmountAllowedMax) {
                inputGreaterThanAllowed();
            }
            else {
                $("#CREDIT_AMOUNT").val(parseFloat(amountText));
                $("#CREDIT_AMOUNT_HIDDEN").val(amountText);
            }
        }
        function addTransferAmount(amount){
            var transferAmountL = parseFloat($("#CREDIT_AMOUNT_HIDDEN").val());
            if(isNaN(transferAmountL)){
                transferAmountL = 0;
            }
            transferAmountL += amount;
            transferAmountL = Math.round(transferAmountL*100)/100;
            if(transferAmountL <= 0){
                transferAmountL = '';
            }
            if(transferAmountL > transferAmountAllowedMax) {
                inputGreaterThanAllowed();
            }
            else {
                $('#CREDIT_AMOUNT').val(parseFloat(transferAmountL));
                $("#CREDIT_AMOUNT_HIDDEN").val(transferAmountL);
            }
        }
        function setTransferAmountMax(){
            transferAmountAllowedMax = $('#PLAYER_CREDIT_STATUS_HIDDEN').val();

            $("#CREDIT_AMOUNT").val(parseFloat(transferAmountAllowedMax));
            $("#CREDIT_AMOUNT_HIDDEN").val(transferAmountAllowedMax);
        }
        function setTransferAmountMaxAndSubmit(){
            transferAmountAllowedMax = $('#PLAYER_CREDIT_STATUS_HIDDEN').val();
            $('#CREDIT_AMOUNT_HIDDEN').val(transferAmountAllowedMax);
            $('#CREDIT_AMOUNT').val(transferAmountAllowedMax);
            $("#credit_transfer_payout_form").submit();
        }

        function setTransferAmountZero(){
            transferAmount = 0;
            $('#CREDIT_AMOUNT').val('');
            $('#CREDIT_AMOUNT_HIDDEN').val('');
        }

        function closeErrorDialog(){
            $("#modalMessage").hide();
        }

        $(document).ready(function() {
            $("#modalMessage").hide();
            setTransferAmountMax();
            setTransferAmountZero();

            $("#CREDIT_AMOUNT").numeric({ negative: false });
            $("#CREDIT_AMOUNT").keyup(function(){
                var transferAmountL = parseFloat($("#CREDIT_AMOUNT").val());
                $("#CREDIT_AMOUNT_HIDDEN").val(transferAmountL);
            });

            $("#CLEAR").click(function(){
                setTransferAmountZero();
            });
            $("#backBtn").click(function(){
                history.go(-1);
            });
        });
    </script>

    <div class="content-wrapper">

        <section class="content-header">

        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            @include('layouts.shared.form_messages')

                                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'transfer-credit/cashier-player-withdraw/user_id/' . $user_id), 'method'=>'POST', 'id'=> 'credit_transfer_payout_form' ]) !!}
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <div class="col-xs-5 pull-left">
                                                    <label class="control-label" for="DIRECT_PLAYER_NAME">
                                                        {{ __("authenticated.Player Name") }}
                                                    </label>
                                                </div>
                                                <div class="col-xs-7 pull-left">
                                                    <input type="text" class="form-control margin-1 bold-text darkgray_input_text_field right-text-align"
                                                           name="DIRECT_PLAYER_NAME" id="DIRECT_PLAYER_NAME" readonly value="{{ $player_username }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('DIRECT_PLAYER_NAME'))
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('DIRECT_PLAYER_NAME') }}</strong>
                                            </span>&nbsp;
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <div class="col-xs-5 pull-left">
                                                    <label class="control-label" for="PLAYER_CREDIT_STATUS">
                                                        {{ __("authenticated.Player Credit Status") }}
                                                    </label>
                                                </div>
                                                <div class="col-xs-7 pull-left">
                                                    <input type="text" class="form-control margin-1 bold-text darkgray_input_text_field right-text-align"
                                                           name="PLAYER_CREDIT_STATUS" id="PLAYER_CREDIT_STATUS" readonly value="{{ $player_credits_formatted }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('PLAYER_CREDIT_STATUS'))
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('PLAYER_CREDIT_STATUS') }}</strong>
                                            </span>&nbsp;
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row" style="max-width: 600px;display: none">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <div class="col-xs-5 pull-left">
                                                    <label class="control-label" for="PLAYER_CURRENCY">
                                                        {{ __("authenticated.Currency") }}
                                                    </label>
                                                </div>
                                                <div class="col-xs-7 pull-left">
                                                    <input type="text" class="form-control margin-1 bold-text darkgray_input_text_field right-text-align"
                                                           name="PLAYER_CURRENCY" id="PLAYER_CURRENCY" readonly value="{{ $player_currency }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('PLAYER_CURRENCY'))
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('PLAYER_CURRENCY') }}</strong>
                                            </span>&nbsp;
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <div class="form-group required">
                                                <div class="col-xs-5 pull-left">
                                                    <label class="control-label" for="CREDIT_AMOUNT">
                                                        {{ __("authenticated.Credit Amount") }}
                                                    </label>
                                                </div>
                                                <div class="col-xs-7 pull-left">
                                                    <input type="text" class="form-control margin-1 bold-text darkgray_input_text_field right-text-align"
                                                           name="CREDIT_AMOUNT" id="CREDIT_AMOUNT" autofocus />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('CREDIT_AMOUNT'))
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('CREDIT_AMOUNT') }}</strong>
                                            </span>&nbsp;
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-6">
                                            @if ($player_credits != 0)
                                            <input class="btn btn-danger btn-lg btn-block" type="submit" name="SUBMIT" id="SUBMIT" value="{{ __("authenticated.Payout") }}" />
                                            @endif
                                        </div>
                                        <div class="col-xs-6">
                                            @if ($player_credits != 0)
                                            <a href="#" class="btn btn-danger btn-lg btn-block noblockui" name="CLEAR" id="CLEAR">
                                                {{ __("authenticated.Clear") }}
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-6">
                                            @if ($player_credits != 0)
                                            <input class="btn btn-danger btn-lg btn-block" type="submit"
                                                name="PAYOUT_ALL" id="PAYOUT_ALL" value="{{ __("authenticated.Payout All") }}"
                                                onclick="setTransferAmountMaxAndSubmit()" />
                                            @endif
                                        </div>
                                        <div class="col-xs-6">
                                            <button type="button" id="backBtn" class="btn btn-warning btn-lg btn-block noblockui" title="{{ __('authenticated.Back') }}">
                                                {{ __("authenticated.Back") }}
                                            </button>
                                            <input style="display: none" type="submit" class="btn btn-warning btn-lg btn-block noblockui" name="PREVIOUS_PAGE" id="PREVIOUS_PAGE" value="{{ __("authenticated.Previous Page") }}" />
                                        </div>
                                    </div>
                                    <div class="row invincible">
                                        <div class="col-xs-12">
                                            <input type="hidden" name="CASHIER_ID" id="CASHIER_ID" value="{{ $logged_user_id }}"/>
                                            <input type="hidden" name="CASHIER_CREDIT_STATUS_HIDDEN" id="CASHIER_CREDIT_STATUS_HIDDEN" value="{{ $user_credits }}" />
                                            <input type="hidden" name="PLAYER_CREDIT_STATUS_HIDDEN" id="PLAYER_CREDIT_STATUS_HIDDEN" value="{{ $player_credits }}" />
                                            <input type="hidden" name="CREDIT_AMOUNT_HIDDEN" id="CREDIT_AMOUNT_HIDDEN" />
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12" style="max-width: 600px;">
                    <div class="box">
                        <div class="box-body">
                            <div class="row no-margin">
                                <div class="col-xs-6 no-margin">
                                    <a onclick="addTransferAmount(5)" class="btn btn-danger btn-block noblockui vertical-align-lg-button large-text" href="javascript:void(0)">+5</a>
                                </div>
                                <div class="col-xs-6 no-margin">
                                    <a onclick="addTransferAmount(10)" class="btn btn-danger btn-block noblockui vertical-align-lg-button large-text" href="javascript:void(0)">+10</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="row margin-1">
                                <div class="col-xs-6 margin-1">
                                    <a onclick="addTransferAmount(50)" class="btn btn-danger btn-block noblockui vertical-align-lg-button large-text" href="javascript:void(0)">+50</a>
                                </div>
                                <div class="col-xs-6 margin-1">
                                    <a onclick="addTransferAmount(100)" class="btn btn-danger btn-block noblockui vertical-align-lg-button large-text" href="javascript:void(0)">+100</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="row margin-1">
                                <div class="col-xs-6 margin-1">
                                    <a onclick="addTransferAmount(500)" class="btn btn-danger btn-block noblockui vertical-align-lg-button large-text" href="javascript:void(0)">+500</a>
                                </div>
                                <div class="col-xs-6 margin-1">
                                    <a onclick="addTransferAmount(1000)" class="btn btn-danger btn-block noblockui vertical-align-lg-button large-text" href="javascript:void(0)">+1.000</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="modalMessage" class="modal modal-danger modalMessage" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __("authenticated.Amount is too large") }}
                    </h4>
                </div>
                <div class="modal-body">
                    {{ __("authenticated.Value cannot be bigger than affiliate balance.") }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeErrorDialog()">{{ __("authenticated.Close") }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
