<?php

namespace App\Http\Controllers\Authenticated;

use App\Helpers\NumberHelper;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Postgres\PlayerModel;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\CashierModel;
use App\Models\Postgres\TicketModel;
use App\Helpers\DateTimeHelper;
use Mcamara\LaravelLocalization\LaravelLocalization;


class TicketController extends Controller
{
    public function __construct()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            $this->layout = View::make('layouts.mobile_layout');
        }
        if ($agent->isTablet()) {
            $this->layout = View::make('layouts.desktop_layout');
        } else {
            $this->layout = View::make('layouts.desktop_layout');
        }
    }
	
	public function temporaryToReal(Request $request){

        $ticket_id = $request->get('ticket_id');

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultTempToReal = TicketModel::temporaryToRealTicket($backoffice_session_id, $ticket_id);
		
		$language = \LaravelLocalization::getCurrentLocale();
		if($resultTempToReal['status'] == "OK"){
			return \Redirect::to('/' . $language . '/ticket/list-temporary-tickets')
			->with("success_message", __("authenticated.Changes saved"));
		}else{
			return \Redirect::to('/' . $language . '/ticket/list-temporary-tickets')
			->with("error_message", __("authenticated.Changes not saved"));
		}
    }

    public function listTemporaryTickets(){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultTicketResult = TicketModel::listTemporaryTickets($backoffice_session_id);

        return view(
            '/authenticated/ticket/list-temporary-tickets',
            [
                "list_tickets" => $resultTicketResult["ticket_result"]
            ]
        );
    }

    public function searchTickets(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $start_date = $request->get('report_start_date', date("d-M-Y", strtotime("-2 day", strtotime($authSessionData['report_end_date']))));
        $end_date = $request->get('report_end_date', $authSessionData['report_end_date']);

        $ticket_id = $request->get('ticket_id', null);
        $ticket_draw_id = $request->get('draw_id', null);
        $ticket_barcode = $request->get('barcode', null);
        $player_name = $request->get('player_name', null);
        $cashier_name = $request->get('cashier_name', null);
        $ticket_status = $request->get('ticket_status', null);

        $resultListCashiers = CashierModel::listCashiers($backoffice_session_id);

        $list_cashiers = array();

        foreach($resultListCashiers['list_cashiers'] as $cashier){
          $list_cashiers[$cashier->username] = $cashier->username;
        }

        $resultTicketStatuses = TicketModel::listTicketStatuses($backoffice_session_id);
        $list_ticket_statuses = array();

        foreach ($resultTicketStatuses['ticket_statuses'] as $ticket) {
            $list_ticket_statuses[$ticket->ticket_status] = __("authenticated." . $ticket->ticket_status_desc);
        }
        if($request->has('generate_report_search_ticket_id') && $request->get('ticket_id', null) != ""){
            $barcodeSearch = true;
            $resultCheckTicketDetails = TicketModel::searchTickets($backoffice_session_id, null, null, null, null,
                null, null, null, $ticket_id
            );
        }
        else {
            $barcodeSearch = false;
            $resultCheckTicketDetails = TicketModel::searchTickets($backoffice_session_id, $ticket_draw_id, null, $player_name, $cashier_name,
                $start_date, $end_date, $ticket_status, null
            );
        }

        $i = 0;
        foreach ($resultCheckTicketDetails['ticket_result'] as $row){
            $i++;
        }

        if($barcodeSearch && $i > 0){
            $laravelLocalized = new LaravelLocalization();

            $url = "/ticket/ticket-details-with-serial-number/ticket_serial_number/";

            $ticketSerialNumber = $resultCheckTicketDetails['ticket_result'][0]->serial_number;

            $link = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$ticketSerialNumber);

            return redirect($link);
        }

        if($request->has('small')){
            $view_name = '/authenticated/ticket/search-tickets-small';
        }
        else if($request->has('large')){
            $view_name = '/authenticated/ticket/search-tickets';
        }else {
            $view_name = $request->exists('large_tag') ? '/authenticated/ticket/search-tickets' : '/authenticated/ticket/search-tickets-small';
        }

        return view(
            $view_name,
            [
                "ticket_draw_id" => $ticket_draw_id,
                "ticket_id" => $ticket_id,
                "ticket_barcode" => $ticket_barcode,
                "player_name" => $player_name,
                "cashier_name" => $cashier_name,
                "report_start_date" => $start_date,
                "report_end_date" => $end_date,
                "ticket_status" => $ticket_status,
                "barcodeSearch" => $barcodeSearch,

                //"list_players" => $list_players,

                "list_cashiers" => $list_cashiers,
                "list_tickets" => $resultCheckTicketDetails['ticket_result'],
                "list_ticket_statuses" => $list_ticket_statuses,
            ]
        );
    }

    public function ticketDetailsWithSerialNumber($ticket_serial_number, Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $logged_user_id = $authSessionData['user_id'];

        $payTable = TicketModel::payTable();

        if(strlen($ticket_serial_number) != 0) {
            $resultCheckTicketDetails = TicketModel::checkTicketDetailsWithSerialNumber($backoffice_session_id, $ticket_serial_number);
        }else{
            $resultCheckTicketDetails = array();
        }

        //dd($resultCheckTicketDetails);

        $combinationsResult = $resultCheckTicketDetails["combinations_result"];
        $combinationsResultNew = array();
        $combinationsResultNewAll = array();

        $drawResult = $resultCheckTicketDetails["draw_result"];
        $drawResultNew = array();

        $i = 0;
        foreach ($combinationsResult as $combination){
            $combinationsResultNew[$i]["combination_type_id"] = $combination->combination_type_id;
            $combinationsResultNew[$i]["combination_type"] = $combination->combination_type;
            $combinationsResultNew[$i]["combination_type_name"] = $combination->combination_type_name;
            $combinationsResultNew[$i]["combination_value"] = $combination->combination_value;
            $combinationsResultNew[$i]["bet"] = NumberHelper::format_double($combination->bet);

            if($combination->win > 0){
                $combinationsResultNewAll[$i]["bet"] = NumberHelper::format_double($combination->bet);
                $combinationsResultNewAll[$i]["combination_value"] = $combination->combination_value;
                $combinationsResultNewAll[$i]["combination_type_name"] = $combination->combination_type_name;
                $combinationsResultNewAll[$i]["combination_type"] = $combination->combination_type;
                $combinationsResultNewAll[$i]["combination_type_id"] = $combination->combination_type_id;
                $combinationsResultNewAll[$i]["win"] = NumberHelper::format_double($combination->win);
                $combinationsResultNewAll[$i]["order_num"] = $combination->order_num;
            }

            $i++;
        }
        $i = 0;
        foreach ($drawResult as $draw){
            $drawResultNew[$i]["draw_id"] = $draw->draw_id;
            $drawResultNew[$i]["order_num"] = $draw->order_num;
            $drawResultNew[$i]["first_draw_sn"] = $draw->first_draw_sn;
            $drawResultNew[$i]["first_draw_id"] = $draw->first_draw_id;
            $drawResultNew[$i]["first_draw_date_time"] = $draw->first_draw_date_time;
            $drawResultNew[$i]["jackpot_win"] = $draw->jackpot_win;
            $drawResultNew[$i]["draw_status"] = $draw->draw_status;
            $drawResultNew[$i]["chosen_numbers"] = $draw->chosen_numbers;
            $i++;
        }
        $i = 0;

        $result = array_unique($combinationsResultNew, SORT_REGULAR);
        //$result = $combinationsResultNew;

        if($resultCheckTicketDetails['ticket_result'][0]->ticket_status == 1) {
            $resultCheckPreferredButtonVisibility = TicketModel::checkPreferredButtonVisibility($backoffice_session_id, $logged_user_id, $resultCheckTicketDetails["ticket_result"][0]->parent_id, $resultCheckTicketDetails["ticket_result"][0]->barcode);
            if ($resultCheckPreferredButtonVisibility['status'] == "NOK") {
                $preferred_button_visibility_status = -99;
            } else {
                $preferred_button_visibility_status = $resultCheckPreferredButtonVisibility['enabled_preferred_button_out'];
            }
        }else{
            $preferred_button_visibility_status = 20000;
        }

        //dd($preferred_button_visibility_status);

        $view_result = [
            "ticket_serial_number" => $ticket_serial_number,
            "ticket_id" => $resultCheckTicketDetails['ticket_result'][0]->ticket_id,
            "ticket_result" => isset($resultCheckTicketDetails["ticket_result"]) ? $resultCheckTicketDetails['ticket_result'] : array(),
            "combinations_result" => isset($resultCheckTicketDetails["combinations_result"]) ? $resultCheckTicketDetails['combinations_result'] : array(),
            "combinations" => $result,
            "draw_result" => $drawResultNew,
            "payTable" => $payTable["payTable"],
            "coefficients" => $payTable["coefficients"],
            "win_result" => $combinationsResultNewAll,
            "check_preferred_button_visibility" => $preferred_button_visibility_status
        ];

        return view(
            '/authenticated/ticket/ticket-details-with-serial-number',
            $view_result
        );
    }
	
	public function ticketDetails($ticket_id, Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        if(strlen($ticket_id) != 0) {
            $resultCheckTicketDetails = TicketModel::ticketDetails($backoffice_session_id, $ticket_id);
        }else{
            $resultCheckTicketDetails = array();
        }
		//dd($resultCheckTicketDetails);

        return view(
            '/authenticated/ticket/ticket-details',
            [
                "ticket_id" => $ticket_id,
                "ticket_serial_number" => $resultCheckTicketDetails['ticket_result'][0]->ticket_serial_number,
                "ticket_result" => isset($resultCheckTicketDetails["ticket_result"]) ? $resultCheckTicketDetails['ticket_result'] : array(),
				"combinations_result" => isset($resultCheckTicketDetails["combinations_result"]) ? $resultCheckTicketDetails['combinations_result'] : array(),
            ]
        );
    }
	
	public function listWinsForTicket($ticket_id, Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultTicketResult = TicketModel::listWinsForTicket($backoffice_session_id, $ticket_id);

        //dd($resultTicketResult);
        //dd($resultTicketResult["list_wins_for_ticket"][0]->serial_number);

        return view(
            '/authenticated/ticket/list-wins-for-ticket',
            [
				"ticket_id" => $ticket_id,
                "ticket_serial_number" => $resultTicketResult["list_wins_for_ticket"][0]->serial_number,
                "list_wins_for_ticket" => $resultTicketResult["list_wins_for_ticket"]
            ]
        );
    }

    public function controlPreferredTicket($ticket_serial_number, $barcode, $status, $parent_id, Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $logged_user_id = $authSessionData['user_id'];

        $resultControlPreferredTicket = TicketModel::setPreferredTicket($backoffice_session_id, $logged_user_id, $parent_id, $barcode, $status);
        //dd($resultControlPreferredTicket);

		$language = \LaravelLocalization::getCurrentLocale();

		if($resultControlPreferredTicket['status'] == "OK") {
		    if ($status == 1 && $resultControlPreferredTicket['status_out'] == 1) {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("success_message", __("authenticated.Ticket set preferred control to :status for draw id :draw_id", array("status" => __("authenticated.Control Preferred Ticket Small"), "draw_id" => $resultControlPreferredTicket['draw_id_out'])));
            }
            else if ($status == 2 && $resultControlPreferredTicket['status_out'] == 1) {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("success_message", __("authenticated.Ticket set preferred control to :status for draw id :draw_id", array("status" => __("authenticated.Control Preferred Ticket Medium"), "draw_id" => $resultControlPreferredTicket['draw_id_out'])));
            }
            else if ($status == -1 && $resultControlPreferredTicket['status_out'] == 1) {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("success_message", __("authenticated.Ticket set preferred control to :status for draw id :draw_id", array("status" => __("authenticated.Control Preferred Ticket Off"), "draw_id" => $resultControlPreferredTicket['draw_id_out'])));
            }
            else if($resultControlPreferredTicket['status_out'] == -1){
		        return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                	->with("error_message", __("authenticated.Unexpected error" ));
            }
            else if($resultControlPreferredTicket['status_out'] == -2){
		        return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                	->with("error_message", __("authenticated.Draw already started" ));
            }
            else if($resultControlPreferredTicket['status_out'] == -3){
		        return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                	->with("error_message", __("authenticated.There is one ticket already in queue. Wait for next draw." ));
            }
            else {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("error_message", __("authenticated.Changes not saved"));
            }
        }
        else{
		    return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("error_message", __("authenticated.Changes not saved"));
        }

		/*if($resultControlPreferredTicket['status'] == "OK") {
            if ($status == 1) {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("success_message", __("authenticated.Ticket set preferred control to :status for draw id :draw_id", array("status" => __("authenticated.Control Preferred Ticket Small"), "draw_id" => $resultControlPreferredTicket['draw_id_out'])));
            } else if ($status == 2) {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("success_message", __("authenticated.Ticket set preferred control to :status for draw id :draw_id", array("status" => __("authenticated.Control Preferred Ticket Medium"), "draw_id" => $resultControlPreferredTicket['draw_id_out'])));
            } else if ($status == -1) {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("success_message", __("authenticated.Ticket set preferred control to :status for draw id :draw_id", array("status" => __("authenticated.Control Preferred Ticket Off"), "draw_id" => $resultControlPreferredTicket['draw_id_out'])));
            }else {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("error_message", __("authenticated.Changes not saved"));
            }
        }else{
		    $status_out = $resultControlPreferredTicket['status_out'];
		    if($status_out == -1){
		        return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                	->with("error_message", __("authenticated.Unexpected error" ));
            }
		    else if($status_out == -2){
		        return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                	->with("error_message", __("authenticated.Draw already started" ));
            }
            else if($status_out == -3) {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("error_message", __("authenticated.There is one ticket already in queue. Wait for next draw."));
            }
            else {
                return \Redirect::to('/' . $language . "/ticket/ticket-details-with-serial-number/ticket_serial_number/" . $ticket_serial_number)
                    ->with("error_message", __("authenticated.Changes not saved"));
            }
		}*/
    }
}
