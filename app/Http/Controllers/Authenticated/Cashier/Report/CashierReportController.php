<?php

namespace App\Http\Controllers\Authenticated\Cashier\Report;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

use App\Models\Postgres\UserReportModel;
use App\Models\Postgres\UserModel;
use App\Helpers\NumberHelper;

class CashierReportController extends Controller
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

    public function listLoginHistory($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $userInformation = UserModel::userInformation($user_id);

        $start_date = $request->get('report_start_date', $authSessionData['report_start_date']);
        $end_date = $request->get('report_end_date', $authSessionData['report_end_date']);

        $resultListReport = UserReportModel::listLoginHistory($backoffice_session_id, $user_id, $start_date, $end_date);
        //$resultListReport = array();
		//dd($resultListReport["report"]);

        return view(
            '/authenticated/cashier/report/list-login-history',
            array(
				"user_id" => $user_id,
                "username" => $userInformation['user']['username'],
                "list_report" => $resultListReport['report'],
                "report_start_date" => $start_date,
                "report_end_date" => $end_date,
            )
        );
    }
}
