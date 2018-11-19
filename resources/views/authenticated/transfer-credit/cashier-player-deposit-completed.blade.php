
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <span>
                <a class="btn btn-warning btn-lg pull-right" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/transfer-credit/deposit-list') }}" title="{{ __('authenticated.Back') }}">
                    {{ __("authenticated.Back") }}
                </a>
                <br /><br />
            </span>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            @include('layouts.shared.form_messages')
                                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'transfer-credit/cashier-player-deposit-completed/user_id/' . $user_id), 'method'=>'POST' ]) !!}
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
                                                           name="PLAYER_CREDIT_STATUS" id="PLAYER_CREDIT_STATUS" readonly value="{{ $player_credits_formatted }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <div class="col-xs-5 pull-left">
                                                    <label class="control-label" for="PLAYER_CURRENCY">
                                                        {{ __("authenticated.Currency") }}
                                                    </label>
                                                </div>
                                                <div class="col-xs-7 pull-left">
                                                    <input type="text" class="form-control margin-1 bold-text darkgray_input_text_field right-text-align"
                                                           name="PLAYER_CURRENCY" id="PLAYER_CURRENCY" readonly value="{{ $player_currency }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="row" style="max-width: 600px;">
                                        <div class="col-xs-12">
                                            <input class="btn btn-success btn-lg btn-block" type="submit" name="SUBMIT" id="SUBMIT" value="{{ __("authenticated.Done") }}" />
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
