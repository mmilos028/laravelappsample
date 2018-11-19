
<?php
$mobile_menu_button_css = "col-xs-12";
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

    .btn{
        height: 50px !important;
        white-space: normal !important;
        vertical-align: middle !important;
    }

    #menuContainer > div {
        margin-top: 10px !important;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">

    </section>
    <section class="content">
        <div class="row" id="menuContainer">
            @if(session("auth.subject_type_id") != config("constants.COLLECTOR_LOCATION_TYPE_ID"))
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "newUser2")}}">
                        {{ __("authenticated.New User") }}
                    </a>
                </div>
            @endif
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/search-users")}}">
                        {{ __("authenticated.Search Users") }}
                    </a>
                </div>
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listUsersTree")}}">
                        {{ __("authenticated.Structure View") }}
                    </a>
                </div>
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/list-administrators")}}">
                        {{ __("authenticated.List Administrators") }}
                    </a>
                </div>
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/list-terminals")}}">
                        {{ __("authenticated.List Terminals") }}
                    </a>
                </div>
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "deactivatedTerminals")}}">
                        {{ __("authenticated.List Deactivated Terminals") }}
                    </a>
                </div>
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/list-players")}}">
                        {{ __("authenticated.List Players") }}
                    </a>
                </div>
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-danger" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/index")}}">
                        {{ __("authenticated.Main Menu") }}
                    </a>
                </div>
        </div>
    </section>
</div>
@endsection
