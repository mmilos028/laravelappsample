<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\Postgres\UserModel;
use App\Models\Postgres\CashierModel;
use App\Helpers\PasswordHasherHelper;

class AdministrationUserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function listSubjectTypesForAdministrationNewUser()
    {
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');

        try {
            $subject_types = UserModel::listAllSubjectTypesForAdministrationNewUser();
            $response = array();
            foreach($subject_types as $key => $value){
                $response[] = [
                    "role_id" => $key,
                    "role_name" => $value
                ];
            }
            return response()->json([
                "status" => "OK",
                "list_subject_types" => $response
            ]);
        }catch(\Exception $ex1){
            return response()->json([
                "status" => "NOK",
                "backoffice_session_id" => $backoffice_session_id
            ]);
        }
    }

    public function listParentAffiliates(){
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');

        try {
            $sub_subjects = UserModel::listAffiliates($backoffice_session_id);
            if($sub_subjects['status'] != OK){
                return response()->json([
                    "status" => "NOK",
                    "backoffice_session_id" => $backoffice_session_id
                ]);
            }
            $response = array();
            foreach($sub_subjects['list_affiliates'] as $affiliate){
                $response[] = [
                    "user_id" => $affiliate->subject_id,
                    "username" => $affiliate->username
                ];
            }
            return response()->json([
                "status" => "OK",
                "list_affiliates" => $response
            ]);
        }catch(\Exception $ex1){
            return response()->json([
                "status" => "NOK",
                "backoffice_session_id" => $backoffice_session_id
            ]);
        }
    }

    public function createNewUser(){

        /*return response()->json([
            "status" => "OK",
            "success_message" => __("authenticated.Changes saved")
        ]);*/

        $user = \Request::json()->get('user');

        $backoffice_session_id = $user['backoffice_session_id'];
        $backoffice_user_username = $user['backoffice_user_username'];
        $username = $user['username'];
        $password = $user['password'];
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $currency = $user['currency'];
        $subject_type_id = $user['subject_type_id'];
        $subject_type_name = $user['subject_type_name'];
        $parent_affiliate_username = $user['parent_affiliate_username'];
        $language = $user['language'];
        $email = $user['email'];
        $address = $user['address'];
        $city = $user['city'];
        $country = $user['country'];
        $mobile_phone = $user['mobile_phone'];
        $post_code = $user['post_code'];
        $commercial_address = $user['commercial_address'];
        $draw_model_id = $user['draw_model_id'];

        if(in_array($subject_type_id,
            array(config('constants.TERMINAL_CASHIER_TYPE_ID'), config('constants.TERMINAL_TYPE_ID'), config('constants.PLAYER_TYPE_ID')))
        ){
            $hashed_password = PasswordHasherHelper::make($password);
        }else{
            $hashed_password = $password;
        }

        $user = array(
            'username'=>$username,
            'password'=>$hashed_password,
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'currency'=>$currency,
            'parent_name'=>$parent_affiliate_username,
            'registered_by'=>$backoffice_user_username,
            'subject_type_id'=>$subject_type_id,
            'player_type_name'=>'',
            'language'=>$language,
            'email'=>$email,
            'address'=>$address,
            'city'=>$city,
            'country'=>$country,
            'mobile_phone'=>$mobile_phone,
            'post_code'=>$post_code,
            'commercial_address'=>$commercial_address,
        );

        $resultInsertUserInformation = UserModel::newUser($user);
        if($resultInsertUserInformation['status'] == "OK"){
            if($subject_type_id == config('constants.TERMINAL_CASHIER_TYPE_ID')){
                $resultSetServiceKeyForTerminal = TerminalModel::setServiceKeyForTerminal($resultInsertUserInformation['subject_id']);
                if($resultSetServiceKeyForTerminal['status'] == "OK") {
                    return response()->json([
                        "status" => "OK",
                        "success_message" => __("authenticated.Changes saved")
                    ]);
                }
                else{
                    return response()->json([
                        "status" => "WARNING",
                        "warning_message" => __("authenticated.Terminal created, but service key not set !")
                    ]);
                }
            }
            else if($subject_type_id == config('constants.AFFILIATE_TYPE_ID')) {
                $resultDrawModelToAffiliate = DrawModelSetupModel::addDrawModelToAffiliate($backoffice_session_id, $resultInsertUserInformation['subject_id'], $draw_model_id);
                if($resultDrawModelToAffiliate['status'] == 'OK') {
                    return response()->json([
                        "status" => "OK",
                        "success_message" => __("authenticated.Changes saved")
                    ]);
                }else{
                    return response()->json([
                        "status" => "WARNING",
                        "warning_message" => __("authenticated.Affiliate created, but draw model not connected !")
                    ]);
                }
            }
            else {
                return response()->json([
                    "status" => "OK",
                    "success_message" => __("authenticated.Changes saved")
                ]);
            }
        }else{
            if($resultInsertUserInformation["message"] == "GENERAL_ERROR"){
                $error_message = __("authenticated.Changes not saved");
            }
            else if($resultInsertUserInformation["message"] == "EMAIL NOT AVAILABLE"){
                $error_message = __("authenticated.Email is not available");
            }
            else if($resultInsertUserInformation["message"] == "USERNAME NOT AVAILABLE"){
                $error_message = __("authenticated.Username is not available");
            }
            else{
                $error_message = __("authenticated.Changes not saved");
            }

            return response()->json([
                "status" => "NOK",
                "error_message" => $error_message
            ]);
        }
    }

    public function searchUsers(){
        $username = \Request::json()->get('username');
        $first_name = \Request::json()->get('first_name');
        $last_name = \Request::json()->get('last_name');
        $email = \Request::json()->get('email');
        $city = \Request::json()->get('city');
        $country_id = \Request::json()->get('country_id');
        $mobile_phone = \Request::json()->get('mobile_phone');
        $currency = \Request::json()->get('currency');
        $banned_status = \Request::json()->get('banned_status');
        $subject_type_id = \Request::json()->get('subject_type');
        $affiliate_id = \Request::json()->get('affiliate_id');
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');

        $resultSearchUsers = UserModel::administrationSearchUsers($backoffice_session_id, $username, $first_name,
            $last_name, $email, $city, $country_id, $mobile_phone, $currency, $banned_status, $subject_type_id, $affiliate_id);

        return response()->json([
            "status" => "OK",
            "list_users" => $resultSearchUsers['list_users']
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocationAddressInformation(Request $request){
        try {

            $body = \Request::json()->get('body');

            $backoffice_session_id = $body['backoffice_session_id'];

            $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
            $location_id = $resultPersonalInformation['user']['user_id'];

            $resultLocationAddressInformation = CashierModel::getLocationAddress($backoffice_session_id, $location_id);

            if($resultLocationAddressInformation['status'] == "OK"){
                return response()->json([
                    "status" => "OK",
                    "location_id" => $location_id,
                    "city" => $resultLocationAddressInformation['city'],
                    "address" => $resultLocationAddressInformation['address'],
                    "commercial_address" => $resultLocationAddressInformation['commercial_address']
                ]);
            }else{
                return response()->json([
                    "status" => "NOK"
                ]);
            }
        }catch(\PDOException $ex2){
            return response()->json([
                "status" => "NOK"
            ]);
        }catch(\Exception $ex4){
            return response()->json([
                "status" => "NOK"
            ]);
        }
   }
}
