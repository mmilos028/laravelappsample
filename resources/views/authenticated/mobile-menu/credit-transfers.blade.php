
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
            <div class="col-md-6 col-xs-6">
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/deposit-list")}}">
                    {{ __("authenticated.Deposit") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/withdraw-list")}}">
                    {{ __("authenticated.Withdraw") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/deposit-user-structure-view")}}">
                    {{ __("authenticated.Deposit - Structure View") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/withdraw-user-structure-view")}}">
                    {{ __("authenticated.Withdraw - Structure View") }}
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
