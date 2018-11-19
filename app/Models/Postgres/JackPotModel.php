<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use PDO;

use App\Helpers\ErrorHelper;

class JackPotModel
{
    private static $DEBUG = false;

    public static function updateJPModelDetailsForAff($subject_id, $model_id, $priority, $local_level_on_off, $global_level_on_off, $current_amount, $inherit_from){
        try{
            if(self::$DEBUG){
                $message = "JackPotModel::updateJPModelDetailsForAff >>> SELECT core.update_jp_model_for_aff(:p_aff_id = {$subject_id}, :p_jp_model_id = {$model_id},
                :p_priority = {$priority}, :p_local_level_on_off = {$local_level_on_off}, :p_global_level_on_off = {$global_level_on_off}, p_current_amount = {$current_amount}, p_global_inherited_from = {$inherit_from}";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT core.update_jp_model_for_aff(:p_aff_id, :p_jp_model_id, :p_priority, :p_local_level_on_off, :p_global_level_on_off, :p_current_amount, :p_global_inherited_from)";

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_aff_id'=>$subject_id,
                    'p_jp_model_id'=>$model_id,
                    "p_priority" => $priority,
                    "p_local_level_on_off" => $local_level_on_off,
                    "p_global_level_on_off" => $global_level_on_off,
                    "p_current_amount" => $current_amount,
                    "p_global_inherited_from" => $inherit_from
                )
            );
            $result = $fn_result[0]->update_jp_model_for_aff;

            DB::connection('pgsql')->commit();

            return [
                "status" => $result,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::updateJPModelDetailsForAff(subject_id={$subject_id}, model_id={$model_id}, priority={$priority}, local_level_on_off={$local_level_on_off}, global_level_on_off={$global_level_on_off}, current_amount={$current_amount}, inherit_from={$inherit_from})<br />\n\n",
                "core.update_jp_model_for_aff(:p_aff_id = {$subject_id}, :p_jp_model_id = {$model_id},
                :p_priority = {$priority}, :p_local_level_on_off = {$local_level_on_off}, :p_global_level_on_off = {$global_level_on_off}, :p_current_amount = {$current_amount}, p_global_inherited_from = {$inherit_from})<br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::updateJPModelDetailsForAff(subject_id={$subject_id}, model_id={$model_id}, priority={$priority}, local_level_on_off={$local_level_on_off}, global_level_on_off={$global_level_on_off}, current_amount={$current_amount}, inherit_from={$inherit_from})<br />\n\n",
                "core.update_jp_model_for_aff(:p_aff_id = {$subject_id}, :p_jp_model_id = {$model_id},
                :p_priority = {$priority}, :p_local_level_on_off = {$local_level_on_off}, :p_global_level_on_off = {$global_level_on_off}, p_current_amount = {$current_amount}, p_global_inherited_from = {$inherit_from})<br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function getAffJPModelSettings($aff_id){
        try{

            if(self::$DEBUG){
                $message = "JackPotModel::getAffJPModelSettings >>> SELECT core.get_aff_jp_model_settings(:p_aff_id = {$aff_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_aff_jp_model_settings(:p_aff_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_aff_id'=>$aff_id

                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getAffJPModelSettings(aff_id={$aff_id})<br />\n\n",
                "core.get_aff_jp_model_settings(:p_aff_id = {$aff_id}, 'cur_result_out')<br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getAffJPModelSettings(aff_id={$aff_id})<br />\n\n",
                "core.get_aff_jp_model_settings(:p_aff_id = {$aff_id}, 'cur_result_out')<br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function listSubjectsForGlobalJP($subject_id, $model_id){
        try{
            if(self::$DEBUG){
                $message = "JackPotModel::listSubjectsForGlobalJP >>> SELECT core.list_aff_for_global_jp(:p_aff_id = {$subject_id}, :p_jp_model_id = {$model_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.list_aff_for_global_jp(:p_aff_id, :p_jp_model_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_aff_id'=>$subject_id,
                    'p_jp_model_id'=>$model_id,

                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::listSubjectsForGlobalJP(subject_id={$subject_id}, model_id={$model_id})<br />\n\n",
                "core.list_aff_for_global_jp(:p_aff_id = {$subject_id}, :p_jp_model_id = {$model_id}, 'cur_result_out')<br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::listSubjectsForGlobalJP(subject_id={$subject_id}, model_id={$model_id})<br />\n\n",
                "core.list_aff_for_global_jp(:p_aff_id = {$subject_id}, :p_jp_model_id = {$model_id}, 'cur_result_out')<br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function getJpModelDetails($model_id){

        try{

            if(self::$DEBUG){
                $message = "JackPotModel::getJpModelDetails >>> SELECT core.get_jp_model_details(:p_jp_model_id = {$model_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_jp_model_details(:p_jp_model_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_jp_model_id'=>$model_id

                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getJpModelDetails(model_id={$model_id})<br />\n\n",
                "core.get_jp_model_details(:p_jp_model_id = {$model_id}, 'cur_result_out')<br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getJpModelDetails(model_id={$model_id})<br />\n\n",
                "core.get_jp_model_details(:p_jp_model_id = {$model_id}, 'cur_result_out')<br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function getDisabledSubjectsForJPModel($session_id, $model_id){
        try{

            if(self::$DEBUG){
                $message = "JackPotModel::getDisabledSubjectsForJPModel >>> SELECT core.list_aff_without_jp(:p_session_id_in = {$session_id}, :p_jp_model_id = {$model_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.list_aff_without_jp(:p_session_id_in, :p_jp_model_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in'=>$session_id,
                    'p_jp_model_id'=>$model_id,

                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getDisabledSubjectsForJPModel(session_id={$session_id}, model_id={$model_id})<br />\n\n",
                "core.list_aff_without_jp(:p_session_id_in={$session_id}, :p_jp_model_id={$model_id})<br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getDisabledSubjectsForJPModel(session_id={$session_id}, model_id={$model_id})<br />\n\n",
                "core.list_aff_without_jp(:p_session_id_in={$session_id}, :p_jp_model_id={$model_id})<br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function getEnabledSubjectsForJPModel($session_id, $model_id){
        try{

            if(self::$DEBUG){
                $message = "JackPotModel::getEnabledSubjectsForJPModel >>> SELECT core.list_aff_for_jp_model(:p_session_id_in = {$session_id}, :p_jp_model_id = {$model_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.list_aff_for_jp_model(:p_session_id_in, :p_jp_model_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in'=>$session_id,
                    'p_jp_model_id'=>$model_id,

                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getEnabledSubjectsForJPModel(session_id={$session_id}, model_id={$model_id})<br />\n\n",
                "core.list_aff_for_jp_model(:p_session_id_in={$session_id}, :p_jp_model_id={$model_id})<br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getEnabledSubjectsForJPModel(session_id={$session_id}, model_id={$model_id})<br />\n\n",
                "core.list_aff_for_jp_model(:p_session_id_in={$session_id}, :p_jp_model_id={$model_id})<br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function getJpModels($session_id, $logged_in_id){
        try{

            if(self::$DEBUG){
                $message = "JackPotModel::getJpModels >>> SELECT core.get_jp_models(:p_session_id_in = {$session_id}, :p_logged_in_user = {$logged_in_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_jp_models(:p_session_id_in, :p_logged_in_user)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in'=>$session_id,
                    'p_logged_in_user'=>$logged_in_id,

                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getJpModels(session_id={$session_id}, logged_in_id={$logged_in_id})<br />\n\n",
                "core.get_jp_models(:p_session_id_in={$session_id}, :p_logged_in_user={$logged_in_id})<br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::getJpModels(session_id={$session_id}, logged_in_id={$logged_in_id})<br />\n\n",
                "core.get_jp_models(:p_session_id_in={$session_id}, :p_logged_in_user={$logged_in_id})<br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }
    public static function editJPModel($session_id, $logged_in_id, $model_id, $model_name, $currency, $local_level_win_price, $global_level_win_price, $jp_time_active_from,
                                         $jp_time_active_to, $local_level_percent_from_bet, $global_level_percent_from_bet, $local_win_probability, $global_win_probability, $local_min_bet,
                                         $global_min_bet, $local_pot_start, $global_pot_start, $local_forced_win_before, $global_forced_win_before, $whole_pot, $min_tick_to_win, $global_on_off, $local_on_off){
        try{

            if(self::$DEBUG){
                $message = "JackPotModel::editJPModel >>> SELECT core.update_jp_model(:p_session_id = {$session_id}, :p_logged_in_user = {$logged_in_id}, :p_jp_model_id = {$model_id}, 
                :p_jp_model = {$model_name}, :p_currency = {$currency}, :p_local_level_value = {$local_level_win_price}, p_global_level_value = {$global_level_win_price}, 
                :p_jp_time_active_from = {$jp_time_active_from}, :p_jp_time_active_to = {$jp_time_active_to}, 
             :p_local_level_percent_from_bet = {$local_level_percent_from_bet}, :p_global_level_percent_from_bet = {$global_level_percent_from_bet}, 
             :p_local_win_probability = {$local_win_probability}, :p_global_win_probability = {$global_win_probability}, 
             :p_local_min_bet = {$local_min_bet}, :p_global_min_bet = {$global_min_bet}, 
             :p_local_pot_start_value = {$local_pot_start}, :p_global_pot_start_value = {$global_pot_start},
             :p_local_forced_win_before = {$local_forced_win_before}, :p_global_forced_win_before = {$global_forced_win_before},
             :p_win_whole_pot = {$whole_pot}, :p_min_tickets_to_win = {$min_tick_to_win})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT core.update_jp_model(
            :p_session_id, :p_logged_in_user,
             :p_jp_model_id, :p_jp_model, :p_currency, 
             :p_local_level_value, :p_global_level_value, 
             :p_jp_time_active_from, :p_jp_time_active_to, 
             :p_local_level_percent_from_bet, :p_global_level_percent_from_bet, 
             :p_local_win_probability, :p_global_win_probability, 
             :p_local_min_bet, :p_global_min_bet, 
             :p_local_pot_start_value, :p_global_pot_start_value,
             :p_win_whole_pot, :p_min_tickets_to_win,
             :p_local_forced_win_before, :p_global_forced_win_before, :p_local_level_on_off, :p_global_level_on_off
             )";

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id'=>$session_id,
                    'p_logged_in_user'=>$logged_in_id,
                    "p_jp_model_id" => $model_id,
                    "p_jp_model" => $model_name,
                    "p_currency" => $currency,
                    "p_local_level_value" => $local_level_win_price,
                    "p_global_level_value" => $global_level_win_price,
                    "p_jp_time_active_from" => $jp_time_active_from,
                    "p_jp_time_active_to" => $jp_time_active_to,
                    "p_local_level_percent_from_bet" => $local_level_percent_from_bet,
                    "p_global_level_percent_from_bet" => $global_level_percent_from_bet,
                    "p_local_win_probability" => $local_win_probability,
                    "p_global_win_probability" => $global_win_probability,
                    "p_local_min_bet" => $local_min_bet,
                    "p_global_min_bet" => $global_min_bet,
                    "p_local_pot_start_value" => $local_pot_start,
                    "p_global_pot_start_value" => $global_pot_start,
                    "p_local_forced_win_before" => $local_forced_win_before,
                    "p_global_forced_win_before" => $global_forced_win_before,
                    "p_win_whole_pot" => $whole_pot,
                    "p_min_tickets_to_win" => $min_tick_to_win,
                    "p_local_level_on_off" => $local_on_off,
                    "p_global_level_on_off" => $global_on_off
                )
            );
            $result = $fn_result[0]->update_jp_model;

            DB::connection('pgsql')->commit();

            return [
                "status" => $result,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::editJPModel(session_id={$session_id}, logged_in_id={$logged_in_id}, model_id={$model_id}, model_name={$model_name}, currency={$currency}, 
                                         local_level_win_price={$local_level_win_price}, global_level_win_price={$global_level_win_price}, jp_time_active_from={$jp_time_active_from},
                                         jp_time_active_to={$jp_time_active_to}, local_level_percent_from_bet={$local_level_percent_from_bet}, global_level_percent_from_bet={$global_level_percent_from_bet}, 
                                         local_win_probability={$local_win_probability}, global_win_probability={$global_win_probability}, local_min_bet={$local_min_bet},
                                         global_min_bet={$global_min_bet}, local_pot_start={$local_pot_start}, global_pot_start={$global_pot_start}, local_forced_win_before={$local_forced_win_before}, 
                                         global_forced_win_before={$global_forced_win_before}, whote_pot={$whole_pot}, min_tick_to_win={$min_tick_to_win}) <br />\n\n",
                "core.update_jp_model(:p_session_id = {$session_id}, :p_logged_in_user = {$logged_in_id}, :p_jp_model_id = {$model_id}, 
                     :p_jp_model = {$model_name}, :p_currency = {$currency}, :p_local_level_value = {$local_level_win_price}, p_global_level_value = {$global_level_win_price}, 
                     :p_jp_time_active_from = {$jp_time_active_from}, :p_jp_time_active_to = {$jp_time_active_to}, 
                     :p_local_level_percent_from_bet = {$local_level_percent_from_bet}, :p_global_level_percent_from_bet = {$global_level_percent_from_bet}, 
                     :p_local_win_probability = {$local_win_probability}, :p_global_win_probability = {$global_win_probability}, 
                     :p_local_min_bet = {$local_min_bet}, :p_global_min_bet = {$global_min_bet}, 
                     :p_local_pot_start_value = {$local_pot_start}, :p_global_pot_start_value = {$global_pot_start},
                     :p_local_forced_win_before = {$local_forced_win_before}, :p_global_forced_win_before = {$global_forced_win_before},
                     :p_win_whole_pot = {$whole_pot}, :p_min_tickets_to_win = {$min_tick_to_win}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::editJPModel(session_id={$session_id}, logged_in_id={$logged_in_id}, model_id={$model_id}, model_name={$model_name}, currency={$currency}, 
                     local_level_win_price={$local_level_win_price}, global_level_win_price={$global_level_win_price}, jp_time_active_from={$jp_time_active_from},
                     jp_time_active_to={$jp_time_active_to}, local_level_percent_from_bet={$local_level_percent_from_bet}, global_level_percent_from_bet={$global_level_percent_from_bet}, 
                     local_win_probability={$local_win_probability}, global_win_probability={$global_win_probability}, local_min_bet={$local_min_bet},
                     global_min_bet={$global_min_bet}, local_pot_start={$local_pot_start}, global_pot_start={$global_pot_start}, local_forced_win_before={$local_forced_win_before}, 
                     global_forced_win_before={$global_forced_win_before}, whote_pot={$whole_pot}, min_tick_to_win={$min_tick_to_win}) <br />\n\n",
                "core.update_jp_model(:p_session_id = {$session_id}, :p_logged_in_user = {$logged_in_id}, :p_jp_model_id = {$model_id}, 
                     :p_jp_model = {$model_name}, :p_currency = {$currency}, :p_local_level_value = {$local_level_win_price}, p_global_level_value = {$global_level_win_price}, 
                     :p_jp_time_active_from = {$jp_time_active_from}, :p_jp_time_active_to = {$jp_time_active_to}, 
                     :p_local_level_percent_from_bet = {$local_level_percent_from_bet}, :p_global_level_percent_from_bet = {$global_level_percent_from_bet}, 
                     :p_local_win_probability = {$local_win_probability}, :p_global_win_probability = {$global_win_probability}, 
                     :p_local_min_bet = {$local_min_bet}, :p_global_min_bet = {$global_min_bet}, 
                     :p_local_pot_start_value = {$local_pot_start}, :p_global_pot_start_value = {$global_pot_start},
                     :p_local_forced_win_before = {$local_forced_win_before}, :p_global_forced_win_before = {$global_forced_win_before},
                     :p_win_whole_pot = {$whole_pot}, :p_min_tickets_to_win = {$min_tick_to_win}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }

    public static function createJPModel($session_id, $logged_in_id, $model_name, $currency, $local_level_win_price, $global_level_win_price, $jp_time_active_from,
         $jp_time_active_to, $local_level_percent_from_bet, $global_level_percent_from_bet, $local_win_probability, $global_win_probability, $local_min_bet,
         $global_min_bet, $local_pot_start, $global_pot_start, $local_forced_win_before, $global_forced_win_before, $whole_pot, $min_tick_to_win, $global_on_off, $local_on_off){
        try{

            /*if(self::$DEBUG){
                $message = "ReportModel::listDailyReport >>> SELECT tomboladb.tombola.daily_report(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }*/

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT core.insert_into_jp_model(
            :p_session_id_in, :p_logged_in_user,
             :p_jp_mode, :p_currency, 
             :p_local_level_win, :p_global_level_win, 
             :p_jp_time_active_from, :p_jp_time_active_to, 
             :p_local_level_percent_from_bet, :p_global_level_percent_from_bet, 
             :p_local_win_probability, :p_global_win_probability, 
             :p_local_min_bet, :p_global_min_bet, 
             :p_local_pot_start_value, :p_global_pot_start_value,
             :p_local_forced_win_before, :p_global_forced_win_before,
             :p_win_whole_pot, :p_min_tickets_to_win, :p_local_level_on_off, :p_global_level_on_off
             )";

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in'=>$session_id,
                    'p_logged_in_user'=>$logged_in_id,
                    "p_jp_mode" => $model_name,
                    "p_currency" => $currency,
                    "p_local_level_win" => $local_level_win_price,
                    "p_global_level_win" => $global_level_win_price,
                    "p_jp_time_active_from" => $jp_time_active_from,
                    "p_jp_time_active_to" => $jp_time_active_to,
                    "p_local_level_percent_from_bet" => $local_level_percent_from_bet,
                    "p_global_level_percent_from_bet" => $global_level_percent_from_bet,
                    "p_local_win_probability" => $local_win_probability,
                    "p_global_win_probability" => $global_win_probability,
                    "p_local_min_bet" => $local_min_bet,
                    "p_global_min_bet" => $global_min_bet,
                    "p_local_pot_start_value" => $local_pot_start,
                    "p_global_pot_start_value" => $global_pot_start,
                    "p_local_forced_win_before" => $local_forced_win_before,
                    "p_global_forced_win_before" => $global_forced_win_before,
                    "p_win_whole_pot" => $whole_pot,
                    "p_min_tickets_to_win" => $min_tick_to_win,
                    "p_local_level_on_off" => $local_on_off,
                    "p_global_level_on_off" => $global_on_off
                )
            );
            $result = $fn_result[0]->insert_into_jp_model;

            DB::connection('pgsql')->commit();

            return [
                "status" => $result,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::createJPModel(session_id={$session_id}, logged_in_id={$logged_in_id}, model_name={$model_name}, currency={$currency}, 
                     local_level_win_price={$local_level_win_price}, global_level_win_price={$global_level_win_price}, jp_time_active_from={$jp_time_active_from},
                     jp_time_active_to={$jp_time_active_to}, local_level_percent_from_bet={$local_level_percent_from_bet}, global_level_percent_from_bet={$global_level_percent_from_bet}, 
                     local_win_probability={$local_win_probability}, global_win_probability={$global_win_probability}, local_min_bet={$local_min_bet},
                     global_min_bet={$global_min_bet}, local_pot_start={$local_pot_start}, global_pot_start={$global_pot_start}, local_forced_win_before={$local_forced_win_before}, 
                     global_forced_win_before={$global_forced_win_before}, whote_pot={$whole_pot}, min_tick_to_win={$min_tick_to_win}) <br />\n\n",
                "core.insert_into_jp_model(:p_session_id = {$session_id}, :p_logged_in_user = {$logged_in_id}, 
                     :p_jp_mode = {$model_name}, :p_currency = {$currency}, :p_local_level_value = {$local_level_win_price}, p_global_level_value = {$global_level_win_price}, 
                     :p_jp_time_active_from = {$jp_time_active_from}, :p_jp_time_active_to = {$jp_time_active_to}, 
                     :p_local_level_percent_from_bet = {$local_level_percent_from_bet}, :p_global_level_percent_from_bet = {$global_level_percent_from_bet}, 
                     :p_local_win_probability = {$local_win_probability}, :p_global_win_probability = {$global_win_probability}, 
                     :p_local_min_bet = {$local_min_bet}, :p_global_min_bet = {$global_min_bet}, 
                     :p_local_pot_start_value = {$local_pot_start}, :p_global_pot_start_value = {$global_pot_start},
                     :p_local_forced_win_before = {$local_forced_win_before}, :p_global_forced_win_before = {$global_forced_win_before},
                     :p_win_whole_pot = {$whole_pot}, :p_min_tickets_to_win = {$min_tick_to_win}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::createJPModel(session_id={$session_id}, logged_in_id={$logged_in_id}, model_name={$model_name}, currency={$currency}, 
                     local_level_win_price={$local_level_win_price}, global_level_win_price={$global_level_win_price}, jp_time_active_from={$jp_time_active_from},
                     jp_time_active_to={$jp_time_active_to}, local_level_percent_from_bet={$local_level_percent_from_bet}, global_level_percent_from_bet={$global_level_percent_from_bet}, 
                     local_win_probability={$local_win_probability}, global_win_probability={$global_win_probability}, local_min_bet={$local_min_bet},
                     global_min_bet={$global_min_bet}, local_pot_start={$local_pot_start}, global_pot_start={$global_pot_start}, local_forced_win_before={$local_forced_win_before}, 
                     global_forced_win_before={$global_forced_win_before}, whote_pot={$whole_pot}, min_tick_to_win={$min_tick_to_win}) <br />\n\n",
                "core.insert_into_jp_model(:p_session_id = {$session_id}, :p_logged_in_user = {$logged_in_id}, 
                     :p_jp_mode = {$model_name}, :p_currency = {$currency}, :p_local_level_value = {$local_level_win_price}, p_global_level_value = {$global_level_win_price}, 
                     :p_jp_time_active_from = {$jp_time_active_from}, :p_jp_time_active_to = {$jp_time_active_to}, 
                     :p_local_level_percent_from_bet = {$local_level_percent_from_bet}, :p_global_level_percent_from_bet = {$global_level_percent_from_bet}, 
                     :p_local_win_probability = {$local_win_probability}, :p_global_win_probability = {$global_win_probability}, 
                     :p_local_min_bet = {$local_min_bet}, :p_global_min_bet = {$global_min_bet}, 
                     :p_local_pot_start_value = {$local_pot_start}, :p_global_pot_start_value = {$global_pot_start},
                     :p_local_forced_win_before = {$local_forced_win_before}, :p_global_forced_win_before = {$global_forced_win_before},
                     :p_win_whole_pot = {$whole_pot}, :p_min_tickets_to_win = {$min_tick_to_win}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }
    public static function deleteJPModel($session_id, $logged_in_id, $model_id){
        try{

            if(self::$DEBUG){
                $message = "JackPotModel::deleteJPModel >>> SELECT core.remove_jp_model(:p_session_id_in = {$session_id}, :p_logged_in_user = {$logged_in_id}, 
                :p_jp_model_id = {$model_id})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT core.remove_jp_model(:p_session_id_in, :p_logged_in_user, :p_jp_model_id)";

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in'=>$session_id,
                    'p_logged_in_user'=>$logged_in_id,
                    "p_jp_model_id" => $model_id
                )
            );
            $result = $fn_result[0]->remove_jp_model;

            DB::connection('pgsql')->commit();

            return [
                "status" => $result,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::deleteJPModel(session_id={$session_id}, logged_in_id={$logged_in_id}, model_id={$model_id}) <br />\n\n",
                "core.remove_jp_model(:p_session_id_in={$session_id}, :p_logged_in_user={$logged_in_id}, :p_jp_model_id={$model_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::deleteJPModel(session_id={$session_id}, logged_in_id={$logged_in_id}, model_id={$model_id}) <br />\n\n",
                "core.remove_jp_model(:p_session_id_in={$session_id}, :p_logged_in_user={$logged_in_id}, :p_jp_model_id={$model_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }
    public static function deleteJPModelForSubject($session_id, $logged_in_id, $aff_id){
        try{

            if(self::$DEBUG){
                $message = "JackPotModel::remove_jp_model_for_aff >>> SELECT core.remove_jp_model_for_aff(:p_session_id = {$session_id}, :p_logged_in_user = {$logged_in_id}, 
                :p_aff_id = {$aff_id})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT core.remove_jp_model_for_aff(:p_session_id, :p_logged_in_user, :p_aff_id)";

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id'=>$session_id,
                    'p_logged_in_user'=>$logged_in_id,
                    "p_aff_id" => $aff_id
                )
            );
            $result = $fn_result[0]->remove_jp_model_for_aff;

            DB::connection('pgsql')->commit();

            return [
                "status" => $result,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::deleteJPModelForSubject(session_id={$session_id}, logged_in_id={$logged_in_id}, aff_id={$aff_id}) <br />\n\n",
                "core.remove_jp_model_for_aff(:p_session_id = {$session_id}, :p_logged_in_user = {$logged_in_id}, :p_aff_id = {$aff_id}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::deleteJPModelForSubject(session_id={$session_id}, logged_in_id={$logged_in_id}, aff_id={$aff_id}) <br />\n\n",
                "core.remove_jp_model_for_aff(:p_session_id = {$session_id}, :p_logged_in_user = {$logged_in_id}, :p_aff_id = {$aff_id}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }
    public static function addJPModelForSubject($session_id, $logged_in_id, $aff_id, $model_id, $inherited_from, $priority, $local_level_on_off, $global_level_on_off, $payout_percent){
        try{

            if(self::$DEBUG){
                $message = "JackPotModel::add_jp_model_to_aff >>> SELECT core.add_jp_model_to_aff(:p_aff_id = {$aff_id}, :p_jp_model_id = {$model_id}, 
                :p_global_jp_inherited_from = {$inherited_from}, :p_priority = {$priority}, p_local_level_on_off = {$local_level_on_off}, 
                :p_global_level_on_off = {$global_level_on_off}, :p_payout_percent = {$payout_percent})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT core.add_jp_model_to_aff(:p_aff_id, :p_jp_model_id, :p_global_jp_inherited_from, :p_priority, 
            :p_local_level_on_off, :p_global_level_on_off, :p_payout_percent)";

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_aff_id'=> $aff_id,
                    'p_jp_model_id'=> $model_id,
                    "p_global_jp_inherited_from" => $inherited_from,
                    'p_priority'=> $priority,
                    'p_local_level_on_off'=>$local_level_on_off,
                    "p_global_level_on_off" => $global_level_on_off,
                    "p_payout_percent" => $payout_percent
                )
            );

            $result = $fn_result[0]->add_jp_model_to_aff;

            DB::connection('pgsql')->commit();

            return [
                "status" => $result,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::addJPModelForSubject(session_id={$session_id}, logged_in_id={$logged_in_id}, aff_id={$aff_id}, model_id={$model_id}, inherited_from={$inherited_from}, priority={$priority}, 
                    local_level_on_off={$local_level_on_off}, global_level_on_off={$global_level_on_off}, payout_percent={$payout_percent}) <br />\n\n",
                "core.add_jp_model_to_aff(:p_aff_id = {$aff_id}, :p_jp_model_id = {$model_id}, 
                :p_global_jp_inherited_from = {$inherited_from}, :p_priority = {$priority}, p_local_level_on_off = {$local_level_on_off}, 
                :p_global_level_on_off = {$global_level_on_off}, :p_payout_percent = {$payout_percent}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "JackPotModel::addJPModelForSubject(session_id={$session_id}, logged_in_id={$logged_in_id}, aff_id={$aff_id}, model_id={$model_id}, inherited_from={$inherited_from}, priority={$priority}, 
                    local_level_on_off={$local_level_on_off}, global_level_on_off={$global_level_on_off}, payout_percent={$payout_percent}) <br />\n\n",
                "core.add_jp_model_to_aff(:p_aff_id = {$aff_id}, :p_jp_model_id = {$model_id}, 
                :p_global_jp_inherited_from = {$inherited_from}, :p_priority = {$priority}, p_local_level_on_off = {$local_level_on_off}, 
                :p_global_level_on_off = {$global_level_on_off}, :p_payout_percent = {$payout_percent}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }
    }
}
