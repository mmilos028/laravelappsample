<?php

namespace App\Http\Controllers\Authenticated;

use App\Helpers\NumberHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Carbon\Carbon;
use Session;
use App\Models\Postgres\ReportModel;
use Mail;
class TestingController extends Controller
{
    public function compareProfitAndCollected(Request $request){
        $authSessionData = Session::get('auth');
        $session_id = $authSessionData['backoffice_session_id'];
        $parent_id = $authSessionData['parent_id'];

        $from_date = Carbon::now()->firstOfMonth();
        $from_date_formatted = $from_date->toDateString("d-M-Y");

        $to_date = Carbon::now();
        $to_date_formatted = $to_date->toDateString("d-M-Y");

        $currency = "EUR";

        $profitAndCollectedReportResult = ReportModel::transactionReport($session_id, $parent_id, $from_date_formatted, $to_date_formatted, $currency);

        $notMatchingProfitTransactionsArray = array();
        $notMatchingCollectorTransactionsArray = array();
        $notMatchingPlayerLiabilityArray = array();
        $notMatchingAllTransactionsArray = array();
        $notMatchingCashierShiftReportArray = array();
        $nonCalculatedCashierShiftReportArray = array();

        foreach ($profitAndCollectedReportResult["result"] as $subject){
            $subject_id = $subject->child_id;
            $subject_type = $subject->child_dtype;
            $subject_profit_for_period = NumberHelper::format_double($subject->profit_for_period);
            $subject_collected = $subject->collected;
            $subject_actual_balance = $subject->actual_credits;

            //comparing Profit For Period with Netto on Profit Transactions report -------------------------------------
            $profitTransactionsReport = ReportModel::financialReport($session_id, $subject_id, $from_date_formatted, $to_date_formatted);
            $profitTransactionsReportResult = $profitTransactionsReport["report"];
            $subject_profit_for_period_2 = 0;
            $subject_profit_for_period_2_true = 0;

            foreach($profitTransactionsReportResult as $day){
                if ($day->rec_tmstp_day == null){
                    $subject_profit_for_period_2 = $day->neto;
                }else{
                    $subject_profit_for_period_2_true += $day->neto;
                }
            }

            $subject_profit_for_period_2 = NumberHelper::format_double($subject_profit_for_period_2);
            $subject_profit_for_period_2_true = NumberHelper::format_double($subject_profit_for_period_2_true);

            if($subject_profit_for_period != $subject_profit_for_period_2 || $subject_profit_for_period_2 != $subject_profit_for_period_2_true){
                $row = array();
                $row["profit_and_collected"] = $subject;
                $row["profit_transactions"] = array("netto" => $subject_profit_for_period_2, "true_netto" => $subject_profit_for_period_2_true);

                array_push($notMatchingProfitTransactionsArray, $row);
            }

            //comparing Collected On Entity Level with Total Collected on Collector Transactions report ----------------
            $collectorTransactionsReport = ReportModel::collectorTransactionsReport($session_id, $subject_id, $from_date_formatted, $to_date_formatted);
            $subject_2 = $collectorTransactionsReport["report2"];
            $subject_collected_2 = $subject_2[0]->total_collected;

            if($subject_collected != $subject_collected_2){
                $row = array();
                $row["profit_and_collected"] = $subject;
                $row["collector_transactions"] = $subject_2[0];

                array_push($notMatchingCollectorTransactionsArray, $row);
            }

            //comparing Actual Balance with End Balance on Cashier Shift report ----------------------------------------
            if($subject_type == config("constants.SHIFT_CASHIER")){
                $details = array(
                    'backoffice_session_id' => $session_id,
                    'cashier_id' => $subject_id,
                    'page_number' => 1,
                    'number_of_results' => 1000000,
                    'start_date' => $from_date_formatted,
                    'end_date' => $to_date_formatted,
                );

                $cashierShiftReport = ReportModel::listShiftCashierReport($details);
                $cashierShiftReportResult = $cashierShiftReport["report"];
                $endDate = $cashierShiftReportResult[0]->shift_end_time;


                if(isset($endDate)){
                    $endBalance = $cashierShiftReportResult[0]->end_balance;

                    if($subject_actual_balance != $endBalance){
                        $row = array();
                        $row["profit_and_collected"] = $subject;
                        $row["cashier_shift_report"] = $cashierShiftReportResult[0];

                        array_push($notMatchingCashierShiftReportArray, $row);
                    }
                }else{
                    $row = array();
                    $row["profit_and_collected"] = $subject;
                    $row["cashier_shift_report"] = $cashierShiftReportResult[0];

                    array_push($nonCalculatedCashierShiftReportArray, $row);
                }
            }
        }

        $emails = explode(",", config("mail.mail_error_to"));

        foreach ($emails as $email){
            Mail::send('authenticated/mail.compare_profit_and_collected',
                array(
                    "start_date" => $from_date_formatted,
                    "end_date" => $to_date_formatted,
                    'profit_transactions' => $notMatchingProfitTransactionsArray,
                    "collector_transactions" => $notMatchingCollectorTransactionsArray,
                    "cashier_shift_report" => array("calculated" => $notMatchingCashierShiftReportArray, "non_calculated" => $nonCalculatedCashierShiftReportArray)
                ),
                function($message) use ($email){
                    $message->to($email, 'Lucky6 Test - Profit & Collected ('.config("app.env").')')->subject('Lucky6 Test - Profit & Collected ('.config("app.env").')');
            });
        }

        return [
            "start_date" => $from_date_formatted,
            "end_date" => $to_date_formatted,
            'profit_transactions' => $notMatchingProfitTransactionsArray,
            "collector_transactions" => $notMatchingCollectorTransactionsArray,
            "cashier_shift_report" => array("calculated" => $notMatchingCashierShiftReportArray, "non_calculated" => $nonCalculatedCashierShiftReportArray)
        ];
    }
    public function compareProfitOverview(Request $request){
        $authSessionData = Session::get('auth');
        $session_id = $authSessionData['backoffice_session_id'];
        $parent_id = $authSessionData['parent_id'];

        $from_date = Carbon::now()->firstOfMonth();
        $from_date_formatted = $from_date->toDateString("d-M-Y");

        $to_date = Carbon::now();
        $to_date_formatted = $to_date->toDateString("d-M-Y");

        $profitOverviewReport = ReportModel::listAffiliateMonthlySummaryReport($session_id);
        $profitOverviewReportResult = $profitOverviewReport["report"];

        $notMatchingProfitTransactionsArray = array();

        foreach ($profitOverviewReportResult as $subject){
            $subject_id = $subject->aff_id;
            $subject_difference = $subject->difference;

            //comparing Difference with Netto on Profit Transactions report -------------------------------------
            $profitTransactionsReport = ReportModel::financialReport($session_id, $subject_id, $from_date_formatted, $to_date_formatted);
            $profitTransactionsReportResult = $profitTransactionsReport["report"];
            $subject_profit_for_period_2 = 0;
            $subject_profit_for_period_2_true = 0;

            foreach($profitTransactionsReportResult as $day){
                if ($day->rec_tmstp_day == null){
                    $subject_profit_for_period_2 = $day->neto;
                }else{
                    $subject_profit_for_period_2_true += $day->neto;
                }
            }

            $subject_profit_for_period_2 = NumberHelper::format_double($subject_profit_for_period_2);
            $subject_profit_for_period_2_true = NumberHelper::format_double($subject_profit_for_period_2_true);

            if($subject_difference != $subject_profit_for_period_2 || $subject_profit_for_period_2 != $subject_profit_for_period_2_true){
                $row = array();
                $row["profit_overview"] = $subject;
                $row["profit_transactions"] = array("netto" => $subject_profit_for_period_2, "true_netto" => $subject_profit_for_period_2_true);

                array_push($notMatchingProfitTransactionsArray, $row);
            }
        }

        $emails = explode(",", config("mail.mail_error_to"));

        foreach ($emails as $email){
            Mail::send('authenticated/mail.compare_profit_overview',
                array(
                    "start_date" => $from_date_formatted,
                    "end_date" => $to_date_formatted,
                    'profit_transactions' => $notMatchingProfitTransactionsArray,
                ),
                function($message) use ($email){
                    $message->to($email, 'Lucky6 Test - Profit Overview For Actual Month ('.config("app.env").')')->subject('Lucky6 Test - Profit Overview For Actual Month ('.config("app.env").')');
                });
        }

        return [
            "start_date" => $from_date_formatted,
            "end_date" => $to_date_formatted,
            'profit_transactions' => $notMatchingProfitTransactionsArray
        ];
    }
}
