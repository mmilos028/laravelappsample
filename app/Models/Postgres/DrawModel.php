<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class DrawModel
{

    private static $DEBUG = false;

	/**
     * @param $backoffice_session_id
     * @param $user_affiliate_id
     * @param $draw_id
     * @return array
     */
    public static function drawDetails($backoffice_session_id, $user_affiliate_id, $draw_id){
        try{

            if(self::$DEBUG){
                $message = "DrawModel::drawDetails >>> SELECT tomboladb.core.report_draw_details(:p_session_id = {$backoffice_session_id}, :p_logged_in_user = {$user_affiliate_id}, :p_draw_id_in = {$draw_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_draw_details(:p_session_id, :p_logged_in_user, :p_draw_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id' => $backoffice_session_id,
                    'p_logged_in_user' => $user_affiliate_id,
                    'p_draw_id_in' => $draw_id
                )
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_name_2 = $fn_result[0]->cur_jp_codes_for_draw;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");
            $cur_result_2 = DB::connection('pgsql')->select("fetch all in {$cursor_name_2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "draw_result"=>$cur_result,
                "jp_codes_result"=>$cur_result_2
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModel::drawDetails(backoffice_session_id = {$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, draw_id={$draw_id}) <br />\n\n",
                "tomboladb.core.report_draw_details(:p_session_id = {$backoffice_session_id}, :p_logged_in_user = {$user_affiliate_id}, :p_draw_id_in = {$draw_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModel::drawDetails(backoffice_session_id = {$backoffice_session_id}, user_affiliate_id={$user_affiliate_id}, draw_id={$draw_id}) <br />\n\n",
                "tomboladb.core.report_draw_details(:p_session_id = {$backoffice_session_id}, :p_logged_in_user = {$user_affiliate_id}, :p_draw_id_in = {$draw_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }
}
