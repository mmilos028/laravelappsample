<style>
    #ul{
        list-style: none !important;
        display: inline !important;
        padding-left: 0px !important;
    }
    #li{
        display: inline !important;
    }
    .btn.btn-app{
        height: 50px !important;
    }
</style>
<div class="row">
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets") }}">
        <i class="fa fa-search"></i>
        {{ __('authenticated.Search Tickets') }}
        <span class="sr-only">(current)</span>
    </a>
    @if(isset($ticket_serial_number))
        <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket_serial_number}") }}">
            <i class="fa fa-info"></i>
            {{ __('authenticated.Ticket Details') }}
            <span class="sr-only">(current)</span>
        </a>
    @endif
    <!--<ul id="ul">
        <li class="dropdown" id="li">
            <a class="dropdown-toggle noblockui btn btn-app" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-bar-chart"></i>
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
    </ul>-->
</div>