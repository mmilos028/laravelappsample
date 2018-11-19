
    @if ($status == 1)
        <span class="label label-success">{{ __("authenticated.Active") }}</span>
    @elseif($status == -1)
        <span class="label label-danger">{{ __("authenticated.Banned") }}</span>
    @elseif($status == -2)
        <span class="label label-warning">{{ __("authenticated.Locked") }}</span>
    @else
        <span class="label">{{ $status  }}</span>
    @endif
