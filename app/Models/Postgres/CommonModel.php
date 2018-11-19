<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class CommonModel
{

    private static $DEBUG = false;

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listCountries($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "CurrencyModel::listCurrencies >>> SELECT * from tomboladb.core.list_countries( 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }
            DB::beginTransaction();
            $statement_string = "SELECT tomboladb.core.list_countries( )";
            $fn_result = DB::select(
                $statement_string
            );
            $cursor_name = $fn_result[0]->list_countries;
            $cursor_result = DB::select("fetch all in {$cursor_name};");
            DB::commit();
            return [
                "status" => "OK",
                "list_countries" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::rollBack();
            $message = implode(" ", [
                "CommonModel::listCountries(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_countries( 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_countries" => []
            ];
        }catch(\Exception $ex2){
            DB::rollBack();
            $message = implode(" ", [
                "CommonModel::listCountries(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_countries( 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_countries" => []
            ];
        }
    }
}
