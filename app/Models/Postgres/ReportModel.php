<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\ResultLimitHelper;

class ReportModel
{

    private static $DEBUG = false;

    public static function allMachineKeysAndCodesReport($terminal_id, $machine_key){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::allMachineKeysAndCodesReport >>> SELECT core.get_all_maschine_keys_and_codes(:p_terminal_id = {$terminal_id},
                :p_maschine_key = {$machine_key}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_all_maschine_keys_and_codes(:p_terminal_id, :p_maschine_key)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_terminal_id' => $terminal_id,
                    'p_maschine_key' => $machine_key,
                )
            );
            $cursor_name1 = $fn_result[0]->cur_result_out ;

            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result1,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::allMachineKeysAndCodesReport(p_terminal_id={$terminal_id}, p_maschine_key={$machine_key}) <br />\n\n",
                "core.get_all_maschine_keys_and_codes(:p_terminal_id = {$terminal_id}, :p_maschine_key = {$machine_key}, 'cur_report_list') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::playerLiabilityReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}) <br />\n\n",
                "core.report_player_liability(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, 'cur_report_list') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function playerTransactionsReport($backoffice_session_id, $affiliate_id, $start_date, $end_date){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::playerTransactionsReport >>> SELECT core.report_player_transactions(:p_session_id_in = {$backoffice_session_id},
                :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_report_list')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.report_player_transactions(:p_session_id_in, :p_aff_id, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_aff_id' => $affiliate_id,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date,
                )
            );
            $cursor_name1 = $fn_result[0]->cur_report_list;

            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result1,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::playerTransactionsReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
                "core.report_player_transactions(:p_session_id_in = {$backoffice_session_id},
                :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_report_list') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::playerTransactionsReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
                "core.report_player_transactions(:p_session_id_in = {$backoffice_session_id},
                :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_report_list') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function playerLiabilityReport($backoffice_session_id, $affiliate_id){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::playerLiabilityReport >>> SELECT core.report_player_liability(:p_session_id_in = {$backoffice_session_id},
                :p_aff_id = {$affiliate_id}, 'cur_report_list')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.report_player_liability(:p_session_id_in, :p_aff_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_aff_id' => $affiliate_id,
                )
            );
            $cursor_name1 = $fn_result[0]->cur_report_list;

            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result1,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::playerLiabilityReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}) <br />\n\n",
                "core.report_player_liability(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, 'cur_report_list') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::playerLiabilityReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}) <br />\n\n",
                "core.report_player_liability(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, 'cur_report_list') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function collectorTransactionsReport($backoffice_session_id, $affiliate_id, $start_date, $end_date){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::collectorTransactionsReport >>> SELECT core.report_collector_transactions(:p_session_id_in = {$backoffice_session_id},
                :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_report_list', 'cur_sum_report')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.report_collector_transactions(:p_session_id_in, :p_aff_id, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_aff_id' => $affiliate_id,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date,
                )
            );
            $cursor_name1 = $fn_result[0]->cur_report_list;
            $cursor_name2 = $fn_result[0]->cur_sum_report;

            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");
            $cur_result2 = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result1,
                "report2"=>$cur_result2
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::collectorTransactionsReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
                "core.report_collector_transactions(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::collectorTransactionsReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
                "core.report_collector_transactions(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function allTransactionsReport($backoffice_session_id, $affiliate_id, $start_date, $end_date){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::allTransactionsReport >>> SELECT core.report_all_financial_trans(:p_session_id_in = {$backoffice_session_id},
                :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_report_sum', 'cur_report_list')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.report_all_financial_trans(:p_session_id_in, :p_aff_id, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_aff_id' => $affiliate_id,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date,
                )
            );
            $cursor_name1 = $fn_result[0]->cur_report_sum;
            $cursor_name2 = $fn_result[0]->cur_report_list;

            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");
            $cur_result2 = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result1,
                "report2"=>$cur_result2
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::allTransactionsReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
                "core.report_all_financial_trans(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::allTransactionsReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
                "core.report_all_financial_trans(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function financialReport($backoffice_session_id, $affiliate_id, $start_date, $end_date){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::listLocationTickets >>> SELECT core.report_financial(:p_session_id_in = {$backoffice_session_id},
                :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_location_report_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.report_financial(:p_session_id_in, :p_aff_id, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_aff_id' => $affiliate_id,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date,
                )
            );
            $cursor_name1 = $fn_result[0]->cur_location_report_out;
            $cursor_name2 = $fn_result[0]->cur_report_list;

            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");
            $cur_result2 = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result1,
                "report2"=>$cur_result2
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::financialReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
                "core.report_financial(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::financialReport(backoffice_session_id={$backoffice_session_id}, affiliate_id={$affiliate_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
                "core.report_financial(:p_session_id_in = {$backoffice_session_id}, :p_aff_id = {$affiliate_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function cashierDailyReport($backoffice_session_id, $subject_id, $date){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::daily_report >>> SELECT core.daily_report(:p_session_id_in = {$backoffice_session_id}, 
                :p_subject_id = {$subject_id}, :p_date = {$date}, ':p_csh_location_out', ':p_csh_start_credits', ':p_end_credits', 'cur_result_out', 'cur_location_report_out', ':p_currency')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.daily_report(:p_session_id_in, :p_subject_id, :p_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    "p_subject_id" => $subject_id,
                    "p_date" => $date
                )
            );

            $cursor_name1 = $fn_result[0]->cur_result_out;
            $cursor_name2 = $fn_result[0]->cur_location_report_out;
            $location_name = $fn_result[0]->p_csh_location_out;
            $start_credits = $fn_result[0]->p_csh_start_credits;
            $end_credits = $fn_result[0]->p_end_credits;
            $currency = $fn_result[0]->p_currency;

            $cur_result_cashier = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");
            $cur_result_location = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report" => $fn_result,
                "cashier" => $cur_result_cashier,
                "location" => $cur_result_location,
                "location_name" => $location_name,
                "start_credits" => $start_credits,
                "end_credits" => $end_credits,
                "currency" => $currency
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::cashierDailyReport(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, date = {$date}) <br />\n\n",
                "core.daily_report(:p_session_id_in = {$backoffice_session_id}, 
                :p_subject_id = {$subject_id}, :p_date = {$date}, ':p_csh_location_out', ':p_csh_start_credits', ':p_end_credits', 'cur_result_out', 'cur_location_report_out', ':p_currency') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::cashierDailyReport(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, date = {$date}) <br />\n\n",
                "core.daily_report(:p_session_id_in = {$backoffice_session_id}, 
                :p_subject_id = {$subject_id}, :p_date = {$date}, ':p_csh_location_out', ':p_csh_start_credits', ':p_end_credits', 'cur_result_out', 'cur_location_report_out', ':p_currency') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }
    public static function listDailyReport($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::listDailyReport >>> SELECT tomboladb.tombola.daily_report(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.daily_report(:p_session_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in'=>$backoffice_session_id
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listDailyReport(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "SELECT tomboladb.tombola.daily_report(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listDailyReport(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "SELECT tomboladb.tombola.daily_report(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $user_affiliate_id
     * @param $affiliate_id
     * @param $ticket_status
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public static function listLocationTickets($backoffice_session_id, $user_affiliate_id, $affiliate_id, $ticket_status, $start_date, $end_date){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::listLocationTickets >>> SELECT tomboladb.core.report_location_ticket_list(:p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_aff_id = {$affiliate_id}, 
                :p_ticket_status = {$ticket_status}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_location_ticket_list(:p_session_id_in, :p_logged_in_user, :p_aff_id, :p_ticket_status, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_logged_in_user' => $user_affiliate_id,
                    'p_aff_id' => $affiliate_id,
                    'p_ticket_status' => $ticket_status,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date

                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listLocationTickets(backoffice_session_id={$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, affiliate_id={$affiliate_id}, ticket_status={$ticket_status}, start_date={$start_date}, end_date={$end_date}) <br />\n\n",
                "tomboladb.core.report_location_ticket_list(:p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_aff_id = {$affiliate_id}, 
                :p_ticket_status = {$ticket_status}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listLocationTickets(backoffice_session_id={$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, affiliate_id={$affiliate_id}, ticket_status={$ticket_status}, start_date={$start_date}, end_date={$end_date}) <br />\n\n",
                "tomboladb.core.report_location_ticket_list(:p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_aff_id = {$affiliate_id}, 
                :p_ticket_status = {$ticket_status}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $ticket_serial_number
     * @return array
     */
    public static function listReportTicketDetailsPerDraw($backoffice_session_id, $ticket_serial_number){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::listReportTicketDetailsPerDraw >>> SELECT tomboladb.core.report_ticket_details_per_draw(:p_session_id_in = {$backoffice_session_id},
                :p_ticket_serial_number = {$ticket_serial_number}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_ticket_details_per_draw(:p_session_id_in, :p_ticket_serial_number)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_ticket_serial_number' => $ticket_serial_number
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listReportTicketDetailsPerDraw(backoffice_session_id={$backoffice_session_id}, ticket_serial_number={$ticket_serial_number}) <br />\n\n",
                "tomboladb.core.report_ticket_details_per_draw(:p_session_id_in = {$backoffice_session_id}, :p_ticket_serial_number = {$ticket_serial_number}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listReportTicketDetailsPerDraw(backoffice_session_id={$backoffice_session_id}, ticket_serial_number={$ticket_serial_number}) <br />\n\n",
                "tomboladb.core.report_ticket_details_per_draw(:p_session_id_in = {$backoffice_session_id}, :p_ticket_serial_number = {$ticket_serial_number}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $user_affiliate_id
     * @param $parent_id
     * @param $affiliate_id
     * @param $ticket_status
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public static function listPlayerTickets($backoffice_session_id, $user_affiliate_id, $parent_id, $affiliate_id, $ticket_status, $start_date, $end_date){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::listPlayerTickets >>> SELECT tomboladb.core.report_player_ticket_list(:p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_parent_id = {$parent_id}, :p_aff_id = {$affiliate_id}, 
                :p_ticket_status = {$ticket_status}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_player_ticket_list(:p_session_id_in, :p_logged_in_user, :p_parent_id, :p_aff_id, :p_ticket_status, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_logged_in_user' => $user_affiliate_id,
                    'p_parent_id' => $parent_id,
                    'p_aff_id' => $affiliate_id,
                    'p_ticket_status' => $ticket_status,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date

                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listPlayerTickets(backoffice_session_id={$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, parent_id={$parent_id}, affiliate_id={$affiliate_id}, ticket_status={$ticket_status}, start_date={$start_date}, end_date={$end_date}) <br />\n\n",
                "tomboladb.core.report_player_ticket_list(:p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_parent_id = {$parent_id}, :p_aff_id = {$affiliate_id}, 
                :p_ticket_status = {$ticket_status}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listPlayerTickets(backoffice_session_id={$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, parent_id={$parent_id}, affiliate_id={$affiliate_id}, ticket_status={$ticket_status}, start_date={$start_date}, end_date={$end_date}) <br />\n\n",
                "tomboladb.core.report_player_ticket_list(:p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_parent_id = {$parent_id}, :p_aff_id = {$affiliate_id}, 
                :p_ticket_status = {$ticket_status}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function listPreviousDrawsReport2($backoffice_session_id, $user_affiliate_id, $parent_id, $draw_model_id, $currency, $date_from, $date_to,
                                                    $draw_id, $draw_sn, $draw_status, $page_number, $number_of_results){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::listPreviousDrawsReport >>> SELECT tomboladb.core.list_previous_draws(
                :p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_parent_id = {$parent_id}, :p_number_of_results = {$number_of_results}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_list_previous_draws(:p_session_id_in, :p_logged_in_subject, :p_parent_id, :p_draw_model_id,
                                :p_currency, :p_date_from, :p_date_to, :p_draw_id, :p_draw_sn, :p_draw_status, :p_page_number, :p_number_of_results)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_logged_in_subject' => $user_affiliate_id,
                    'p_parent_id' => $parent_id,
                    'p_draw_model_id' => $draw_model_id,
                    'p_currency' => $currency,
                    'p_date_from' => $date_from,
                    'p_date_to' => $date_to,
                    'p_draw_id' => $draw_id,
                    'p_draw_sn' => $draw_sn,
                    'p_draw_status' => $draw_status,
                    'p_page_number' => $page_number,
                    'p_number_of_results' => $number_of_results
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listPreviousDrawsReport2(backoffice_session_id={$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, 
                    parent_id={$parent_id}, draw_model_id={$draw_model_id}, currency={$currency}, date_from={$date_from}, date_to={$date_to}, 
                    draw_id={$draw_id}, draw_sn={$draw_sn}, draw_status={$draw_status}, page_number={$page_number}, number_of_results={$number_of_results}) <br />\n\n",

                "tomboladb.core.list_previous_draws(p_session_id_in={$backoffice_session_id}, p_logged_in_subject={$user_affiliate_id}, 
                    p_parent_id={$parent_id}, p_draw_model_id={$draw_model_id}, p_currency={$currency}, p_date_from={$date_from}, p_date_to={$date_to}, 
                    p_draw_id={$draw_id}, p_draw_sn={$draw_sn}, p_draw_status={$draw_status}, p_page_number={$page_number}, p_number_of_results={$number_of_results}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listPreviousDrawsReport2(backoffice_session_id={$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, 
                    parent_id={$parent_id}, draw_model_id={$draw_model_id}, currency={$currency}, date_from={$date_from}, date_to={$date_to}, 
                    draw_id={$draw_id}, draw_sn={$draw_sn}, draw_status={$draw_status}, page_number={$page_number}, number_of_results={$number_of_results}) <br />\n\n",

                "tomboladb.core.list_previous_draws(p_session_id_in={$backoffice_session_id}, p_logged_in_subject={$user_affiliate_id}, 
                    p_parent_id={$parent_id}, p_draw_model_id={$draw_model_id}, p_currency={$currency}, p_date_from={$date_from}, p_date_to={$date_to}, 
                    p_draw_id={$draw_id}, p_draw_sn={$draw_sn}, p_draw_status={$draw_status}, p_page_number={$page_number}, p_number_of_results={$number_of_results}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function listPreviousDrawsReport($backoffice_session_id, $user_affiliate_id, $parent_id, $number_of_results = 200){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::listPreviousDrawsReport >>> SELECT tomboladb.core.list_previous_draws(
                :p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_parent_id = {$parent_id}, :p_number_of_results = {$number_of_results}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_list_previous_draws(:p_session_id_in, :p_logged_in_user, :p_parent_id, :p_number_of_results)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_logged_in_user' => $user_affiliate_id,
                    'p_parent_id' => $parent_id,
                    'p_number_of_results' => $number_of_results
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listPreviousDrawsReport(backoffice_session_id={$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, parent_id={$parent_id}, number_of_results={$number_of_results}) <br />\n\n",
                "tomboladb.core.list_previous_draws(
                :p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_parent_id = {$parent_id}, :p_number_of_results = {$number_of_results}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listPreviousDrawsReport(backoffice_session_id={$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, parent_id={$parent_id}, number_of_results={$number_of_results}) <br />\n\n",
                "tomboladb.core.list_previous_draws(
                :p_session_id_in = {$backoffice_session_id},
                :p_logged_in_user = {$user_affiliate_id}, :p_parent_id = {$parent_id}, :p_number_of_results = {$number_of_results}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $ticket_serial_number
     * @param $draw_serial_number
     * @return array
     */
    public static function listReportTicketSubdetailsPerDraw($backoffice_session_id, $ticket_serial_number, $draw_serial_number){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::listReportTicketSubdetailsPerDraw >>> SELECT tomboladb.core.report_ticket_sub_details_per_draw(
                :p_session_id_in = {$backoffice_session_id},
                :p_ticket_serial_number = {$ticket_serial_number}, :p_draw_serial_number = {$draw_serial_number}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_ticket_sub_details_per_draw(:p_session_id_in, :p_ticket_serial_number, :p_draw_serial_number)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_ticket_serial_number' => $ticket_serial_number,
                    'p_draw_serial_number' => $draw_serial_number
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listReportTicketSubdetailsPerDraw(backoffice_session_id={$backoffice_session_id}, ticket_serial_number = {$ticket_serial_number}, draw_serial_number = {$draw_serial_number}) <br />\n\n",
                "tomboladb.core.report_ticket_sub_details_per_draw(:p_session_id_in = {$backoffice_session_id}, :p_ticket_serial_number = {$ticket_serial_number}, :p_draw_serial_number = {$draw_serial_number}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listReportTicketSubdetailsPerDraw(backoffice_session_id={$backoffice_session_id}, ticket_serial_number = {$ticket_serial_number}, draw_serial_number = {$draw_serial_number}) <br />\n\n",
                "tomboladb.core.report_ticket_sub_details_per_draw(:p_session_id_in = {$backoffice_session_id}, :p_ticket_serial_number = {$ticket_serial_number}, :p_draw_serial_number = {$draw_serial_number}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function getSubjectTreeEntitiesAndCashiers($parent_id, $tree_tpe, $listType){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::getSubjectTreeEntitiesAndCashiers >>> SELECT * from tomboladb.core.get_stree_entities_and_cashiers( 
                :p_parent_id = {$parent_id}, p_subject_dtype = {$listType}, p_subject_type = {$tree_tpe}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from core.get_stree_entities_and_cashiers(:p_parent_id, :p_subject_dtype, :p_subject_type)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_parent_id" => $parent_id,
                    "p_subject_dtype" => $listType,
                    "p_subject_type" => $tree_tpe
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::getSubjectTreeEntitiesAndCashiers(parent_id={$parent_id}, tree_tpe={$tree_tpe}, listType={$listType}) <br />\n\n",
                "tomboladb.core.get_stree_entities_and_cashiers( 
                :p_parent_id = {$parent_id}, p_subject_dtype = {$listType}, p_subject_type = {$tree_tpe}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result"=>[]
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::getSubjectTreeEntitiesAndCashiers(parent_id={$parent_id}, tree_tpe={$tree_tpe}, listType={$listType}) <br />\n\n",
                "tomboladb.core.get_stree_entities_and_cashiers( 
                :p_parent_id = {$parent_id}, p_subject_dtype = {$listType}, p_subject_type = {$tree_tpe}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result"=>[]
            ];
        }
    }

    public static function transactionReport($session_id, $aff_id, $start_date, $end_date, $currency){
        try{

            if(self::$DEBUG){
                $message = "ReportModel::transactionReport >>> SELECT * from core.report_bo_financial_trans( 
                :p_session_id_in = {$session_id}, p_aff_id = {$aff_id}, p_start_date = {$start_date}, p_end_date = {$end_date}, p_currency = {$currency}, 'cur_report_list' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from core.report_bo_financial_trans(:p_session_id_in, :p_aff_id, :p_start_date, :p_end_date, :p_currency)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id_in" => $session_id,
                    "p_aff_id" => $aff_id,
                    "p_start_date" => $start_date,
                    "p_end_date" => $end_date,
                    "p_currency" => $currency
                ]
            );

            $cursor_name = $fn_result[0]->cur_report_list;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::transactionReport(session_id={$session_id}, aff_id={$aff_id}, start_date={$start_date}, end_date={$end_date}, currency={$currency}) <br />\n\n",
                "core.report_bo_financial_trans( 
                :p_session_id_in = {$session_id}, p_aff_id = {$aff_id}, p_start_date = {$start_date}, p_end_date = {$end_date}, 'cur_report_list' ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result"=>[]
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::transactionReport(session_id={$session_id}, aff_id={$aff_id}, start_date={$start_date}, end_date={$end_date}, currency={$currency}) <br />\n\n",
                "core.report_bo_financial_trans( 
                :p_session_id_in = {$session_id}, p_aff_id = {$aff_id}, p_start_date = {$start_date}, p_end_date = {$end_date}, 'cur_report_list' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result"=>[]
            ];
        }
    }

    /**
     * @param $backoffice_session_id
	 * @param $subject_id
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public static function listLoginHistory($backoffice_session_id, $subject_id, $start_date, $end_date){
        try{

            if(self::$DEBUG){
                $message = "App\Models\Postgres\ReportModel::listLoginHistory >>> 
                SELECT tomboladb.core.report_login_history(:p_session_id_in = {$backoffice_session_id}, :p_subject_id = {$subject_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_report_list')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_login_history(:p_session_id_in, :p_subject_id, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
					'p_subject_id' => $subject_id,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date
                )
            );
            $cursor_name = $fn_result[0]->cur_report_list;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listLoginHistory(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, start_date={$start_date}, end_date={$end_date}) <br />\n\n",
                "tomboladb.core.report_login_history(:p_session_id_in = {$backoffice_session_id}, :p_subject_id = {$subject_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_report_list') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listLoginHistory(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, start_date={$start_date}, end_date={$end_date}) <br />\n\n",
                "tomboladb.core.report_login_history(:p_session_id_in = {$backoffice_session_id}, :p_subject_id = {$subject_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}, 'cur_report_list') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function listAffiliateMonthlySummaryReport($backoffice_session_id){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::listAffiliateMonthlySummaryReport >>> SELECT tomboladb.core.list_aff_monthly_summary(
                :p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.list_aff_monthly_summary(:p_session_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listAffiliateMonthlySummaryReport(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_aff_monthly_summary(p_session_id_in={$backoffice_session_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listAffiliateMonthlySummaryReport(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_aff_monthly_summary(p_session_id_in={$backoffice_session_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function listShiftCashierReport($details){
        try{
            if(self::$DEBUG){
                $message = "ReportModel::listShiftCashierReport >>> SELECT tomboladb.core.cashier_shift_report(
                :p_session_id_in = {$details['backoffice_session_id']}, :p_cashier_id = {$details['cashier_id']}, :p_page_number = {$details['page_number']}, 
                :p_number_of_results = {$details['number_of_results']}, :p_start_date = {$details['start_date']}, 
                :p_end_date = {$details['end_date']}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.cashier_shift_report(:p_session_id_in, :p_cashier_id, :p_page_number, :p_number_of_results, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $details['backoffice_session_id'],
                    'p_cashier_id' => $details['cashier_id'],
                    'p_page_number' => $details['page_number'],
                    'p_number_of_results' => $details['number_of_results'],
                    'p_start_date' => $details['start_date'],
                    'p_end_date' => $details['end_date'],
                )
            );
            $cursor_name = $fn_result[0]->cur_report_list;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report"=>$cur_result,
                "records_total" => $fn_result[0]->p_rows_number
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listShiftCashierReport >>> SELECT tomboladb.core.cashier_shift_report(
                :p_session_id_in = {$details['backoffice_session_id']}, :p_cashier_id = {$details['cashier_id']}, :p_page_number = {$details['page_number']}, 
                :p_number_of_results = {$details['number_of_results']}, :p_start_date = {$details['start_date']}, 
                :p_end_date = {$details['end_date']}, 'cur_result_out')\n\n",
                "tomboladb.core.cashier_shift_report(:p_session_id_in = {$details['backoffice_session_id']}, :p_cashier_id = {$details['cashier_id']}, :p_page_number = {$details['page_number']}, 
                :p_number_of_results = {$details['number_of_results']}, :p_start_date = {$details['start_date']}, :p_end_date = {$details['end_date']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => array(0),
                "recordsTotal" => 0
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ReportModel::listShiftCashierReport >>> SELECT tomboladb.core.cashier_shift_report(
                :p_session_id_in = {$details['backoffice_session_id']}, :p_cashier_id = {$details['cashier_id']}, :p_page_number = {$details['page_number']}, 
                :p_number_of_results = {$details['number_of_results']}, :p_start_date = {$details['start_date']}, 
                :p_end_date = {$details['end_date']}, 'cur_result_out')\n\n",
                "tomboladb.core.cashier_shift_report(:p_session_id_in = {$details['backoffice_session_id']}, :p_cashier_id = {$details['cashier_id']}, :p_page_number = {$details['page_number']}, 
                :p_number_of_results = {$details['number_of_results']}, :p_start_date = {$details['start_date']}, :p_end_date = {$details['end_date']}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => array(0),
                "recordsTotal" => 0
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param null $start_date
     * @param null $end_date
     * @param null $ticket_serial_number
     * @param null $ticket_draw_id
     * @param null $ticket_barcode
     * @param null $player_name
     * @param null $cashier_name
     * @param null $preferred_by
     * @return array
     */
    public static function reportListAllPreferredTickets($backoffice_session_id, $start_date = null, $end_date = null, $ticket_serial_number = null, $ticket_draw_id = null, $ticket_barcode = null,
      $player_name = null, $cashier_name = null, $preferred_by = null
    ){
        if(self::$DEBUG){
            $message = "TicketModel::reportListAllPreferredTickets >>> 
            SELECT tomboladb.tombola.tombola.report_list_all_preferred_tickets(:p_session_id_in = {$backoffice_session_id},
              :p_ticket_serial_number = {$ticket_serial_number}, :p_draw_id = {$ticket_draw_id}, :p_ticket_barcode = {$ticket_barcode}, :p_player_name = {$player_name}, :p_cashier_name = {$cashier_name},
              :p_start_date = {$start_date}, :p_end_date = {$end_date}, :p_preferred_by = {$preferred_by}, 'cur_result_out')";
            ErrorHelper::writeInfo($message, $message);
       }
       try{
            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.report_list_all_preferred_tickets(:p_session_id_in, :p_ticket_serial_number, :p_draw_id, :p_ticket_barcode, :p_player_name, :p_cashier_name, :p_start_date, :p_end_date, :p_preferred_by)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_ticket_serial_number' => $ticket_serial_number,
                    'p_draw_id' => $ticket_draw_id,
                    'p_ticket_barcode' => $ticket_barcode,
                    'p_player_name' => $player_name,
                    'p_cashier_name' => $cashier_name,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date,
                    'p_preferred_by' => $preferred_by,
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result" => $cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::reportListAllPreferredTickets(backoffice_session_id = {$backoffice_session_id}, start_date = {$start_date}, end_date = {$end_date}, ticket_serial_number = {$ticket_serial_number}, 
                    ticket_draw_id = {$ticket_draw_id}, ticket_barcode = {$ticket_barcode},
                    player_name = {$player_name}, cashier_name = {$cashier_name}, preferred_by = {$preferred_by}
                )
                <br />\n\n",
                "tomboladb.tombola.tombola.report_list_all_preferred_tickets(:p_session_id_in = {$backoffice_session_id},
                :p_ticket_serial_number = {$ticket_serial_number}, :p_draw_id = {$ticket_draw_id}, :p_ticket_barcode = {$ticket_barcode}, :p_player_name = {$player_name}, :p_cashier_name = {$cashier_name},
                :p_start_date = {$start_date}, :p_end_date = {$end_date}, :p_preferred_by = {$preferred_by}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::reportListAllPreferredTickets(backoffice_session_id = {$backoffice_session_id}, start_date = {$start_date}, end_date = {$end_date}, ticket_serial_number = {$ticket_serial_number}, 
                    ticket_draw_id = {$ticket_draw_id}, ticket_barcode = {$ticket_barcode},
                    player_name = {$player_name}, cashier_name = {$cashier_name}, preferred_by = {$preferred_by}
                )
                <br />\n\n",
                "tomboladb.tombola.tombola.report_list_all_preferred_tickets(:p_session_id_in = {$backoffice_session_id},
                :p_ticket_serial_number = {$ticket_serial_number}, :p_draw_id = {$ticket_draw_id}, :p_ticket_barcode = {$ticket_barcode}, :p_player_name = {$player_name}, :p_cashier_name = {$cashier_name},
                :p_start_date = {$start_date}, :p_end_date = {$end_date}, :p_preferred_by = {$preferred_by}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }
    }
}
