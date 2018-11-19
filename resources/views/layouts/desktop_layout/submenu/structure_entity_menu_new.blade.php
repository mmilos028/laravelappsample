<style>
    .btn.btn-app{
        height: 50px !important;
    }
</style>
<div class="row">
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/search-entity") }}">
        <i class="fa fa-search"></i>
        {{ __('authenticated.Search Entity') }}
        <span class="sr-only">(current)</span>
    </a>
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/details/user_id/{$user_id}") }}">
        <i class="fa fa-info"></i>
        {{ __('authenticated.Account Details') }}
        <span class="sr-only">(current)</span>
    </a>
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/update-entity/user_id/{$user_id}") }}">
        <i class="fa fa-edit"></i>
        {{ __('authenticated.Update Entity') }}
        <span class="sr-only">(current)</span>
    </a>
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/change-password/user_id/{$user_id}") }}">
        <i class="fa fa-lock"></i>
        {{ __('authenticated.Change Password') }}
        <span class="sr-only">(current)</span>
    </a>
    @if($user_type != config("constants.TERMINAL_SALES") && $user_type != config("constants.ROLE_CASHIER_TERMINAL"))
        <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}") }}">
            <i class="fa fa-wrench"></i>
            {{ __('authenticated.Parameters') }}
            <span class="sr-only">(current)</span>
        </a>
    @endif
</div>