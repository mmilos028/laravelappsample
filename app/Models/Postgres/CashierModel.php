<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class CashierModel
{

    private static $DEBUG = false;
    //private static $DEBUG = true;

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function getLocationAddress($backoffice_session_id, $location_id){
      try{

            if(self::$DEBUG){
                $message = "
                CashierModel::getLocationAddress(backoffice_session_id = {$backoffice_session_id}, location_id = {$location_id}) >>>
                SELECT * from tomboladb.core.get_location_address(p_location_id_in = {$location_id}, p_city, p_address, p_commercial_address )
                ";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.get_location_address(:p_location_id_in)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_location_id_in" => $location_id
                ]
            );

            $city = $fn_result[0]->p_city;
            $address = $fn_result[0]->p_address;
            $commercial_address = $fn_result[0]->p_commercial_address;

            DB::connection('pgsql')->commit();

            $response = [
                "status" => "OK",
                "city" => $city,
                "address" => $address,
                "commercial_address" => $commercial_address
            ];

            if(self::$DEBUG){
              ErrorHelper::writeToFirebug("CashierModel::getLocationAddress(backoffice_session_id = {$backoffice_session_id}, location_id = {$location_id})", $response);
            }

            return $response;
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CashierModel::getLocationAddress(backoffice_session_id = {$backoffice_session_id}, location_id={$location_id}) <br />\n\n",
                "tomboladb.core.get_location_address(:p_location_id_in = {$location_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CashierModel::getLocationAddress(backoffice_session_id = {$backoffice_session_id}, location_id={$location_id}) <br />\n\n",
                "tomboladb.core.get_location_address(:p_location_id_in = {$location_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listCashiers($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "CashierModel::listCashiers >>> SELECT * from tomboladb.core.list_cashiers( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_cashiers( :p_session_id_in  )";
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
                "list_cashiers" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CashierModel::listCashiers(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_cashiers( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_cashiers" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CashierModel::listCashiers(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_cashiers( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_cashiers" => []
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $user_id
     * @return array
     */
    public static function setCashierPinCode($backoffice_session_id, $user_id){

        if(self::$DEBUG){
            $message = "CashierModel::setCashierPinCode >>> SELECT tomboladb.tombola.set_cashier_pin(:p_cashier_id = {$user_id})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.tombola.set_cashier_pin(:p_cashier_id)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_cashier_id' => $user_id
                ]
            );
            DB::connection('pgsql')->commit();
            if($fn_result[0]->set_cashier_pin == 1) {
                return ['status' => "OK"];
            }else{
                return ['status' => "NOK"];
            }

        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CashierModel::setCashierPinCode(backoffice_session_id = {$backoffice_session_id}, user_id={$user_id}) <br />\n\n",
                "tomboladb.tombola.set_cashier_pin(:p_cashier_id = {$user_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CashierModel::setCashierPinCode(backoffice_session_id = {$backoffice_session_id}, user_id={$user_id}) <br />\n\n",
                "tomboladb.tombola.set_cashier_pin(:p_cashier_id = {$user_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $user_id
     * @return array
     */
    public static function getCashierPinCode($backoffice_session_id, $user_id){

        if(self::$DEBUG){
            $message = "CashierModel::getCashierPinCode >>> SELECT tomboladb.tombola.get_cashier_pin(:p_cashier_id = {$user_id})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.tombola.get_cashier_pin(:p_cashier_id)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_cashier_id' => $user_id
                ]
            );
            DB::connection('pgsql')->commit();
            if($fn_result[0]->get_cashier_pin > 0) {
                return ["status" => "OK", "cashier_pin_code" => $fn_result[0]->get_cashier_pin];
            }else{
                return ["status"=>"NOK"];
            }

        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CashierModel::getCashierPinCode(backoffice_session_id = {$backoffice_session_id}, user_id={$user_id}) <br />\n\n",
                "tomboladb.tombola.get_cashier_pin(:p_cashier_id = {$user_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "CashierModel::getCashierPinCode(backoffice_session_id = {$backoffice_session_id}, user_id={$user_id}) <br />\n\n",
                "tomboladb.tombola.get_cashier_pin(:p_cashier_id = {$user_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }
}
