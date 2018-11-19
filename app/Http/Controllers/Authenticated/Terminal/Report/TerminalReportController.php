<?php

namespace App\Http\Controllers\Authenticated\Terminal\Report;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

use App\Models\Postgres\TerminalModel;
use App\Models\Postgres\TerminalReportModel;
use App\Helpers\NumberHelper;

class TerminalReportController extends Controller
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

    public function listMoneyTransactions($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $start_date = $request->get('report_start_date', $authSessionData['report_start_date']);
        $end_date = $request->get('report_end_date', $authSessionData['report_end_date']);

        $terminalInformation = TerminalModel::terminalInformation($user_id);

        $resultListTransactions = TerminalReportModel::listSubjectMoneyTransactions($backoffice_session_id, $user_id, $start_date, $end_date);
		//dd($resultListTransactions);

        return view(
            '/authenticated/terminal/report/list-money-transactions',
            array(
				"user_id" => $user_id,
                "username" => $terminalInformation['user']['username'],
                "list_transactions" => $resultListTransactions['report_list_transactions'],
                "total_report" => $resultListTransactions['report_total'],
                "report_start_date" => $start_date,
                "report_end_date" => $end_date
            )
        );
    }
	
	public function listPlayerTickets($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $terminalInformation = TerminalModel::terminalInformation($user_id);

        $resultListPlayerTickets = TerminalReportModel::listPlayerTickets($backoffice_session_id, $user_id);
		//dd($resultListTransactions);

        return view(
            '/authenticated/terminal/report/list-player-tickets',
            array(
				"user_id" => $user_id,
                "username" => $terminalInformation['user']['username'],
                "list_tickets" => $resultListPlayerTickets['report']
            )
        );
    }

    public function listLoginHistory($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $terminalInformation = TerminalModel::terminalInformation($user_id);

        $start_date = $request->get('report_start_date', $authSessionData['report_start_date']);
        $end_date = $request->get('report_end_date', $authSessionData['report_end_date']);

        $resultListReport = TerminalReportModel::listPlayerLoginHistory($backoffice_session_id, $user_id, $start_date, $end_date);
        //$resultListReport = array();
		//dd($resultListReport["report"]);

        return view(
            '/authenticated/terminal/report/list-login-history',
            array(
				"user_id" => $user_id,
                "username" => $terminalInformation['user']['username'],
                "list_report" => $resultListReport['report'],
                "report_start_date" => $start_date,
                "report_end_date" => $end_date,
            )
        );
    }
}
