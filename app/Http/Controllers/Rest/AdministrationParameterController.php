<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\Postgres\ParameterModel;

class AdministrationParameterController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function listParameters(Request $request){
        $resultListParameters = ParameterModel::listParameters();

        return response()->json(
            $resultListParameters
        );
    }

    public function addNewParameter(Request $request){

        $parameter = \Request::json()->get('parameter');
        $backoffice_session_id = $parameter['backoffice_session_id'];

        $parameter_name = $parameter['parameter_name'];

        $details = array(
            'backoffice_session_id'=>$backoffice_session_id,
            'parameter_name'=>strtoupper($parameter_name)
        );

        $resultAddNewParameter = ParameterModel::addNewParameter($details);

        if($resultAddNewParameter['status'] == "OK"){
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
    }
}
