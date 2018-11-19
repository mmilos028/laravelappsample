
    @if($ticket_status == -1)
        <span class="yellow-caption-text" style="color: gray;">
        {{ __("authenticated.DEACTIVATED") }}
        </span>
    @elseif($ticket_status == 0)
        {{ __("authenticated.RESERVED") }}
    @elseif($ticket_status == 1)
        {{ __("authenticated.PAID-IN") }}
    @elseif($ticket_status == 2)
        <span class="green-caption-text" style="color: green">
        {{ __("authenticated.WINNING") }}
        </span>
    @elseif($ticket_status == 3)
        <span class="yellow-caption-text" style="color: #97A230;">
        {{ __("authenticated.WINNING NOT PAID-OUT") }}
        </span>
    @elseif($ticket_status == 4)
        <span class="yellow-caption-text" style="color: green;">
        {{ __("authenticated.PAID-OUT") }}
        </span>
    @elseif($ticket_status == 5)
        <span class="red-caption-text">
        {{ __("authenticated.LOSING") }}
        </span>
    @endif
