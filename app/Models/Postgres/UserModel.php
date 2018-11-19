<?php

namespace App\Models\Postgres;

use App\Helpers\NumberHelper;
use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class UserModel
{

    private static $DEBUG = false;

    public static function updateUserLanguage($subject_id, $language){
        try{

            if(self::$DEBUG){
                $message = "UserModel::updateUser >>> SELECT tomboladb.core.update_language(:p_subject_id_in = {$subject_id},
				:p_language = {$language})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = "SELECT tomboladb.core.update_language(:p_subject_id_in, :p_language)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_subject_id_in'=>$subject_id,
                    'p_language' => $language,
                ]
            );
            DB::connection('pgsql')->commit();

            return ['status'=>$fn_result[0]->update_language];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::updateUserLanguage(subject_id={$subject_id}, language={$language}) <br />\n\n",
                "tomboladb.core.update_language(:p_subject_id_in = {$subject_id}, :p_language = {$language}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::updateUserLanguage(subject_id={$subject_id}, language={$language}) <br />\n\n",
                "tomboladb.core.update_language(:p_subject_id_in = {$subject_id}, :p_language = {$language}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @return array
     */
    public static function listStructureEntitySubjectTypes(){

        $roles = [
            config("constants.OPERATER_TYPE_ID") => config("constants.OPERATER_TYPE_NAME"),
            config("constants.LOCATION_TYPE_ID") => config("constants.LOCATION_TYPE_NAME"),
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;
    }

    /**
     * @return array
     */
    public static function listSubjectTypes(){

        $roles = [
            config("constants.MASTER_TYPE_ID") => config("constants.MASTER_TYPE_NAME"),
            config("constants.AFFILIATE_TYPE_ID") => config("constants.AFFILIATE_TYPE_NAME"),
            config("constants.OPERATER_TYPE_ID") => config("constants.OPERATER_TYPE_NAME"),
            config("constants.LOCATION_TYPE_ID") => config("constants.LOCATION_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;
    }

    /**
     * @return array
     */
    public static function listSubjectTypesForUserNewUser(){

        $roles = [
            config("constants.MASTER_TYPE_ID") => config("constants.MASTER_TYPE_NAME"),
            config("constants.AFFILIATE_TYPE_ID") => config("constants.AFFILIATE_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;
    }
	
	/**
     * @return array
     */
    public static function listTerminalSubjectTypes(){
        return [            
            config("constants.TERMINAL_TYPE_ID") => config("constants.TERMINAL_TYPE_NAME"),
            config("constants.TERMINAL_CASHIER_TYPE_ID") => config("constants.TERMINAL_CASHIER_TYPE_NAME")
        ];
    }

    /**
     * @return array
     */
    public static function listAllSubjectTypesForAdministrationNewUser()
    {

        $roles = [
            config("constants.MASTER_TYPE_ID") => config("constants.MASTER_TYPE_NAME"),
            //config("constants.PLAYER_TYPE_ID") => config("constants.PLAYER_TYPE_NAME"),
            config("constants.TERMINAL_TYPE_ID") => config("constants.TERMINAL_TYPE_NAME"),
            config("constants.TERMINAL_CASHIER_TYPE_ID") => config("constants.TERMINAL_CASHIER_TYPE_NAME"),

            config("constants.AFFILIATE_TYPE_ID") => config("constants.AFFILIATE_TYPE_NAME"),
            config("constants.OPERATER_TYPE_ID") => config("constants.OPERATER_TYPE_NAME"),
            config("constants.LOCATION_TYPE_ID") => config("constants.LOCATION_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),

            config("constants.COLLECTOR_TYPE_ID") => config("constants.COLLECTOR_TYPE_NAME"),
            config("constants.SUPPORT_TYPE_ID") => config("constants.SUPPORT_TYPE_NAME"),

        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;
    }

    /**
     * @return array
     */
    public static function listAccountActiveOptions(){
        return [
            "1" => __("authenticated.Active"),
            "-1" => __("authenticated.Inactive")
        ];
    }

    /**
     * @return array
     */
    public static function listLanguages(){
        return [
            "en_GB" => __("authenticated.English"),
            "de_DE" => __("authenticated.German"),
            "sv_SE" => __("authenticated.Swedish"),
            "da_DK" => __("authenticated.Danish"),
            "it_IT" => __("authenticated.Italian"),
            "ru_RU" => __("authenticated.Russian"),
            "pl_PL" => __("authenticated.Polish"),
            "hr_HR" => __("authenticated.Croatian"),
            "rs_RS" => __("authenticated.Serbian"),
            "tr_TR" => __("authenticated.Turkish"),
            "cs_CZ" => __("authenticated.Czeck"),
            "sq_AL" => __("authenticated.Albanian")
        ];
    }

    /**
     * @param $user_id
     * @return array
     */
    public static function userInformation($user_id){
        try{

            if(self::$DEBUG){
                $message = "UserModel::userInformation >>> SELECT tomboladb.core.get_subjects_details(:p_subject_id_in = {$user_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.get_subjects_details(:p_subject_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array('p_subject_id_in'=>$user_id)
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            $result = get_object_vars($cur_result[0]);

            DB::connection('pgsql')->commit();
            //print_r($result);
            return [
                "status" => "OK",
                "user" => [
                    "user_id" => $result['subject_id'],
                    "username" => $result['username'],
                    "first_name" => $result['first_name'],
                    "last_name" => $result['last_name'],
                    "email" => $result['email'],
                    "registration_date" => $result['registration_date'],
                    "subject_type" => $result['subject_dtype'],
                    "active" => $result['subject_state'],
                    "language" => isset($result['language']) ? $result['language'] : 'en_GB',
                    "parent_id"=> $result['parent_id'],
                    "parent_username" => $result['parent_username'],
                    "address"=> $result['address'],
                    "commercial_address" => $result['commercial_address'],
                    "city"=> $result['city'],
                    "country_code"=> $result['country_id'],
                    "country_name"=> $result['country_name'],
                    "mobile_phone"=> $result['mobile_phone'],
                    "post_code"=> $result['post_code'],
                    "currency"=> $result['currency'],
                    "subject_dtype_bo_name" => $result['subject_dtype_bo_name'],
                    "last_activity"=>$cur_result[0]->last_activity,
                    "created_by"=>$cur_result[0]->created_by,
                ]
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::userInformation(user_id = {$user_id}) <br />\n\n",
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
                "UserModel::userInformation(user_id = {$user_id}) <br />\n\n",
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

    public static function personalInformationForHomePage($backoffice_session_id){
        try{
            if(self::$DEBUG){
                $message = "UserModel::personalInformation >>> SELECT tomboladb.core.get_subjects_details_from_session(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out', 'cur_currency_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.get_subjects_details_from_session(:p_session_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array('p_session_id_in'=>$backoffice_session_id)
            );

            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            $cursor_currency_name = $fn_result[0]->cur_currency_out;

            //subject_id, currency fields
            $cur_currency = DB::connection('pgsql')->select("fetch all in {$cursor_currency_name}");

            DB::connection('pgsql')->commit();

            $currency_list = [];
            foreach($cur_currency as $cur){
                $currency_list[$cur->currency] = $cur->currency;
            }

            return [
                "status" => "OK",
                "cur_result" => $cur_result,
                "cur_result_currency" => $currency_list
            ];

            /*return [
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
                    "commercial_address" => $cur_result[0]->commercial_address,
                    "city"=>$cur_result[0]->city,
                    "country_code"=>$cur_result[0]->country_id,
                    "country_name"=>$cur_result[0]->country_name,
                    "mobile_phone"=>$cur_result[0]->mobile_phone,
                    "post_code"=>$cur_result[0]->post_code
                ],
                "list_currency" =>
                    $list_currency
            ];*/
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::personalInformationForHomePage(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.get_subjects_details_from_session(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out', 'cur_currency_out') <br />\n\n",
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
                "UserModel::personalInformationForHomePage(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.get_subjects_details_from_session(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out', 'cur_currency_out') <br />\n\n",
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
     * @param $backoffice_session_id
     * @return array
     */
    public static function personalInformation($backoffice_session_id){
        try{
            if(self::$DEBUG){
                $message = "UserModel::personalInformation >>> SELECT tomboladb.core.get_subjects_details_from_session(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out', 'cur_currency_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.get_subjects_details_from_session(:p_session_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array('p_session_id_in'=>$backoffice_session_id)
            );

            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            $cursor_currency_name = $fn_result[0]->cur_currency_out;

            //subject_id, currency fields
            $cur_currency = DB::connection('pgsql')->select("fetch all in {$cursor_currency_name}");

            DB::connection('pgsql')->commit();

            $list_currency = [];
            foreach($cur_currency as $cur){
                $list_currency[$cur->currency] = $cur->currency;
            }
            //dd($cur_result);

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
                    "subject_type_id" => $cur_result[0]->subject_dtype_id,
                    "active" => $cur_result[0]->subject_state,
                    "language" => $cur_result[0]->language,
                    "parent_id"=> $cur_result[0]->parent_id,
                    "parent_username" => $cur_result[0]->parent_username,
                    "address"=> $cur_result[0]->address,
                    "commercial_address" => $cur_result[0]->commercial_address,
                    "city"=>$cur_result[0]->city,
                    "country_code"=>$cur_result[0]->country_id,
                    "country_name"=>$cur_result[0]->country_name,
                    "mobile_phone"=>$cur_result[0]->mobile_phone,
                    "post_code"=>$cur_result[0]->post_code,
                    "currency"=>$cur_result[0]->currency,
                    "credits"=>NumberHelper::convert_double($cur_result[0]->credits),
                    "credits_formatted"=>NumberHelper::format_double($cur_result[0]->credits)
                ],
                "list_currency" =>
                    $list_currency
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::personalInformation(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.get_subjects_details_from_session(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out', 'cur_currency_out') <br />\n\n",
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
                "UserModel::personalInformation(backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.core.get_subjects_details_from_session(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out', 'cur_currency_out') <br />\n\n",
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
    public static function updateUser($user){
        try{

            if(self::$DEBUG){
                $message = "UserModel::updateUser >>> SELECT tomboladb.core.update_subject(:p_subject_id_in = {$user['user_id']},
				:p_username_in = {$user['username']},
				:p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']}, :p_currency_in = {$user['currency']},
                :p_email_in = {$user['email']}, :p_edited_by_in = {$user['edited_by']}, :p_player_dtype_in = {$user['subject_type_name']}, :p_subject_state_in = {$user['subject_state']}, :p_language_in = {$user['language']},
                :p_address = {$user['address']}, :p_city = {$user['city']}, :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = "SELECT tomboladb.core.update_subject(:p_subject_id_in, :p_username_in, :p_first_name_in, :p_last_name_in, :p_currency_in, :p_email_in, :p_edited_by_in, :p_player_dtype_in, :p_subject_state_in, :p_language_in, :p_address, :p_city, :p_country, :p_mobile_phone, :p_post_code, :p_commercial_address)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_subject_id_in'=>$user['user_id'],
					'p_username_in' => $user['username'],
                    'p_first_name_in'=>$user['first_name'],
                    'p_last_name_in'=>$user['last_name'],
                    'p_currency_in'=>null,
                    'p_email_in'=>$user['email'],
                    'p_edited_by_in'=>$user['edited_by'],
                    'p_player_dtype_in'=>$user['subject_type_name'],
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
                "UserModel::updateUser(user=" . print_r($user, true) .") <br />\n\n",
                "tomboladb.core.update_subject(:p_subject_id_in = {$user['user_id']},
				:p_username_in = {$user['username']},
				:p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']}, :p_currency_in = {$user['currency']},
                :p_email_in = {$user['email']}, :p_edited_by_in = {$user['edited_by']}, :p_player_dtype_in = {$user['subject_type_name']}, :p_subject_state_in = {$user['subject_state']}, :p_language_in = {$user['language']},
                :p_address = {$user['address']}, :p_city = {$user['city']}, :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::updateUser(user=" . print_r($user, true) .") <br />\n\n",
                "tomboladb.core.update_subject(:p_subject_id_in = {$user['user_id']},
				:p_username_in = {$user['username']},
				:p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']}, :p_currency_in = {$user['currency']},
                :p_email_in = {$user['email']}, :p_edited_by_in = {$user['edited_by']}, :p_player_dtype_in = {$user['subject_type_name']}, :p_subject_state_in = {$user['subject_state']}, :p_language_in = {$user['language']},
                :p_address = {$user['address']}, :p_city = {$user['city']}, :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @param array $user
     * @return array
     */
    public static function updateSubjectState($user){
        try{

            if(self::$DEBUG){
                $message = "UserModel::updateSubjectState >>> SELECT tomboladb.core.update_subject_state(:p_subject_id_in = {$user['user_id']},				
                :p_subject_state_in = {$user['subject_state']})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = "SELECT tomboladb.core.update_subject_state(:p_subject_id_in, :p_subject_state_in)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_subject_id_in'=>$user['user_id'],
                    'p_subject_state_in'=>$user['active'],
                ]
            );
            DB::connection('pgsql')->commit();
			if($fn_result[0]->update_subject_state >= 1)
			{
				return ['status'=>"OK"];
			}
            else if($fn_result[0]->update_subject_state == "-1")
			{
                return ['status'=>"NOK"];
            }else {
			    return ['status'=>"NOK"];
            }

        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::updateSubjectState(user=" . print_r($user, true) .") <br />\n\n",
                "tomboladb.core.update_subject_state(:p_subject_id_in = {$user['user_id']},				
                :p_subject_state_in = {$user['subject_state']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::updateSubjectState(user=" . print_r($user, true) .") <br />\n\n",
                "tomboladb.core.update_subject_state(:p_subject_id_in = {$user['user_id']},				
                :p_subject_state_in = {$user['subject_state']}) <br />\n\n",
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

        if(self::$DEBUG){
            $message = "UserModel::changePassword >>> SELECT tomboladb.core.change_password(:p_session_id_in = {$details['backoffice_session_id']}, :p_subject_id_in = {$details['user_id']}, :p_password_in = {$details['password']})";
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
                    'p_password_in'=>$details['password'],
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
                "UserModel::changePassword(details=" . print_r($details, true) .") <br />\n\n",
                "tomboladb.core.change_password(:p_session_id_in = {$details['backoffice_session_id']}, :p_subject_id_in = {$details['user_id']}, :p_password_in) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::changePassword(details=" . print_r($details, true) .") <br />\n\n",
                "tomboladb.core.change_password(:p_session_id_in = {$details['backoffice_session_id']}, :p_subject_id_in = {$details['user_id']}, :p_password_in) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @param array $user
     * @return array
     */
    public static function newUser2($user){
        //procedure that takes parent id instead of parent name
        try{

            /*if(self::$DEBUG){
                $message = "UserModel::newUser >>> SELECT tomboladb.core.create_subject(:p_username_in = {$user['username']}, :p_password_in = {$user['password']},
                :p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = {$user['currency']}, :p_parent_id = {$user['p_parent_id']}, :p_registered_by_in = {$user['registered_by']},
                :p_subject_dtype_id_in = {$user['subject_type_id']},
                :p_language_in = {$user['language']}, :p_email_in = {$user['email']}, :p_address = {$user['address']}, :p_city = {$user['city']},
                :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']})";
                ErrorHelper::writeInfo($message, $message);
            }*/

            DB::connection('pgsql')->beginTransaction();

            $statement_string = "SELECT tomboladb.core.create_subject(:p_username_in, :p_password_in, :p_first_name_in, :p_last_name_in, :p_currency_in, :p_parent_id, :p_registered_by_in, :p_subject_dtype_id_in, :p_language_in, :p_email_in, :p_address, :p_city, :p_country, :p_mobile_phone, :p_post_code, :p_commercial_address)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_username_in'=>$user['username'],
                    'p_password_in'=>$user['password'],
                    'p_first_name_in'=>$user['first_name'],
                    'p_last_name_in'=>$user['last_name'],
                    'p_currency_in'=>$user['currency'],
                    'p_parent_id'=>$user['parent_id'],
                    'p_registered_by_in'=>$user['registered_by'],
                    'p_subject_dtype_id_in'=>$user['subject_type_id'],
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

            //ErrorHelper::writeError($fn_result[0]->create_subject, $fn_result[0]->create_subject);
            //dd($fn_result);
            if($fn_result[0]->create_subject >= 1)
            {
                return ['status'=>"OK", 'subject_id'=>$fn_result[0]->create_subject];
            }
            if($fn_result[0]->create_subject == -1)
            {
                return [
                    'status'=>"NOK",
                    "message" => "GENERAL_ERROR",
                    "true_status" => $fn_result[0]->create_subject
                ];
            }
            else if($fn_result[0]->create_subject == "-2")
            {
                return ['status'=>"NOK", "message" => "EMAIL NOT AVAILABLE", "true_status" => $fn_result[0]->create_subject];
            }
            else if($fn_result[0]->create_subject == "-3")
            {
                return ['status'=>"NOK", "message" => "USERNAME NOT AVAILABLE", "true_status" => $fn_result[0]->create_subject];
            }else{
                return ['status'=>"NOK", "message" => "UNKNOWN_ERROR", "true_status" => $fn_result[0]->create_subject];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::newUser2(user=" . print_r($user, true) .") <br />\n\n",
                "tomboladb.core.create_subject(:p_username_in = {$user['username']}, :p_password_in = {$user['password']},
                :p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = {$user['currency']}, :p_parent_id = {$user['p_parent_id']}, :p_registered_by_in = {$user['registered_by']},
                :p_subject_dtype_id_in = {$user['subject_type_id']},
                :p_language_in = {$user['language']}, :p_email_in = {$user['email']}, :p_address = {$user['address']}, :p_city = {$user['city']},
                :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::newUser2(user=" . print_r($user, true) .") <br />\n\n",
                "tomboladb.core.create_subject(:p_username_in = {$user['username']}, :p_password_in = {$user['password']},
                :p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = {$user['currency']}, :p_parent_id = {$user['p_parent_id']}, :p_registered_by_in = {$user['registered_by']},
                :p_subject_dtype_id_in = {$user['subject_type_id']},
                :p_language_in = {$user['language']}, :p_email_in = {$user['email']}, :p_address = {$user['address']}, :p_city = {$user['city']},
                :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }
    public static function newUser($user){
        try{

            //ErrorHelper::writeError($user["parent_name"], $user["parent_name"]);

            if(self::$DEBUG){
                $message = "UserModel::newUser >>> SELECT tomboladb.core.create_subject(:p_username_in = {$user['username']}, :p_password_in = {$user['password']},
                :p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = {$user['currency']}, :p_parent_name_in = {$user['parent_name']}, :p_registered_by_in = {$user['registered_by']},
                :p_subject_dtype_id_in = {$user['subject_type_id']}, :p_player_dtype_in = {$user['player_type_name']},
                :p_language_in = {$user['language']}, :p_email_in = {$user['email']}, :p_address = {$user['address']}, :p_city = {$user['city']},
                :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();

            $statement_string = "SELECT tomboladb.core.create_subject(:p_username_in, :p_password_in, :p_first_name_in, :p_last_name_in, :p_currency_in, :p_parent_name_in, :p_registered_by_in, :p_subject_dtype_id_in, :p_player_dtype_in, :p_language_in, :p_email_in, :p_address, :p_city, :p_country, :p_mobile_phone, :p_post_code, :p_commercial_address)";
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
                    'p_player_dtype_in'=>null,
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

            //ErrorHelper::writeError($fn_result[0]->create_subject, $fn_result[0]->create_subject);

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
                return ['status'=>"NOK", "message" => "UNKNOWN_ERROR"];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::newUser(user=" . print_r($user, true) .") <br />\n\n",
                "tomboladb.core.create_subject(:p_username_in = {$user['username']}, :p_password_in = {$user['password']},
                :p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = {$user['currency']}, :p_parent_id = {$user['p_parent_id']}, :p_registered_by_in = {$user['registered_by']},
                :p_subject_dtype_id_in = {$user['subject_type_id']},
                :p_language_in = {$user['language']}, :p_email_in = {$user['email']}, :p_address = {$user['address']}, :p_city = {$user['city']},
                :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::newUser(user=" . print_r($user, true) .") <br />\n\n",
                "tomboladb.core.create_subject(:p_username_in = {$user['username']}, :p_password_in = {$user['password']},
                :p_first_name_in = {$user['first_name']}, :p_last_name_in = {$user['last_name']},
                :p_currency_in = {$user['currency']}, :p_parent_id = {$user['p_parent_id']}, :p_registered_by_in = {$user['registered_by']},
                :p_subject_dtype_id_in = {$user['subject_type_id']},
                :p_language_in = {$user['language']}, :p_email_in = {$user['email']}, :p_address = {$user['address']}, :p_city = {$user['city']},
                :p_country = {$user['country']}, :p_mobile_phone = {$user['mobile_phone']}, :p_post_code = {$user['post_code']}, :p_commercial_address = {$user['commercial_address']}) <br />\n\n",
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
    public static function listAffiliates($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "UserModel::listAffiliates >>> SELECT * from tomboladb.core.list_affiliates( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_affiliates(:p_session_id_in)";
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
                "list_affiliates" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::listAffiliates(backoffice_session_id={$backoffice_session_id} <br />\n\n",
                "tomboladb.core.list_affiliates( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_affiliates"=>[]
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::listAffiliates(backoffice_session_id={$backoffice_session_id} <br />\n\n",
                "tomboladb.core.list_affiliates( :p_session_id_in = {$backoffice_session_id}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_affiliates"=>[]
            ];
        }
    }

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
     * @param $affiliate_id
     * @return array
     */
    public static function searchUsers($backoffice_session_id, $username = null, $first_name = null,
      $last_name = null, $email = null, $city = null, $country_id = null, $mobile_phone = null, $currency = null, $banned_status = null, $subject_type_id = null, $affiliate_id = null
    ){
        if(self::$DEBUG){
            $message = "UserModel::searchUsers >>> SELECT tomboladb.core.search_users(:p_session_id_in = {$backoffice_session_id},
              :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
              :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
              :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$affiliate_id},
               'cur_result_out')";
            ErrorHelper::writeInfo($message, $message);
        }
        try{
            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.search_users(:p_session_id_in, :p_username_in, :p_first_name_in, :p_last_name_in, :p_email_in, :p_city_in, :p_country_id_in, :p_mobile_phone_in, :p_currency_in, :p_banned_status_in, :p_subject_type_id_in, :p_subject_id_in)';
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
                    'p_subject_id_in' => $affiliate_id
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
                "UserModel::searchUsers(backoffice_session_id={$backoffice_session_id}, username={$username}, first_name={$first_name},
                last_name={$last_name}, email={$email}, city={$city}, country_id={$country_id}, mobile_phone={$mobile_phone}, currency={$currency}, banned_status={$banned_status}, 
                subject_type_id={$subject_type_id}, affiliate_id={$affiliate_id} ) <br />\n\n",
                "tomboladb.core.search_users(:p_session_id_in = {$backoffice_session_id},
                :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
                :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
                :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$affiliate_id},
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
                "UserModel::searchUsers(backoffice_session_id={$backoffice_session_id}, username={$username}, first_name={$first_name},
                last_name={$last_name}, email={$email}, city={$city}, country_id={$country_id}, mobile_phone={$mobile_phone}, currency={$currency}, banned_status={$banned_status}, 
                subject_type_id={$subject_type_id}, affiliate_id={$affiliate_id} ) <br />\n\n",
                "tomboladb.core.search_users(:p_session_id_in = {$backoffice_session_id},
                :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
                :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
                :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$affiliate_id},
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
    public static function administrationSearchUsers($backoffice_session_id, $username, $first_name,
      $last_name, $email, $city, $country_id, $mobile_phone, $currency, $banned_status, $subject_type_id, $subject_id
    ){
        if(self::$DEBUG){
            $message = "UserModel::administrationSearchUsers >>> SELECT tomboladb.core.administration_search_users(:p_session_id_in = {$backoffice_session_id},
              :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
              :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
              :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$subject_id}
               'cur_result_out')";
            ErrorHelper::writeInfo($message, $message);
        }
       try{
            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.administration_search_users(:p_session_id_in, :p_username_in, :p_first_name_in, :p_last_name_in, :p_email_in, :p_city_in, :p_country_id_in, :p_mobile_phone_in, :p_currency_in, :p_banned_status_in, :p_subject_type_id_in, :p_subject_id_in)';
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
                "UserModel::administrationSearchUsers(backoffice_session_id={$backoffice_session_id}, username={$username}, first_name={$first_name},
                last_name={$last_name}, email={$email}, city={$city}, country_id={$country_id}, mobile_phone={$mobile_phone}, currency={$currency}, banned_status={$banned_status}, 
                subject_type_id={$subject_type_id}, affiliate_id={$subject_id} ) <br />\n\n",
                "tomboladb.core.administration_search_users(:p_session_id_in = {$backoffice_session_id},
                :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
                :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
                :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$subject_id},
                'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_users" => null
            ];
       }catch(\Exception $ex2) {
           DB::connection('pgsql')->rollBack();
           $message = implode(" ", [
               "UserModel::administrationSearchUsers(backoffice_session_id={$backoffice_session_id}, username={$username}, first_name={$first_name},
                last_name={$last_name}, email={$email}, city={$city}, country_id={$country_id}, mobile_phone={$mobile_phone}, currency={$currency}, banned_status={$banned_status}, 
                subject_type_id={$subject_type_id}, affiliate_id={$subject_id} ) <br />\n\n",
               "tomboladb.core.administration_search_users(:p_session_id_in = {$backoffice_session_id},
                :p_username_in = {$username}, :p_first_name_in = {$first_name}, :p_last_name_in = {$last_name}, :p_email_in = {$email},
                :p_city_in = {$city}, :p_country_id_in = {$country_id}, :p_mobile_phone_in = {$mobile_phone}, :p_currency_in = {$currency},
                :p_banned_status_in = {$banned_status}, :p_subject_type_id_in = {$subject_type_id}, :p_subject_id_in = {$subject_id},
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

    /**
     * @param $backoffice_session_id
     * @param $subject_id
     * @param $subject_type_id
     * @return array
     */
    public static function listAffiliatesBasedOnRole($backoffice_session_id, $subject_id, $subject_type_id){
        try{
            if(self::$DEBUG){
                $message = "UserModel::listAffiliatesBasedOnRole >>> SELECT * from tomboladb.core.get_direct_parents_based_on_role( 
                :p_logged_in_subject_id = {$subject_id}, p_subject_type_id = {$subject_type_id}, 'cur_result_out' ) Backoffice session id = {$backoffice_session_id}";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from core.get_direct_parents_based_on_role(:p_logged_in_subject_id, :p_subject_type_id)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_logged_in_subject_id" => $subject_id,
                    "p_subject_type_id" => $subject_type_id
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_affiliates" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
               "UserModel::listAffiliatesBasedOnRole(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, subject_type_id={$subject_type_id}) <br />\n\n",
               "core.get_direct_parents_based_on_role(:p_logged_in_subject_id = {$subject_id}, :p_subject_type_id = {$subject_type_id}) <br />\n\n",
               $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_affiliates"=>[]
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
               "UserModel::listAffiliatesBasedOnRole(backoffice_session_id={$backoffice_session_id}, subject_id={$subject_id}, subject_type_id={$subject_type_id}) <br />\n\n",
               "core.get_direct_parents_based_on_role(:p_logged_in_subject_id = {$subject_id}, :p_subject_type_id = {$subject_type_id}) <br />\n\n",
               $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_affiliates"=>[]
            ];
        }
    }

    /**
     * @param $parent_id
     * @param $tree_type
     * @param $logged_in_subject_id
     * @return array
     */
    public static function getDepositWithdrawSubjectTree($parent_id, $tree_type, $logged_in_subject_id){
        try{

            if(self::$DEBUG){
                $message = "UserModel::listAffiliatesBasedOnRole >>> SELECT * from tomboladb.core.get_subjects_for_credit_transfer( 
                :p_logged_in_subject = {$logged_in_subject_id}, :p_parent_id = {$parent_id}, p_subject_type = {$tree_type}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from core.get_subjects_for_credit_transfer(:p_logged_in_subject, :p_parent_id, :p_subject_type)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_logged_in_subject" => $logged_in_subject_id,
                    "p_parent_id" => $parent_id,
                    "p_subject_type" => $tree_type
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
               "UserModel::getDepositWithdrawSubjectTree(parent_id={$parent_id}, tree_type={$tree_type}, logged_in_subject_id={$logged_in_subject_id}) <br />\n\n",
               "core.get_subjects_for_credit_transfer(:p_logged_in_subject={$logged_in_subject_id}, :p_parent_id = {$parent_id}, :p_subject_type = {$tree_type}) <br />\n\n",
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
               "UserModel::getDepositWithdrawSubjectTree(parent_id={$parent_id}, tree_type={$tree_type}, logged_in_subject_id={$logged_in_subject_id}) <br />\n\n",
               "core.get_subjects_for_credit_transfer(:p_logged_in_subject={$logged_in_subject_id}, :p_parent_id = {$parent_id}, :p_subject_type = {$tree_type}) <br />\n\n",
               $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result"=>[]
            ];
        }
    }

    public static function getSubjectTreeForParameterSetup($parent_id, $tree_type){
        try{

            if(self::$DEBUG){
                $message = "UserModel::listAffiliatesBasedOnRole >>> SELECT * from tomboladb.core.get_entity_list_for_param_list( 
                :p_parent_id = {$parent_id}, p_subject_type = {$tree_type}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from core.get_entity_list_for_param_list(:p_parent_id, :p_subject_type)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_parent_id" => $parent_id,
                    "p_subject_type" => $tree_type,
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
                "UserModel::getSubjectTree(parent_id={$parent_id}, tree_type={$tree_type}) <br />\n\n",
                "tomboladb.tombola.get_subjects_tree( 
                :p_parent_id = {$parent_id}, p_subject_type = {$tree_type}, 'cur_result_out' ) <br />\n\n",
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
                "UserModel::getSubjectTree(parent_id={$parent_id}, tree_type={$tree_type}) <br />\n\n",
                "tomboladb.tombola.get_subjects_tree( 
                :p_parent_id = {$parent_id}, p_subject_type = {$tree_type}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result"=>[]
            ];
        }
    }

    public static function getSubjectTree($parent_id, $tree_type, $showTerminals){
        try{

            if(self::$DEBUG){
                $message = "UserModel::getSubjectTree >>> SELECT * from tomboladb.tombola.get_subjects_tree( 
                :p_parent_id = {$parent_id}, p_subject_type = {$tree_type}, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tombola.get_subjects_tree(:p_parent_id, :p_subject_type, :p_show_terminals)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_parent_id" => $parent_id,
                    "p_subject_type" => $tree_type,
                    "p_show_terminals" => $showTerminals,

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
                "UserModel::getSubjectTree(parent_id={$parent_id}, tree_type={$tree_type}, show_terminals={$showTerminals}) <br />\n\n",
                "tomboladb.tombola.get_subjects_tree( 
                :p_parent_id = {$parent_id}, p_subject_type = {$tree_type}, p_show_terminals = {$showTerminals}, 'cur_result_out' ) <br />\n\n",
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
                "UserModel::getSubjectTree(parent_id={$parent_id}, tree_type={$tree_type}, show_terminals={$showTerminals}) <br />\n\n",
                "tomboladb.tombola.get_subjects_tree( 
                :p_parent_id = {$parent_id}, p_subject_type = {$tree_type}, p_show_terminals = {$showTerminals}, 'cur_result_out' ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "result"=>[]
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $player_type
     * @return array
     */
    public static function listPlayersByType($backoffice_session_id, $player_type){
        try{

            if(self::$DEBUG){
                $message = "UserModel::listPlayersByType >>> SELECT * from tomboladb.core.list_players_by_type( :p_session_id_in = {$backoffice_session_id}, :p_player_type, 'cur_result_out' )";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.core.list_players_by_type(:p_session_id_in, :p_player_type)";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    "p_session_id_in" => $backoffice_session_id,
                    "p_player_type" => $player_type
                ]
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_users" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::listPlayersByType(backoffice_session_id={$backoffice_session_id}, player_type={$player_type}) <br />\n\n",
                "tomboladb.core.list_players_by_type(:p_session_id_in = {$backoffice_session_id}, :p_player_type = {$player_type}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_users"=>[]
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "UserModel::listPlayersByType(backoffice_session_id={$backoffice_session_id}, player_type={$player_type}) <br />\n\n",
                "tomboladb.core.list_players_by_type(:p_session_id_in = {$backoffice_session_id}, :p_player_type = {$player_type}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_users"=>[]
            ];
        }
    }
}
