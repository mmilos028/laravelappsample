

@if($account_role_name == config('constants.ROLE_CLIENT'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_LOCATION') || $account_role_name == config('constants.TERMINAL_SALES'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_OPERATER'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_CASHIER_TERMINAL'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_SUPPORT'))
    {{ $account_username }}
@elseif($account_role_name == config('constants.ROLE_SUPPORT_SYSTEM'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR_CLIENT'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR_LOCATION'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR_OPERATER'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR_SYSTEM'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_CASHIER'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_COLLECTOR_LOCATION'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_COLLECTOR_OPERATER'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_COLLECTOR_CLIENT'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_SUPPORT_CLIENT'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_SUPPORT_OPERATER'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_TERMINAL_TV'))
<a class="underline-text bold-text"
  href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}") }}"
  title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>
@elseif($account_role_name == config('constants.ROLE_PLAYER'))
<a class="underline-text bold-text"
   href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/details/user_id/{$account_id}") }}"
   title="{{ __("authenticated.Details") }}">
    {{ $account_username }}
</a>

@else
    {{ $account_username }}
@endif
