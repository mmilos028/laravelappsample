<div class="navbar-custom-menu pull-left">
  <ul class="nav navbar-nav">
	<li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/list-administrators") }}">
        {{ __('authenticated.List Administrators') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/details/user_id/{$user_id}") }}">
        {{ __("authenticated.Account Details") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/update-administrator/user_id/{$user_id}") }}">
        {{ __("authenticated.Update Administrator") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/change-password/user_id/{$user_id}") }}">
        {{ __("authenticated.Change Password") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle noblockui" data-toggle="dropdown" aria-expanded="true">
        {{ __("authenticated.Reports") }} <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li>
			<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/report/list-login-history/user_id/{$user_id}") }}">
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
          <a id="dailyCashierReport">
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
        $("#dailyCashierReport").on("click", function(){
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