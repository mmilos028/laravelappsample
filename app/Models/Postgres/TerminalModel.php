<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;
use App\Helpers\NumberHelper;

class TerminalModel
{

    private static $DEBUG = false;

    public static function listDisconnectedTerminals($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_deactivated_terminals( :p_session_id_in = {$backoffice_session_id}, cur_result_out)";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = "SELECT * from tomboladb.core.list_deactivated_terminals(:p_session_id_in)";
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
                "result" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::listDisconnectedTerminals(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_deactivated_terminals( :p_session_id_in = {$backoffice_session_id},cur_result_out' ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::listDisconnectedTerminals(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.list_deactivated_terminals( :p_session_id_in = {$backoffice_session_id},cur_result_out' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result" => []
            ];
        }
    }

    public function deactivateTerminal($session_id, $subject_id, $mac_address){
        try{
            if(self::$DEBUG){
                $message = "TerminalModel::deactivateTerminal >>> SELECT tomboladb.core.disconnect_terminal(:p_session_id = {$session_id}, :p_subject_id = {$subject_id}, :p_mac_address = {$mac_address})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.disconnect_terminal(:p_session_id, :p_subject_id, :p_mac_address)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_session_id' => $session_id,
                    'p_subject_id' => $subject_id,
                    'p_mac_address' => $mac_address
                ]
            );

            DB::connection('pgsql')->commit();

            if($fn_result[0]->disconnect_terminal >= 1){
                return ['status'=>"OK", 'subject_id'=>$fn_result[0]->disconnect_terminal];
            }elseif($fn_result[0]->disconnect_terminal == "-1") {
                return ['status'=>"NOK", "message" => "GENERAL_ERROR"];
            }else{
                return ['status'=>"NOK", "message" => "GENERAL_ERROR"];
            }

        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();

            $output = $session_id.", ".$subject_id.", ".$mac_address;

            $message = implode(" ", [
                "TerminalModel::deactivateTerminal(data =" . print_r($output, true) . ") <br />\n\n",
                "tomboladb.core.deactivateTerminal(:p_session_id = {$session_id}, :p_subject_id = {$subject_id}, :p_mac_address = {$mac_address} <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();

            $output = $session_id.", ".$subject_id.", ".$mac_address;

            $message = implode(" ", [
                "TerminalModel::deactivateTerminal(data =" . print_r($output, true) . ") <br />\n\n",
                "tomboladb.core.deactivateTerminal(:p_session_id = {$session_id}, :p_subject_id = {$subject_id}, :p_mac_address = {$mac_address} <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    public function connectTerminal($session_id, $subject_id, $mac_address){
        try{
            if(self::$DEBUG){
                $message = "TerminalModel::connectTerminal >>> SELECT tomboladb.core.connect_terminal(:p_session_id = {$session_id}, :p_subject_id = {$subject_id}, :p_mac_address = {$mac_address})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.connect_terminal(:p_session_id, :p_subject_id, :p_mac_address)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_session_id' => $session_id,
                    'p_subject_id' => $subject_id,
                    'p_mac_address' => $mac_address,
                ]
            );

            DB::connection('pgsql')->commit();

            $status = $fn_result[0]->connect_terminal;

            if($status == 1){
                return ['status'=>"OK"];
            }elseif($status == -2) {
                return ['status'=>"TAKEN"];
            }else {
                return ['status'=>"NOK"];
            }

        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();

            $output = "p_session_id = ".$session_id.", p_subject_id = ".$subject_id.", p_mac_address = ".$mac_address;

            $message = implode(" ", [
                "TerminalModel::connectTerminal(output =" . print_r($output, true) . ") <br />\n\n",
                "tomboladb.core.connect_terminal(:p_session_id = {$session_id}, :p_subject_id = {$subject_id}, :p_mac_address = {$mac_address} <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();

            $output = "p_session_id = ".$session_id.", p_subject_id = ".$subject_id.", p_mac_address = ".$mac_address;

            $message = implode(" ", [
                "TerminalModel::connectTerminal(output =" . print_r($output, true) . ") <br />\n\n",
                "tomboladb.core.connect_terminal(:p_session_id = {$session_id}, :p_subject_id = {$subject_id}, :p_mac_address = {$mac_address} <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    public function disconnectTerminal($service_code){
        try{
            if(self::$DEBUG){
                $message = "TerminalModel::disconnectTerminal >>> SELECT tomboladb.tombola.disconnect_terminal(:p_service_code = {$service_code})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.tombola.disconnect_terminal(:p_service_code)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_service_code' => $service_code,
                ]
            );

            DB::connection('pgsql')->commit();

            if($fn_result[0]->disconnect_terminal >= 1){
                return ['status'=>"OK", 'subject_id'=>$fn_result[0]->disconnect_terminal];
            }elseif($fn_result[0]->disconnect_terminal == "-1") {
                return ['status'=>"NOK", "message" => "GENERAL_ERROR"];
            }else{
                return ['status'=>"NOK", "message" => "GENERAL_ERROR"];
            }

        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::updateTerminal(user =" . print_r($service_code, true) . ") <br />\n\n",
                "tomboladb.core.updateTerminal(:p_service_code = {$service_code} <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::updateTerminal(user =" . print_r($service_code, true) . ") <br />\n\n",
                "tomboladb.core.updateTerminal(:p_service_code = {$service_code} <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }


    /*public static function listTerminals($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.core.list_players( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_players( :p_session_id_in, 'cur_result_out' )";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id_in" => $backoffice_session_id
                ]
            );

            $cursor_name = $fn_result[0]->list_players;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();
            return [
                "status" => "OK",
                "list_terminals" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_terminals" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_terminals" => []
            ];
        }
    }*/

     /**
     * @param array $user
     * @return array
     */
    public static function createUser($user){

        if(self::$DEBUG){
            $message = "TerminalModel::createUser >>> SELECT tomboladb.core.create_subject(:p_username_in = '{$user['username']}', :p_password_in = '{$user['password']}',
            :p_first_name_in = '{$user['first_name']}', :p_last_name_in = '{$user['last_name']}', :p_currency_in = '{$user['currency']}',
            :p_parent_name_in = '{$user['parent_name']}', :p_registered_by_in = '{$user['registered_by']}', :p_subject_dtype_id_in = {$user['subject_type_id']},
            :p_player_dtype_in = '{$user['player_type_name']}', :p_language_in = '{$user['language']}', :p_email_in = '{$user['email']}, :p_city = {$user['city']},
            :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']})'";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT tomboladb.core.create_subject(:p_username_in, :p_password_in, :p_first_name_in, :p_last_name_in, :p_currency_in, :p_parent_name_in, :p_registered_by_in, :p_subject_dtype_id_in, :p_player_dtype_in, :p_language_in, :p_email_in, :p_address, :p_city, :p_country, :p_mobile_phone, :p_post_code, :p_commercial_address)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_username_in'=>$user['username'],
                    'p_password_in'=>$user['password'],
                    'p_first_name_in'=>$user['first_name'],
                    'p_last_name_in'=>$user['last_name'],
                    'p_currency_in'=>$user['currency'],
                    'p_parent_name_in'=>$user['parent_name'],
                    'p_registered_by_in'=>$user['registered_by'],
                    'p_subject_dtype_id_in'=>$user['subject_type_id'],
                    'p_player_dtype_in'=>$user['player_type_name'],
                    'p_language_in'=>$user['language'],
                    'p_email_in'=>$user['email'],
                    'p_address'=>$user['address'],
                    'p_city'=>$user['city'],
                    'p_country'=>$user['country'],
                    'p_mobile_phone'=>$user['mobile_phone'],
                    'p_post_code'=>$user['post_code'],
                    'p_commercial_address' => $user['commercial_address']
                ]
            );
            DB::connection('pgsql')->commit();
			if($fn_result[0]->create_subject >= 1)
			{
				return ['status'=>"OK", 'subject_id'=>$fn_result[0]->create_subject];
			}
            if($fn_result[0]->create_subject == "-1")
			{
                return ['status'=>"NOK", "message" => "GENERAL_ERROR"];
            }
			else if($fn_result[0]->create_subject == "-2")				
			{
				return ['status'=>"NOK", "message" => "EMAIL NOT AVAILABLE"];
			}
			else if($fn_result[0]->create_subject == "-3")
			{
				return ['status'=>"NOK", "message" => "USERNAME NOT AVAILABLE"];		
			}else{
			    return ['status'=>"NOK", "message" => "GENERAL_ERROR"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::createUser(user = " . print_r($user, true) . ") <br />\n\n",
                "tomboladb.core.create_subject(:p_username_in = '{$user['username']}', :p_password_in = '{$user['password']}',
                :p_first_name_in = '{$user['first_name']}', :p_last_name_in = '{$user['last_name']}', :p_currency_in = '{$user['currency']}',
                :p_parent_name_in = '{$user['parent_name']}', :p_registered_by_in = '{$user['registered_by']}', :p_subject_dtype_id_in = {$user['subject_type_id']},
                :p_player_dtype_in = '{$user['player_type_name']}', :p_language_in = '{$user['language']}', :p_email_in = '{$user['email']}, :p_city = {$user['city']},
                :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::createUser(user = " . print_r($user, true) . ") <br />\n\n",
                "tomboladb.core.create_subject(:p_username_in = '{$user['username']}', :p_password_in = '{$user['password']}',
                :p_first_name_in = '{$user['first_name']}', :p_last_name_in = '{$user['last_name']}', :p_currency_in = '{$user['currency']}',
                :p_parent_name_in = '{$user['parent_name']}', :p_registered_by_in = '{$user['registered_by']}', :p_subject_dtype_id_in = {$user['subject_type_id']},
                :p_player_dtype_in = '{$user['player_type_name']}', :p_language_in = '{$user['language']}', :p_email_in = '{$user['email']}, :p_city = {$user['city']},
                :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @param $user_id
     * @return array
     */
    public static function terminalInformation($user_id){
        try{

            if(self::$DEBUG){
                $message = "TerminalModel::terminalInformation >>> SELECT tomboladb.core.get_subjects_details(:p_subject_id_in = {$user_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.get_subjects_details(:p_subject_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array('p_subject_id_in'=>$user_id)
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "user" => [
                    "user_id" => $cur_result[0]->subject_id,
                    "username" => $cur_result[0]->username,
                    "first_name" => $cur_result[0]->first_name,
                    "last_name" => $cur_result[0]->last_name,
                    "email" => $cur_result[0]->email,
                    "registration_date" => $cur_result[0]->registration_date,
                    "subject_type" => $cur_result[0]->subject_dtype,
                    "active" => $cur_result[0]->subject_state,
                    "language" => $cur_result[0]->language,
                    "parent_id"=> $cur_result[0]->parent_id,
                    "parent_username" => $cur_result[0]->parent_username,
                    "address"=> $cur_result[0]->address,
                    "commercial_address"=> $cur_result[0]->commercial_address,
                    "city"=>$cur_result[0]->city,
                    "country_code"=>$cur_result[0]->country_id,
                    "country_name"=>$cur_result[0]->country_name,
                    "post_code"=>$cur_result[0]->post_code,
                    "mobile_phone"=>$cur_result[0]->mobile_phone,
                    "credits"=>$cur_result[0]->credits,
                    "credits_formatted"=>NumberHelper::format_double($cur_result[0]->credits),
                    "currency"=>$cur_result[0]->currency,
                    "subject_dtype_bo_name"=>$cur_result[0]->subject_dtype_bo_name,
                    "last_activity"=>$cur_result[0]->last_activity,
                    "created_by"=>$cur_result[0]->created_by,
                ],
                "result" => $cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::terminalInformation(user_id = {$user_id}) <br />\n\n",
                "tomboladb.core.get_subjects_details(:p_subject_id_in = {$user_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::terminalInformation(user_id = {$user_id}) <br />\n\n",
                "tomboladb.core.get_subjects_details(:p_subject_id_in = {$user_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result" => null
            ];
        }
    }

    /**
     * @param array $user
     * @return array
     */
    public static function updateTerminal($user){
        try{

            if(self::$DEBUG){
                $message = "TerminalModel::updateTerminal >>> SELECT tomboladb.core.update_subject(:p_subject_id_in = {$user['user_id']},
				:p_username_in = {$user['username']},
				:p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = null, :p_email_in = {$user['email']}, :p_edited_by_in = {$user['edited_by']}, :p_player_dtype_in = {$user['player_type_name']},
                :p_subject_state_in = {$user['active']}, :p_language_in = {$user['language']}, :p_city = {$user['city']}, :p_country = {$user['country']},
                :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.update_subject(:p_subject_id_in, :p_username_in, :p_first_name_in, :p_last_name_in, :p_currency_in, :p_email_in, :p_edited_by_in, :p_player_dtype_in, :p_subject_state_in, :p_language_in, :p_address, :p_city, :p_country, :p_mobile_phone, :p_post_code, :p_commercial_address)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_subject_id_in'=>$user['user_id'],
					'p_username_in'=>$user['username'],
                    'p_first_name_in'=>$user['first_name'],
                    'p_last_name_in'=>$user['last_name'],
                    'p_currency_in'=>null,
                    'p_email_in'=>$user['email'],
                    'p_edited_by_in'=>$user['edited_by'],
                    'p_player_dtype_in'=>$user['player_type_name'],
                    'p_subject_state_in'=>$user['active'],
                    'p_language_in'=>$user['language'],
                    'p_address'=>$user['address'],
                    'p_city'=>$user['city'],
                    'p_country'=>$user['country'],
                    'p_mobile_phone'=>$user['mobile_phone'],
                    'p_post_code'=>$user['post_code'],
                    'p_commercial_address' => $user['commercial_address']
                ]
            );
            DB::connection('pgsql')->commit();
            if($fn_result[0]->update_subject >= 1)
			{
				return ['status'=>"OK", 'subject_id'=>$fn_result[0]->update_subject];
			}
            if($fn_result[0]->update_subject == "-1")
			{
                return ['status'=>"NOK", "message" => "GENERAL_ERROR"];
            }
			else if($fn_result[0]->update_subject == "-2")				
			{
				return ['status'=>"NOK", "message" => "EMAIL NOT AVAILABLE"];
			}
			else if($fn_result[0]->update_subject == "-3")
			{
				return ['status'=>"NOK", "message" => "USERNAME NOT AVAILABLE"];		
			}else{
                return ['status'=>"NOK", "message" => "GENERAL_ERROR"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::updateTerminal(user =" . print_r($user, true) . ") <br />\n\n",
                "tomboladb.core.update_subject(:p_subject_id_in = {$user['user_id']},
				:p_username_in = {$user['username']},
				:p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = null, :p_email_in = {$user['email']}, :p_edited_by_in = {$user['edited_by']}, :p_player_dtype_in = {$user['player_type_name']},
                :p_subject_state_in = {$user['active']}, :p_language_in = {$user['language']}, :p_city = {$user['city']}, :p_country = {$user['country']},
                :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::updateTerminal(user =" . print_r($user, true) . ") <br />\n\n",
                "tomboladb.core.update_subject(:p_subject_id_in = {$user['user_id']},
				:p_username_in = {$user['username']},
				:p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = null, :p_email_in = {$user['email']}, :p_edited_by_in = {$user['edited_by']}, :p_player_dtype_in = {$user['player_type_name']},
                :p_subject_state_in = {$user['active']}, :p_language_in = {$user['language']}, :p_city = {$user['city']}, :p_country = {$user['country']},
                :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
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
    public static function changePassword($details){

        //$hashed_password = Hash::make($details['password']);
        $hashed_password = $details['password'];
        if(self::$DEBUG){
            $message = "TerminalModel::changePassword >>> SELECT tomboladb.core.change_password(:p_session_id_in = {$details['backoffice_session_id']}, :p_subject_id_in = {$details['user_id']}, :p_password_in = {$details['password']})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.core.change_password(:p_session_id_in, :p_subject_id_in, :p_password_in)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_session_id_in'=>$details['backoffice_session_id'],
                    'p_subject_id_in'=>$details['user_id'],
                    'p_password_in'=>$hashed_password,
                ]
            );
            DB::connection('pgsql')->commit();
            //dd($fn_result[0]->update_subject);
            if($fn_result[0]->change_password == 1){
                return ['status'=>"OK"];
            }else{
                return ['status'=>"NOK"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::changePassword(details =" . print_r($details, true) . ") <br />\n\n",
                "tomboladb.core.change_password(:p_session_id_in = {$details['backoffice_session_id']}, :p_subject_id_in = {$details['user_id']}, :p_password_in=) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::changePassword(details =" . print_r($details, true) . ") <br />\n\n",
                "tomboladb.core.change_password(:p_session_id_in = {$details['backoffice_session_id']}, :p_subject_id_in = {$details['user_id']}, :p_password_in=) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }
	
	/**
     * @param int $terminal_id
     * @return array
     */
    public static function setServiceKeyForTerminal($terminal_id){
        
        if(self::$DEBUG){
            $message = "TerminalModel::setServiceKeyForTerminal >>> SELECT tomboladb.core.set_service_key_for_terminal(:p_terminal_id = {$terminal_id}, :p_status_out)";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT * from tomboladb.tombola.set_service_key_for_terminal(:p_terminal_id)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_terminal_id'=>$terminal_id                    
                ]
            );
            DB::connection('pgsql')->commit();
            // dd($fn_result[0]->update_subject);
            if($fn_result[0]->p_status_out == 1){
                return ['status'=>"OK"];
            }else{
                return ['status'=>"NOK"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::setServiceKeyForTerminal(terminal_id={$terminal_id}) <br />\n\n",
                "tomboladb.tombola.set_service_key_for_terminal(:p_terminal_id={$terminal_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::setServiceKeyForTerminal(terminal_id={$terminal_id}) <br />\n\n",
                "tomboladb.tombola.set_service_key_for_terminal(:p_terminal_id={$terminal_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }
	
	/**
     * @param $backoffice_session_id
	 * @param $terminal_id
     * @return array
     */
    public static function listTerminalMaschineKeyAndCodes($backoffice_session_id, $terminal_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.tombola.get_maschine_key_and_code( :p_session_id_in = {$backoffice_session_id}, 
				:p_terminal_id = {$terminal_id}, :p_maschine_key = -1, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }
			
			$maschine_key = "-1";

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.tombola.get_maschine_key_and_code(:p_terminal_id, :p_maschine_key)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_terminal_id" => $terminal_id,
					"p_maschine_key" => $maschine_key
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();
            return [
                "status" => "OK",
                "list_terminal_maschine_key_and_codes" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::listTerminalMaschineKeyAndCodes(backoffice_session_id={$backoffice_session_id}, terminal_id={$terminal_id}) <br />\n\n",
                "tomboladb.tombola.get_maschine_key_and_code( :p_session_id_in = {$backoffice_session_id}, 
				:p_terminal_id = {$terminal_id}, :p_maschine_key = -1, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_terminal_maschine_key_and_codes" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::listTerminalMaschineKeyAndCodes(backoffice_session_id={$backoffice_session_id}, terminal_id={$terminal_id}) <br />\n\n",
                "tomboladb.tombola.get_maschine_key_and_code( :p_session_id_in = {$backoffice_session_id}, 
				:p_terminal_id = {$terminal_id}, :p_maschine_key = -1, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_terminal_maschine_key_and_codes" => []
            ];
        }
    }
	
	/**
     * @param $backoffice_session_id
	 * @param $service_code
	 * @param $maschine_key
     * @return array
     */
    public static function checkServiceCode($backoffice_session_id, $service_code, $maschine_key){
        try{

            if(self::$DEBUG){
                $message = "TerminalModel::checkServiceCode, backoffice_session_id = {$backoffice_session_id}, SELECT * from tomboladb.tombola.check_service_code(:p_service_code = {$service_code}, :p_maschine_key = {$maschine_key}, :p_status_out)";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.tombola.check_service_code(:p_service_code, :p_maschine_key)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_service_code" => $service_code,
					"p_maschine_key" => $maschine_key
                ]
            );

            DB::connection('pgsql')->commit();
									
			return [ 'status' => "OK", 'check_status' => $fn_result[0]->p_status_out ];
			
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::checkServiceCode(backoffice_session_id = {$backoffice_session_id}, service_code={$service_code}, maschine_key={$maschine_key}) <br />\n\n",
                "tomboladb.tombola.check_service_code(:p_service_code = {$service_code}, :p_maschine_key = {$maschine_key}, :p_status_out) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TerminalModel::checkServiceCode(backoffice_session_id = {$backoffice_session_id}, service_code={$service_code}, maschine_key={$maschine_key}) <br />\n\n",
                "tomboladb.tombola.check_service_code(:p_service_code = {$service_code}, :p_maschine_key = {$maschine_key}, :p_status_out) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
            ];
        }
    }
}
