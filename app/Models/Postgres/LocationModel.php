<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class LocationModel
{

    private static $DEBUG = false;

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listLocations($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "LocationModel::listLocations >>> SELECT * from tomboladb.core.list_locations( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_locations(:p_session_id_in)";
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
                "list_locations" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "LocationModel::listLocations(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_locations(:p_session_id_in = {$backoffice_session_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_locations"=>[]
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "LocationModel::listLocations(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_locations(:p_session_id_in = {$backoffice_session_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_locations"=>[]
            ];
        }
    }

}
