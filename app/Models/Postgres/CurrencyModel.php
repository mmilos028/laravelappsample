<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class CurrencyModel
{

    private static $DEBUG = false;

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listCurrenciesForStartEndDate($backoffice_session_id, $startDate, $endDate){
        try{

            if(self::$DEBUG){
                $message = "CurrencyModel::listCurrencies >>> SELECT * from tomboladb.core.list_currencies( :p_session_id_in = {$backoffice_session_id}, :p_start_date = {$startDate}, :p_end_date = {$endDate}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT tomboladb.core.list_currencies( :p_session_id_in, :p_start_date, :p_end_date )";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id_in" => $backoffice_session_id,
                    "p_start_date" => $startDate,
                    "p_end_date" => $endDate
                ]
            );

            $cursor_name = $fn_result[0]->list_currencies;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            /*
            $list_currency = array();
            foreach($cursor_result as $res){
                $list_currency[$res->currency_id] = $res->currency;
            }
            */

            //dd($list_currency);

            return [
                "status" => "OK",
                "list_currency" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CurrencyModel::listCurrenciesForStartEndDate(backoffice_session_id = {$backoffice_session_id}, startDate = {$startDate}, endDate = {$endDate}) <br />\n\n",
                "tomboladb.core.list_currencies( :p_session_id_in = {$backoffice_session_id}, :p_start_date = {$startDate}, :p_end_date = {$endDate} ) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_currency" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CurrencyModel::listCurrenciesForStartEndDate(backoffice_session_id = {$backoffice_session_id}, startDate = {$startDate}, endDate = {$endDate}) <br />\n\n",
                "tomboladb.core.list_currencies( :p_session_id_in = {$backoffice_session_id}, :p_start_date = {$startDate}, :p_end_date = {$endDate} ) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_currency" => []
            ];
        }
    }

    public static function listCurrencies($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "CurrencyModel::listCurrencies >>> SELECT * from tomboladb.core.list_currencies( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT tomboladb.core.list_currencies( :p_session_id_in )";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id_in" => $backoffice_session_id
                ]
            );

            $cursor_name = $fn_result[0]->list_currencies;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");
            DB::connection('pgsql')->commit();
            /*
            $list_currency = array();
            foreach($cursor_result as $res){
                $list_currency[$res->currency_id] = $res->currency;
            }
            */

            //dd($list_currency);

            return [
                "status" => "OK",
                "list_currency" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CurrencyModel::listCurrencies(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_currencies( :p_session_id_in = {$backoffice_session_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_currency" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CurrencyModel::listCurrencies(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_currencies( :p_session_id_in = {$backoffice_session_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_currency" => []
            ];
        }
    }

    /**
     * @param array $details
     * @return array
     */
    public static function addCurrencyToSubject($details){

        if(self::$DEBUG){
            $message = "CurrencyModel::addCurrencyToSubject >>> SELECT tomboladb.core.add_currency_to_subject(:p_subject_id_in = {$details['user_id']}, :p_currency_in = {$details['currency']})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.add_currency_to_subject(:p_subject_id_in, :p_currency_in)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_subject_id_in'=>$details['user_id'],
                    'p_currency_in'=>$details['currency'],
                ]
            );
            DB::connection('pgsql')->commit();

            if($fn_result[0]->add_currency_to_subject == 1){
                return ['status'=>"OK"];
            }else{
                return ['status'=>"NOK"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CurrencyModel::addCurrencyToSubject(details = " . print_r($details) .") <br />\n\n",
                "tomboladb.core.add_currency_to_subject(:p_subject_id_in = {$details['user_id']}, :p_currency_in = {$details['currency']}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK", "code"=>$ex1->getCode()];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CurrencyModel::addCurrencyToSubject(details = " . print_r($details) .") <br />\n\n",
                "tomboladb.core.add_currency_to_subject(:p_subject_id_in = {$details['user_id']}, :p_currency_in = {$details['currency']}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK", "code"=>$ex2->getCode()];
        }
    }
}
