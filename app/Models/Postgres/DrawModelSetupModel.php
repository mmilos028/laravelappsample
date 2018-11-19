<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use PDO;

use App\Helpers\ErrorHelper;

class DrawModelSetupModel
{

    private static $DEBUG = false;

    public static function listAllDrawModelsForCurrency($backoffice_session_id, $currency){
        try{
            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_draw_models_for_currency( :p_session_id = {$backoffice_session_id}, :p_currency = {$currency}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_draw_models_for_currency(:p_session_id, :p_currency)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id" => $backoffice_session_id,
                    "p_currency" => $currency
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_draw_models" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::listAllDrawModelsForCurrency(backoffice_session_id = {$backoffice_session_id}, p_currency = {$currency}) <br />\n\n",
                "tomboladb.core.list_draw_models_for_currency( :p_session_id = {$backoffice_session_id},:p_currency = {$currency}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage()
            ]);

            ErrorHelper::writeError($message, $message);

            return [
                "status" => "NOK",
                "list_draw_models" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::listAllDrawModelsForCurrency(backoffice_session_id = {$backoffice_session_id}, p_currency = {$currency}) <br />\n\n",
                "tomboladb.core.list_draw_models_for_currency( :p_session_id = {$backoffice_session_id},:p_currency = {$currency}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage()
            ]);

            ErrorHelper::writeError($message, $message);

            return [
                "status" => "NOK",
                "list_draw_models" => []
            ];
        }
    }

    public static function getDrawModelDetailsForAff($aff_id){
        if(self::$DEBUG){
            $message = "DrawModelSetupModel::getDrawModelForAff >>> SELECT tomboladb.core.get_draw_model_details_for_aff(:p_aff_id = {$aff_id})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.get_draw_model_details_for_aff(:p_aff_id)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_aff_id' => $aff_id,
                ]
            );

            $cursor_name = $fn_result[0]->get_draw_model_details_for_aff;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::getDrawModelDetailsForAff(aff_id = {$aff_id}) <br />\n\n",
                "tomboladb.core.get_draw_model_details_for_aff(:p_aff_id = {$aff_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::getDrawModelDetailsForAff(aff_id = {$aff_id}) <br />\n\n",
                "tomboladb.core.get_draw_model_details_for_aff(:p_aff_id = {$aff_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    public static function getDrawModelForAff($aff_id){
        if(self::$DEBUG){
            $message = "DrawModelSetupModel::getDrawModelForAff >>> SELECT tomboladb.tombola.get_draw_model_for_aff(:p_aff_id = {$aff_id})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.tombola.get_draw_model_for_aff(:p_aff_id)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_aff_id' => $aff_id,
                ]
            );

            //ErrorHelper::writeError($fn_result[0]->get_draw_model_for_aff, $fn_result[0]->get_draw_model_for_aff);

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "model_id" => $fn_result[0]->get_draw_model_for_aff
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::getDrawModelForAff(aff_id = {$aff_id}) <br />\n\n",
                "tomboladb.tombola.get_draw_model_for_aff(:p_aff_id = {$aff_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::getDrawModelForAff(aff_id = {$aff_id}) <br />\n\n",
                "tomboladb.tombola.get_draw_model_for_aff(:p_aff_id = {$aff_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }
    public static function listAllDrawModels($backoffice_session_id, $logged_in, $parent_id){
        try{
            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_all_draw_models( :p_session_id = {$backoffice_session_id}, :p_logged_in_user={$logged_in}, 
                            :p_parent_id={$parent_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_all_draw_models(:p_session_id, :p_logged_in_user, :p_parent_id)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id" => $backoffice_session_id,
                    "p_logged_in_user" => $logged_in,
                    "p_parent_id" => $parent_id
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();
            return [
                "status" => "OK",
                "list_draw_models" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::listAllDrawModels(backoffice_session_id = {$backoffice_session_id}, p_logged_in_user = {$logged_in}, p_parent_id = {$parent_id}) <br />\n\n",
                "tomboladb.core.list_all_draw_models( :p_session_id = {$backoffice_session_id},:p_logged_in_user = {$logged_in},:p_parent_id = {$parent_id}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_draw_models" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::listAllDrawModels(backoffice_session_id = {$backoffice_session_id}, p_logged_in_user = {$logged_in}, p_parent_id = {$parent_id}) <br />\n\n",
                "tomboladb.core.list_all_draw_models( :p_session_id = {$backoffice_session_id},:p_logged_in_user = {$logged_in},:p_parent_id = {$parent_id}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_draw_models" => []
            ];
        }
    }

    public static function listDrawModelAffiliates($session_id, $logged_in, $parent_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_aff_draw_model( :p_session_id = {$session_id}, :p_logged_in_user = {$logged_in}, :p_parent_id = {$parent_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_aff_draw_model( :p_session_id, :p_logged_in_user, :p_parent_id)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id" => $session_id,
                    "p_logged_in_user" => $logged_in,
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
            $message = implode(" " , [
                "DrawModelSetupModel::listDrawModelAffiliates(p_session_id = {$session_id}, :p_logged_in_user = {$logged_in}, :p_parent_id = {$parent_id}) <br />\n\n",
                "tomboladb.core.list_aff_draw_model( :p_session_id = {$session_id}, :p_logged_in_user = {$logged_in}, :p_parent_id = {$parent_id}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_draw_models" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::listDrawModelAffiliates(p_session_id = {$session_id}, :p_logged_in_user = {$logged_in}, :p_parent_id = {$parent_id}) <br />\n\n",
                "tomboladb.core.list_aff_draw_model( :p_session_id = {$session_id}, :p_logged_in_user = {$logged_in}, :p_parent_id = {$parent_id}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_draw_models" => []
            ];
        }
    }


    public static function listDrawModels($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_draw_models( :p_session_id = {$backoffice_session_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_draw_models( :p_session_id )";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id" => $backoffice_session_id
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();
            return [
                "status" => "OK",
                "list_draw_models" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::listDrawModels(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_draw_models( :p_session_id = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_draw_models" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::listDrawModels(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_draw_models( :p_session_id = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_draw_models" => []
            ];
        }
    }

    public static function createNewDrawModel($backoffice_session_id, $subject_id, $draw_model_name, $currency, $active_inactive, $draw_sequence,
                                              $draw_active_from, $draw_active_to, $control_free, $bet_win, $super_draw, $super_draw_coefficient, $super_draw_frequency){

        if(self::$DEBUG){
            $message = "DrawModelSetupModel::createNewDrawModel >>> SELECT tomboladb.core.create_draw_model(
            :p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, :p_currency = {$currency}, 
            :p_rec_sts = {$active_inactive}, :p_draw_sequence_in_minutes = {$draw_sequence}, :p_draw_active_from = {$draw_active_from}, 
             :p_draw_active_to = {$draw_active_to}, :p_under_control = {$control_free}, :p_payback_percent = {$bet_win}, :p_super_draw = {$super_draw}, 
             :p_super_draw_coeficient = {$super_draw_coefficient}, :p_super_draw_frequency = {$super_draw_frequency})";

            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT * from tomboladb.core.create_draw_model(:p_session_id, :p_logged_in_subject, :p_draw_model_name, :p_currency, :p_rec_sts, 
            :p_draw_sequence_in_minutes, :p_draw_active_from, :p_draw_active_to, :p_under_control, :p_payback_percent, :p_super_draw, :p_super_draw_coeficient, 
            :p_super_draw_frequency)';

            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_session_id' => $backoffice_session_id,
                    'p_logged_in_subject' => $subject_id,
                    'p_draw_model_name' => $draw_model_name,
                    'p_currency' => $currency,
                    'p_rec_sts' => $active_inactive,
                    "p_draw_sequence_in_minutes" => $draw_sequence,
                    "p_draw_active_from" => $draw_active_from,
                    "p_draw_active_to" => $draw_active_to,
                    "p_under_control" =>$control_free,
                    "p_payback_percent" => $bet_win,
                    "p_super_draw" => $super_draw,
                    "p_super_draw_coeficient" => $super_draw_coefficient,
                    "p_super_draw_frequency" => $super_draw_frequency
                ]
            );
            DB::connection('pgsql')->commit();

            $status_out = $fn_result[0]->p_status_out;
            //$status_out = $fn_result[0]->create_draw_model;

            if($status_out >= 0){
                $message = implode(" " , [
                    "DrawModelSetupModel::createNewDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                    "tomboladb.core.create_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}, p_status_out = {$status_out} ) <br />\n\n",
                    "response = 'Success'"
                ]);

                //ErrorHelper::writeError($message, $message);
                return ['status'=>"OK", 'code' => 1];
            }
            else if($status_out == -4){
                $message = implode(" " , [
                    "DrawModelSetupModel::createNewDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                    "tomboladb.core.create_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}, p_status_out = {$status_out} ) <br />\n\n",
                    "response = 'time frame for draw model is expired, draws will be generated by midnight with the rest of draw models'"
                ]);
                //ErrorHelper::writeError($message, $message);
                return ['status'=>"OK", 'code' => -4, 'message' => 'Time frame for draw model is expired, draws will be generated by midnight with the rest of draw models' ];
            }
            else if($status_out == -3){
                $message = implode(" " , [
                    "DrawModelSetupModel::createNewDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                    "tomboladb.core.create_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}, p_status_out = {$status_out} ) <br />\n\n",
                    "response = 'draws hasn't been generated due to unexpected error but they will be generated by midnight with the rest of draw models'"
                ]);
                //ErrorHelper::writeError($message, $message);
                return ['status'=>"OK", 'code' => -3, 'message' => 'Draws hasn\'t been generated due to unexpected error but they will be generated by midnight with the rest of draw models' ];
            }
            else if($status_out == -2){
                $message = implode(" " , [
                "DrawModelSetupModel::createNewDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                "tomboladb.core.create_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}, p_status_out = {$status_out} ) <br />\n\n",
                "response = 'Model name already exists'"
                ]);
                return ['status'=>"NOK", 'code' => -2, 'message' => 'Model name already exists'];
            }
            else if($status_out == -1){
                $message = implode(" " , [
                    "DrawModelSetupModel::createNewDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                    "tomboladb.core.create_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}, p_status_out = {$status_out} ) <br />\n\n",
                "response = 'General error occurred'"
                ]);
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'code' => -1, 'message' => 'General error occurred'];
            }
            else{
                $message = implode(" " , [
                    "DrawModelSetupModel::createNewDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                    "tomboladb.core.create_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}, status = {$status_out} ) <br />\n\n",
                "response = 'Unknown error occurred'"
                ]);
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'code' => $status_out, 'message' => 'Unknown error occurred' ];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::createNewDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                "tomboladb.core.create_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::createNewDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free}) <br />\n\n",
                "tomboladb.core.create_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_name = {$draw_model_name}, p_currency={$currency}, p_rec_sts={$active_inactive}, 
                    p_draw_sequence_in_minutes={$draw_sequence}, p_draw_active_from={$draw_active_from}, p_draw_active_to={$draw_active_to}, p_under_control={$control_free} ) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    public static function updateDrawModel($backoffice_session_id, $subject_id, $draw_model_id, $draw_model_name, $record_status, $sequence, $active_from,
                                           $active_to, $control_free, $bet_win, $super_draw, $super_draw_coefficient, $super_draw_frequency){
        if(self::$DEBUG){
            $message = "DrawModelSetupModel::updateDrawModel >>> SELECT tomboladb.core.update_draw_model(
            :p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, :p_draw_model_id = {$draw_model_id}, :p_draw_model_name = {$draw_model_name},
            :p_rec_sts = {$record_status}, :p_payback_percent = {$bet_win}, :p_super_draw = {$super_draw}, :p_super_draw_coeficient = {$super_draw_coefficient}, :p_super_draw_frequency = {$super_draw_frequency})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT * from tomboladb.core.update_draw_model(:p_session_id, :p_logged_in_subject, :p_draw_model_id, :p_draw_model_name, :p_rec_sts, 
            :draw_sequence_in_minutes, :p_draw_active_from, :p_draw_active_to, :p_under_control, :p_payback_percent, :p_super_draw, :p_super_draw_coeficient, :p_super_draw_frequency)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_session_id' => $backoffice_session_id,
                    'p_logged_in_subject' => $subject_id,
                    'p_draw_model_id' => $draw_model_id,
                    'p_draw_model_name' => $draw_model_name,
                    'p_rec_sts' => $record_status,
                    "draw_sequence_in_minutes" => $sequence,
                    "p_draw_active_from" => $active_from,
                    "p_draw_active_to" => $active_to,
                    "p_under_control" => $control_free,
                    "p_payback_percent" => $bet_win,
                    "p_super_draw" => $super_draw,
                    "p_super_draw_coeficient" => $super_draw_coefficient,
                    "p_super_draw_frequency" => $super_draw_frequency,
                ]
            );
            DB::connection('pgsql')->commit();

            $status_out = $fn_result[0]->p_status_out;
            //$status_out = $fn_result[0]->update_draw_model;

            if($status_out >= 0){
                return ['status'=>"OK", 'code' => 1];
            }
            else if($status_out == -4){
                $message = implode(" " , [
                "DrawModelSetupModel::updateDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, rec_sts = {$record_status}) result = {$status_out}) <br />\n\n",
                "tomboladb.core.update_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, 
                :p_draw_model_id = {$draw_model_id}, :p_draw_model_name = {$draw_model_name}, :p_rec_sts = {$record_status}, :draw_sequence_in_minutes = {$sequence}, 
                 :p_draw_active_from = {$active_from}, :p_draw_active_to = {$active_to}, :p_under_control = {$control_free}, :p_payback_percent = {$bet_win}, :p_status_out = {$status_out}) <br />\n\n",
                "response = 'Model name already exists'"
                ]);
                ErrorHelper::writeError($message, $message);
                return ['status'=>"OK", 'code' => -4, 'message' => 'time frame for draw model is expired, draws will be generated by midnight with the rest of draw models'];
            }
            else if($status_out == -3){
                $message = implode(" " , [
                "DrawModelSetupModel::updateDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, rec_sts = {$record_status}) result = {$status_out}) <br />\n\n",
                "tomboladb.core.update_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, 
                :p_draw_model_id = {$draw_model_id}, :p_draw_model_name = {$draw_model_name}, :p_rec_sts = {$record_status}, :draw_sequence_in_minutes = {$sequence}, 
                 :p_draw_active_from = {$active_from}, :p_draw_active_to = {$active_to}, :p_under_control = {$control_free}, :p_payback_percent = {$bet_win}, :p_status_out = {$status_out}) <br />\n\n",
                "response = 'Model name already exists'"
                ]);
                ErrorHelper::writeError($message, $message);
                return ['status'=>"OK", 'code' => -3, 'message' => 'draws hasn\'t been generated due to unexpected error but they will be generated by midnight with the rest of draw models'];
            }
            else if($status_out == -2){
                $message = implode(" " , [
                "DrawModelSetupModel::updateDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, rec_sts = {$record_status}) result = {$status_out}) <br />\n\n",
                "tomboladb.core.update_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, 
                :p_draw_model_id = {$draw_model_id}, :p_draw_model_name = {$draw_model_name}, :p_rec_sts = {$record_status}, :draw_sequence_in_minutes = {$sequence}, 
                 :p_draw_active_from = {$active_from}, :p_draw_active_to = {$active_to}, :p_under_control = {$control_free}, :p_payback_percent = {$bet_win}, :p_status_out = {$status_out}) <br />\n\n",
                "response = 'Model name already exists'"
                ]);
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'code' => -2, 'message' => 'Model name already exists'];
            }
            else if($status_out == -1){
                $message = implode(" " , [
                "DrawModelSetupModel::updateDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, rec_sts = {$record_status}) result = {$status_out}) <br />\n\n",
                    "tomboladb.core.update_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, 
                :p_draw_model_id = {$draw_model_id}, :p_draw_model_name = {$draw_model_name}, :p_rec_sts = {$record_status}, :draw_sequence_in_minutes = {$sequence}, 
                 :p_draw_active_from = {$active_from}, :p_draw_active_to = {$active_to}, :p_under_control = {$control_free}, :p_payback_percent = {$bet_win}, :p_status_out = {$status_out}) <br />\n\n",
                "response = 'General error occurred'"
                ]);
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'code' => -1, 'message' => 'General error occurred'];
            }
            else{
                $message = implode(" " , [
                "DrawModelSetupModel::updateDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, rec_sts = {$record_status}) result = {$status_out}) <br />\n\n",
                    "tomboladb.core.update_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, 
                :p_draw_model_id = {$draw_model_id}, :p_draw_model_name = {$draw_model_name}, :p_rec_sts = {$record_status}, :draw_sequence_in_minutes = {$sequence}, 
                 :p_draw_active_from = {$active_from}, :p_draw_active_to = {$active_to}, :p_under_control = {$control_free}, :p_payback_percent = {$bet_win}, :p_status_out = {$status_out}) <br />\n\n",
                "response = 'Unknown error occurred'"
                ]);
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'code' => $status_out, 'message' => 'Unknown error occurred' ];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::updateDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, rec_sts = {$record_status}) <br />\n\n",
                "tomboladb.core.update_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, 
                :p_draw_model_id = {$draw_model_id}, :p_draw_model_name = {$draw_model_name}, :p_rec_sts = {$record_status}, :draw_sequence_in_minutes = {$sequence}, 
                 :p_draw_active_from = {$active_from}, :p_draw_active_to = {$active_to}, :p_under_control = {$control_free}, :p_payback_percent = {$bet_win}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" " , [
                "DrawModelSetupModel::updateDrawModel(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, draw_model_name={$draw_model_name}, rec_sts = {$record_status}) <br />\n\n",
                "tomboladb.core.update_draw_model(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject = {$subject_id}, 
                :p_draw_model_id = {$draw_model_id}, :p_draw_model_name = {$draw_model_name}, :p_rec_sts = {$record_status}, :draw_sequence_in_minutes = {$sequence}, 
                 :p_draw_active_from = {$active_from}, :p_draw_active_to = {$active_to}, :p_under_control = {$control_free}, :p_payback_percent = {$bet_win}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    //
    public static function drawModelDetails($backoffice_session_id, $draw_model_id)
    {
        //core.get_draw_model_details(p_draw_model_id bigint, OUT cur_result_out refcursor)
        if (self::$DEBUG) {
            $message = "SELECT * from tomboladb.core.get_draw_model_details( :p_draw_model_id = {$draw_model_id}, 'cur_result_out' )";
            ErrorHelper::writeInfo($message, $message);
        }
        try {
            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.get_draw_model_details( :p_draw_model_id )";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_draw_model_id" => $draw_model_id
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();
            return [
                "status" => "OK",
                "draw_model_details" => $cursor_result[0]
            ];
        } catch (\PDOException $ex1) {
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "DrawModelSetupModel::drawModelDetails(backoffice_session_id = {$backoffice_session_id}, draw_model_id={$draw_model_id}) <br />\n\n",
                "tomboladb.core.get_draw_model_details( :p_draw_model_id = {$draw_model_id} ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "draw_model_details" => []
            ];
        } catch (\Exception $ex2) {
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "DrawModelSetupModel::drawModelDetails(backoffice_session_id = {$backoffice_session_id}, draw_model_id={$draw_model_id}) <br />\n\n",
                "tomboladb.core.get_draw_model_details( :p_draw_model_id = {$draw_model_id} ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "draw_model_details" => []
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $affiliate_id
     * @param $draw_model_id
     * @return array
     */
    public static function addDrawModelToAffiliate($backoffice_session_id, $affiliate_id, $draw_model_id){
        if(self::$DEBUG){
            $message = "DrawModelSetupModel::addDrawModelToAffiliate >>> SELECT tomboladb.tombola.add_draw_model_to_aff(
            :p_aff_id = {$affiliate_id}, :p_draw_model_id = {$draw_model_id})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.tombola.add_draw_model_to_aff(:p_aff_id, :p_draw_model_id)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_aff_id' => $affiliate_id,
                    'p_draw_model_id' => $draw_model_id
                ]
            );

            //ErrorHelper::writeError($fn_result[0]->add_draw_model_to_af, $fn_result[0]->add_draw_model_to_af);

            DB::connection('pgsql')->commit();

            if($fn_result[0]->add_draw_model_to_aff >= 0){
                return ['status'=>"OK"];
            }elseif ($fn_result[0]->add_draw_model_to_aff >= -3){
                $message = "DrawModelSetupModel::addDrawModelToAffiliate(backoffice_session_id = {$backoffice_session_id}, p_aff_id = {$affiliate_id}, p_draw_model_id = {$draw_model_id}) result = {$fn_result[0]->add_draw_model_to_aff} response = The currency of the affiliate and the currency of the model are not the same.";
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'code' => $fn_result[0]->add_draw_model_to_aff, 'message' => trans('authenticated.The currency of the affiliate and the currency of the model are not the same.') ];
            }else{
                $message = "DrawModelSetupModel::addDrawModelToAffiliate(backoffice_session_id = {$backoffice_session_id}, p_aff_id = {$affiliate_id}, p_draw_model_id = {$draw_model_id}) result = {$fn_result[0]->add_draw_model_to_aff} response = Unknown error occurred";
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'code' => $fn_result[0]->add_draw_model_to_aff, 'message' => 'Unknown error occurred' ];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "DrawModelSetupModel::addDrawModelToAffiliate(backoffice_session_id = {$backoffice_session_id}, affiliate_id = {$affiliate_id}, draw_model_id={$draw_model_id}) <br />\n\n",
                "tomboladb.tombola.add_draw_model_to_aff( :p_aff_id = {$affiliate_id}, :p_draw_model_id = {$draw_model_id} ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "DrawModelSetupModel::addDrawModelToAffiliate(backoffice_session_id = {$backoffice_session_id}, affiliate_id = {$affiliate_id}, draw_model_id={$draw_model_id}) <br />\n\n",
                "tomboladb.tombola.add_draw_model_to_aff( :p_aff_id = {$affiliate_id}, :p_draw_model_id = {$draw_model_id} ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

     /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listFeeds($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.get_all_feeds( 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.get_all_feeds()";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();
            return [
                "status" => "OK",
                "list_feeds" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "DrawModelSetupModel::listFeeds(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.get_all_feeds() <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_feeds" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "DrawModelSetupModel::listFeeds(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.get_all_feeds() <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_feeds" => []
            ];
        }
    }

}
