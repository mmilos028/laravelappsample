<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class StructureEntityModel
{

    private static $DEBUG = false;

    /**
     * @param $backoffice_session_id
     * @param $username
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $city
     * @param $country_id
     * @param $mobile_phone
     * @param $currency
     * @param $banned_status
     * @param $subject_type_id
     * @param $subject_id
     * @return array
     */
    public static function searchEntity($backoffice_session_id, $username = null, $first_name = null,
      $last_name = null, $email = null, $city = null, $country_id = null, $mobile_phone = null, $currency = null, $banned_status = null, $subject_type_id = null, $subject_id = null
    ){
        if(self::$DEBUG){
            $message = "StructureEntityModel::searchEntity >>> SELECT tomboladb.core.search_entity(:p_session_id_in = {$backoffice_session_id},
              :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
              :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
              :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$subject_id}
               'cur_result_out')";
            ErrorHelper::writeInfo($message, $message);
        }
       try{
            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.search_entity(:p_session_id_in, :p_username_in, :p_first_name_in, :p_last_name_in, :p_email_in, :p_city_in, :p_country_id_in, :p_mobile_phone_in, :p_currency_in, :p_banned_status_in, :p_subject_type_id_in, :p_subject_id_in)';
            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_username_in' => $username,
                    'p_first_name_in' => $first_name,
                    'p_last_name_in' => $last_name,
                    'p_email_in' => $email,
                    'p_city_in' => $city,
                    'p_country_id_in' => $country_id,
                    'p_mobile_phone_in' => $mobile_phone,
                    'p_currency_in' => $currency,
                    'p_banned_status_in' => $banned_status,
                    'p_subject_type_id_in' => $subject_type_id,
                    'p_subject_id_in' => $subject_id
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_users"=>$cur_result
            ];
       }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "StructureEntityModel::searchEntity(backoffice_session_id={$backoffice_session_id}, username={$username}, first_name={$first_name},
                  last_name={$last_name}, email={$email}, city={$city}, country_id={$country_id}, mobile_phone={$mobile_phone}, currency={$currency}, banned_status={$banned_status}, subject_type_id={$subject_type_id}, 
                  subject_id={$subject_id}
                ) <br />\n\n",
                "tomboladb.core.search_entity(:p_session_id_in = {$backoffice_session_id},
                  :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
                  :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
                  :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$subject_id}
                   'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_users" => null
            ];
       }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "StructureEntityModel::searchEntity(backoffice_session_id={$backoffice_session_id}, username={$username}, first_name={$first_name},
                  last_name={$last_name}, email={$email}, city={$city}, country_id={$country_id}, mobile_phone={$mobile_phone}, currency={$currency}, banned_status={$banned_status}, subject_type_id={$subject_type_id}, 
                  subject_id={$subject_id}
                ) <br />\n\n",
                "tomboladb.core.search_entity(:p_session_id_in = {$backoffice_session_id},
                  :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
                  :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
                  :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$subject_id}
                   'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_users" => null
            ];
        }
    }

    public static function getStructureEntityTreeForEntityParameterSetup($parent_id){
        try{

            if(self::$DEBUG){
                $message = "StructureEntityModel::getStructureEntityTree >>> SELECT * from tomboladb.core.get_tree_without_location( 
                :p_parent_id = {$parent_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from core.get_tree_without_location(:p_parent_id)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_parent_id" => $parent_id
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
                "StructureEntityModel::getStructureEntityTreeForEntityParameterSetup(parent_id={$parent_id}) <br />\n\n",
                "tomboladb.core.get_tree_without_location( :p_parent_id = {$parent_id}, 'cur_result_out' ) <br />\n\n",
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
                "StructureEntityModel::getStructureEntityTreeForEntityParameterSetup(parent_id={$parent_id}) <br />\n\n",
                "tomboladb.core.get_tree_without_location( :p_parent_id = {$parent_id}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result"=>[]
            ];
        }
    }
}
