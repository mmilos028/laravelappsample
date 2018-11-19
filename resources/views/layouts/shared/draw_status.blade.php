
    @if($draw_status == -1)
        {{ __("authenticated.SCHEDULED") }}
    @elseif($draw_status == 0)
        {{ __("authenticated.IN PROGRESS") }}
    @elseif($draw_status == 1)
        {{ __("authenticated.COMPLETED") }}
    @endif
