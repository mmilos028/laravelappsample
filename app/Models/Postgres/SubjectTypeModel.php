<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class SubjectTypeModel
{

    private static $DEBUG = false;

    /**
     * @return array
     */
    public static function listStructureEntitySubjectTypes(){

        try{

            /*if(self::$DEBUG){
                $message = "ReportModel::listDailyReport >>> SELECT tomboladb.tombola.daily_report(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }*/

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_structure_subject_dtype_list()';

            $fn_result = DB::connection('pgsql')->select($statement_string
            /*array(
                'p_session_id_in'=>$backoffice_session_id
            )*/
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
                "SubjectTypeModel::listStructureEntitySubjectTypes() <br />\n\n",
                "core.get_structure_subject_dtype_list() <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SubjectTypeModel::listStructureEntitySubjectTypes() <br />\n\n",
                "core.get_structure_subject_dtype_list() <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }

        /*$roles = [
            config("constants.CLIENT_TYPE_ID") => config("constants.CLIENT_TYPE_NAME"),
            config("constants.OPERATER_TYPE_ID") => config("constants.OPERATER_TYPE_NAME"),
            config("constants.LOCATION_TYPE_ID") => config("constants.LOCATION_TYPE_NAME"),
            config("constants.TERMINAL_TYPE_ID") => config("constants.TERMINAL_TYPE_NAME"),
            config("constants.TERMINAL_CASHIER_TYPE_ID") => config("constants.TERMINAL_CASHIER_TYPE_NAME")
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;*/
    }

    /**
     * @return array
     */
    public static function listNewStructureEntitySubjectTypes($logged_user_id){

        try{

            /*if(self::$DEBUG){
                $message = "ReportModel::listDailyReport >>> SELECT tomboladb.tombola.daily_report(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }*/

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_bo_subject_entity_list(:p_logged_in_subject_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_logged_in_subject_id'=>$logged_user_id
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
                "SubjectTypeModel::listNewStructureEntitySubjectTypes(logged_user_id={$logged_user_id}) <br />\n\n",
                "core.get_bo_subject_entity_list(:p_logged_in_subject_id={$logged_user_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SubjectTypeModel::listNewStructureEntitySubjectTypes(logged_user_id={$logged_user_id}) <br />\n\n",
                "core.get_bo_subject_entity_list(:p_logged_in_subject_id={$logged_user_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }

        /*$roles = [
            config("constants.CLIENT_TYPE_ID") => config("constants.CLIENT_TYPE_NAME"),
            config("constants.OPERATER_TYPE_ID") => config("constants.OPERATER_TYPE_NAME"),
            config("constants.LOCATION_TYPE_ID") => config("constants.LOCATION_TYPE_NAME"),
            config("constants.TERMINAL_TYPE_ID") => config("constants.TERMINAL_TYPE_NAME"),
            config("constants.TERMINAL_CASHIER_TYPE_ID") => config("constants.TERMINAL_CASHIER_TYPE_NAME")
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;*/
    }

    /**
     * @return array
     */
    public static function listSubjectTypes(){

        $roles = [
            config("constants.MASTER_TYPE_ID") => config("constants.MASTER_TYPE_NAME"),
            config("constants.CLIENT_TYPE_ID") => config("constants.CLIENT_TYPE_NAME"),
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
    public static function listSubjectTypesForUserSearchUser(){

        $roles = [
            config("constants.PLAYER_TYPE_ID") => config("constants.PLAYER_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
            config("constants.SUPPORT_TYPE_ID") => config("constants.SUPPORT_TYPE_NAME"),
            config("constants.COLLECTOR_TYPE_ID") => config("constants.COLLECTOR_TYPE_NAME"),
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;
    }

    /**
     * @return array
     */
    public static function listBOSubjectTypesForUserNewUser($logged_in_id){
        try{

            /*if(self::$DEBUG){
                $message = "ReportModel::listDailyReport >>> SELECT tomboladb.tombola.daily_report(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }*/

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_bo_subject_dtype_list(:p_logged_in_subject_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
            array(
                'p_logged_in_subject_id'=>$logged_in_id
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
                "SubjectTypeModel::listBOSubjectTypesForUserNewUser(logged_user_id={$logged_in_id}) <br />\n\n",
                "core.get_bo_subject_dtype_list(:p_logged_in_subject_id={$logged_in_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SubjectTypeModel::listBOSubjectTypesForUserNewUser(logged_user_id={$logged_in_id}) <br />\n\n",
                "core.get_bo_subject_dtype_list(:p_logged_in_subject_id={$logged_in_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }

        /*$roles = [
            config("constants.PLAYER_TYPE_ID") => config("constants.PLAYER_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
            config("constants.SUPPORT_TYPE_ID") => config("constants.SUPPORT_TYPE_NAME"),
            config("constants.COLLECTOR_TYPE_ID") => config("constants.COLLECTOR_TYPE_NAME"),
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;*/
    }

    public static function listSubjectTypesForAdministrationSearchUser($logged_in){
        try{

            if(self::$DEBUG){
                $message = "SubjectTypeModel::listSubjectTypesForAdministrationSearchUser >>> SELECT core.get_bo_user_entity_list(:p_logged_in_subject_id = {$logged_in}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_bo_user_entity_list(:p_logged_in_subject_id)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
            array(
                'p_logged_in_subject_id'=>$logged_in
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
                "SubjectTypeModel::listSubjectTypesForAdministrationSearchUser(logged_in={$logged_in}) <br />\n\n",
                "core.get_bo_user_entity_list(:p_logged_in_subject_id={$logged_in}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SubjectTypeModel::listSubjectTypesForAdministrationSearchUser(logged_in={$logged_in}) <br />\n\n",
                "core.get_bo_user_entity_list(:p_logged_in_subject_id={$logged_in}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }

        /*$roles = [
            config("constants.PLAYER_TYPE_ID") => config("constants.PLAYER_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
            config("constants.SUPPORT_TYPE_ID") => config("constants.SUPPORT_TYPE_NAME"),
            config("constants.COLLECTOR_TYPE_ID") => config("constants.COLLECTOR_TYPE_NAME"),
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;*/
    }

    public static function listSubjectTypesForUserNewUser(){
        try{

            /*if(self::$DEBUG){
                $message = "ReportModel::listDailyReport >>> SELECT tomboladb.tombola.daily_report(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }*/

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from core.get_subject_dtype_list()';

            $fn_result = DB::connection('pgsql')->select($statement_string
            /*array(
                'p_session_id_in'=>$backoffice_session_id
            )*/
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
                "SubjectTypeModel::listSubjectTypesForUserNewUser() <br />\n\n",
                "core.get_subject_dtype_list() <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "SubjectTypeModel::listSubjectTypesForUserNewUser() <br />\n\n",
                "core.get_subject_dtype_list() <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "report" => null
            ];
        }

        /*$roles = [
            config("constants.PLAYER_TYPE_ID") => config("constants.PLAYER_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
            config("constants.SUPPORT_TYPE_ID") => config("constants.SUPPORT_TYPE_NAME"),
            config("constants.COLLECTOR_TYPE_ID") => config("constants.COLLECTOR_TYPE_NAME"),
        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;*/
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
    public static function listAllSubjectTypesForAdministrationSearchUser()
    {

        $roles = [
            config("constants.MASTER_TYPE_ID") => __(config("constants.MASTER_TYPE_NAME")),
            //config("constants.PLAYER_TYPE_ID") => config("constants.PLAYER_TYPE_NAME"),
            config("constants.TERMINAL_TYPE_ID") => config("constants.TERMINAL_TYPE_NAME"),
            config("constants.TERMINAL_CASHIER_TYPE_ID") => config("constants.TERMINAL_CASHIER_TYPE_NAME"),

            config("constants.CLIENT_TYPE_ID") => config("constants.CLIENT_TYPE_NAME"),
            config("constants.OPERATER_TYPE_ID") => config("constants.OPERATER_TYPE_NAME"),
            config("constants.LOCATION_TYPE_ID") => config("constants.LOCATION_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),

            config("constants.COLLECTOR_TYPE_ID") => config("constants.COLLECTOR_TYPE_NAME"),
            config("constants.SUPPORT_TYPE_ID") => config("constants.SUPPORT_TYPE_NAME"),
            config("constants.PLAYER_TYPE_ID") => __(config("constants.PLAYER_TYPE_NAME")),

        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;
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

            config("constants.CLIENT_TYPE_ID") => config("constants.CLIENT_TYPE_NAME"),
            config("constants.OPERATER_TYPE_ID") => config("constants.OPERATER_TYPE_NAME"),
            config("constants.LOCATION_TYPE_ID") => config("constants.LOCATION_TYPE_NAME"),
            config("constants.CASHIER_TYPE_ID") => config("constants.CASHIER_TYPE_NAME"),
            config("constants.ADMINISTRATOR_TYPE_ID") => config("constants.ADMINISTRATOR_TYPE_NAME"),

            config("constants.COLLECTOR_TYPE_ID") => config("constants.COLLECTOR_TYPE_NAME"),
            config("constants.SUPPORT_TYPE_ID") => config("constants.SUPPORT_TYPE_NAME"),
            config("constants.PLAYER_TYPE_ID") => config("constants.PLAYER_TYPE_NAME"),

        ];

        $roles = \App\Helpers\ArrayHelper::aasort($roles, 0, "ASC");

        return $roles;
    }

}
