<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class TransferCreditModel
{

    private static $DEBUG = false;

    /**
     * @param $user_id
     * @return array
     */
    public static function listSubjectsForDepositWithdraw($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "UserModel::listPlayersByType >>> SELECT * from tomboladb.core.list_players_by_type( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_users_for_credit_transfer(:p_session_id_in)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id_in" => $backoffice_session_id,
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_users" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TransferCreditModel::listSubjectsForDepositWithdraw(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_players_by_type( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_users"=>[]
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TransferCreditModel::listSubjectsForDepositWithdraw(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_players_by_type( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_users"=>[]
            ];
        }
    }
    public static function getCredits($user_id){
        try{

            if(self::$DEBUG){
                $message = "TransferCreditModel::getCredits, subject_id = {$user_id}, SELECT * from tomboladb.tombola.get_credits(:p_subject_id_in = {$user_id})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.tombola.get_credits(:p_subject_id_in)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_subject_id_in" => $user_id
                ]
            );

            DB::connection('pgsql')->commit();

            return [ 'status' => "OK", 'credits' => $fn_result[0]->get_credits ];

        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TransferCreditModel::getCredits(user_id={$user_id}) <br />\n\n",
                "tomboladb.tombola.get_credits(:p_subject_id_in = {$user_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TransferCreditModel::getCredits(user_id={$user_id}) <br />\n\n",
                "tomboladb.tombola.get_credits(:p_subject_id_in = {$user_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
            ];
        }
    }

    /**
     * @param $session_id
     * @param $cashier_id
     * @param $player_id
     * @param $transaction_sign
     * @param $transfer_amount
     * @return array
     */
    public static function transferCredits($session_id, $user_id, $logged_in_id, $transaction_sign, $transfer_amount){

        try{

            if(self::$DEBUG){
                $message = "TransferCreditModel::transferCredits, p_session_id = {$session_id}, p_subject_id_from = {$user_id}, 
                p_subject_id_to = {$logged_in_id} p_transaction_sign = {$transaction_sign}, p_amount = {$transfer_amount}, 
                SELECT * from tomboladb.core.transfer_credits(:p_session_id, :p_subject_id_from = {$user_id}, :p_subject_id_to = {$logged_in_id},
                    p_transaction_sign = {$transaction_sign}, p_amount = {$transfer_amount}, p_status_out)";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.transfer_credits(:p_session_id, :p_subject_id_from, :p_subject_id_to, :p_transaction_sign, :p_amount)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id" => $session_id,
                    "p_subject_id_from" => $user_id,
                    "p_subject_id_to" => $logged_in_id,
                    "p_transaction_sign" => $transaction_sign,
                    "p_amount" => $transfer_amount
                ]
            );

            DB::connection('pgsql')->commit();

            return [ 'status' => "OK", 'status_out' => $fn_result[0]->p_status_out ];

        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TransferCreditModel::transferCredits(backoffice_session_id={$session_id}, cashier_id={$user_id}, player_id={$logged_in_id}, transaction_sign={$transaction_sign}, transfer_amount={$transfer_amount}) <br />\n\n",
                "tomboladb.core.transfer_credits(:p_session_id, :p_subject_id_from = {$user_id}, :p_subject_id_to = {$logged_in_id},
                    p_transaction_sign = {$transaction_sign}, p_amount = {$transfer_amount}, p_status_out) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TransferCreditModel::transferCredits(backoffice_session_id={$session_id}, cashier_id={$user_id}, player_id={$logged_in_id}, transaction_sign={$transaction_sign}, transfer_amount={$transfer_amount}) <br />\n\n",
                "tomboladb.core.transfer_credits(:p_session_id, :p_subject_id_from = {$user_id}, :p_subject_id_to = {$logged_in_id},
                    p_transaction_sign = {$transaction_sign}, p_amount = {$transfer_amount}, p_status_out) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
            ];
        }
    }
}
