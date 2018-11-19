<?php

namespace App\Models\Postgres;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;


class AuthModel
{

    private static $DEBUG = false;

    /**
     * @param $user_id
     * @return mixed
     */
    public static function retrieveById( $user_id ){

        if(self::$DEBUG){
            $message = "AuthModel::retrieveById SELECT tomboladb.core.get_subjects_details(:p_subject_id_in = {$user_id})";
            ErrorHelper::writeInfo($message, $message);
        }

        try {

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.get_subjects_details(:p_subject_id_in)";

            $cursor_result = DB::connection('pgsql')->select($statement_string, array('p_subject_id_in'=>$user_id));

            $cursor_name = $cursor_result[0]->cur_result_out;
            $result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            $user = [
                "user_id" => $result->subject_id,
                "username" => $result->username,
                "password" => $result->password,
                "first_name" => $result->first_name,
                "last_name" => $result->last_name,
                "backoffice_session_id" => $result->session_id
            ];

            return [
                'status' => "OK",
                'user' => $user
            ];
        }
        catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "AuthModel::retrieveById(user_id = {$user_id}) <br />\n\n",
                "tomboladb.core.get_subjects_details(:p_subject_id_in = {$user_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                'status' => "NOK",
                'user' => null
            ];
        }
        catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "AuthModel::retrieveById(user_id = {$user_id}) <br />\n\n",
                "tomboladb.core.get_subjects_details(:p_subject_id_in = {$user_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                'status' => "NOK",
                'user' => null
            ];
        }

    }

    /**
     * @param string $username
     * @param string $password
     * @param string $ip_address
     * @param string $device
     * @return mixed
     */
    public static function loginUser($username, $password, $ip_address, $city, $country, $device){
        try {
            $subject_type_id = config("constants.BACKOFFICE_SUBJECT_TYPE_ID");

            if(self::$DEBUG){
                $message = "AuthModel::loginUser >>> 
                SELECT * from tombola.core.log_in_subject(:p_username_in = {$username}, :p_password_in = {$password}, :p_subject_type_id = {$subject_type_id}, :p_ip_address = {$ip_address}, :p_city = {$city}, :p_country_name = {$country}, :p_login_platform = {$device})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = "SELECT * from core.log_in_subject(:p_username_in, :p_password_in, :p_subject_type_id, :p_ip_address, :p_city, :p_country_name, :p_login_platform)";
            //$statement_string = "SELECT * from tombola.log_in_subject(:p_username_in, :p_password_in, :p_subject_type_id, :ip_address, :p_login_platform)";
            $result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_username_in'=>$username,
                    'p_password_in'=>$password,
                    'p_subject_type_id'=>$subject_type_id,
                    'p_ip_address' => $ip_address,
                    'p_city' => $city,
                    'p_country_name' => $country,
                    'p_login_platform' => $device
                )
            );
            DB::connection('pgsql')->commit();

            $session_id = $result[0]->p_session_id_out;
            $status_out = $result[0]->p_status_out;

            if($status_out == "1"){
                $user = [
                    "username"=>$username,
                    "backoffice_session_id"=>$session_id
                ];
                return [
                    'status' => "OK",
                    'user' => $user
                ];
            }else{
                return [
                    'status' => "OK",
                    'user' => null
                ];
            }
        }
        catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "AuthModel::loginUser(username = {$username}, password={$password}, ip_address={$ip_address}, city={$city}, country={$country}, device={$device}) <br />\n\n",
                "core.log_in_subject(:p_username_in = {$username}, :p_password_in={$password}, :p_subject_type_id={$subject_type_id}, :ip_address={$ip_address}, city={$city}, country={$country}, :p_login_platform={$device}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                'status' => "NOK",
                'user' => null
            ];
        }
        catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "AuthModel::loginUser(username = {$username}, password={$password}, ip_address={$ip_address}, city={$city}, country={$country}, device={$device}) <br />\n\n",
                "core.log_in_subject(:p_username_in = {$username}, :p_password_in={$password}, :p_subject_type_id={$subject_type_id}, :ip_address={$ip_address}, city={$city}, country={$country}, :p_login_platform={$device}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                'status' => "NOK",
                'user' => null
            ];
        }
    }

    //tombola.db.core
    /**
     * @param $session_id
     * @return mixed
     */
    public static function logoutUser($session_id){
        try{

            if(self::$DEBUG){
                $message = "AuthModel::logoutUser >>> SELECT * from tombola.log_out_subject(:p_session_id = {$session_id})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tombola.log_out_subject(:p_session_id)";
            $result = DB::connection('pgsql')->select($statement_string, array('p_session_id'=>$session_id));
            DB::connection('pgsql')->commit();
            return array(
                "status"=>"OK",
                "status_out"=>$result[0]->p_status_out,
            );
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "AuthModel::logoutUser(session_id={$session_id}) <br />\n\n",
                "tombola.log_out_subject(:p_session_id = {$session_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return array(
                "status"=>"NOK",
                "exception_type" => "PDOException",
                "error_message"=>$message
            );
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "AuthModel::logoutUser(session_id={$session_id}) <br />\n\n",
                "tombola.log_out_subject(:p_session_id = {$session_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return array(
                "status"=>"NOK",
                "exception_type" => "Exception",
                "error_message"=>$message
            );
        }
    }

}
