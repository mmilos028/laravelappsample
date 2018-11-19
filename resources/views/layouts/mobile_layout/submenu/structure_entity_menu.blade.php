
	<li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/search-entity") }}">
        {{ __('authenticated.Search Entity') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/update-entity/user_id/{$user_id}") }}">
        {{ __("authenticated.Update Entity") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/change-password/user_id/{$user_id}") }}">
        {{ __("authenticated.Change Password") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>