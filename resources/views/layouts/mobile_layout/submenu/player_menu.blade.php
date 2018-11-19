	<li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/list-players") }}">
        {{ __('authenticated.List Players') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/details/user_id/{$user_id}") }}">
        {{ __('authenticated.Account Details') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/update-player/user_id/{$user_id}") }}">
        {{ __("authenticated.Update Player") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/change-password/user_id/{$user_id}") }}">
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
			<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/report/list-money-transactions/user_id/{$user_id}") }}" class="noblockui">
				{{ __("authenticated.List Money Transactions") }}
			</a>
		</li>
		<li>
			<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/report/list-player-tickets/user_id/{$user_id}") }}" class="noblockui">
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