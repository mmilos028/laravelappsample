<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class SessionModel
{

    private static $DEBUG = false;

    /**
     * @param $session_id
     * @return array
     */
    public static function validateSession($session_id){
        if(self::$DEBUG){
            $message = "SessionModel::validateSession >>> SELECT tomboladb.core.validate_session(:p_session_id = {$session_id})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.validate_session(:p_session_id_in)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_session_id_in'=>$session_id
                ]
            );
            DB::connection('pgsql')->commit();

            if($fn_result[0]->validate_session == 1){
                return ['status'=>"OK"];
            }else{
                return ['status'=>"NOK"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SessionModel::validateSession(session_id={$session_id}) <br />\n\n",
                "tomboladb.core.validate_session(:p_session_id = {$session_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK", "code"=>$ex1->getCode()];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SessionModel::validateSession(session_id={$session_id}) <br />\n\n",
                "tomboladb.core.validate_session(:p_session_id = {$session_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK", "code"=>$ex2->getCode()];
        }
    }
    public function getSessionRemainingTime($session_id){
        if(self::$DEBUG){
            $message = "SessionModel::getSessionRemainingTime >>> SELECT core.get_session_remaining_time(:p_session_id = {$session_id})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT core.get_session_remaining_time(:p_session_id_in)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_session_id_in'=>$session_id
                ]
            );
            DB::connection('pgsql')->commit();

            $remaining_time = $fn_result[0]->get_session_remaining_time;

            return [
                "status" => "OK",
                "time" => $remaining_time
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SessionModel::getSessionRemainingTime(session_id={$session_id}) <br />\n\n",
                "core.get_session_remaining_time(:p_session_id = {$session_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK", "code"=>$ex1->getCode()];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SessionModel::getSessionRemainingTime(session_id={$session_id}) <br />\n\n",
                "core.get_session_remaining_time(:p_session_id = {$session_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK", "code"=>$ex2->getCode()];
        }
    }
}
