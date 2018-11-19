
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
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket-list")}}">
                    {{ __("authenticated.Ticket List") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "draw-list")}}">
                    {{ __("authenticated.Draw List") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a id="allTransactionsReportLink" class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "allTransactionsReport")}}">
                    {{ __("authenticated.All Transactions") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a id="profitReportLink" class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/financial-report")}}">
                    {{ __("authenticated.Profit Transactions") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a id="collectorTransactionsReportLink" class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/collector-transaction-report")}}">
                    {{ __("authenticated.Collector Transactions") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a id="profitAndCollectedReportLink" class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/transaction-report")}}">
                    {{ __("authenticated.Profit & Collected") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a id="playerLiabilityReportLink" class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/player-liability-report")}}">
                    {{ __("authenticated.Player Liability") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a id="dailyCashierReport" class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/dailyCashierReport")}}">
                    {{ __("authenticated.Daily Report Cashier View") }}
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/list-login-history")}}">
                    {{ __("authenticated.List Login History") }}
                </a>
            </div>
            @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"))))
            <div class="col-md-6 col-xs-6">
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/affiliate-monthly-summary-report")}}">
                    {{ __("authenticated.List Affiliate Monthly Summary Report") }}
                </a>
            </div>
            @endif
            <div class="col-md-6 col-xs-6">
                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/history-of-preferred-tickets")}}">
                    {{ __("authenticated.History Of Preferred Tickets") }}
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
    <script>
        $(document).ready(function() {
            $("#profitAndCollectedReportLink,#profitReportLink,#collectorTransactionsReportLink,#playerLiabilityReportLink,#allTransactionsReportLink,#dailyCashierReport").on("click", function(){
                sessionStorage.setItem("automaticSelect", "no");
            });
        });
    </script>
@endsection
