<?php

namespace App\Http\Controllers\Authenticated;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Postgres\ReportModel;
use App\Models\Postgres\DrawModel;
use App\Models\Postgres\CustomerModel;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\CashierModel;
use App\Models\Postgres\TicketModel;

use App\Helpers\ArrayHelper;
use App\Helpers\ResultLimitHelper;
use App\Helpers\ErrorHelper;
use App\Helpers\NumberHelper;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class ReportController extends Controller
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

    public function returnCashierDailyReport(Request $request){
        return view("authenticated/report.daily-report-cashier");
    }
    public function returnFinancialReport(Request $request){
        return view("authenticated/report.financial-report-2");
    }
    public function returnTransactionReport(){
        return view("authenticated/report.transaction-report");
    }
    public function returnCollectorTransactionReport(){
        return view("authenticated/report.collector_transactions");
    }
    public function returnPlayerLiabilityReport(){
        return view("authenticated/report.player-liability");
    }
    public function returnAllTransactionsReport(){
        return view("authenticated/report.all-transactions");
    }
    public function returnMachineKeysAndCodesReport(){
        return view("authenticated/report.machine-keys-and-codes");
    }
    public function returnDrawList(){
        return view("authenticated/report.draw-list-2");
    }
    public function returnTicketList(){
        return view("authenticated/report.ticket-list-2");
    }

    public function returnListAffiliateMonthlySummaryReport(){
        return view("authenticated/report.list-affiliate-monthly-summary-report");
    }

    public function returnCashierShiftReport(){
        return view("authenticated/report.cashier-shift-report");
    }

    public function cashierDailyReport(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $subject_id = $request->input("subject_id");
        $date = $request->input("date");

        //dd($subject_id);

        $result = ReportModel::cashierDailyReport($backoffice_session_id, $subject_id, $date);

        //dd($result);

        $cashier = $result["cashier"];
        $cashierProcessed = array();
        $location = $result["location"];
        $locationProcessed = array();

        $i = 0;
        foreach ($cashier as $c){
            $cashierProcessed[$i]["start_credits"] = $c->start_credits;
            $cashierProcessed[$i]['start_credits_formatted'] = NumberHelper::format_double($c->start_credits);
            $cashierProcessed[$i]["no_of_deposits"] = $c->no_of_deposits;
            $cashierProcessed[$i]["no_of_deposits_formatted"] = NumberHelper::format_double($c->no_of_deposits);
            $cashierProcessed[$i]["sum_deposits"] = $c->sum_deposits;
            $cashierProcessed[$i]['sum_deposits_formatted'] = NumberHelper::format_double($c->sum_deposits);
            $cashierProcessed[$i]["no_of_cashier_deposits"] = $c->no_of_cashier_deposits;
            $cashierProcessed[$i]["no_of_cashier_deposits_formatted"] = NumberHelper::format_double($c->no_of_cashier_deposits);
            $cashierProcessed[$i]["sum_cashier_deposits"] = $c->sum_cashier_deposits;
            $cashierProcessed[$i]['sum_cashier_deposits_formatted'] = NumberHelper::format_double($c->sum_cashier_deposits);
            $cashierProcessed[$i]["no_of_online_deposits"] = $c->no_of_online_deposits;
            $cashierProcessed[$i]["no_of_online_deposits_formatted"] = NumberHelper::format_double($c->no_of_online_deposits);
            $cashierProcessed[$i]["sum_of_online_deposits"] = $c->sum_of_online_deposits;
            $cashierProcessed[$i]['sum_of_online_deposits_formatted'] = NumberHelper::format_double($c->sum_of_online_deposits);
            $cashierProcessed[$i]["no_of_deactivated_tickets"] = $c->no_of_deactivated_tickets;
            $cashierProcessed[$i]["no_of_deactivated_tickets_formatted"] = NumberHelper::format_double($c->no_of_deactivated_tickets);
            $cashierProcessed[$i]["sum_canceled_deposits"] = $c->sum_canceled_deposits;
            $cashierProcessed[$i]['sum_canceled_deposits_formatted'] = NumberHelper::format_double($c->sum_canceled_deposits);
            $cashierProcessed[$i]["no_of_payed_out_tickets"] = $c->no_of_payed_out_tickets;
            $cashierProcessed[$i]["no_of_payed_out_tickets_formatted"] = NumberHelper::format_double($c->no_of_payed_out_tickets);
            $cashierProcessed[$i]["sum_of_payed_out_tickets"] = $c->sum_of_payed_out_tickets;
            $cashierProcessed[$i]['sum_of_payed_out_tickets_formatted'] = NumberHelper::format_double($c->sum_of_payed_out_tickets);
            $cashierProcessed[$i]["no_of_payed_out_tickets_cashier"] = $c->no_of_payed_out_tickets_cashier;
            $cashierProcessed[$i]["no_of_payed_out_tickets_cashier_formatted"] = NumberHelper::format_double($c->no_of_payed_out_tickets_cashier);
            $cashierProcessed[$i]["sum_of_payed_out_tickets_cashier"] = $c->sum_of_payed_out_tickets_cashier;
            $cashierProcessed[$i]['sum_of_payed_out_tickets_cashier_formatted'] = NumberHelper::format_double($c->sum_of_payed_out_tickets_cashier);
            $cashierProcessed[$i]["no_of_payed_out_tickets_online"] = $c->no_of_payed_out_tickets_online;
            $cashierProcessed[$i]["no_of_payed_out_tickets_online_formatted"] = NumberHelper::format_double($c->no_of_payed_out_tickets_online);
            $cashierProcessed[$i]["sum_of_payed_out_tickets_online"] = $c->sum_of_payed_out_tickets_online;
            $cashierProcessed[$i]['sum_of_payed_out_tickets_online_formatted'] = NumberHelper::format_double($c->sum_of_payed_out_tickets_online);
            $cashierProcessed[$i]["end_credits"] = $c->end_credits;
            $cashierProcessed[$i]['end_credits_formatted'] = NumberHelper::format_double($c->end_credits);
            $i++;
        }
        $i = 0;
        foreach ($location as $l){
            $locationProcessed[$i]["no_of_deposits"] = $l->no_of_deposits;
            $locationProcessed[$i]["no_of_deposits_formatted"] = NumberHelper::format_double($l->no_of_deposits);
            $locationProcessed[$i]["sum_deposits"] = $l->sum_deposits;
            $locationProcessed[$i]['sum_deposits_formatted'] = NumberHelper::format_double($l->sum_deposits);
            $locationProcessed[$i]["no_of_cashier_deposits"] = $l->no_of_cashier_deposits;
            $locationProcessed[$i]["no_of_cashier_deposits_formatted"] = NumberHelper::format_double($l->no_of_cashier_deposits);
            $locationProcessed[$i]["sum_cashier_deposits"] = $l->sum_cashier_deposits;
            $locationProcessed[$i]['sum_cashier_deposits_formatted'] = NumberHelper::format_double($l->sum_cashier_deposits);
            $locationProcessed[$i]["no_of_online_deposits"] = $l->no_of_online_deposits;
            $locationProcessed[$i]["no_of_online_deposits_formatted"] = NumberHelper::format_double($l->no_of_online_deposits);
            $locationProcessed[$i]["sum_of_online_deposits"] = $l->sum_of_online_deposits;
            $locationProcessed[$i]['sum_of_online_deposits_formatted'] = NumberHelper::format_double($l->sum_of_online_deposits);
            $locationProcessed[$i]["no_of_deactivated_tickets"] = $l->no_of_deactivated_tickets;
            $locationProcessed[$i]["no_of_deactivated_tickets_formatted"] = NumberHelper::format_double($l->no_of_deactivated_tickets);
            $locationProcessed[$i]["sum_canceled_deposits"] = $l->sum_canceled_deposits;
            $locationProcessed[$i]['sum_canceled_deposits_formatted'] = NumberHelper::format_double($l->sum_canceled_deposits);
            $locationProcessed[$i]["no_of_payed_out_tickets"] = $l->no_of_payed_out_tickets;
            $locationProcessed[$i]["no_of_payed_out_tickets_formatted"] = NumberHelper::format_double($l->no_of_payed_out_tickets);
            $locationProcessed[$i]["sum_of_payed_out_tickets"] = $l->sum_of_payed_out_tickets;
            $locationProcessed[$i]['sum_of_payed_out_tickets_formatted'] = NumberHelper::format_double($l->sum_of_payed_out_tickets);
            $locationProcessed[$i]["no_of_payed_out_tickets_cashier"] = $l->no_of_payed_out_tickets_cashier;
            $locationProcessed[$i]["no_of_payed_out_tickets_cashier_formatted"] = NumberHelper::format_double($l->no_of_payed_out_tickets_cashier);
            $locationProcessed[$i]["sum_of_payed_out_tickets_cashier"] = $l->sum_of_payed_out_tickets_cashier;
            $locationProcessed[$i]['sum_of_payed_out_tickets_cashier_formatted'] = NumberHelper::format_double($l->sum_of_payed_out_tickets_cashier);
            $locationProcessed[$i]["no_of_payed_out_tickets_online"] = $l->no_of_payed_out_tickets_online;
            $locationProcessed[$i]["no_of_payed_out_tickets_online_formatted"] = NumberHelper::format_double($l->no_of_payed_out_tickets_online);
            $locationProcessed[$i]["sum_of_payed_out_tickets_online"] = $l->sum_of_payed_out_tickets_online;
            $locationProcessed[$i]['sum_of_payed_out_tickets_online_formatted'] = NumberHelper::format_double($l->sum_of_payed_out_tickets_online);
            $i++;
        }

        return response()->json([
            "cashier" => $cashierProcessed,
            "location" => $locationProcessed,
            "location_name" => $result["location_name"],
            "start_credits" => $result["start_credits"],
            "start_credits_formatted" => NumberHelper::format_double($result["start_credits"]),
            "end_credits" => $result["end_credits"],
            "end_credits_formatted" => NumberHelper::format_double($result["end_credits"]),
            "currency" => $result["currency"],
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function dailyReport(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListDailyReport = ReportModel::listDailyReport($backoffice_session_id);

        return view(
            '/authenticated/report/daily-report',
            array(
                "list_report" => $resultListDailyReport['report'],
            )
        );
    }

    public function dailyReportAjax(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListDailyReport = ReportModel::listDailyReport($backoffice_session_id);

        return response()->json([
            "result" => $resultListDailyReport,
        ]);
    }

    public function ticketList(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $user_affiliate_id = $authSessionData['user_id'];
        $parent_affiliate_id = $authSessionData['parent_id'];

        $affiliate_id = $request->get('affiliate_id', $parent_affiliate_id); //id affiliate-a za koga listas
        $ticket_status = $request->get('ticket_status', null); //-1 do 5 statusi
        $report_start_date = $request->get('report_start_date', $authSessionData['report_start_date']);
        $report_end_date = $request->get('report_end_date', $authSessionData['report_end_date']);

        $resultTicketStatuses = TicketModel::listTicketStatuses($backoffice_session_id);
        $list_ticket_statuses = array();
        foreach($resultTicketStatuses['ticket_statuses'] as $ticket){
            $list_ticket_statuses[$ticket->ticket_status] = __("authenticated." . $ticket->ticket_status_desc);
        }

        $resultListFilterUsers = CustomerModel::listCustomers($backoffice_session_id);
        $list_filter_users = [];
        foreach($resultListFilterUsers['list_customers'] as $user){
            $list_filter_users[$user->subject_id] = $user->username;
        }

        if(strlen($affiliate_id) == 0){
            $affiliate_id = $parent_affiliate_id;
        }

        $resultListTicketReport = ReportModel::listLocationTickets($backoffice_session_id, $user_affiliate_id, $affiliate_id, $ticket_status, $report_start_date, $report_end_date);

       // dd($resultListTicketReport);

        if($request->has('small')){
            $view_name = '/authenticated/report/ticket-list-small';
        }
        else if($request->has('large')){
            $view_name = '/authenticated/report/ticket-list';
        }else {
            $view_name = $request->exists('large_tag') ? '/authenticated/report/ticket-list' : '/authenticated/report/ticket-list-small';
        }

        return view(
            $view_name,
            array(
                "list_report" => $resultListTicketReport['report'],
                "report_start_date" => $report_start_date,
                "report_end_date" => $report_end_date,
                "list_ticket_statuses" => $list_ticket_statuses,
                "ticket_status" => $ticket_status,
                "list_filter_users" => $list_filter_users,
                "affiliate_id" => $affiliate_id
            )
        );
    }

    public function collectorTransactionReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $affiliate_id = $request->input("subject_id");
            $start_date = $request->input("start_date");
            $end_date = $request->input("end_date");

            $result = ReportModel::collectorTransactionsReport($backoffice_session_id, $affiliate_id, $start_date, $end_date);
            $resultResult = $result["report"];
            $resultResult2 = $result["report2"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $resultProcessed2 = array();

            $laravelLocalized = new LaravelLocalization();
            $arrayHelper = new ArrayHelper();

            $i = 0;

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $resultProcessed[$i]["transaction_id"] = $r->transaction_id;
                    $resultProcessed[$i]["currency"] = $r->currency;
                    $resultProcessed[$i]["amount"] = $r->amount;
                    $resultProcessed[$i]["amount_formatted"] = NumberHelper::format_double($r->amount);
                    $resultProcessed[$i]["date"] = $r->rec_tmstp;
                    $resultProcessed[$i]["date_formatted"] = $r->rec_tmstp_formated;
                    $resultProcessed[$i]["subject_name_for"] = $r->subject_name_from;
                    $resultProcessed[$i]["subject_id_for"] = $r->subject_id_from;
                    $resultProcessed[$i]["subject_name_to"] = $r->subject_name_to;
                    $resultProcessed[$i]["subject_id_to"] = $r->subject_id_to;
                    $resultProcessed[$i]["from_entity"] = $r->from_entity;
                    $resultProcessed[$i]["from_entity_id"] = $r->from_entity_id;
                    $resultProcessed[$i]["to_entity"] = $r->to_entity;
                    $resultProcessed[$i]["to_entity_id"] = $r->to_entity_id;
                    $resultProcessed[$i]["from_entity_subject_type"] = $r->from_entity_subject_type;
                    $resultProcessed[$i]["to_entity_subject_type"] = $r->to_entity_subject_type;
                    $resultProcessed[$i]["from_user_subject_type"] = $r->from_user_subject_type;
                    $resultProcessed[$i]["to_user_subject_type"] = $r->to_user_subject_type;
                    $propertiesFromEntity = $arrayHelper->determineTreeGridProperties($r->from_entity_subject_type);
                    $propertiesToEntity = $arrayHelper->determineTreeGridProperties($r->to_entity_subject_type);
                    $propertiesFromUser = $arrayHelper->determineTreeGridProperties($r->from_user_subject_type);
                    $propertiesToUser = $arrayHelper->determineTreeGridProperties($r->to_user_subject_type);
                    $urlFromUser = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $propertiesFromUser["url"].$r->subject_id_from);
                    $urlToUSer = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $propertiesToUser["url"].$r->subject_id_to);

                    if($r->from_entity_id == config("constants.ROOT_MASTER_ID") || $r->from_entity_id == config("constants.LUCKY_SIX_ID")){
                        $urlFromEntity = "";
                    }else{
                        $urlFromEntity = $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $propertiesFromEntity["url"].$r->from_entity_id);
                    }

                    if($r->to_entity_id == config("constants.ROOT_MASTER_ID") || $r->to_entity_id == config("constants.LUCKY_SIX_ID")){
                        $urlToEntity = "";
                    }else{
                        $urlToEntity = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $propertiesToEntity["url"].$r->to_entity_id);
                    }

                    $resultProcessed[$i]["url_from_entity"] = $urlFromEntity;
                    $resultProcessed[$i]["url_to_entity"] = $urlToEntity;
                    $resultProcessed[$i]["url_from_user"] = $urlFromUser;
                    $resultProcessed[$i]["url_to_user"] = $urlToUSer;
                    $i++;
                }

                $i = 0;

                foreach ($resultResult2 as $r){
                    $resultProcessed2[$i]["currency"] = $r->currency;
                    $resultProcessed2[$i]["no_of_transactions"] = $r->no_of_transactions;
                    $resultProcessed2[$i]["total_collected"] = NumberHelper::format_double($r->total_collected);
                    $resultProcessed2[$i]["total_withdraw"] = $r->total_withdraw;
                    $resultProcessed2[$i]["difference"] = NumberHelper::format_double($r->difference);
                    $i++;
                }

                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                    "result2" => $resultProcessed2,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function playerTransactionsReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $affiliate_id = $request->input("subject_id");
            $start_date = $request->input("start_date");
            $end_date = $request->input("end_date");

            $result = ReportModel::playerTransactionsReport($backoffice_session_id, $affiliate_id, $start_date, $end_date);
            $resultResult = $result["report"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $i = 0;

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $resultProcessed[$i]["subject_id"] = $r->subject_id;
                    $resultProcessed[$i]["first_name"] = $r->first_name;
                    $resultProcessed[$i]["last_name"] = $r->last_name;
                    $resultProcessed[$i]["username"] = $r->username;
                    $resultProcessed[$i]["date_formatted"] = $r->rec_tmstp_formated;
                    $resultProcessed[$i]["serial_number"] = $r->serial_number;
                    $resultProcessed[$i]["transaction_id"] = $r->transaction_id;
                    $resultProcessed[$i]["transaction_type_id"] = $r->transaction_type_id;
                    $resultProcessed[$i]["transaction_type"] = $r->transaction_type;
                    $resultProcessed[$i]["ticket_status"] = $r->ticket_status;
                    $resultProcessed[$i]["amount"] = $r->amount;
                    $resultProcessed[$i]["amount_formatted"] = NumberHelper::format_double($r->amount);
                    $resultProcessed[$i]["sum_win"] = $r->sum_win;
                    $resultProcessed[$i]["sum_win_formatted"] = NumberHelper::format_double($r->sum_win);
                    $resultProcessed[$i]["currency"] = $r->currency;
                    $i++;
                }

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function allMachineKeysAndCodesReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $terminal_id = "-1";
            $machine_key = "-1";

            $result_processed = array();
            $laravelLocalized = new LaravelLocalization();

            $result = ReportModel::allMachineKeysAndCodesReport($terminal_id, $machine_key);
            $resultResult = $result["report"];
            $resultStatus = $result["status"];

            if($resultStatus == "OK"){
                $i = 0;
                foreach ($resultResult as $result){
                    $url = "/terminal/details/user_id/";
                    $link = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$result->terminal_id."/".$result->subject_dtype);

                    $result_processed[$i]["terminal_id"] = $result->terminal_id;
                    $result_processed[$i]["terminal_name"] = $result->terminal_name;
                    $result_processed[$i]["service_code"] = $result->service_code;
                    $result_processed[$i]["subject_dtype_id"] = $result->subject_dtype_id;
                    $result_processed[$i]["subject_dtype"] = $result->subject_dtype;
                    $result_processed[$i]["subject_dtype_bo_name"] = $result->subject_dtype_bo_name;
                    $result_processed[$i]["subject_state"] = $result->subject_state;
                    $result_processed[$i]["parent_name"] = $result->parent_name;
                    $result_processed[$i]["parent_id"] = $result->parent_id;
                    $result_processed[$i]["valid_until"] = $result->valid_until;
                    $result_processed[$i]["link"] = $link;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $result_processed,
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $resultResult,
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function playerLiabilityReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $affiliate_id = $request->input("subject_id");

            $result = ReportModel::playerLiabilityReport($backoffice_session_id, $affiliate_id);
            $resultResult = $result["report"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $laravelLocalized = new LaravelLocalization();
            $arrayHelper = new ArrayHelper();

            $playerTransactionsUrl = "/player/report/list-money-transactions/user_id/";
            $playerTicketsUrl = "/player/report/list-player-tickets/user_id/";

            $i = 0;
            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $subject_type = config("constants.ROLE_PLAYER");

                    $properties = $arrayHelper->determineTreeGridProperties($subject_type);

                    $url_disabled = $properties["url_disabled"];
                    $url = $properties["url"];
                    $color = $properties["color"];

                    $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$r->subject_id);
                    $playerTransactionsUrl2 = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $playerTransactionsUrl.$r->subject_id);
                    $playerTicketsUrl2 = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $playerTicketsUrl.$r->subject_id);

                    $resultProcessed[$i]["currency"] = $r->currency;
                    $resultProcessed[$i]["ord"] = $r->ord; // if 2, then total
                    $resultProcessed[$i]["url"] = $url;
                    $resultProcessed[$i]["playerTransactionsUrl"] = $playerTransactionsUrl2;
                    $resultProcessed[$i]["playerTicketsUrl"] = $playerTicketsUrl2;
                    $resultProcessed[$i]["subject_id"] = $r->subject_id;
                    $resultProcessed[$i]["first_name"] = $r->first_name;
                    $resultProcessed[$i]["last_name"] = $r->last_name;
                    $resultProcessed[$i]["username"] = $r->username;
                    $resultProcessed[$i]["total_deposits"] = $r->total_deposits;
                    $resultProcessed[$i]["total_deposits_formatted"] = NumberHelper::format_double($r->total_deposits);
                    $resultProcessed[$i]["total_withdraws"] = $r->total_withdraws;
                    $resultProcessed[$i]["total_withdraws_formatted"] = NumberHelper::format_double($r->total_withdraws_formatted);
                    $resultProcessed[$i]["total_tickets"] = $r->total_tickets;
                    $resultProcessed[$i]["total_tickets_formatted"] = NumberHelper::format_double($r->total_tickets);
                    $resultProcessed[$i]["total_win"] = $r->total_win;
                    $resultProcessed[$i]["total_win_formatted"] = NumberHelper::format_double($r->total_win);
                    $resultProcessed[$i]["actual_balance"] = $r->actual_balance;
                    $resultProcessed[$i]["actual_balance_formatted"] = NumberHelper::format_double($r->actual_balance);
                    $i++;
                }

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function allTransactionReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $affiliate_id = $request->input("subject_id");
            $start_date = $request->input("start_date");
            $end_date = $request->input("end_date");

            $result = ReportModel::allTransactionsReport($backoffice_session_id, $affiliate_id, $start_date, $end_date);
            $resultResult = $result["report"];
            $resultResult2 = $result["report2"];
            $resultStatus = $result["status"];

            //dd($result);

            $resultProcessed = array();
            $resultProcessed2 = array();
            $i = 0;

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $resultProcessed[$i]["currency"] = $r->currency;
                    $resultProcessed[$i]["no_of_tickets"] = $r->no_of_tickets;
                    $resultProcessed[$i]["profit_in"] = NumberHelper::format_double($r->profit_in);
                    $resultProcessed[$i]["profit_out"] = NumberHelper::format_double($r->profit_out);
                    $resultProcessed[$i]['profit_result'] = NumberHelper::format_double($r->profit_result);
                    $resultProcessed[$i]["collected"] = NumberHelper::format_double($r->collected);
                    $resultProcessed[$i]["withdraw"] = NumberHelper::format_double($r->withdraw);
                    $resultProcessed[$i]['difference'] = NumberHelper::format_double($r->difference);
                    $i++;
                }

                $i = 0;

                foreach ($resultResult2 as $r){
                    $resultProcessed2[$i]["transaction_id"] = $r->transaction_id;
                    $resultProcessed2[$i]["currency"] = $r->currency;
                    $resultProcessed2[$i]["transaction_from"] = $r->transaction_from;
                    $resultProcessed2[$i]["transaction_to"] = $r->transaction_to;
                    $resultProcessed2[$i]["date"] = $r->rec_tmstp;
                    $resultProcessed2[$i]["amount"] = $r->amount;
                    $resultProcessed2[$i]['transaction_type'] = $r->transaction_type;
                    $resultProcessed2[$i]["transaction_sign"] = $r->transaction_sign;

                    if($r->transaction_sign == 1){
                        $resultProcessed2[$i]["amountDeposit"] =  $r->amount * $r->transaction_sign;
                        $resultProcessed2[$i]["amountWithdraw"] = 0;
                        $resultProcessed2[$i]["amountDepositFormatted"] = NumberHelper::format_double($r->amount);
                        $resultProcessed2[$i]["amountWithdrawFormatted"] = NumberHelper::format_double(0);
                    }elseif ($r->transaction_sign == -1){
                        $resultProcessed2[$i]["amountWithdraw"] = $r->amount * $r->transaction_sign;
                        $resultProcessed2[$i]["amountDeposit"] = 0;
                        $resultProcessed2[$i]["amountWithdrawFormatted"] = NumberHelper::format_double($r->amount);
                        $resultProcessed2[$i]["amountDepositFormatted"] = NumberHelper::format_double(0);
                    }

                    $resultProcessed2[$i]["start_credits"] = $r->start_credits;
                    $resultProcessed2[$i]["start_credits_formatted"] = NumberHelper::format_double($r->start_credits);
                    $resultProcessed2[$i]["to_start_credits"] = $r->subject_to_start_credits;
                    $resultProcessed2[$i]["to_start_credits_formatted"] = NumberHelper::format_double($r->subject_to_start_credits);
                    $resultProcessed2[$i]["end_credits"] = $r->end_credits;
                    $resultProcessed2[$i]["end_credits_formatted"] = NumberHelper::format_double($r->end_credits);
                    $resultProcessed2[$i]["to_end_credits"] = $r->subject_to_end_credits;
                    $resultProcessed2[$i]["to_end_credits_formatted"] = NumberHelper::format_double($r->subject_to_end_credits);

                    $resultProcessed2[$i]['barcode'] = $r->barcode;
                    $resultProcessed2[$i]["transaction_to"] = $r->transaction_to;
                    $resultProcessed2[$i]["parent"] = $r->parent;
                    $resultProcessed2[$i]["date_formatted"] = $r->rec_tmstp_formated;
                    $resultProcessed2[$i]['subject_id_from'] = $r->subject_id_from;
                    $resultProcessed2[$i]["subject_id_to"] = $r->subject_id_to;
                    $resultProcessed2[$i]["session_id"] = $r->session_id;
                    if(isset($r->serial_number))
                        $resultProcessed2[$i]["serial_number"] = $r->serial_number;
                    else
                        $resultProcessed2[$i]["serial_number"] = "";

                    $i++;
                }

                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                    "result2" => $resultProcessed2,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function financialReport2(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $affiliate_id = $request->input("subject_id");
            $start_date = $request->input("start_date");
            $end_date = $request->input("end_date");

            $result = ReportModel::financialReport($backoffice_session_id, $affiliate_id, $start_date, $end_date);
            $resultResult = $result["report"];
            $resultResult2 = $result["report2"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $resultProcessed2 = array();
            $i = 0;

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $resultProcessed[$i]["currency"] = $r->currency;
                    $resultProcessed[$i]["subject_name_for"] = $r->subject_name_for;
                    $resultProcessed[$i]["no_of_deactivated_tickets"] = $r->no_of_deactivated_tickets;
                    $resultProcessed[$i]["no_of_deactivated_tickets_formatted"] = NumberHelper::format_double($r->no_of_deactivated_tickets);

                    $resultProcessed[$i]["no_of_win_not_paid_out_cashier"] = $r->no_of_win_not_paid_out_cashier;
                    $resultProcessed[$i]["sum_of_win_not_paid_out_cashier"] = NumberHelper::format_double($r->sum_of_win_not_paid_out_cashier);

                    $resultProcessed[$i]["no_of_deposits"] = $r->no_of_deposits;
                    $resultProcessed[$i]["no_of_deposits_formatted"] = NumberHelper::format_double($r->no_of_deposits);
                    $resultProcessed[$i]["sum_deposits"] = $r->sum_deposits;
                    $resultProcessed[$i]['sum_deposits_formatted'] = NumberHelper::format_double($r->sum_deposits);
                    $resultProcessed[$i]["no_of_tickets"] = $r->no_of_tickets;
                    $resultProcessed[$i]["no_of_tickets_formatted"] = NumberHelper::format_double($r->no_of_tickets);
                    $resultProcessed[$i]["no_of_cashier_deposits"] = $r->no_of_cashier_deposits;
                    $resultProcessed[$i]["no_of_cashier_deposits_formatted"] = NumberHelper::format_double($r->no_of_cashier_deposits);
                    $resultProcessed[$i]["sum_cashier_deposits"] = $r->sum_cashier_deposits;
                    $resultProcessed[$i]['sum_cashier_deposits_formatted'] = NumberHelper::format_double($r->sum_cashier_deposits);
                    $resultProcessed[$i]["no_of_online_deposits"] = $r->no_of_online_deposits;
                    $resultProcessed[$i]['no_of_online_deposits_formatted'] = NumberHelper::format_double($r->no_of_online_deposits);
                    $resultProcessed[$i]["sum_of_online_deposits"] = $r->sum_of_online_deposits;
                    $resultProcessed[$i]['sum_of_online_deposits_formatted'] = NumberHelper::format_double($r->sum_of_online_deposits);
                    $resultProcessed[$i]["sum_canceled_deposits"] = $r->sum_canceled_deposits;
                    $resultProcessed[$i]['sum_canceled_deposits_formatted'] = NumberHelper::format_double($r->sum_canceled_deposits);
                    $resultProcessed[$i]["no_of_payed_out_tickets"] = $r->no_of_payed_out_tickets;
                    $resultProcessed[$i]['no_of_payed_out_tickets_formatted'] = NumberHelper::format_double($r->no_of_payed_out_tickets);
                    $resultProcessed[$i]["sum_of_payed_out_tickets"] = $r->sum_of_payed_out_tickets;
                    $resultProcessed[$i]['sum_of_payed_out_tickets_formatted'] = NumberHelper::format_double($r->sum_of_payed_out_tickets);
                    $resultProcessed[$i]["no_of_payed_out_tickets_cashier"] = $r->no_of_payed_out_tickets_cashier;
                    $resultProcessed[$i]['no_of_payed_out_tickets_cashier_formatted'] = NumberHelper::format_double($r->no_of_payed_out_tickets_cashier);
                    $resultProcessed[$i]["sum_of_payed_out_tickets_cashier"] = $r->sum_of_payed_out_tickets_cashier;
                    $resultProcessed[$i]['sum_of_payed_out_tickets_cashier_formatted'] = NumberHelper::format_double($r->sum_of_payed_out_tickets_cashier);
                    $resultProcessed[$i]["no_of_payed_out_tickets_online"] = $r->no_of_payed_out_tickets_online;
                    $resultProcessed[$i]['no_of_payed_out_tickets_online_formatted'] = NumberHelper::format_double($r->no_of_payed_out_tickets_online);
                    $resultProcessed[$i]["sum_of_payed_out_tickets_online"] = $r->no_of_payed_out_tickets;
                    $resultProcessed[$i]['sum_of_payed_out_tickets_online_formatted'] = NumberHelper::format_double($r->sum_of_payed_out_tickets_online);
                    $resultProcessed[$i]["neto"] = $r->neto;
                    $resultProcessed[$i]["neto_formatted"] = NumberHelper::format_double($r->neto);
                    if(!isset($r->rec_tmstp_day)){
                        $resultProcessed[$i]["total_date"] = "total";
                    }else{
                        $resultProcessed[$i]["total_date"] = $r->rec_tmstp_day;
                    }
                    $i++;
                }

                $i = 0;

                foreach ($resultResult2 as $r){
                    $resultProcessed2[$i]["transaction_id"] = $r->transaction_id;
                    $resultProcessed2[$i]["currency"] = $r->currency;
                    $resultProcessed2[$i]["transaction_from"] = $r->transaction_from;
                    $resultProcessed2[$i]["date"] = $r->rec_tmstp;
                    $resultProcessed2[$i]["amount"] = $r->amount;
                    $resultProcessed2[$i]['transaction_type'] = $r->transaction_type;
                    $resultProcessed2[$i]["transaction_sign"] = $r->transaction_sign;

                    if($r->transaction_sign == 1){
                        $resultProcessed2[$i]["amountDeposit"] =  $r->amount * $r->transaction_sign;
                        $resultProcessed2[$i]["amountWithdraw"] = 0;
                        $resultProcessed2[$i]["amountDepositFormatted"] = NumberHelper::format_double($r->amount);
                        $resultProcessed2[$i]["amountWithdrawFormatted"] = NumberHelper::format_double(0);
                    }elseif ($r->transaction_sign == -1){
                        $resultProcessed2[$i]["amountWithdraw"] = $r->amount * $r->transaction_sign;
                        $resultProcessed2[$i]["amountDeposit"] = 0;
                        $resultProcessed2[$i]["amountWithdrawFormatted"] = NumberHelper::format_double($r->amount);
                        $resultProcessed2[$i]["amountDepositFormatted"] = NumberHelper::format_double(0);
                    }

                    $resultProcessed2[$i]["start_credits"] = $r->start_credits;
                    $resultProcessed2[$i]["start_credits_formatted"] = NumberHelper::format_double($r->start_credits);
                    $resultProcessed2[$i]["end_credits"] = $r->end_credits;
                    $resultProcessed2[$i]["end_credits_formatted"] = NumberHelper::format_double($r->end_credits);
                    $resultProcessed2[$i]['barcode'] = $r->barcode;
                    $resultProcessed2[$i]["transaction_to"] = $r->transaction_to;
                    $resultProcessed2[$i]["parent"] = $r->parent;
                    $resultProcessed2[$i]["date_formatted"] = $r->rec_tmstp_formated;
                    $resultProcessed2[$i]['subject_id_from'] = $r->subject_id_from;
                    $resultProcessed2[$i]["subject_id_to"] = $r->subject_id_to;
                    $resultProcessed2[$i]["session_id"] = $r->session_id;
                    if(isset($r->serial_number))
                        $resultProcessed2[$i]["serial_number"] = $r->serial_number;
                    else
                        $resultProcessed2[$i]["serial_number"] = "";

                    $i++;
                }

                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                    "result2" => $resultProcessed2,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function ticketDetailsPerDrawAjax(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $ticket_serial_number = $request->get('ticket_serial_number');

        $resultCheckTicketDetails = ReportModel::listReportTicketDetailsPerDraw($backoffice_session_id, $ticket_serial_number);
        $result = array();
        $laravelLocalized = new LaravelLocalization();
        $url = "/report/draw-details/draw_id/";

        $i = 0;
        foreach ($resultCheckTicketDetails["report"] as $row){
            $result[$i]["link"] = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$row->draw_id);
            $result[$i]["barcode"]=$row->barcode;
            $result[$i]["bet_per_draw"]= NumberHelper::format_double($row->bet_per_draw);
            $result[$i]["bet_per_ticket"]= NumberHelper::format_double($row->bet_per_ticket);
            $result[$i]["cashier_name"]=$row->cashier_name;
            $result[$i]["created_by"]=$row->created_by;
            $result[$i]["currency"]=$row->currency;
            $result[$i]["draw_date_time"]=$row->draw_date_time;
            $result[$i]["draw_id"]=$row->draw_id;
            $result[$i]["draw_serial_numer"]=$row->draw_serial_numer;
            $result[$i]["executed_win"]= NumberHelper::format_double($row->executed_win);
            $result[$i]["global_jp_code"]=$row->global_jp_code;
            $result[$i]["jackpot_win"]=$row->jackpot_win;
            $result[$i]["local_jp_code"]=$row->local_jp_code;
            $result[$i]["location_name"]=$row->location_name;
            $result[$i]["player_name"]=$row->player_name;
            $result[$i]["possible_win"]= NumberHelper::format_double($row->possible_win);
            $result[$i]["serial_number"]=$row->serial_number;
            $result[$i]["ticket_id"]=$row->ticket_id;
            $result[$i]["ticket_rec_tmstp"]=$row->ticket_rec_tmstp;
            $result[$i]["ticket_repeat_no"]=$row->ticket_repeat_no;
            $result[$i]["ticket_status"]=$row->ticket_status;
            $i++;
        }
        $i = 0;

        return response()->json([
            "status" => "OK",
            "result" => $result
        ]);
    }

    public function ticketDetailsPerDraw(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $ticket_serial_number = $request->get('ticket_serial_number');

        if(strlen($ticket_serial_number) != 0) {
            $resultCheckTicketDetails = ReportModel::listReportTicketDetailsPerDraw($backoffice_session_id, $ticket_serial_number);
        }else{
            $resultCheckTicketDetails = array();
        }
		//dd($resultCheckTicketDetails);

        if($request->has('small')){
            $view_name = '/authenticated/report/ticket-details-per-draw-small';
        }
        else if($request->has('large')){
            $view_name = '/authenticated/report/ticket-details-per-draw';
        }else {
            $view_name = $request->exists('large_tag') ? '/authenticated/report/ticket-details-per-draw' : '/authenticated/report/ticket-details-per-draw-small';
        }

        return view(
            $view_name,
            [
                "list_report" => $resultCheckTicketDetails['report']
            ]
            /*[
                "ticket_id" => $ticket_id,
                "ticket_result" => isset($resultCheckTicketDetails["ticket_result"]) ? $resultCheckTicketDetails['ticket_result'] : array(),
				"combinations_result" => isset($resultCheckTicketDetails["combinations_result"]) ? $resultCheckTicketDetails['combinations_result'] : array(),
            ]*/
        );
    }

    public function ticketDetails($ticket_serial_number, Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $user_affiliate_id = $authSessionData['user_id'];

        if(strlen($ticket_serial_number) != 0) {
            //$resultCheckTicketDetails = TicketModel::ticketDetails($backoffice_session_id, $ticket_id);
            $resultCheckTicketDetails = TicketModel::checkTicketDetailsWithSerialNumber($backoffice_session_id, $ticket_serial_number);
        }else{
            $resultCheckTicketDetails = array();
        }
		//dd($resultCheckTicketDetails["ticket_result"][0]->first_draw_sn);

        $view_result = [
            "ticket_serial_number" => $ticket_serial_number,
            "ticket_result" => isset($resultCheckTicketDetails["ticket_result"]) ? $resultCheckTicketDetails['ticket_result'] : array(),
            "combinations_result" => isset($resultCheckTicketDetails["combinations_result"]) ? $resultCheckTicketDetails['combinations_result'] : array(),
        ];

        //dd($view_result);

        return view(
            '/authenticated/report/ticket-details',
            $view_result
        );
    }

    public function ticketDrawDetails($ticket_serial_number, $draw_serial_number, $draw_id, Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $user_affiliate_id = $authSessionData['user_id'];

        if(strlen($ticket_serial_number) != 0 && strlen($draw_serial_number) != 0) {
            $resultCheckDrawDetails = ReportModel::listReportTicketSubdetailsPerDraw($backoffice_session_id, $ticket_serial_number, $draw_serial_number);
            //$resultCheckDrawDetails = array();
        }else {
            $resultCheckDrawDetails = array();
        }
        //dd($resultCheckDrawDetails);

        if(strlen($draw_id) != 0) {
            $resultCheckListDrawDetails = DrawModel::drawDetails($backoffice_session_id, $user_affiliate_id, $draw_id);
        }else{
            $resultCheckListDrawDetails = array();
        }

        $view_result = [
            "ticket_serial_number" => $ticket_serial_number,
            "draw_serial_number" => $draw_serial_number,
            "draw_id" => $draw_id,
            "list_report" => isset($resultCheckDrawDetails["report"]) ? $resultCheckDrawDetails['report'] : array(),
            "draw_result" => isset($resultCheckListDrawDetails["draw_result"]) ? $resultCheckListDrawDetails['draw_result'] : array(),
        ];

        //dd($view_result);

        return view(
            '/authenticated/report/ticket-draw-details',
            $view_result
        );
    }

    public function drawDetails($draw_id, Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $user_affiliate_id = $authSessionData['user_id'];
        $result = array();

        if(strlen($draw_id) != 0) {
            $resultCheckDrawDetails = DrawModel::drawDetails($backoffice_session_id, $user_affiliate_id, $draw_id);
        }else{
            $resultCheckDrawDetails = array();
        }

        $payTable = TicketModel::payTable();

        $arrayHelper = new ArrayHelper();

        $i = 0;
        foreach ($resultCheckDrawDetails["draw_result"] as $r){
            $result[$i]["draw_id"] = $r->draw_id;
            $result[$i]["super_draw"] = $r->super_draw;

            if($r->super_draw == 1){
                $result[$i]["super_draw_yes_no"] = "<span class = 'label label-success'>".trans("authenticated.Yes")."</span>";
            }else{
                $result[$i]["super_draw_yes_no"] = "<span class = 'label label-danger'>".trans("authenticated.No")."</span>";
            }
            
            $result[$i]["date_time"] = $r->date_time;
            $result[$i]["order_num"] = $r->order_num;
            $chosen_numbers = $r->chosen_numbers;
            $result[$i]["chosen_numbers"] = $chosen_numbers;
            $result[$i]["feed_id"] = $r->feed_id;
            $result[$i]["subject_id"] = $r->subject_id;
            $result[$i]["draw_status"] = $r->draw_status;
            $result[$i]["date_time"] = $r->date_time;
            $result[$i]["rec_edit_tmstp"] = $r->rec_edit_tmstp;
            $stars = $r->stars;
            $stars = str_replace(","," ; ", $stars);
            $result[$i]["stars"] = $stars;
            $result[$i]["jackpot_code"] = $r->jackpot_code;
            $result[$i]["draw_model_id"] = $r->draw_model_id;
            $result[$i]["draw_model"] = $r->draw_model;
            $result[$i]["rec_sts"] = $r->rec_sts;
            $result[$i]["rec_tmstp"] = $r->rec_tmstp;
            $result[$i]["currency"] = $r->currency;
            $result[$i]["win_to_pay_out"] = $r->win_to_pay_out;
            $result[$i]["date_time_formated"] = $r->date_time_formated;
            $chosen_numbers_array = explode(",", $chosen_numbers);
            $chosen_numbers_array_count = 0;
            $first_five_numbers = array_slice($chosen_numbers_array, 0, 5, true);
            $first_five_numbers_sum = array_sum($first_five_numbers);
            $first_five_numbers_sum_flag = "";
            $first_ball_flag = "";
            $first_ball_odd_even_flag = "";
            $first_five_even = 0;
            $first_five_odd = 0;

            foreach($first_five_numbers as $num){
                if($num % 2 == 0)
                    $first_five_even++;
                else
                    $first_five_odd++;
            }

             if($first_five_numbers_sum < NUMBER_SUM_LIMIT)
                 $first_five_numbers_sum_flag = trans("authenticated.Under");
             elseif ($first_five_numbers_sum > NUMBER_SUM_LIMIT)
                 $first_five_numbers_sum_flag = trans("authenticated.Over");

            if($chosen_numbers_array[0] < NUMBER_LIMIT)
                $first_ball_flag = trans("authenticated.Under");
            elseif ($chosen_numbers_array[0] > NUMBER_LIMIT)
                $first_ball_flag = trans("authenticated.Over");

            if($chosen_numbers_array[0] % 2 == 0)
                $first_ball_odd_even_flag = trans("authenticated.Even");
            else
                $first_ball_odd_even_flag = trans("authenticated.Odd");

            $result[$i]["first_five_numbers"] = $first_five_numbers;
            $result[$i]["first_five_numbers_sum"] = $first_five_numbers_sum;
            $result[$i]["first_five_numbers_sum_flag"] = $first_five_numbers_sum_flag;
            $result[$i]["first_ball_flag"] = $first_ball_flag;
            $result[$i]["first_ball_odd_even_flag"] = $first_ball_odd_even_flag;
            $result[$i]["more_even_odd_first_five"] = ($first_five_even>$first_five_odd)? trans("authenticated.Even") : trans("authenticated.Odd");

            $red = 0;
            $red_array = array();
            $blue = 0;
            $blue_array = array();
            $green = 0;
            $green_array = array();
            $purple = 0;
            $purple_array = array();
            $yellow = 0;
            $yellow_array = array();
            $orange = 0;
            $orange_array = array();
            $brown = 0;
            $brown_array = array();
            $black = 0;
            $black_array = array();
            $evenBalls = 0;
            $oddBalls = 0;

            $chosen_numbers_colorful_array = array();

            foreach ($chosen_numbers_array as $row){
                $chosen_numbers_array_count++;

                if($row % 2 == 0)
                    $evenBalls++;
                else
                    $oddBalls++;

                if(in_array($row, config("constants.RED_BALL"))){
                    $element = '<label style="color: #ED1C24">'.$row.'</label>';
                    array_push($chosen_numbers_colorful_array, $element);
                    array_push($red_array, $row);
                    $red++;
                }elseif(in_array($row, config("constants.GREEN_BALL"))){
                    $element = '<label style="color: #0B9444">'.$row.'</label>';
                    array_push($chosen_numbers_colorful_array, $element);
                    array_push($green_array, $row);
                    $green++;
                }elseif(in_array($row, config("constants.BLUE_BALL"))){
                    $element = '<label style="color: #152987">'.$row.'</label>';
                    array_push($chosen_numbers_colorful_array, $element);
                    array_push($blue_array, $row);
                    $blue++;
                }elseif(in_array($row, config("constants.PURPLE_BALL"))){
                    $element = '<label style="color: #6250A2">'.$row.'</label>';
                    array_push($chosen_numbers_colorful_array, $element);
                    array_push($purple_array, $row);
                    $purple++;
                }elseif(in_array($row, config("constants.YELLOW_BALL"))){
                    $element = '<label style="color: #C9D436">'.$row.'</label>';
                    array_push($chosen_numbers_colorful_array, $element);
                    array_push($yellow_array, $row);
                    $yellow++;
                }elseif(in_array($row, config("constants.ORANGE_BALL"))){
                    $element = '<label style="color: #D96427">'.$row.'</label>';
                    array_push($orange_array, $row);
                    array_push($chosen_numbers_colorful_array, $element);
                    $orange++;
                }elseif(in_array($row, config("constants.BROWN_BALL"))){
                    $element = '<label style="color: #693E17">'.$row.'</label>';
                    array_push($chosen_numbers_colorful_array, $element);
                    array_push($brown_array, $row);
                    $brown++;
                }elseif(in_array($row, config("constants.BLACK_BALL"))){
                    $element = '<label style="color: #000000">'.$row.'</label>';
                    array_push($chosen_numbers_colorful_array, $element);
                    array_push($black_array, $row);
                    $black++;
                }
            }

            $result[$i]["chosen_numbers_colorful_array"] = $chosen_numbers_colorful_array;
            $result[$i]["chosen_numbers_array"] = $chosen_numbers_array;
            $result[$i]["number_of_even_balls"] = $evenBalls;
            $result[$i]["number_of_odd_balls"] = $oddBalls;
            $result[$i]["more_even_odd"] = ($evenBalls>$oddBalls)? trans("authenticated.Even") : trans("authenticated.Odd");

            $colorsArray = array();
            $numberr = array();

            if($red == 6){
                $last_ball = end($red_array);
                array_push($colorsArray, array("color_name"=>trans("authenticated.RED"), "number" => $red, "color" => "#ED1C24", "last_ball" => $last_ball));
            }if ($blue == 6){
                $last_ball = end($blue_array);
                array_push($colorsArray, array("color_name"=>trans("authenticated.BLUE"), "number" => $blue, "color" => "#152987", "last_ball" => $last_ball));
            }if ($green == 6){
                $last_ball = end($green_array);
                array_push($colorsArray, array("color_name"=>trans("authenticated.GREEN"), "number" => $green, "color" => "#0B9444", "last_ball" => $last_ball));
            }if ($yellow == 6){
                $last_ball = end($yellow_array);
                array_push($colorsArray, array("color_name"=>trans("authenticated.YELLOW"), "number" => $yellow, "color" => "#C9D436", "last_ball" => $last_ball));
            }if ($black == 6){
                $last_ball = end($black_array);
                array_push($colorsArray, array("color_name"=>trans("authenticated.BLACK"), "number" => $black, "color" => "#000000", "last_ball" => $last_ball));
            }if ($brown == 6){
                $last_ball = end($brown_array);
                array_push($colorsArray, array("color_name"=>trans("authenticated.BROWN"), "number" => $brown, "color" => "#693E17", "last_ball" => $last_ball));
            }if ($purple == 6){
                $last_ball = end($purple_array);
                array_push($colorsArray, array("color_name"=>trans("authenticated.PURPLE"), "number" => $purple, "color" => "#6250A2", "last_ball" => $last_ball));
            }if ($orange == 6){
                $last_ball = end($orange_array);
                array_push($colorsArray, array("color_name"=>trans("authenticated.ORANGE"), "number" => $orange, "color" => "#D96427", "last_ball" => $last_ball));
            }

            /*foreach ($colorsArray as $key => $row)
            {
                $numberr[$key] = $row['number'];
            }
            array_multisort($numberr, SORT_DESC, $colorsArray);*/

            $result[$i]["colors_array"] = $colorsArray;

            $result[$i]["first_ball"] = $chosen_numbers_array[0];

            $firstBallProperties = $arrayHelper->determineBallColor($chosen_numbers_array[0]);
            $firstBallColor = $firstBallProperties["color"];
            $firstBallColorName = $firstBallProperties["color_name"];

            $result[$i]["first_ball_color"] = $firstBallColor;
            $result[$i]["first_ball_color_name"] = $firstBallColorName;

            $result[$i]["last_ball"] = $chosen_numbers_array[$chosen_numbers_array_count-1];

            $last_five_numbers = array_slice($chosen_numbers_array, $chosen_numbers_array_count-5, $chosen_numbers_array_count-1, true);
            $last_five_numbers_sum = array_sum($last_five_numbers);
            $last_five_numbers_sum_flag = "";
            $last_ball_flag = "";
            $last_ball_odd_even_flag = "";

            if($last_five_numbers_sum < NUMBER_SUM_LIMIT)
                $last_five_numbers_sum_flag = trans("authenticated.Under");
            elseif ($last_five_numbers_sum > NUMBER_SUM_LIMIT)
                $last_five_numbers_sum_flag = trans("authenticated.Over");

            if($chosen_numbers_array[$chosen_numbers_array_count-1] < NUMBER_LIMIT)
                $last_ball_flag = trans("authenticated.Under");
            elseif ($chosen_numbers_array[$chosen_numbers_array_count-1] > NUMBER_LIMIT)
                $last_ball_flag = trans("authenticated.Over");

            if($chosen_numbers_array[$chosen_numbers_array_count-1] % 2 == 0)
                $last_ball_odd_even_flag = trans("authenticated.Even");
            else
                $last_ball_odd_even_flag = trans("authenticated.Odd");

            $result[$i]["last_five_numbers"] = $last_five_numbers;
            $result[$i]["last_five_numbers_sum"] = $last_five_numbers_sum;
            $result[$i]["last_five_numbers_sum_flag"] = $last_five_numbers_sum_flag;
            $result[$i]["last_ball_flag"] = $last_ball_flag;
            $result[$i]["last_ball_odd_even_flag"] = $last_ball_odd_even_flag;

            $lastBallProperties = $arrayHelper->determineBallColor($chosen_numbers_array[$chosen_numbers_array_count-1]);
            $lastBallColor = $lastBallProperties["color"];
            $lastBallColorName = $lastBallProperties["color_name"];

            $result[$i]["last_ball_color"] = $lastBallColor;
            $result[$i]["last_ball_color_name"] = $lastBallColorName;

            $i++;
        }
        $i = 0;

        return view(
            '/authenticated/report/draw-details',
            [
                "draw_id" => $draw_id,
                "draw_result" => $result,
                "payTable" => $payTable["payTable"],
                "coefficients" => $payTable["coefficients"],
                "jp_codes_result" => $resultCheckDrawDetails["jp_codes_result"]
            ]
        );
    }

    public function drawList(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $user_affiliate_id = $authSessionData['user_id'];
        $parent_affiliate_id = $authSessionData['parent_id'];

        $affiliate_id = $request->get('affiliate_id', $parent_affiliate_id); //id affiliate-a za koga listas
        $number_of_results = $request->get('number_of_results', ResultLimitHelper::getDefaultLimit());

        $resultListFilterUsers = CustomerModel::listCustomers($backoffice_session_id);
        $list_filter_users = [];
        foreach($resultListFilterUsers['list_customers'] as $user){
            $list_filter_users[$user->subject_id] = $user->username;
        }

        if(strlen($affiliate_id) == 0){
            $affiliate_id = $parent_affiliate_id;
        }

        $limitResult = ResultLimitHelper::listLimitsPerPageAndUpdate($number_of_results);

        $resultDrawListResult = ReportModel::listPreviousDrawsReport($backoffice_session_id, $user_affiliate_id, $affiliate_id, $number_of_results);

        //dd($resultDrawListResult);

        return view(
            '/authenticated/report/draw-list',
            [
                "list_report" => $resultDrawListResult['report'],
                "list_filter_users" => $list_filter_users,
                "affiliate_id" => $affiliate_id,
                "number_of_results_array" => $limitResult['limits'],
                "default_limit_per_page" => $number_of_results
            ]
        );
    }

    public function listAffiliates(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $session_id = $authSessionData['backoffice_session_id'];
            $result = CustomerModel::listCustomers($session_id);

            if($result["status"] == "OK"){
                return response()->json([
                    "status" => $result["status"],
                    "result" => $result["list_customers"],
                ]);
            }else{
                return response()->json([
                    "status" => $result["status"],
                    "result" => null
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function ticketStatusesList(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $session_id = $authSessionData['backoffice_session_id'];

            $result = array();

            $resultTicketStatuses = TicketModel::listTicketStatuses($session_id);
            $result = array();
            foreach($resultTicketStatuses['ticket_statuses'] as $ticket){
                $result[$ticket->ticket_status] = __("authenticated." . $ticket->ticket_status_desc);
            }

            return response()->json([
                "status" => $resultTicketStatuses["status"],
                "result" => $result,
            ]);

            /*if($resultDrawListResult["status"] == "OK"){
                $i = 0;
                foreach($resultDrawListResult["report"] as $row){
                    $link = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$row->draw_id);

                    $result[$i]["draw_id"] = $row->draw_id;
                    $result[$i]["order_num"] = $row->order_num;
                    $result[$i]["date_time"] = $row->date_time;
                    $result[$i]["draw_date_time_formated"] = $row->draw_date_time_formated;
                    $result[$i]["number_of_tickets_for_draw"] = $row->number_of_tickets_for_draw;
                    $result[$i]["sum_bet_for_draw"] = NumberHelper::format_double($row->sum_bet_for_draw);
                    $result[$i]["sum_win_for_draw"] = NumberHelper::format_double($row->sum_win_for_draw);
                    $result[$i]["draw_model"] = $row->draw_model;
                    $result[$i]["currency"] = $row->currency;
                    $result[$i]["draw_status"] = $row->draw_status;
                    if ($row->draw_status == 0){
                        $result[$i]["draw_status_formatted"] = "<label class='label label-info'>".trans("authenticated.IN PROGRESS")."</label>";
                    }elseif($row->draw_status == 1){
                        $result[$i]["draw_status_formatted"] = "<label class='label label-success'>".trans("authenticated.COMPLETED")."</label>";
                    }elseif($row->draw_status == -1) {
                        $result[$i]["draw_status_formatted"] = "<label class='label label-warning'>".trans("authenticated.SCHEDULED")."</label>";
                    }else{
                        $result[$i]["draw_status_formatted"] = "<label class='label label-danger'>".trans("authenticated.Not Set")."</label>";
                    }
                    $result[$i]["global_jp_win_amount"] = NumberHelper::format_double($row->global_jp_win_amount);
                    $result[$i]["local_jp_win_amount"] = NumberHelper::format_double($row->local_jp_win_amount);
                    $result[$i]["stars"] = $row->stars;
                    $result[$i]["super_draw_coeficient"] = $row->super_draw_coeficient;
                    $result[$i]["link"] = $link;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => $resultDrawListResult["status"],
                    "result" => $result,
                ]);
            }else{
                return response()->json([
                    "status" => $resultDrawListResult["status"],
                    "result" => null
                ]);
            }*/

        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function ticketList2(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $session_id = $authSessionData['backoffice_session_id'];
            $user_id = $authSessionData['user_id'];
            $parent_id = $authSessionData['parent_id'];

            $affiliate_id = $request->get('affiliate_id', $parent_id);
            $ticket_status = $request->get('ticket_status'); //-1 do 5 statusi
            $report_start_date = $request->get('report_start_date');
            $report_end_date = $request->get('report_end_date');

            $result = array();

            $resultListTicketReport = ReportModel::listLocationTickets($session_id, $user_id, $affiliate_id, $ticket_status, $report_start_date, $report_end_date);

            $localization = new LaravelLocalization();
            $url = "/ticket/ticket-details-with-serial-number/ticket_serial_number/";

            $i = 0;
            foreach($resultListTicketReport['report'] as $ticket){
                $result[$i]["link"] = $localization->getLocalizedURL($localization->getCurrentLocale(), $url.$ticket->serial_number);
                $result[$i]["ticket_id"] = $ticket->ticket_id;
                $result[$i]["serial_number"] = $ticket->serial_number;
                $result[$i]["rec_tmstp"] = $ticket->rec_tmstp;
                $result[$i]["rec_tmstp_formated"] = $ticket->rec_tmstp_formated;
                $result[$i]["currency"] = $ticket->currency;
                $result[$i]["created_by"] = $ticket->created_by;

                if($ticket->ticket_status == -1){
                    $result[$i]["ticket_status"] = '<span style="color: gray;">'.trans("authenticated.DEACTIVATED").'</span>';
                }elseif($ticket->ticket_status == 0){
                    $result[$i]["ticket_status"] = '<span style="">'.trans("authenticated.RESERVED").'</span>';
                }elseif($ticket->ticket_status == 1){
                    $result[$i]["ticket_status"] = '<span style="">'.trans("authenticated.PAID-IN").'</span>';
                }elseif($ticket->ticket_status == 2){
                    $result[$i]["ticket_status"] = '<span style="color: green;">'.trans("authenticated.WINNING").'</span>';
                }elseif($ticket->ticket_status == 3){
                    $result[$i]["ticket_status"] = '<span style="color: #97A230;">'.trans("authenticated.WINNING NOT PAID-OUT").'</span>';
                }elseif($ticket->ticket_status == 4){
                    $result[$i]["ticket_status"] = '<span style="color: green;">'.trans("authenticated.PAID-OUT").'</span>';
                }elseif($ticket->ticket_status == 5){
                    $result[$i]["ticket_status"] = '<span style="color: red;">'.trans("authenticated.LOSING").'</span>';
                }

                $result[$i]["bet_per_draw"] = NumberHelper::format_double($ticket->bet_per_draw);
                $result[$i]["bet_per_ticket"] = NumberHelper::format_double($ticket->bet_per_ticket);
                $result[$i]["possible_win"] = NumberHelper::format_double($ticket->possible_win);
                $result[$i]["win_paid_out"] = NumberHelper::format_double($ticket->win_paid_out);
                $result[$i]["executed_win"] = NumberHelper::format_double($ticket->executed_win);
                $result[$i]["ticket_repeat"] = $ticket->ticket_repeat;
                $result[$i]["first_draw_sn"] = $ticket->first_draw_sn;
                $result[$i]["draw_date_time"] = $ticket->draw_date_time;
                $result[$i]["draw_date_time_formated"] = $ticket->draw_date_time_formated;
                $result[$i]["player_name"] = $ticket->player_name;
                $result[$i]["cashier_name"] = $ticket->cashier_name;
                $result[$i]["location_name"] = $ticket->location_name;

                if(!isset($ticket->local_jp_code)){
                    $result[$i]["local_jp_code"] = "";
                }else{
                    $result[$i]["local_jp_code"] = $ticket->local_jp_code;
                }
                if(!isset($ticket->global_jp_code)){
                    $result[$i]["global_jp_code"] = "";
                }else{
                    $result[$i]["global_jp_code"] = $ticket->global_jp_code;
                }

                $result[$i]["super_draw_coeficient"] = $ticket->super_draw_coeficient;
                $result[$i]["super_draw"] = $ticket->super_draw;
                $result[$i]["combination_type_name"] = $ticket->combination_type_name;

                $combination_array = array();
                $combination_array = explode(",", $ticket->combination_type_name);
                $number_of_combinations = 0;
                $first_combination = $combination_array[0];

                foreach ($combination_array as $combination){
                    $number_of_combinations++;
                }
                $result[$i]["number_of_combinations"] = $number_of_combinations;
                $result[$i]["first_combination"] = $first_combination;

                $i++;
            }
            $i = 0;

            return response()->json([
                "status" => $resultListTicketReport["status"],
                "result" => $result
            ]);

            /*if($resultDrawListResult["status"] == "OK"){
                $i = 0;
                foreach($resultDrawListResult["report"] as $row){
                    $link = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$row->draw_id);

                    $result[$i]["draw_id"] = $row->draw_id;
                    $result[$i]["order_num"] = $row->order_num;
                    $result[$i]["date_time"] = $row->date_time;
                    $result[$i]["draw_date_time_formated"] = $row->draw_date_time_formated;
                    $result[$i]["number_of_tickets_for_draw"] = $row->number_of_tickets_for_draw;
                    $result[$i]["sum_bet_for_draw"] = NumberHelper::format_double($row->sum_bet_for_draw);
                    $result[$i]["sum_win_for_draw"] = NumberHelper::format_double($row->sum_win_for_draw);
                    $result[$i]["draw_model"] = $row->draw_model;
                    $result[$i]["currency"] = $row->currency;
                    $result[$i]["draw_status"] = $row->draw_status;
                    if ($row->draw_status == 0){
                        $result[$i]["draw_status_formatted"] = "<label class='label label-info'>".trans("authenticated.IN PROGRESS")."</label>";
                    }elseif($row->draw_status == 1){
                        $result[$i]["draw_status_formatted"] = "<label class='label label-success'>".trans("authenticated.COMPLETED")."</label>";
                    }elseif($row->draw_status == -1) {
                        $result[$i]["draw_status_formatted"] = "<label class='label label-warning'>".trans("authenticated.SCHEDULED")."</label>";
                    }else{
                        $result[$i]["draw_status_formatted"] = "<label class='label label-danger'>".trans("authenticated.Not Set")."</label>";
                    }
                    $result[$i]["global_jp_win_amount"] = NumberHelper::format_double($row->global_jp_win_amount);
                    $result[$i]["local_jp_win_amount"] = NumberHelper::format_double($row->local_jp_win_amount);
                    $result[$i]["stars"] = $row->stars;
                    $result[$i]["super_draw_coeficient"] = $row->super_draw_coeficient;
                    $result[$i]["link"] = $link;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => $resultDrawListResult["status"],
                    "result" => $result,
                ]);
            }else{
                return response()->json([
                    "status" => $resultDrawListResult["status"],
                    "result" => null
                ]);
            }*/

        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function drawList2(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $session_id = $authSessionData['backoffice_session_id'];
            $user_id = $authSessionData['user_id'];
            $parent_id = $authSessionData['parent_id'];

            $draw_model_id = $request->input("draw_model_id");
            $currency = $request->input("currency");
            $date_form = $request->input("date_from");
            $date_to = $request->input("date_to");
            $draw_id = $request->input("draw_id");
            $draw_sn = $request->input("draw_sn");
            $draw_status = $request->input("draw_status");
            $page_number = $request->input("page_number");
            $number_of_results = $request->input("number_of_results");

            $result = array();

            $resultDrawListResult = ReportModel::listPreviousDrawsReport2($session_id, $user_id, $parent_id, $draw_model_id, $currency, $date_form, $date_to, $draw_id,
                $draw_sn, $draw_status, $page_number, $number_of_results);

            $laravelLocalized = new LaravelLocalization();
            $url = "/report/draw-details/draw_id/";

            if($resultDrawListResult["status"] == "OK"){
                $i = 0;
                foreach($resultDrawListResult["report"] as $row){
                    $link = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$row->draw_id);

                    $result[$i]["draw_id"] = $row->draw_id;
                    $result[$i]["order_num"] = $row->order_num;
                    $result[$i]["date_time"] = $row->date_time;
                    $result[$i]["draw_date_time_formated"] = $row->draw_date_time_formated;
                    $result[$i]["number_of_tickets_for_draw"] = $row->number_of_tickets_for_draw;
                    $result[$i]["sum_bet_for_draw"] = NumberHelper::format_double($row->sum_bet_for_draw);
                    $result[$i]["sum_win_for_draw"] = NumberHelper::format_double($row->sum_win_for_draw);
                    $result[$i]["draw_model"] = $row->draw_model;
                    $result[$i]["currency"] = $row->currency;
                    $result[$i]["draw_status"] = $row->draw_status;
                    if ($row->draw_status == 0){
                        $result[$i]["draw_status_formatted"] = "<label class='label label-info'>".trans("authenticated.IN PROGRESS")."</label>";
                    }elseif($row->draw_status == 1){
                        $result[$i]["draw_status_formatted"] = "<label class='label label-success'>".trans("authenticated.COMPLETED")."</label>";
                    }elseif($row->draw_status == -1) {
                        $result[$i]["draw_status_formatted"] = "<label class='label label-warning'>".trans("authenticated.SCHEDULED")."</label>";
                    }else{
                        $result[$i]["draw_status_formatted"] = "<label class='label label-danger'>".trans("authenticated.Not Set")."</label>";
                    }
                    $result[$i]["global_jp_win_amount"] = NumberHelper::format_double($row->global_jp_win_amount);
                    $result[$i]["local_jp_win_amount"] = NumberHelper::format_double($row->local_jp_win_amount);
                    $result[$i]["stars"] = $row->stars;
                    $result[$i]["super_draw_coeficient"] = $row->super_draw_coeficient;
                    $result[$i]["link"] = $link;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => $resultDrawListResult["status"],
                    "result" => $result,
                ]);
            }else{
                return response()->json([
                    "status" => $resultDrawListResult["status"],
                    "result" => null
                ]);
            }

        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function listFinancialReportForUser(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $user_id = $request->get('user_id');
        $start_date = $request->get('report_start_date');
        $end_date = $request->get('report_end_date');

        if(strlen($user_id) != 0) {
            //$resultFinancialReportForUser = TicketModel::ticketDetails($backoffice_session_id, $ticket_id);
            $resultFinancialReportForUser = array();
        }else{
            $resultFinancialReportForUser = array();
        }
		//dd($resultCheckTicketDetails);

        return view(
            '/authenticated/report/list-financial-report-for-user',
            [
                "list_report" => array()
            ]
        );
    }

    public function listFinancialReportForUserSmall(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $user_id = $request->get('user_id');
        $start_date = $request->get('report_start_date');
        $end_date = $request->get('report_end_date');

        if(strlen($user_id) != 0) {
            //$resultFinancialReportForUser = TicketModel::ticketDetails($backoffice_session_id, $ticket_id);
            $resultFinancialReportForUser = array();
        }else{
            $resultFinancialReportForUser = array();
        }
		//dd($resultCheckTicketDetails);

        return view(
            '/authenticated/report/list-financial-report-for-user-small',
            [
                "list_report" => array()
            ]
        );
    }

    public function transactionReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $session_id = $authSessionData['backoffice_session_id'];
            $parent_id = $authSessionData['parent_id'];
            $user_id = $authSessionData['user_id'];
            $treeType = 2;

            $from_date = $request->input("from_date");
            $to_date = $request->input("to_date");
            $currency = $request->input("currency");

            $arr3 = array();

            $result = ReportModel::transactionReport($session_id, $parent_id, $from_date, $to_date, $currency);

            //var_dump($result);

            $i3 = 0;

            $laravelLocalized = new LaravelLocalization();
            $arrayHelper = new ArrayHelper();

            $financialUrl = "/report/financial-report";
            $collectorTransactionUrl = "/report/collector-transaction-report";
            $playerLiabilityUrl = "/report/player-liability-report";

            foreach($result['result'] as $data){
                $subject_type = $data->child_dtype;

                $properties = $arrayHelper->determineTreeGridProperties($subject_type);

                $url_disabled = $properties["url_disabled"];
                $url = $properties["url"];
                $color = $properties["color"];

                $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$data->child_id);

                $financialUrl2 = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $financialUrl);
                $collectorTransactionUrl2 = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $collectorTransactionUrl);
                $playerLiabilityUrl2 = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $playerLiabilityUrl);

                if($data->child_id == $parent_id){
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = 0;
                    $arr3[$i3]['parent_name'] = 0;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['subject_type_id'] = $subject_type;
                    $arr3[$i3]['subject_type_name'] = $data->subject_type_name;
                    $arr3[$i3]['subject_type_name_colourful'] = '<span style="color:'.$color.';">' .$data->subject_type_name. '</span>';

                    if($data->child_id == config("constants.ROOT_MASTER_ID") || $data->child_id == config("constants.LUCKY_SIX_ID")){
                        $arr3[$i3]['start_balance'] = NumberHelper::format_double($data->subject_from_start_credits);
                        $arr3[$i3]['profit_for_period'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Profit Transactions report for this subject in the selected period.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$financialUrl2.'\''.')">'.NumberHelper::format_double($data->profit_for_period).'</button>';
                        $arr3[$i3]['collected_on_entity'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Collector Transactions report for this subject in the selected period.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$collectorTransactionUrl2.'\''.')">'.NumberHelper::format_double($data->collected).'</button>';
                        $arr3[$i3]['end_balance'] = NumberHelper::format_double($data->end_credits);
                        $arr3[$i3]['actual_balance'] = NumberHelper::format_double($data->actual_credits);
                        $arr3[$i3]['player_liability'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Player Liability report for this subject.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$playerLiabilityUrl2.'\''.')">'.NumberHelper::format_double($data->player_liability).'</button>';
                        $arr3[$i3]['currency'] = $data->currency;
                    }else{
                        $arr3[$i3]['start_balance'] = NumberHelper::format_double($data->subject_from_start_credits);
                        $arr3[$i3]['profit_for_period'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Profit Transactions report for this subject in the selected period.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$financialUrl2.'\''.')">'.NumberHelper::format_double($data->profit_for_period).'</button>';
                        $arr3[$i3]['collected_on_entity'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Collector Transactions report for this subject in the selected period.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$collectorTransactionUrl2.'\''.')">'.NumberHelper::format_double($data->collected).'</button>';
                        $arr3[$i3]['end_balance'] = NumberHelper::format_double($data->end_credits);
                        $arr3[$i3]['actual_balance'] = NumberHelper::format_double($data->actual_credits);
                        $arr3[$i3]['player_liability'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Player Liability report for this subject.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$playerLiabilityUrl2.'\''.')">'.NumberHelper::format_double($data->player_liability).'</button>';
                        $arr3[$i3]['currency'] = $data->currency;
                    }
                }else{
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = $data->parent_id;
                    $arr3[$i3]['parent_name'] = $data->parent_name;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['subject_type_id'] = $subject_type;
                    $arr3[$i3]['subject_type_name'] = $data->subject_type_name;
                    $arr3[$i3]['subject_type_name_colourful'] = '<span style="color:'.$color.';">' .$data->subject_type_name. '</span>';

                    $arr3[$i3]['start_balance'] = NumberHelper::format_double($data->subject_from_start_credits);
                    $arr3[$i3]['profit_for_period'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Profit Transactions report for this subject in the selected period.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$financialUrl2.'\''.')">'.NumberHelper::format_double($data->profit_for_period).'</button>';
                    $arr3[$i3]['collected_on_entity'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Collector Transactions report for this subject in the selected period.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$collectorTransactionUrl2.'\''.')">'.NumberHelper::format_double($data->collected).'</button>';
                    $arr3[$i3]['end_balance'] = NumberHelper::format_double($data->end_credits);
                    $arr3[$i3]['actual_balance'] = NumberHelper::format_double($data->actual_credits);
                    $arr3[$i3]['player_liability'] = '<button style = "text-align: right !important;" data-toggle="tooltip" data-placement="right" title="'. __("authenticated.Show Player Liability report for this subject.") .'" class = "btn btn-default btn-block" onclick="openExternalReport('.$data->child_id.',\''.$playerLiabilityUrl2.'\''.')">'.NumberHelper::format_double($data->player_liability).'</button>';
                    $arr3[$i3]['currency'] = $data->currency;
                }
                $i3++;
            }

            //dd($result);

            $count = 0;
            foreach($arr3 as $r){
                $count++;
            }
            if($count > 1){
                $tree = $this->buildTree($arr3, 'parentId', 'id');
                $response = $tree;

                return response()->json(
                    [$response]
                );
            }elseif($count <= 1){
                return response()->json([
                    'result' => $arr3,
                    'status' => 1,
                    'count' => $count
                ]);
            }

        }catch(\PDOException $ex1){
            return response()->json([
            ]);
        }catch(\Exception $ex2){
            return response()->json([

            ]);
        }
    }

    public function financialReportSubjectTree(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $parent_id = $authSessionData['parent_id'];
            $user_id = $authSessionData['user_id'];
            $treeType = 2;
            $listType = $request->input("listType");

            $arr3 = array();

            $result = ReportModel::getSubjectTreeEntitiesAndCashiers($parent_id, $treeType, $listType);

            $i3 = 0;

            $laravelLocalized = new LaravelLocalization();

            foreach($result['result'] as $data){
                $subject_type = $data->child_dtype;
                $url = "";
                $url_disabled = true;
                if($subject_type == config('constants.ROLE_CLIENT')){
                    $url = "/structure-entity/update-entity/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_ADMINISTRATOR') || $subject_type == config('constants.ADMINISTRATOR_SYSTEM') || $subject_type == config('constants.ADMINISTRATOR_CLIENT') || $subject_type == config('constants.ADMINISTRATOR_LOCATION') || $subject_type == config('constants.ADMINISTRATOR_OPERATER')){
                    $url = "/administrator/update-administrator/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_LOCATION')){
                    $url = "/structure-entity/update-entity/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_OPERATER')){
                    $url = "/structure-entity/update-entity/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_CASHIER_TERMINAL') || $subject_type == config('constants.TERMINAL_TV')){
                    $url = "/terminal/details/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_PLAYER')){
                    $url = "/player/details/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_CASHIER')){
                    $url = "/cashier/update-cashier/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_COLLECTOR_LOCATION')){
                    $url = "/user/update-user/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_COLLECTOR_OPERATER')){
                    $url = "/user/update-user/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_COLLECTOR_CLIENT')){
                    $url = "/user/update-user/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_SUPPORT_CLIENT')){
                    $url = "/user/update-user/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_SUPPORT_SYSTEM')){
                    $url = "/user/update-user/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == config('constants.ROLE_SUPPORT_OPERATER')){
                    $url = "/user/update-user/user_id/";
                    $url_disabled = false;
                }elseif ($subject_type == "ROOT MASTER"){
                    $url = "";
                }

                $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$data->child_id);

                if($data->child_id == $parent_id){
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = 0;
                    $arr3[$i3]['parent_name'] = 0;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_id'] = $data->child_subject_type_id;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    if($url_disabled){
                        $arr3[$i3]['action_column'] = __("authenticated.No Details");
                    }else{
                        $arr3[$i3]['action_column'] = '<a href="'.$url.'">' . __("authenticated.View Details") . '</a>';
                    }
                }else{
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = $data->parent_id;
                    $arr3[$i3]['parent_name'] = $data->parent_name;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_id'] = $data->child_subject_type_id;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    if($url_disabled){
                        $arr3[$i3]['action_column'] = __("authenticated.No Details");
                    }else{
                        $arr3[$i3]['action_column'] = '<a href="'.$url.'">' . __("authenticated.View Details") . '</a>';
                    }
                }
                $i3++;
            }

            $count = 0;
            foreach($arr3 as $r){
                $count++;
            }
            if($count > 1){
                $tree = $this->buildTree($arr3, 'parentId', 'id');
                $response = $tree;

                return response()->json(
                    [$response]
                );
                /*return response()->json([
                    'result' => $list_affiliates,
                    'status' => 1,
                    'count' => $count
                ]);*/
            }elseif($count <= 1){
                return response()->json([
                    'result' => $arr3,
                    'status' => 1,
                    'count' => $count
                ]);
            }

        }catch(\PDOException $ex1){
            return response()->json([
            ]);
        }catch(\Exception $ex2){
            return response()->json([

            ]);
        }
    }

    function buildTree($flat, $pidKey, $idKey = null){
        $grouped = array();
        foreach ($flat as $sub){
            $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling[$idKey];
                if(isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }

            return $siblings;
        };
        $tree = $fnBuilder($grouped[0]);

        return $tree;
    }

    public function listLoginHistory(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $user_id = $authSessionData['user_id'];

        $start_date = $request->get('report_start_date', $authSessionData['report_start_date']);
        $end_date = $request->get('report_end_date', $authSessionData['report_end_date']);

        return view(
            '/authenticated/report/list-login-history',
            array(
				"user_id" => $user_id,
                "report_start_date" => $start_date,
                "report_end_date" => $end_date,
            )
        );
    }

    public function listLoginHistoryReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $affiliate_id = $request->input("subject_id");
            $start_date = $request->input("start_date");
            $end_date = $request->input("end_date");

            $result = ReportModel::listLoginHistory($backoffice_session_id, $affiliate_id, $start_date, $end_date);
            $resultResult = $result["report"];
            $resultStatus = $result["status"];

            $resultProcessed = array();

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $resultProcessed[] = [
                        "session_id"=>$r->session_id,
                        "start_date_time"=>$r->start_time_formated,
                        "end_date_time"=>$r->end_time_formated,
                        "duration"=>$r->duration,
                        "ip_address"=>$r->ip_address,
                        "city"=>$r->city,
                        "country"=>$r->country
                    ];
                }
                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function listAffiliateMonthlySummaryReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $session_id = $authSessionData['backoffice_session_id'];

            $result = array();

            $resultAffiliateMonthlySummaryReportResult = ReportModel::listAffiliateMonthlySummaryReport($session_id);

            if($resultAffiliateMonthlySummaryReportResult["status"] == "OK"){
                $i = 0;
                foreach($resultAffiliateMonthlySummaryReportResult["report"] as $row){
                    $result[$i]["affiliate_id"] = $row->aff_id;
                    $result[$i]["affiliate_name"] = $row->aff_name;
                    $result[$i]["cash_in"] = NumberHelper::format_double($row->cash_in);
                    $result[$i]["cash_out"] = NumberHelper::format_double($row->cash_out);
                    $result[$i]["difference"] = NumberHelper::format_double($row->difference);
                    $result[$i]["currency"] = $row->currency;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => $resultAffiliateMonthlySummaryReportResult["status"],
                    "result" => $result,
                ]);
            }else{
                return response()->json([
                    "status" => $resultAffiliateMonthlySummaryReportResult["status"],
                    "result" => null
                ]);
            }

        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function listShiftCashiers(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $session_id = $authSessionData['backoffice_session_id'];
            $subject_type_id = config("constants.SHIFT_CASHIER_TYPE_ID");
            $resultUsers = UserModel::searchUsers($session_id, null, null,
            null, null, null, null, null, null, null, $subject_type_id, null);

            if($resultUsers["status"] == "OK"){
                return response()->json([
                    "status" => $resultUsers["status"],
                    "result" => $resultUsers["list_users"],
                ]);
            }else{
                return response()->json([
                    "status" => $resultUsers["status"],
                    "result" => null
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }

    public function listCashierShiftReport(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $affiliate_id = $request->input("affiliate_id");
            $start_date = $request->input("report_start_date");
            $end_date = $request->input("report_end_date");
            $start = $request->input("start",10);
            $length = $request->input("length",10);
            $draw = $request->input("draw");

            $search_param = $request->input("search");
            $search_value = $search_param['value'];

            $sort_type = 'STRING';
            $order_direction = 'ASC';
            if($request->has('order')) {
                $order_param = $request->input("order");
                $order_column = $order_param[0]['column'];
                $order_direction = ($order_param[0]['dir'] == 'asc') ? 'ASC' : 'DESC';
            }

            $length = ($length == -1) ? $length = 1000000 : $length;

            if($start == 0){
                $page_number = 1;
            }else {
                $page_number = ($start / $length) == 0 ? 1 : ($start / $length) + 1;
            }

            $details = array(
                'backoffice_session_id' => $backoffice_session_id,
                'cashier_id' => $affiliate_id,
                'page_number' => $page_number,
                'number_of_results' => $length,
                'start_date' => $start_date,
                'end_date' => $end_date,
            );

            $result = ReportModel::listShiftCashierReport($details);
            $resultResult = $result["report"];
            $resultStatus = $result["status"];

            $resultProcessed = array();

            $number_of_pages = (ceil($result['records_total'] / $length)) == 0 ? 1 : (ceil($result['records_total'] / $length));

            if($resultStatus == "OK"){
                $recordsFiltered = $result['records_total'];
                foreach ($resultResult as $r){
                    if($search_value != "") {
                        if (stripos($r->cashier_username, $search_value) === 0 || stripos($r->location, $search_value) === 0) {
                            $resultProcessed[] = [
                                "cashier_username" => $r->cashier_username,
                                "location_username" => $r->location,
                                "shift_number" => $r->shift_no,
                                "shift_start_date" => $r->shift_start_time,
                                "start_balance" => NumberHelper::format_double($r->start_balance),
                                "shift_end_date" => $r->shift_end_time,
                                "end_balance" => NumberHelper::format_double($r->end_balance),
                                "currency" => $r->currency,
                                "cashier_id" => $r->cashier_id,
                                "location_id" => $r->location_id,
                            ];
                        } else {
                            $recordsFiltered--;
                        }
                    }else{
                        //dd($r);
                        $resultProcessed[] = [
                            "cashier_username" => $r->cashier_username,
                            "location_username" => $r->location,
                            "shift_number" => $r->shift_no,
                            "shift_start_date" => $r->shift_start_time,
                            "start_balance" => NumberHelper::format_double($r->start_balance),
                            "shift_end_date" => $r->shift_end_time,
                            "end_balance" => NumberHelper::format_double($r->end_balance),
                            "currency" => $r->currency,
                            "cashier_id" => $r->cashier_id,
                            "location_id" => $r->location_id,
                        ];
                    }
                }

                if($request->has('order')) {
                    $sort_type = 'STRING';
                    switch($order_column){
                        case 0: $key_name = 'cashier_username'; $sort_type = 'STRING'; break;
                        case 1: $key_name = 'location_username'; $sort_type = 'STRING'; break;
                        case 2: $key_name = 'shift_number'; $sort_type = 'INTEGER_NUMBER'; break;
                        case 3: $key_name = 'shift_start_date'; $sort_type = 'DATE_TIME'; break;
                        case 4: $key_name = 'start_balance'; $sort_type = 'DOUBLE_NUMBER'; break;
                        case 5: $key_name = 'shift_end_date'; $sort_type = 'DATE_TIME'; break;
                        case 6: $key_name = 'end_balance'; $sort_type = 'DOUBLE_NUMBER'; break;
                        case 7: $key_name = 'currency'; $sort_type = 'STRING'; break;
                    }
                    if($key_name != "") {
                        if($sort_type == 'STRING') {
                            $resultProcessed = ArrayHelper::sortDatatableReportString($resultProcessed, $key_name, $order_direction);
                        }
                        else if($sort_type == 'DOUBLE_NUMBER'){
                            $resultProcessed = ArrayHelper::sortDatatableReportNumberDouble($resultProcessed, $key_name, $order_direction);
                        }
                        else if($sort_type == 'INTEGER_NUMBER'){
                            $resultProcessed = ArrayHelper::sortDatatableReportNumberInteger($resultProcessed, $key_name, $order_direction);
                        }
                        else if($sort_type == 'DATE_TIME'){
                            $resultProcessed = ArrayHelper::sortDatatableReportDate($resultProcessed, $key_name, $order_direction);
                        }
                        else {

                        }
                        //$resultProcessed = ArrayHelper::aasort($resultProcessed, $key_name, $order_direction);
                        //$resultProcessed = ArrayHelper::sortMultiDimArray($resultProcessed, $key_name);
                    }
                }

                return response()->json([
                    "status" => "OK",
                    "draw" => $draw,
                    "data" => $resultProcessed,
                    "start" => $page_number,
                    "total_pages" => $number_of_pages,
                    "recordsTotal" => $result['records_total'],
                    "recordsFiltered" => $result['records_total'],
                    "search_value" => $search_value,
                    "key_name" => $key_name,
                    "sort_type" => $sort_type,
                    "order_direction" => $order_direction,
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "draw" => $draw,
                    "data" => array(0),
                    "start" => 1,
                    "total_pages" => 1,
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "draw" => $draw,
                "data" => array(0),
                "start" => 1,
                "total_pages" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "draw" => $draw,
                "data" => array(0),
                "start" => 1,
                "total_pages" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
            ]);
        }
    }

    public function historyOfPreferredTicketsReport(Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $start_date = $request->get('fromDate', date("d-M-Y", strtotime("-2 day", strtotime($authSessionData['report_end_date']))));
        $end_date = $request->get('toDate', $authSessionData['report_end_date']);

        $ticket_id = $request->get('ticket_id', null);
        $ticket_barcode = $request->get('ticket_barcode', null);
        $ticket_draw_id = $request->get('draw_id', null);
        $player_name = $request->get('player_name', null);
        $cashier_name = $request->get('cashier_name', null);
        $preferred_by = $request->get('preferred_by', null);

        $resultListCashiers = CashierModel::listCashiers($backoffice_session_id);

        $list_cashiers = array();

        foreach($resultListCashiers['list_cashiers'] as $cashier){
          $list_cashiers[$cashier->username] = $cashier->username;
        }

        $list_preferred_types = array(
            "1" => 'Small',
            "2" => 'Large',
            "-1" => 'Off'
        );

        $resultCheckTicketDetails = ReportModel::reportListAllPreferredTickets($backoffice_session_id, $start_date, $end_date, $ticket_id, $ticket_draw_id, $ticket_barcode,
            $player_name, $cashier_name, $preferred_by);

        //dd($resultCheckTicketDetails['ticket_result']);

        $view_name = 'authenticated/report.history-of-preferred-tickets';

        return view(
            $view_name,
            [
                "ticket_draw_id" => $ticket_draw_id,
                "ticket_id" => $ticket_id,
                "ticket_barcode" => $ticket_barcode,
                "player_name" => $player_name,
                "cashier_name" => $cashier_name,
                "preferred_by" => $preferred_by,
                "report_start_date" => $start_date,
                "report_end_date" => $end_date,

                //"list_players" => $list_players,

                "list_cashiers" => $list_cashiers,
                "list_tickets" => $resultCheckTicketDetails['ticket_result'],
                "list_preferred_types" => $list_preferred_types,
            ]
        );
    }

}
