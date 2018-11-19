<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\Postgres\CommonModel;
use App\Models\Postgres\UserModel;
use App\Helpers\PasswordHasherHelper;

class MyAccountController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function changePassword(Request $request)
    {
        $body = \Request::json()->get('body');
        $backoffice_session_id = $body['backoffice_session_id'];
        $user_id = $body['user_id'];
        $username = $body['username'];
        $password = $body['password'];
        //$resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        try {
            $hashed_password = PasswordHasherHelper::make($password);
            $details = array(
                'user_id'=>$user_id,
                'backoffice_session_id'=>$backoffice_session_id,
                'username'=>$username,
                'password'=>$hashed_password
            );

            $resultChangePassword = UserModel::changePassword($details);
            if($resultChangePassword['status'] == "OK"){
                return response()->json([
                    "status" => "OK",
                    "success_message" => __("authenticated.Changes saved")
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "error_message" => __("authenticated.Changes not saved")
                ]);
            }
        }catch(\Exception $ex){
            return response()->json([
                "status" => "NOK",
                "error_message" => __("authenticated.Changes not saved")
            ]);
        }
    }

    public function personalInformation(Request $request){
        $body = \Request::json()->get('body');
        $backoffice_session_id = $body['backoffice_session_id'];
        try {
            $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
            if($resultPersonalInformation['status'] == "OK") {
                return response()->json([
                    "status" => "OK",
                    "user" => $resultPersonalInformation['user']
                ]);
            }else {
                return response()->json([
                    "status" => "NOK",
                ]);
            }
        }catch(\Exception $ex1){
            return response()->json([
                "status" => "NOK",
            ]);
        }
    }

    public function listCountries(Request $request)
    {
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');
        try {
            $countries = CommonModel::listCountries($backoffice_session_id);
            if($countries['status'] == "OK") {
                $list_countries = [];
                foreach ($countries['list_countries'] as $country) {
                    $list_countries[] = array(
                        "countryCode" => $country->country_code,
                        "countryName" => $country->name
                    );
                }
                return response()->json([
                    "status" => "OK",
                    "list_countries" => $list_countries
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "backoffice_session_id" => $backoffice_session_id
                ]);
            }
        }catch(\Exception $ex1){
            return response()->json([
                "status" => "NOK",
                "backoffice_session_id" => $backoffice_session_id
            ]);
        }
    }

    public function listLanguages(Request $request){
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');
        try {
            $list_languages = UserModel::listLanguages();
            $response = [];
            foreach($list_languages as $key=>$value){
                $response[] = array(
                    "languageCode" => $key,
                    "languageName" => $value
                );
            }
            return response()->json([
                "status" => "OK",
                "list_languages" => $response
            ]);

        }catch(\Exception $ex1){
            return response()->json([
                "status" => "NOK",
                "backoffice_session_id" => $backoffice_session_id
            ]);
        }
    }

    public function listCurrency(Request $request){
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');
        try {
            $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
            if($resultPersonalInformation['status'] == "OK") {
                $response = [];
                foreach ($resultPersonalInformation['list_currency'] as $currency) {
                    $response[] = array(
                        "currency" => $currency,
                    );
                }
                return response()->json([
                    "status" => "OK",
                    "list_currency" => $response
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "backoffice_session_id" => $backoffice_session_id
                ]);
            }
        }catch(\Exception $ex1){
            return response()->json([
                "status" => "NOK",
                "backoffice_session_id" => $backoffice_session_id
            ]);
        }
    }

    public function updatePersonalData(Request $request){

        $user = \Request::json()->get('body');

        $backoffice_session_id = $user['backoffice_session_id'];
        $username = $user['username'];
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $currency = $user['currency'];
        $language = $user['language'];
        $email = $user['email'];
        $address = $user['address'];
        $city = $user['city'];
        $country = $user['country'];
        $mobile_phone = $user['mobile_phone'];
        $post_code = $user['post_code'];
        $commercial_address = $user['commercial_address'];
        $user_id = $user['user_id'];
        $account_active = $user['account_active'];

        $updatedUser = array(
            'user_id'=>$user_id,
            'username'=>$username,
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'currency'=>$currency,
            'email'=>$email,
            'edited_by'=>$user_id,
            'player_type'=>$request->get('subject_type'),
            'subject_state'=>$account_active,
            'language'=>$language,
            'address'=>$address,
            'city'=>$city,
            'country'=>$country,
            'mobile_phone'=>$mobile_phone,
            'post_code'=>$post_code
        );

        $resultUpdatePersonalInformation = UserModel::updateUser($updatedUser);
        if($resultUpdatePersonalInformation['status'] == "OK"){

            $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);

            if(isset($resultPersonalInformation['user']['language'])) {
                $localeSaved = explode('_', $resultPersonalInformation['user']['language']);
                $language = $localeSaved[0];
            }else{
                $language = "en";
            }

            \LaravelLocalization::setLocale($language);
            \App::setLocale($language);

            return response()->json([
                "status" => "OK",
                "message" => __("authenticated.Changes saved")
            ]);

        }else{
            $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);

            if($resultUpdatePersonalInformation["message"] == "GENERAL_ERROR"){
                $error_message = __("authenticated.Changes not saved");
            }
            if($resultUpdatePersonalInformation["message"] == "EMAIL NOT AVAILABLE"){
                $error_message = __("authenticated.Email is not available");
            }
            if($resultUpdatePersonalInformation["message"] == "USERNAME NOT AVAILABLE"){
                $error_message = __("authenticated.Username is not available");
            }

            return response()->json([
                "status" => "NOK",
                "message" => $error_message
            ]);
        }
    }
}
