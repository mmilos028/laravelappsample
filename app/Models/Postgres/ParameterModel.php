<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class ParameterModel
{

    private static $DEBUG = false;

    /**
     * @param array $details
     * @return array
     */
    public static function addNewParameter($details){

        if(self::$DEBUG){
            $message = "ParameterModel::addNewParameter >>> SELECT tomboladb.core.create_parameter(
            :p_parameter_name_in = {$details['parameter_name']}, :p_parameter_bo_name = {$details['backoffice_parameter_name']})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.create_parameter(:p_parameter_name_in, :p_parameter_bo_name)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_parameter_name_in'=>$details['parameter_name'],
                    'p_parameter_bo_name' => $details['backoffice_parameter_name']
                ]
            );
            DB::connection('pgsql')->commit();
            if($fn_result[0]->create_parameter == 1){
                return ['status'=>"OK"];
            }else{
                return ['status'=>"NOK"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::addNewParameter(details = ". print_r($details, true) . ") <br />\n\n",
                "tomboladb.core.create_parameter(
                    :p_parameter_name_in = {$details['parameter_name']}, :p_parameter_bo_name = {$details['backoffice_parameter_name']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::addNewParameter(details = ". print_r($details, true) . ") <br />\n\n",
                "tomboladb.core.create_parameter(
                    :p_parameter_name_in = {$details['parameter_name']}, :p_parameter_bo_name = {$details['backoffice_parameter_name']}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @param array $details
     * @return array
     */
    public static function updateParameters($details){

        if(self::$DEBUG){
            foreach($details as $det) {
                $message = "ParameterModel::updateParameters >>> SELECT tomboladb.core.update_parameter(:p_parameter_id = {$det['parameter_id']}, :p_parameter_name = {$det['parameter_name']},
                :p_parameter_bo_name = {$det['backoffice_parameter_name']})";
                ErrorHelper::writeInfo($message, $message);
            }
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.update_parameter(:p_parameter_id, :p_parameter_name, :p_parameter_bo_name)';
            foreach($details as $det) {
                $fn_result = DB::connection('pgsql')->select(
                    $statement_string,
                    [
                        'p_parameter_id' => $det['parameter_id'],
                        'p_parameter_name' => $det['parameter_name'],
                        'p_parameter_bo_name' => $det['backoffice_parameter_name'],
                    ]
                );
            }
            DB::connection('pgsql')->commit();
            /*if($fn_result[0]->update_parameter == 1){
                return ['status'=>"OK"];
            }else{
                return ['status'=>"NOK"];
            }*/
            return ["status" => "OK"];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::updateParameters(details = ". print_r($details, true) . ") <br />\n\n",
                "tomboladb.core.update_parameter( :p_parameter_id, :p_parameter_name, :p_parameter_bo_name) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::updateParameters(details = ". print_r($details, true) . ") <br />\n\n",
                "tomboladb.core.update_parameter( :p_parameter_id, :p_parameter_name, :p_parameter_bo_name) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @return array
     */
    public static function listParameters(){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_parameters();";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_parameters()";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string
            );

            $cursor_result = DB::connection('pgsql')->select("fetch all in \"cur_result_out\";");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_parameters" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::listParameters() <br />\n\n",
                "tomboladb.core.list_parameters() <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_parameters" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::listParameters() <br />\n\n",
                "tomboladb.core.list_parameters() <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_parameters" => []
            ];
        }
    }

    /**
     * @param array $details
     * @return array
     */
    public static function addNewUserParameter($details){

        if(self::$DEBUG){
            $message = "ParameterModel::addNewUserParameter >>> SELECT tomboladb.core.set_aff_parameters(:p_aff_id_in = {$details['user_id']}, :p_parameter_id_in = {$details['parameter_id']},
                :p_currency_in = {$details['currency']}, :p_value_in = {$details['parameter_value']})";
            ErrorHelper::writeInfo($message, $message);
        }

        //return['status'=>"OK"];

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.set_aff_parameters(:p_aff_id_in, :p_parameter_id_in, :p_currency_in, :p_value_in)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_aff_id_in'=>$details['user_id'],
                    'p_parameter_id_in'=>$details['parameter_id'],
                    'p_currency_in'=>$details['currency'],
                    'p_value_in'=>$details['parameter_value']
                ]
            );
            DB::connection('pgsql')->commit();
            if($fn_result[0]->set_aff_parameters == 1){
                return ['status'=>"OK"];
            }else{
                return ['status'=>"NOK"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::addNewUserParameter(" . print_r($details, true) . ")<br />\n\n",
                "tomboladb.core.set_aff_parameters(:p_aff_id_in = {$details['user_id']}, :p_parameter_id_in = {$details['parameter_id']},
                :p_currency_in = {$details['currency']}, :p_value_in = {$details['parameter_value']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::addNewUserParameter(" . print_r($details, true) . ")<br />\n\n",
                "tomboladb.core.set_aff_parameters(:p_aff_id_in = {$details['user_id']}, :p_parameter_id_in = {$details['parameter_id']},
                :p_currency_in = {$details['currency']}, :p_value_in = {$details['parameter_value']}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @return array
     */
    public static function listUserParameters($user_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_aff_parameters_w_values(p_aff_id = {$user_id});";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_aff_parameters_w_values(:p_aff_id)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_aff_id" => $user_id
                ]
            );

            $cursor_result = DB::connection('pgsql')->select("fetch all in \"cur_result_out\";");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_parameters" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::listUserParameters(user_id = {$user_id}) <br />\n\n",
                "tomboladb.core.list_aff_parameters_w_values(:p_aff_id = {$user_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_parameters" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::listUserParameters(user_id = {$user_id}) <br />\n\n",
                "tomboladb.core.list_aff_parameters_w_values(:p_aff_id = {$user_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_parameters" => []
            ];
        }
    }

    /**
     * @return array
     */
    public static function listUserParametersForClientAndOperater($user_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_aff_param_for_change(p_aff_id = {$user_id});";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_aff_param_for_change(:p_aff_id)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_aff_id" => $user_id
                ]
            );

            $cursor_result = DB::connection('pgsql')->select("fetch all in \"cur_result_out\";");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_parameters" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::listUserParametersForClientAndOperater(user_id = {$user_id}) <br />\n\n",
                "tomboladb.core.tomboladb.core.list_aff_param_for_change(:p_aff_id = {$user_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_parameters" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::listUserParametersForClientAndOperater(user_id = {$user_id}) <br />\n\n",
                "tomboladb.core.tomboladb.core.list_aff_param_for_change(:p_aff_id = {$user_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_parameters" => []
            ];
        }
    }

    /**
     * @param array $details
     * @return array
     */
    public static function updateUserParameter($details){

        if(self::$DEBUG){
        //if(true){
            foreach($details as $det) {
                $message = "ParameterModel::updateUserParameter >>> SELECT tomboladb.core.set_aff_parameters(:p_aff_id_in = {$det['user_id']}, :p_parameter_id_in = {$det['parameter_id']},
                :p_currency_in = {$det['currency']}, :p_value_in = {$det['parameter_value']})";
                ErrorHelper::writeInfo($message, $message);
            }
        }

        //return ['status'=>"OK"];

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.update_aff_parameters(:p_aff_parameter_value_id, :p_aff_id_in, :p_parameter_id_in, :p_currency_in, :p_value_in)';

            foreach($details as $det){
                DB::connection('pgsql')->select(
                    $statement_string,
                    [
                        'p_aff_parameter_value_id' => $det['user_parameter_value_id'],
                        'p_aff_id_in'=>$det['user_id'],
                        'p_parameter_id_in'=>$det['parameter_id'],
                        'p_currency_in'=>$det['currency'],
                        'p_value_in'=>$det['parameter_value']
                    ]
                );
            }
            DB::connection('pgsql')->commit();
            return ['status'=>"OK"];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::updateUserParameter(details =" . print_r($details, true) . ")<br />\n\n",
                "tomboladb.core.tomboladb.core.update_aff_parameters(:p_aff_parameter_value_id, :p_aff_id_in, :p_parameter_id_in, :p_currency_in, :p_value_in) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::updateUserParameter(details =" . print_r($details, true) . ")<br />\n\n",
                "tomboladb.core.tomboladb.core.update_aff_parameters(:p_aff_parameter_value_id, :p_aff_id_in, :p_parameter_id_in, :p_currency_in, :p_value_in) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @param array $details
     * @return array
     */
    public static function deleteUserParameter($details){

        if(self::$DEBUG){
            foreach($details as $det) {
                $message = "ParameterModel::deleteUserParameter >>> SELECT tomboladb.core.remove_aff_parameters(:p_aff_parameter_value_id = {$det['user_parameter_value_id']}, :p_status_out})";
                ErrorHelper::writeInfo($message, $message);
            }
        }

        try{
            //dd($details);

            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.remove_aff_parameters(:p_aff_parameter_value_id)';

            $deleted = 0;
            $notDeleted = 0;

            foreach($details as $det){
                $fn_result = DB::connection('pgsql')->select(
                    $statement_string,
                    [
                        'p_aff_parameter_value_id' => $det['user_parameter_value_id']
                    ]
                );

                $status = $fn_result[0]->remove_aff_parameters;

                ErrorHelper::writeError("Status: ".$status." | Param id: ".$det['user_parameter_value_id'], "Status: ".$status." | Param id: ".$det['user_parameter_value_id']);

                if($status == 1){
                    $deleted++;
                }else{
                    $notDeleted++;
                }
            }

            DB::connection('pgsql')->commit();

            return ['status'=>"OK", "deleted" => $deleted, "notDeleted" => $notDeleted];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::deleteUserParameter(details =" . print_r($details, true) . ")<br />\n\n",
                "tomboladb.core.tomboladb.core.remove_aff_parameters(:p_aff_parameter_value_id, :p_aff_id_in, :p_parameter_id_in, :p_currency_in, :p_value_in) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ParameterModel::deleteUserParameter(details =" . print_r($details, true) . ")<br />\n\n",
                "tomboladb.core.tomboladb.core.remove_aff_parameters(:p_aff_parameter_value_id, :p_aff_id_in, :p_parameter_id_in, :p_currency_in, :p_value_in) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }
}
