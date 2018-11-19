<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use PDO;

use App\Helpers\ErrorHelper;

class ApplicationVersionSetupModel
{

    private static $DEBUG = false;

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listApplicationVersionSet($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "SELECT * from tomboladb.tombola.get_applications_with_versions('cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.tombola.get_applications_with_versions()";
            $fn_result = DB::connection('pgsql')->select(
                $statement_string
            );

            $cursor_name = $fn_result[0]->cur_result_out;
            $cursor_result = DB::connection('pgsql')->select("fetch all in {$cursor_name};");

            DB::connection('pgsql')->commit();
            return [
                "status" => "OK",
                "list_application_version_set" => $cursor_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::listApplicationVersionSet($backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.tombola.get_applications_with_versions() <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_application_version_set" => []
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::listApplicationVersionSet($backoffice_session_id = {$backoffice_session_id}) <br />\n\n",
                "tomboladb.tombola.get_applications_with_versions() <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_application_version_set" => []
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $application_name
     * @param $version
     * @return array
     */
    public static function addApplicationAndVersion($backoffice_session_id, $application_name, $version){
        if(self::$DEBUG){
            $message = "ApplicationVersionSetupModel::addApplicationAndVersion >>> SELECT tomboladb.tombola.add_application_and_version(
            :p_application_name = {$application_name}, :p_version_in = {$version})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.tombola.add_application_and_version(:p_application_name, :p_version_in)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_application_name' => $application_name,
                    'p_version_in' => $version
                ]
            );

            DB::connection('pgsql')->commit();

            if($fn_result[0]->p_status_out >= 0){
                return ['status'=>"OK"];
            }
            else{
                $message = "ApplicationVersionSetupModel::addApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, p_application_name = {$application_name}, 
                p_version_in = {$version}) result = {$fn_result[0]->p_status_out} response = Unknown error occurred";
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'status_out' => $fn_result[0]->p_status_out, 'message' => 'Unknown error occurred' ];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::addApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, application_name = {$application_name}, version={$version}) <br />\n\n",
                "tomboladb.tombola.add_application_and_version(:p_application_name = {$application_name}, :p_version_in = {$version}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::addApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, application_name = {$application_name}, version={$version}) <br />\n\n",
                "tomboladb.tombola.add_application_and_version(:p_application_name = {$application_name}, :p_version_in = {$version}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

     /**
     * @param $backoffice_session_id
     * @param $application_name
     * @return array
     */
    public static function deleteApplicationAndVersion($backoffice_session_id, $application_name){
        if(self::$DEBUG){
            //tombola.remove_application_and_version(p_application_name character varying, OUT p_status_out integer)
            $message = "ApplicationVersionSetupModel::deleteApplicationAndVersion >>> SELECT tomboladb.tombola.remove_application_and_version(
            :p_application_name = {$application_name})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.tombola.remove_application_and_version(:p_application_name)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_application_name' => $application_name
                ]
            );

            DB::connection('pgsql')->commit();

            if($fn_result[0]->p_status_out >= 0){
                return ['status'=>"OK"];
            }
            else{
                $message = "ApplicationVersionSetupModel::deleteApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, p_application_name = {$application_name}) result = {$fn_result[0]->p_status_out} response = Unknown error occurred";
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'status_out' => $fn_result[0]->p_status_out, 'message' => 'Unknown error occurred' ];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::deleteApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, application_name = {$application_name}) <br />\n\n",
                "tomboladb.tombola.remove_application_and_version(:p_application_name = {$application_name}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::deleteApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, application_name = {$application_name}) <br />\n\n",
                "tomboladb.tombola.remove_application_and_version(:p_application_name = {$application_name}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $application_name
     * @param $version
     * @return array
     */
    public static function updateApplicationAndVersion($backoffice_session_id, $application_name, $version){
        if(self::$DEBUG){
            $message = "ApplicationVersionSetupModel::updateApplicationAndVersion >>> SELECT tomboladb.tombola.set_application_version(
            :p_application_name = {$application_name}, :p_version_in = {$version})";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT tomboladb.tombola.set_application_version(:p_application_name, :p_version_in)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_application_name' => $application_name,
                    'p_version_in' => $version
                ]
            );
            DB::connection('pgsql')->commit();
            if($fn_result[0]->p_status_out >= 0){
                return ['status'=>"OK"];
            }
            else{
                $message = "ApplicationVersionSetupModel::updateApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, p_application_name = {$application_name}, 
                p_version_in = {$version}) result = {$fn_result[0]->p_status_out} response = Unknown error occurred";
                ErrorHelper::writeError($message, $message);
                return ['status'=>"NOK", 'status_out' => $fn_result[0]->p_status_out, 'message' => 'Unknown error occurred' ];
            }
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::updateApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, application_name={$application_name}, version={$version}) <br />\n\n",
                "tomboladb.tombola.set_application_version(:p_application_name = {$application_name}, :p_version_in = {$version}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::updateApplicationAndVersion(backoffice_session_id = {$backoffice_session_id}, application_name={$application_name}, version={$version}) <br />\n\n",
                "tomboladb.tombola.set_application_version(:p_application_name = {$application_name}, :p_version_in = {$version}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $application_name
     * @return array
     */
    public static function getApplicationForVersion($backoffice_session_id, $application_name){
        if(self::$DEBUG){
            $message = "ApplicationVersionSetupModel::getApplicationForVersion >>> SELECT tomboladb.tombola.get_application_for_version(
            :p_application_name = {$application_name}, :p_version__out)";
            ErrorHelper::writeInfo($message, $message);
        }

        try{
            DB::connection('pgsql')->beginTransaction();

            $statement_string = 'SELECT tomboladb.tombola.get_application_for_version(:p_application_name)';
            $fn_result = DB::connection('pgsql')->select(
                $statement_string,
                [
                    'p_application_name' => $application_name
                ]
            );

            DB::connection('pgsql')->commit();

            return ['status' => 'OK', 'version'=>$fn_result[0]->p_version__out];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::getApplicationForVersion(backoffice_session_id = {$backoffice_session_id}, application_name={$application_name}) <br />\n\n",
                "tomboladb.tombola.get_application_for_version(:p_application_name = {$application_name}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "ApplicationVersionSetupModel::getApplicationForVersion(backoffice_session_id = {$backoffice_session_id}, application_name={$application_name}) <br />\n\n",
                "tomboladb.tombola.get_application_for_version(:p_application_name = {$application_name}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return ["status"=>"NOK"];
        }
    }
}
