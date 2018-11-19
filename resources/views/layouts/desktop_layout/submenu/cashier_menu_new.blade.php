<style>
    #ul{
        list-style: none !important;
        display: inline !important;
        padding-left: 0px !important;
    }
    #li{
        display: inline !important;
    }
    .btn.btn-app{
        height: 50px !important;
    }
</style>
<div class="row">
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/list-cashiers") }}">
        <i class="fa fa-search"></i>
        {{ __('authenticated.List Cashiers') }}
        <span class="sr-only">(current)</span>
    </a>
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/details/user_id/{$user_id}/{$user_type}") }}">
        <i class="fa fa-info"></i>
        {{ __('authenticated.Account Details') }}
        <span class="sr-only">(current)</span>
    </a>
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/update-cashier/user_id/{$user_id}/{$user_type}") }}">
        <i class="fa fa-edit"></i>
        {{ __('authenticated.Update Cashier') }}
        <span class="sr-only">(current)</span>
    </a>
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/change-password/user_id/{$user_id}/{$user_type}") }}">
        <i class="fa fa-lock"></i>
        {{ __('authenticated.Change Password') }}
        <span class="sr-only">(current)</span>
    </a>

    @if($user_type != config("constants.SHIFT_CASHIER"))
        <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/change-pin-code/user_id/{$user_id}/{$user_type}") }}">
            <i class="fa fa-unlock"></i>
            {{ __('authenticated.Change Pin Code') }}
            <span class="sr-only">(current)</span>
        </a>
    @endif

    <ul id="ul">
        <li class="dropdown" id="li">
            <a class="dropdown-toggle noblockui btn btn-app" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-bar-chart"></i>
                {{ __("authenticated.Reports") }} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/report/list-login-history/user_id/{$user_id}") }}">
                        {{ __("authenticated.List Login History") }}
                    </a>
                    <a id="allTransactionsReport">
                        {{ __("authenticated.All Transactions") }}
                    </a>
                    <a id="profitTransactionsReport">
                        {{ __("authenticated.Profit Transactions") }}
                    </a>
                    <a id="collectorTransactionsReport">
                        {{ __("authenticated.Collector Transactions") }}
                    </a>
                    <a id="profitAndCollectedReport">
                        {{ __("authenticated.Profit & Collected") }}
                    </a>
                    <a id="playerLiabilityReport">
                        {{ __("authenticated.Player Liability") }}
                    </a>
                    <a id="dailyCashierReportt">
                        {{ __("authenticated.Daily Report Cashier View") }}
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<script>
    $(document).ready(function(){
        $("#allTransactionsReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "{{$user_id}}");
            var startDateFromSession = "{{session('auth.report_start_date')}}";
            var endDateFromSession = "{{session('auth.report_end_date')}}";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "allTransactionsReport") }}');
        });
        $("#profitTransactionsReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "{{$user_id}}");
            var startDateFromSession = "{{session('auth.report_start_date')}}";
            var endDateFromSession = "{{session('auth.report_end_date')}}";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/financial-report") }}');
        });
        $("#collectorTransactionsReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "{{$user_id}}");
            var startDateFromSession = "{{session('auth.report_start_date')}}";
            var endDateFromSession = "{{session('auth.report_end_date')}}";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/collector-transaction-report") }}');
        });
        $("#profitAndCollectedReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "{{$user_id}}");
            var startDateFromSession = "{{session('auth.report_start_date')}}";
            var endDateFromSession = "{{session('auth.report_end_date')}}";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/transaction-report") }}');
        });
        $("#playerLiabilityReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "{{$user_id}}");
            var startDateFromSession = "{{session('auth.report_start_date')}}";
            var endDateFromSession = "{{session('auth.report_end_date')}}";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/player-liability-report") }}');
        });
        $("#dailyCashierReportt").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "{{$user_id}}");
            var startDateFromSession = "{{session('auth.report_start_date')}}";
            var endDateFromSession = "{{session('auth.report_end_date')}}";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "dailyCashierReport") }}');
        });
    });
</script>