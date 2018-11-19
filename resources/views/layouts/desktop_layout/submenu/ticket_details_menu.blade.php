<div class="navbar-custom-menu pull-left">
  <ul class="nav navbar-nav">
	<li>
      <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets") }}">
        {{ __('authenticated.Search Tickets') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    @if(isset($ticket_serial_number))
    <li>
      <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket_serial_number}") }}">
        {{ __('authenticated.Ticket Details') }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    @endif
    <li class="dropdown">
      <a href="#" class="dropdown-toggle noblockui" data-toggle="dropdown" aria-expanded="true">
        {{ __("authenticated.Reports") }} <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li>
          <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/list-wins-for-ticket/ticket_id/{$ticket_id}") }}">
            {{ __("authenticated.List Wins For Ticket") }}
          </a>
        </li>
      </ul>
    </li>
  </ul>
</div>
