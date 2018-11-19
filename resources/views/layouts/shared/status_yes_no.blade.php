
    @if ($status == 1)
        <span class="label label-success">{{ __("authenticated.Yes") }}</span>
    @else
        <span class="label label-danger">{{ __("authenticated.No") }}</span>
    @endif