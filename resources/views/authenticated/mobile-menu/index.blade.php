
<?php
$mobile_menu_button_css = "col-md-2";
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<style>
    .super-large-text{
        padding-top: 15px;
        font-size: 30px;
    }
    div.info-box a{
        color: white;
    }

    #menuContainer > div {
        margin-top: 10px !important;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="row" id="menuContainer">
            @if(in_array(session("auth.subject_type_id"),
            array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID"))))
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/administration")}}">
                        {{ __("authenticated.Administration") }}
                    </a>
                </div>
            @endif

            @if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID"))))
                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/structure-entity")}}">
                            {{ __("authenticated.Structure Entity") }}
                        </a>
                    </div>
            @endif

            @if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID"))))
                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/user")}}">
                            {{ __("authenticated.Users") }}
                        </a>
                    </div>
            @endif

                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/credit-transfers")}}">
                        {{ __("authenticated.Credit Transfers") }}
                    </a>
                </div>

            @if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID"))))
                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets")}}">
                            {{ __("authenticated.Tickets") }}
                        </a>
                    </div>
            @endif

                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/report")}}">
                        {{ __("authenticated.Reports") }}
                    </a>
                </div>

                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/my-account")}}">
                        {{ __("authenticated.My Account") }}
                    </a>
                </div>

        </div>
        <!-- BELLOW ARE SUBMENUES --->

    </section>
</div>
@endsection
