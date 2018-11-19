<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo noblockui">
      <span class="logo-mini">{{ __("authenticated.Application Title Short") }}</span>
      <span class="logo-lg">
          <img src="{{asset('images/lucky6_logo.ico')}}" class="img-rounded" alt="Lucky Six Logo">
          {{ __("authenticated.Application Title Long") }}
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        @include('layouts.desktop_layout.header_navigation')

    {{--@if ($show_cashier_menu)
    @include('layouts.desktop_layout.submenu.cashier_menu')
    @endif--}}

    {{--@if ($show_administrator_menu)
    @include('layouts.desktop_layout.submenu.administrator_menu')
    @endif--}}

    {{--@if ($show_structure_entity_menu)
    @include('layouts.desktop_layout.submenu.structure_entity_menu')
    @endif--}}

    {{-- @if ($show_user_menu)
    @include('layouts.desktop_layout.submenu.user_menu')
    @endif --}}

    {{-- @if ($show_player_menu)
    @include('layouts.desktop_layout.submenu.player_menu')
    @endif --}}

    {{-- @if ($show_terminal_menu)
    @include('layouts.desktop_layout.submenu.terminal_menu')
    @endif --}}

    {{-- @if ($show_ticket_details_menu)
    @include('layouts.desktop_layout.submenu.ticket_details_menu')
    @endif --}}

    {{-- @if ($show_draw_model_setup_menu)
    @include('layouts.desktop_layout.submenu.administration.draw_model_setup_menu')
    @endif --}}

    </nav>
</header>
<script>
    $(document).ready(function(){
        //$("#toggleSideBar").trigger("click");
    });
</script>
