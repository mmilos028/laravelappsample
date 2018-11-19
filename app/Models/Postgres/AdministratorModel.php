<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class AdministratorModel
{

    private static $DEBUG = false;

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listAdministrators($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "AdministratorModel::listAdministrators >>> SELECT * from tomboladb.core.list_administrators( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_administrators(:p_session_id_in)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id_in" => $backoffice_session_id
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_administrators" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "AdministratorModel::listAdministrators(backoffice_session_id = {$backoffice_session_id} <br />\n\n",
                "tomboladb.core.list_administrators( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "AdministratorModel::listAdministrators(backoffice_session_id = {$backoffice_session_id} <br />\n\n",
                "tomboladb.core.list_administrators( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }

}
