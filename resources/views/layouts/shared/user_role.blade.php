    @if ($name == config("constants.ADMINISTRATOR_SYSTEM"))
        {{ __("authenticated.Administrator System") }}
    @elseif($name == config("constants.ADMINISTRATOR_CLIENT"))
        {{ __("authenticated.Administrator Client") }}
    @elseif($name == config("constants.ADMINISTRATOR_LOCATION"))
        {{ __("authenticated.Administrator Location") }}
    @elseif($name == config("constants.MASTER_TYPE_NAME"))
        {{ __("authenticated.Master") }}
    @elseif($name == config("constants.CLIENT_TYPE_NAME"))
        {{ __("authenticated.Client") }}
    @elseif($name == config("constants.LOCATION_TYPE_NAME"))
        {{ __("authenticated.Location") }}
    @elseif($name == config("constants.ADMINISTRATOR_TYPE_NAME"))
        {{ __("authenticated.Administrator") }}
    @elseif($name == config("constants.PLAYER_TYPE_NAME"))
        {{ __("authenticated.Player") }}
    @elseif($name == config("constants.CASHIER_TYPE_NAME"))
        {{ __("authenticated.Cashier") }}
    @elseif($name == config("constants.COLLECTOR_TYPE_NAME"))
        {{ __("authenticated.Collector") }}
    @elseif($name == config("constants.SUPPORT_TYPE_NAME"))
        {{ __("authenticated.Support") }}
    @elseif($name == config("constants.OPERATER_TYPE_NAME"))
        {{ __("authenticated.Operater") }}
    @elseif($name == config("constants.TERMINAL_TYPE_NAME"))
        {{ __("authenticated.Terminal") }}
    @elseif($name == config("constants.TERMINAL_CASHIER_TYPE_NAME"))
        {{ __("authenticated.Terminal Cashier") }}
    @elseif($name == config("constants.TERMINAL_TV"))
        {{ __("authenticated.Terminal Screen TV") }}
    @elseif($name == config("constants.TERMINAL_APP_NAME"))
        {{ __("authenticated.Terminal App") }}
    @elseif($name == config("constants.TERMINAL_APP_NAME"))
        {{ __("authenticated.Terminal App") }}
    @elseif($name == config("constants.ROLE_CASHIER_TERMINAL"))
        {{ __("authenticated.Cashier Terminal") }}
    @elseif($name == config("constants.ROLE_TERMINAL_SELF_SERVICE"))
        {{ __("authenticated.Terminal Self Service") }}
    @elseif($name == config("constants.ROLE_ADMINISTRATOR_OPERATER"))
        {{ __("authenticated.Administrator Operater") }}
    @elseif($name == config("constants.ROLE_COLLECTOR_CLIENT"))
        {{ __("authenticated.Collector Client") }}
    @elseif($name == config("constants.ROLE_SUPPORT_CLIENT"))
        {{ __("authenticated.Support Client") }}
    @elseif($name == config("constants.ROLE_COLLECTOR_LOCATION"))
        {{ __("authenticated.Collector Location") }}
    @elseif($name == config("constants.ROLE_SUPPORT_OPERATER"))
        {{ __("authenticated.Support Operater") }}
    @elseif($name == config("constants.ROLE_COLLECTOR_OPERATER"))
        {{ __("authenticated.Collector Operater") }}
    @elseif($name == config("constants.ROLE_SUPPORT_SYSTEM"))
        {{ __("authenticated.Support System") }}
    @elseif($name == config("constants.SHIFT_CASHIER"))
        {{ __("authenticated.Shift Cashier") }}
    @else
        {{ $name }}
    @endif