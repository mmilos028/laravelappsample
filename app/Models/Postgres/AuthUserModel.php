<?php

namespace App\Models\Postgres;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use App\AuthUser;
use App\Helpers\ErrorHelper;

class AuthUserModel
{
    public static function listAllUsers(){
        try{
            DB::beginTransaction();
            $cursor_result = DB::select('SELECT public.all_users()');
            $cursor_name = $cursor_result[0]->all_users;
            $result = DB::select("fetch all in {$cursor_name};");
            DB::commit();
            return $result;
        }catch(\PDOException $ex1){
            DB::rollBack();
            $message = implode(" ", [
                "AuthUserModel::listAllUsers() <br />\n\n",
                "public.all_users() <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return null;
        }catch(\Exception $ex2){
            DB::rollBack();
            $message = implode(" ", [
                "AuthUserModel::listAllUsers() <br />\n\n",
                "public.all_users() <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return null;
        }
    }

    public static function listUsersAndAdmins(){
        try{
            DB::beginTransaction();
            $cursor_result = DB::select("SELECT public.all_users_admins('list_admins', 'list_users')");
            $resultAdmins = DB::select("fetch all in \"list_admins\";");
            $resultUsers = DB::select("fetch all in \"list_users\";");
            DB::commit();
            DB::select('end;');
            return array("resultAdmins"=>$resultAdmins, "resultUsers"=>$resultUsers);
        }catch(\PDOException $ex1){
            DB::rollBack();
            $message = implode(" ", [
                "AuthUserModel::listUsersAndAdmins() <br />\n\n",
                "public.all_users_admins('list_admins', 'list_users') <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return null;
        }catch(\Exception $ex2){
            DB::rollBack();
            $message = implode(" ", [
                "AuthUserModel::listUsersAndAdmins() <br />\n\n",
                "public.all_users_admins('list_admins', 'list_users') <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return null;
        }
    }

    public static function retrieveById($identifier){
        try {
            DB::select('begin');
            $cursor_result = DB::select('SELECT public.users_get_user_by_user_id(?)', [$identifier]);
            $cursor_name = $cursor_result[0]->users_get_user_by_user_id;
            $result = DB::select("fetch all in \"{$cursor_name}\";");
            DB::commit();
            DB::select('end;');
            $result = $result[0];
            $user = new AuthUser();
            $user->setAttribute("user_id", $result->user_id);
            $user->setAttribute("username", $result->username);
            $user->setAttribute("password", $result->password);
            $user->setAttribute("first_name", $result->first_name);
            $user->setAttribute("last_name", $result->last_name);
            $user->setAttribute("name", $result->first_name . ' ' . $result->last_name);
            return $user;
        }
        catch(\PDOException $ex1){
            DB::rollBack();
            $message = implode(" ", [
                "AuthUserModel::retrieveById(identifier = {$identifier}) <br />\n\n",
                "public.users_get_user_by_user_id({$identifier}) <br />\n\n",
                $ex1->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return null;
        }
        catch(\Exception $ex2){
            DB::rollBack();
            $message = implode(" ", [
                "AuthUserModel::retrieveById(identifier = {$identifier}) <br />\n\n",
                "public.users_get_user_by_user_id({$identifier}) <br />\n\n",
                $ex2->getMessage()
            ]);
            ErrorHelper::writeError($message, $message);
            return null;
        }
    }

    public static function retrieveByToken($identifier, $token){
        return null;
        $user = new AuthUser();
        $user->setAttribute("user_id", 1);
        $user->setAttribute("username", "DevMilos");
        $user->setAttribute("password", "DevMilos");
        $user->setAttribute("first_name", "milos");
        $user->setAttribute("name", "milos milosevic");
        return $user;
    }

    public static function updateRememberToken(Authenticatable $user, $token){
        //$user->setRememberToken($token);
        //$user->save();
    }

    public static function retrieveByCredentials(array $credentials){
        try {
            $username = $credentials['username'];
            $password = $credentials['password'];
            DB::select('begin');
            //$select_string = "SELECT public.users_login_user('{$username}', '{$password}');";
            $select_string = "SELECT public.users_login_user(?, ?);";
            $cursor_result = DB::select($select_string, [$username, $password]);
            $cursor_name = $cursor_result[0]->users_login_user;
            $select_string = "fetch all in \"{$cursor_name}\";";
            $result = DB::select($select_string);
            DB::commit();
            DB::select('end;');
            if (count($result) == 0) {
                return null;
            } else {
                $result = $result[0];
                $user = new AuthUser();
                $user->setAttribute("user_id", $result->user_id);
                $user->setAttribute("username", $result->username);
                $user->setAttribute("password", $result->password);
                $user->setAttribute("first_name", $result->first_name);
                $user->setAttribute("last_name", $result->last_name);
                $user->setAttribute("name", $result->first_name . ' ' . $result->last_name);
                return $user;
            }
        }
        catch(\PDOException $ex1){
            DB::rollBack();
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);
            return null;
        }
        catch(\Exception $ex2){
            DB::rollBack();
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);
            return null;
        }
    }

    public static function validateCredentials(Authenticatable $user, array $credentials){
        // TODO: Implement validateCredentials() method.
        // we'll assume if a user was retrieved, it's good
        /*
        if ($user->username == $credentials['username'] && $user->getAuthPassword() == md5($credentials['password'] . \Config::get('constants.SALT'))) {

            $user->last_login_time = Carbon::now();
            $user->save();

            return true;
        }
        return false;
        */

        //dd("Auth::validateCredentials");
        try {
            $username = $credentials['username'];
            $password = $credentials['password'];
            DB::select('begin');
            $select_string = "SELECT public.users_login_user(?, ?);";
            $cursor_result = DB::select($select_string, [$username, $password]);
            $cursor_name = $cursor_result[0]->users_login_user;
            $select_string = "fetch all in \"{$cursor_name}\";";
            $result = DB::select($select_string);
            DB::commit();
            DB::select('end;');
            if (count($result) == 0) {
                return false;
            } else {
                $result = $result[0];
                if ($result->username == $username) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        catch(\PDOException $ex1){
            DB::rollBack();
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);
            return null;
        }
        catch(\Exception $ex2){
            DB::rollBack();
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);
            return null;
        }
    }

}
