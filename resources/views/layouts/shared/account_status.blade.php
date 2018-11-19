
    @if ($account_status == 1)
        <span class="label label-success">{{ __("authenticated.Active") }}</span>
    @else
        <span class="label label-danger">{{ __("authenticated.Inactive") }}</span>
    @endif
