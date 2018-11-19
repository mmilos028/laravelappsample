<header class="main-header">
<nav class="navbar navbar-static-top">
	<!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle noblockui" data-target="#mobile_navbar" 
	  data-toggle="collapse" role="button" aria-controls="mobile_navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
	<div id="mobile_navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
	  <ul class="nav navbar-nav">
	  
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropdown-toggle noblockui" data-toggle="dropdown">
			<i class="fa fa-info-circle"></i> <span>{{ __("authenticated.Details") }}</span><span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li>
					<a href="javascript:void(0)" class="noblockui">
						<span class="width-120">{{ __("authenticated.Username") }}:</span>
						<span class="width-120">{{ Session::get('auth.username')}}</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="noblockui">
						<span class="width-120">{{ __("authenticated.Session ID") }}:</span>
						<span class="width-120">{{ Session::get('auth.backoffice_session_id') }}</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="noblockui">
						<span class="width-120">{{ __("authenticated.Session Start") }}:</span>
						<span class="width-120">{{ Session::get('auth.session_start') }}</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="noblockui">
						<span class="width-120">{{ __("authenticated.Duration") }}: </span>
						<span class="width-120">{{ Session::get('auth.duration_interval') }}</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="noblockui">
						<span class="width-120">{{ __("authenticated.Last Login") }}:</span>
						<span class="width-120">{{ Session::get('auth.last_login_date_time') }}</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="noblockui">
						<span class="width-120">{{ __("authenticated.Last Login") }}:</span>
						<span class="width-120">{{ Session::get('auth.last_login_ip_address_country') }}</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="noblockui">
						<span class="width-120">{{ __("authenticated.Selected Start Date") }}:</span>
						<span class="width-120">{{ Session::get('auth.report_start_date') }}</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="noblockui">
						<span class="width-120">{{ __("authenticated.Selected End Date") }}:</span>
						<span class="width-120">{{ Session::get('auth.report_end_date') }}</span>
					</a>
				</li>
			</ul>
		</li>
					
		@if ($show_terminal_menu)
		@include('layouts.mobile_layout.submenu.terminal_menu')
		@endif
		@if ($show_player_menu)
		@include('layouts.mobile_layout.submenu.player_menu')
		@endif
		@if ($show_ticket_details_menu)
		@include('layouts.mobile_layout.submenu.ticket_details_menu')
		@endif
				
	  </ul>
	  
    </div>  
    <div class="container">
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
              <li>
				  <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/index")}}">
					  <i class="fa fa-caret-square-o-down"></i>
					  <span>{{ __("authenticated.Main Menu") }}</span>
				  </a>
			  </li>
              <li>
				  <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/auth/logout")}}">
					  <i class="fa fa-sign-out"></i>
					  <span>{{ __("authenticated.Logout") }}</span>
				  </a>
			  </li>
          </ul>
        </div>
  </div>

</nav>
</header>
