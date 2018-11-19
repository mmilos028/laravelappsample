<header class="main-header">
<nav class="navbar navbar-static-top">
	<!-- Sidebar toggle button-->
      <a style="display: none !important;" href="#" class="sidebar-toggle noblockui" data-target="#mobile_navbar"
	  data-toggle="collapse" role="button" aria-controls="mobile_navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
	<div id="mobile_navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
	  <ul class="nav navbar-nav">
	  
		<li class="dropdown" style="display: none !important;">
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

		  {{--
		  @if ($show_cashier_menu)
		@include('layouts.mobile_layout.submenu.cashier_menu')
		@endif

		@if ($show_administrator_menu)
		@include('layouts.mobile_layout.submenu.administrator_menu')
		@endif
		@if ($show_structure_entity_menu)
		@include('layouts.mobile_layout.submenu.structure_entity_menu')
		@endif
		@if ($show_user_menu)
		@include('layouts.mobile_layout.submenu.user_menu')
		@endif
		@if ($show_terminal_menu)
		@include('layouts.mobile_layout.submenu.terminal_menu')
		@endif
		@if ($show_player_menu)
		@include('layouts.mobile_layout.submenu.player_menu')
		@endif
		@if ($show_ticket_details_menu)
		@include('layouts.mobile_layout.submenu.ticket_details_menu')
		@endif

		@if ($show_draw_model_setup_menu)
		@include('layouts.mobile_layout.submenu.administration.draw_model_setup_menu')
		@endif
		  --}}

	  </ul>
    </div>  
    <div class="container">
        <div class="navbar-custom-menu" style="width: 100% !important;">
          <ul class="nav navbar-nav pull-left" style="font-size: 12px !important;">
              <li>
				  <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/index")}}">
					  <i class="fa fa-caret-square-o-down"></i>
					  <span>{{ __("authenticated.Main Menu") }}</span>
				  </a>
			  </li>
			  <li>
				  <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "home_page")}}">
					  <i class="fa fa-home"></i>
					  <span> {{ __("authenticated.Home") }}</span>
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
<script>
    $(document).ready(function(){
        //Updates time on home page. Can be used for all other time updates if needed.

        var intervalCountdown = setInterval(
            function() {
                var date = new Date();
                var weekday = new Array(7);
                weekday[0] = "Sunday";
                weekday[1] = "Monday";
                weekday[2] = "Tuesday";
                weekday[3] = "Wednesday";
                weekday[4] = "Thursday";
                weekday[5] = "Friday";
                weekday[6] = "Saturday";
                var monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

                var dayName = weekday[date.getDay()];
                var monthDay = date.getDate();
                var year = date.getFullYear();
                var monthName = monthNames[date.getMonth()];
                var dateString = dayName + ", " + monthDay + ". " + monthName + " " + year;
                $("#dateTimeHomePage").val(monthDay + " " + monthName + " " + year + " " + date.toLocaleTimeString());
                //$("#currentServerDate").text(dateString);
            }, 1000
        );
    });
</script>
