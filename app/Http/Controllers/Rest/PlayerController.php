<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\Postgres\PlayerModel;
use App\Models\Postgres\TerminalModel;
use App\Models\Postgres\CommonModel;
use App\Models\Postgres\UserModel;

class PlayerController extends Controller
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
        $player_id = $body['player_id'];
        $new_password = $body['password'];

        try {

            $details = array(
                'user_id'=>$player_id,
                'backoffice_session_id'=>$backoffice_session_id,
                'password'=>$new_password
            );

            $resultChangePlayerPassword = PlayerModel::changePassword($details);
            if($resultChangePlayerPassword['status'] == "OK"){
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

    public function changePlayerAccountStatus(Request $request)
    {
        $body = \Request::json()->get('body');
        $backoffice_session_id = $body['backoffice_session_id'];
        $player_id = $body['player_id'];

        try {
            $resultUserInformation = UserModel::userInformation($player_id);

            $account_status = $resultUserInformation["user"]["active"];
            if ($account_status == "1") {
                $account_status = "-1";
            } else {
                $account_status = "1";
            }

            $user = array(
                'email' => null,
                'first_name' => null,
                'last_name' => null,
                'currency' => null,
                'parent_name' => null,
                'registered_by' => null,
                'language' => null,
                'edited_by' => null,
                'user_id' => $player_id,
                'active' => $account_status,
                'address' => null,
                'city' => null,
                'country' => null,
                'mobile_phone' => null,
                'post_code' => null,
                'commercial_address' => null,
            );

            $resultUpdateUserInformation = UserModel::updateUser($user);

            if($resultUpdateUserInformation['status'] == 'OK'){
                return response()->json([
                    "status" => "OK",
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                ]);
            }
        }catch(\Exception $ex){
            return response()->json([
                "status" => "NOK",
            ]);
        }

    }

    public function newPlayer(Request $request)
    {

        $player = \Request::json()->get('body');

        $backoffice_session_id = $player['backoffice_session_id'];

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);

        if($request->isMethod("POST")) {

            //$hashed_password = PasswordHasherHelper::make($request->get('password'));
            $hashed_password = $player['password'];

            $user = array(
                'username'=>$player['username'],
                'password'=>$hashed_password,
                'email'=>$player['email'],
                'first_name'=>$player['first_name'],
                'last_name'=>$player['last_name'],
                'currency'=>$player['currency'],
                'parent_name'=>$resultPersonalInformation['user']['username'],
                'registered_by'=>$resultPersonalInformation['user']['username'],
                'subject_type_id'=>config("constants.PLAYER_TYPE_ID"),
                'player_type_name'=>config("constants.PLAYER_TYPE_NAME"),
                'language'=>$player['language'],
                'address'=>$player['address'],
                'city'=>$player['city'],
                'country'=>$player['country'],
                'mobile_phone'=>$player['mobile_phone'],
                'post_code'=>$player['post_code'],
                'commercial_address'=>''
            );

            $resultInsertPlayerInformation = PlayerModel::createUser($user);
            if($resultInsertPlayerInformation['status'] == "OK"){
                $resultSetServiceKeyForTerminal = TerminalModel::setServiceKeyForTerminal($resultInsertPlayerInformation['subject_id']);
                if($resultSetServiceKeyForTerminal['status'] == "OK") {
                    return response()->json([
                        "status" => "OK",
                        "success_message" => __("authenticated.Changes saved")
                    ]);
                }else {
                    return response()->json([
                        "status" => "WARNING",
                        "warning_message" => __("authenticated.Terminal created, but service key not set !")
                    ]);
                }
            }else{
                if($resultInsertPlayerInformation["message"] == "GENERAL_ERROR"){
                    $error_message = __("authenticated.Changes not saved");
                }
                if($resultInsertPlayerInformation["message"] == "EMAIL NOT AVAILABLE"){
                    $error_message = __("authenticated.Email is not available");
                }
                if($resultInsertPlayerInformation["message"] == "USERNAME NOT AVAILABLE"){
                    $error_message = __("authenticated.Username is not available");
                }

                return response()->json([
                    "status" => "NOK",
                    "error_message" => $error_message
                ]);
            }
        }else{
            return response()->json([
                "status" => "NOK",
                "error_message" => __("authenticated.Changes not saved")
            ]);
        }
    }

    public function updatePlayer(Request $request)
    {
        $player = \Request::json()->get('body');
        $backoffice_session_id = $player['backoffice_session_id'];
        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        if($request->isMethod("POST")) {
            $user = array(
                'user_id'=>$player['user_id'],
                'username'=>$player['username'],
                'email'=>$player['email'],
                'first_name'=>$player['first_name'],
                'last_name'=>$player['last_name'],
                'currency'=>$player['currency'],
                'parent_name'=>$resultPersonalInformation['user']['username'],
                'registered_by'=>$resultPersonalInformation['user']['username'],
                'subject_type_id'=>config("constants.PLAYER_TYPE_ID"),
                'player_type_name'=>config("constants.PLAYER_TYPE_NAME"),
                'language'=>$player['language'],
                'address'=>$player['address'],
                'city'=>$player['city'],
                'country'=>$player['country'],
                'mobile_phone'=>$player['mobile_phone'],
                'post_code'=>$player['post_code'],
                'commercial_address'=>''
            );
            $resultUpdatePlayerInformation = PlayerModel::updatePlayer($user);
            if($resultUpdatePlayerInformation['status'] == "OK"){
                return response()->json([
                    "status" => "OK",
                    "success_message" => __("authenticated.Changes saved")
                ]);
            }else{
                if($resultUpdatePlayerInformation["message"] == "GENERAL_ERROR"){
                    $error_message = __("authenticated.Changes not saved");
                }
                if($resultUpdatePlayerInformation["message"] == "EMAIL NOT AVAILABLE"){
                    $error_message = __("authenticated.Email is not available");
                }
                if($resultUpdatePlayerInformation["message"] == "USERNAME NOT AVAILABLE"){
                    $error_message = __("authenticated.Username is not available");
                }
                return response()->json([
                    "status" => "NOK",
                    "error_message" => $error_message
                ]);
            }
        }else{
            return response()->json([
                "status" => "NOK",
                "error_message" => __("authenticated.Changes not saved")
            ]);
        }
    }

    public function details(Request $request){
        //sleep(10);
        $body = \Request::json()->get('body');
        $backoffice_session_id = $body['backoffice_session_id'];
        $player_id = $body['player_id'];
        try {
            $resultPlayerInformation = PlayerModel::playerInformation($player_id);
            if($resultPlayerInformation['status'] == "OK") {
                return response()->json([
                    "status" => "OK",
                    "player_id" => $player_id,
                    "user" => $resultPlayerInformation['user']
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

    public function listPlayers()
    {
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');
        //sleep(10);
        try {
            $result = PlayerModel::listPlayers($backoffice_session_id);
            if($result['status'] == "OK"){
              return response()->json([
                  "status" => "OK",
                  "players" => $result['list_players']
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
}
