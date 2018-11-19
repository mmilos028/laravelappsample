<?php

namespace App\Http\Controllers\Rest\Xml;

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
        return response()->xml([
            "status" => "NOK",
            "error_message" => "Method not allowed"
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request){
        try {
            $xml_message = $request->getContent();

            $xml_object = simplexml_load_string($xml_message);
            if(!isset($xml_object->operation)){
                return response()->xml([
                    "status" => "NOK",
                    "error_message" => "Invalid request"
                ]);
            }

            switch(strtolower($xml_object->operation)){
                case 'login':
                    return response()->xml(
                        AuthService::loginSubject($xml_object)
                    );
                    break;
                case 'logout':
                    return response()->xml(
                        AuthService::logoutSubject($xml_object)
                    );
                    break;
                default:
                  return response()->xml([
                    "status" => "NOK",
                    "error_message" => "Invalid operation"
                  ]);
            }

        }catch(\RuntimeException $ex1){
            return response()->xml([
                "status" => "NOK",
                "error_message"=> $ex1->getMessage()
            ]);
        }catch(\Exception $ex4){
            return response()->xml([
                "status" => "NOK",
                "error_message"=> $ex4->getMessage()
            ]);
        }
    }
}
