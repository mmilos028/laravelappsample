<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class PlayerReportModel
{

    private static $DEBUG = false;

    /**
     * @param $backoffice_session_id
	 * @param $subject_id
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public static function listSubjectMoneyTransactions($backoffice_session_id, $subject_id, $start_date, $end_date){
        try{

            if(self::$DEBUG){
                $message = "App\Models\Postgres\PlayerReportModel::listSubjectMoneyTransactions >>> 
                SELECT tomboladb.tombola.list_subjects_money_transactions(:p_session_id_in = {$backoffice_session_id}, :p_subject_id_in = {$subject_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.list_subjects_money_transactions(:p_session_id_in, :p_subject_id_in, :p_start_date, :p_end_date)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
					'p_subject_id_in' => $subject_id,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date
                )
            );
            $cursor_name1 = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");

            $cursor_name2 = $fn_result[0]->cur_list_transactions;

            $cur_list_transactions = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "report_total"=>$cur_result,
                "report_list_transactions" => $cur_list_transactions
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "PlayerModel::listSubjectMoneyTransactions(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, start_date={$start_date}, end_date={$end_date}) <br />\n\n",
                "tomboladb.tombola.list_subjects_money_transactions(:p_session_id_in = {$backoffice_session_id}, :p_subject_id_in = {$subject_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report_total" => null,
                "report_list_transactions" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "PlayerModel::listSubjectMoneyTransactions(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, start_date={$start_date}, end_date={$end_date}) <br />\n\n",
                "tomboladb.tombola.list_subjects_money_transactions(:p_session_id_in = {$backoffice_session_id}, :p_subject_id_in = {$subject_id}, :p_start_date = {$start_date}, :p_end_date = {$end_date}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report_total" => null,
                "report_list_transactions" => null
            ];
        }
    }
	
	/**
     * @param $backoffice_session_id
	 * @param $subject_id
     * @return array
     */
    public static function listPlayerTickets($backoffice_session_id, $subject_id){
        try{

            if(self::$DEBUG){
                $message = "App\Models\Postgres\PlayerReportModel::listPlayerTickets >>> SELECT tomboladb.tombola.list_player_tickets(:p_session_id_in = {$backoffice_session_id}, :p_subject_id_in = {$subject_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.list_player_tickets(:p_session_id_in, :p_subject_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
					'p_subject_id_in' => $subject_id
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
                "PlayerModel::listPlayerTickets(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}) <br />\n\n",
                "tomboladb.tombola.list_player_tickets(:p_session_id_in = {$backoffice_session_id}, :p_subject_id_in = {$subject_id}) <br />\n\n",
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
                "PlayerModel::listPlayerTickets(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}) <br />\n\n",
                "tomboladb.tombola.list_player_tickets(:p_session_id_in = {$backoffice_session_id}, :p_subject_id_in = {$subject_id}) <br />\n\n",
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
	 * @param $subject_id
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public static function listPlayerLoginHistory($backoffice_session_id, $subject_id, $start_date, $end_date){
        try{

            if(self::$DEBUG){
                $message = "App\Models\Postgres\PlayerReportModel::listPlayerLoginHistory >>> 
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
                "PlayerModel::listPlayerLoginHistory(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
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
                "PlayerModel::listPlayerLoginHistory(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, start_date = {$start_date}, end_date = {$end_date}) <br />\n\n",
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
}
