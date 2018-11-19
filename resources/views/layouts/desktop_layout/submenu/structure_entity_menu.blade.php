<div class="collapse navbar-collapse">
  <ul class="nav navbar-nav">
	<li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/search-entity") }}">
        {{ __('authenticated.Search Entity') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    <li>
      <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/details/user_id/{$user_id}") }}">
        {{ __("authenticated.Account Details") }}
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
    @if($user_type != config("constants.TERMINAL_SALES") && $user_type != config("constants.ROLE_CASHIER_TERMINAL"))
      <li>
        <a class="noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}") }}">
          {{ __("authenticated.Parameters") }}
          <span class="sr-only">(current)</span>
        </a>
      </li>
    @endif
  </ul>
</div>