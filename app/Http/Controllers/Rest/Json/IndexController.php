<?php

namespace App\Http\Controllers\Rest\Json;

use App\Services\AuthService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function methodNotAllowed(Request $request)
    {
        return response()->json([
            "status" => "NOK",
            "error_message" => "Method not allowed"
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){

        try {
            $json_message = $request->getContent();

            $json_object = json_decode($json_message);
            if(!isset($json_object->operation)){
                return response()->json([
                    "status" => "NOK",
                    "error_message" => "Invalid request",
                    "request"=> $json_message
                ]);
            }

            switch(strtolower($json_object->operation)){
                case 'login':
                    return
                        response()->json(
                            AuthService::loginSubject($json_object)
                        );
                    break;
                case 'logout':
                    return
                        response()->json(
                            AuthService::logoutSubject($json_object)
                        );
                    break;
                default:
                  return response()->json([
                    "status" => "NOK",
                    "error_message" => "Invalid operation"
                  ]);
            }

        }catch(\RuntimeException $ex1){
            return response()->json([
                "status" => "NOK",
                "error_message"=> $ex1->getMessage()
            ]);
        }catch(\Exception $ex2){
            return response()->json([
                "status" => "NOK",
                "error_message"=> $ex2->getMessage()
            ]);
        }
    }

}
