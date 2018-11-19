<?php

namespace App\Http\Controllers\Authenticated;

use App\Models\Postgres\SessionModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class SessionValidationController extends Controller
{
    public function __construct()
    {

    }

    public function pingSession(Request $request){
        if(Session::has('auth')){
            $response = array(
                "status" => "OK",
                "valid_session" => true,
            );
            return response()->json($response);
        }else{
            $response = array(
                "status" => "OK",
                "valid_session" => false
            );
            return response()->json($response);
        }
    }

    public function getSessionRemainingTime(Request $request){
        try{
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $model_session = new SessionModel();
            $result = $model_session->getSessionRemainingTime($backoffice_session_id);

            if($result["status"] == "OK"){
                return [
                    "status" => $result["status"],
                    "time" => $result["time"]
                ];
            }else{
                return [
                    "status" => $result["status"],
                    "message" => "Fail"
                ];
            }
        }catch (\Exception $ex){
            return [
                "status" => "NOK",
                "message" => "Fail"
            ];
        }
    }

    public function validateSession(Request $request){
        try{
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $result = SessionModel::validateSession($backoffice_session_id);

            if($result["status"] == "OK"){
                return [
                    "status" => $result["status"],
                ];
            }else{
                return [
                    "status" => $result["status"],
                    "message" => trans("authenticated.Unable to extend session.")
                ];
            }
        }catch (\Exception $ex){
            return [
                "status" => "NOK",
                "message" => trans("authenticated.Unable to extend session.")
            ];
        }
    }

}
