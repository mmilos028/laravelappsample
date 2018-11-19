
    @if($status == 1)
        {{ __("authenticated.Control Preferred Ticket Small") }}
    @elseif($status == 2)
        {{ __("authenticated.Control Preferred Ticket Medium") }}
    @elseif($status == -1)
        {{ __("authenticated.Control Preferred Ticket Off") }}
    @endif
