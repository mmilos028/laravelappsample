@if ($show_cashier_menu)
    @include('layouts.desktop_layout.submenu.cashier_menu_new')
@endif

@if ($show_administrator_menu)
    @include('layouts.desktop_layout.submenu.administrator_menu_new')
@endif

@if ($show_structure_entity_menu)
    @include('layouts.desktop_layout.submenu.structure_entity_menu_new')
@endif

@if ($show_user_menu)
    @include('layouts.desktop_layout.submenu.user_menu_new')
@endif

@if ($show_player_menu)
    @include('layouts.desktop_layout.submenu.player_menu_new')
@endif

@if ($show_terminal_menu)
    @include('layouts.desktop_layout.submenu.terminal_menu_new')
@endif

@if ($show_ticket_details_menu)
    @include('layouts.desktop_layout.submenu.ticket_details_menu_new')
@endif

@if ($show_draw_model_setup_menu)
    @include('layouts.desktop_layout.submenu.administration.draw_model_setup_menu_new')
@endif