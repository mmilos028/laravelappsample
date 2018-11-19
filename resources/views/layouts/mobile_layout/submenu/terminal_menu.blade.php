    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/list-terminals") }}">
        {{ __('authenticated.List Terminals') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/details/user_id/{$user_id}") }}">
        {{ __('authenticated.Account Details') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/update-terminal/user_id/{$user_id}") }}">
        {{ __("authenticated.Update Terminal") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/change-password/user_id/{$user_id}") }}">
        {{ __("authenticated.Change Password") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/code-list/user_id/{$user_id}") }}">
        {{ __("authenticated.Code List") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle noblockui" data-toggle="dropdown" aria-expanded="true">
        {{ __("authenticated.Reports") }} <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li>
			<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/report/list-money-transactions/user_id/{$user_id}") }}" class="noblockui">
				{{ __("authenticated.List Money Transactions") }}
			</a>
		</li>
		<li>
			<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/report/list-player-tickets/user_id/{$user_id}") }}" class="noblockui">
				{{ __("authenticated.List Player Tickets") }}
			</a>
		</li>
        <li>
			<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/report/list-login-history/user_id/{$user_id}") }}">
				{{ __("authenticated.List Login History") }}
			</a>
		</li>
      </ul>
    </li>
