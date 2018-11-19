<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\Postgres\UserModel;
use App\Helpers\NumberHelper;
use App\Helpers\ErrorHelper;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function listUsers()
    {
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');

        try {
            $result = UserModel::listAffiliates($backoffice_session_id);
            if($result['status'] == "OK"){
              return response()->json([
                  "status" => "OK",
                  "users" => $result
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

    public function personalInformationForHomePage(){
        try {
            $body = \Request::json()->get('body');
            $backoffice_session_id = $body['backoffice_session_id'];

            $resultPersonalInformation = UserModel::personalInformationForHomePage($backoffice_session_id);

            $personalInfoResult = array();

            $i = 0;
            foreach ($resultPersonalInformation["cur_result"] as $r){
                $personalInfoResult[$i]["subject_id"] = $r->subject_id;
                $personalInfoResult[$i]["username"] = $r->username;
                $personalInfoResult[$i]["first_name"] = $r->first_name;
                $personalInfoResult[$i]["last_name"] = $r->last_name;
                $personalInfoResult[$i]["email"] = $r->email;
                $personalInfoResult[$i]["registration_date"] = $r->registration_date;
                $personalInfoResult[$i]["subject_type"] = $r->subject_dtype;
                $personalInfoResult[$i]["subject_state"] = $r->subject_state;
                $personalInfoResult[$i]["language"] = $r->language;
                $personalInfoResult[$i]["parent_id"] = $r->parent_id;
                $personalInfoResult[$i]["parent_username"] = $r->parent_username;
                $personalInfoResult[$i]["mobile_phone"] = $r->mobile_phone;
                $personalInfoResult[$i]["post_code"] = $r->post_code;
                $personalInfoResult[$i]["country_id"] = $r->country_id;
                $personalInfoResult[$i]["address"] = $r->address;
                $personalInfoResult[$i]["city"] = $r->city;
                $personalInfoResult[$i]["country_name"] = $r->country_name;
                $personalInfoResult[$i]["credits"] = $r->credits;
                $personalInfoResult[$i]["commercial_address"] = $r->commercial_address;
                $personalInfoResult[$i]["currency"] = $r->currency;
                $personalInfoResult[$i]["last_login_date"] = $r->last_login_tmstp;
                $personalInfoResult[$i]["credits"] = $r->credits;
                $personalInfoResult[$i]["credits_formatted"] = NumberHelper::format_double($r->credits);

                $pos = strpos($r->last_login_tmstp, " ");
                $date_formatted = $r->last_login_tmstp;
                $date_formatted = substr_replace($date_formatted,"          ",$pos,1);

                $personalInfoResult[$i]["last_login_date_formatted"] = $date_formatted;

                $personalInfoResult[$i]["last_login_ip"] = $r->last_login_ip;
                if(empty($r->last_login_city)){
                    $personalInfoResult[$i]["last_login_city"] = "UNKNOWN";
                }else{
                    $personalInfoResult[$i]["last_login_city"] = $r->last_login_city;
                }
                if(empty($r->last_login_country)){
                    $personalInfoResult[$i]["last_login_country"] = "UNKNOWN";
                }else{
                    $personalInfoResult[$i]["last_login_country"] = $r->last_login_country;
                }
                $personalInfoResult[$i]["last_session_id"] = $r->last_session_id;
                $personalInfoResult[$i]["current_session_ip"] = $r->current_sess_ip;
                if(empty($r->current_sess_city)){
                    $personalInfoResult[$i]["current_session_city"] = "UNKNOWN";
                }else{
                    $personalInfoResult[$i]["current_session_city"] = $r->current_sess_city;
                }
                if(empty($r->current_sess_country)){
                    $personalInfoResult[$i]["current_session_country"] = "UNKNOWN";
                }else{
                    $personalInfoResult[$i]["current_session_country"] = $r->current_sess_country;
                }
                $personalInfoResult[$i]["current_session_country"] = $r->current_sess_country;
                $i++;
            }
            $i = 0;

            if($resultPersonalInformation['status'] == "OK"){

                return response()->json([
                    "status" => "OK",
                    "result" => $personalInfoResult,
                    "currency_result" => $resultPersonalInformation['cur_result_currency'],
                ]);


                /*return response()->json([
                    "status" => "OK",
                    "location_id" => $location_id,
                    "city" => $resultLocationAddressInformation['city'],
                    "address" => $resultLocationAddressInformation['address'],
                    "commercial_address" => $resultLocationAddressInformation['commercial_address']
                ]);*/
            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => null
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null
            ]);
        }
    }
}
