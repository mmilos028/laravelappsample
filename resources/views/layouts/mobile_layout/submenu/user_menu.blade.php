
	<li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/search-users") }}">
        {{ __('authenticated.Search Users') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$user_id}") }}">
        {{ __("authenticated.Account Details") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/update-user/user_id/{$user_id}") }}">
        {{ __("authenticated.Update User") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/change-password/user_id/{$user_id}") }}">
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
			<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/report/list-login-history/user_id/{$user_id}") }}">
				{{ __("authenticated.List Login History") }}
			</a>
		</li>
      </ul>
    </li>