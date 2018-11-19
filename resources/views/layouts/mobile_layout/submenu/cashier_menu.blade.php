
	<li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/list-cashiers") }}">
        {{ __('authenticated.List Cashiers') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/update-cashier/user_id/{$user_id}") }}">
        {{ __("authenticated.Update Cashier") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/change-password/user_id/{$user_id}") }}">
        {{ __("authenticated.Change Password") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/change-pin-code/user_id/{$user_id}") }}">
        {{ __("authenticated.Change Pin Code") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle noblockui" data-toggle="dropdown" aria-expanded="true">
        {{ __("authenticated.Reports") }} <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li>
			<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/report/list-login-history/user_id/{$user_id}") }}">
				{{ __("authenticated.List Login History") }}
			</a>
		</li>
      </ul>
    </li>