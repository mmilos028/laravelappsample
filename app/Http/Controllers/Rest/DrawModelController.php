<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\Postgres\DrawModelSetupModel;

class DrawModelController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function listDrawModels()
    {
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');

        try {
            $result = DrawModelSetupModel::listDrawModels($backoffice_session_id);
            if($result['status'] == "NOK"){
                return response()->json([
                    "status" => "NOK",
                    "backoffice_session_id" => $backoffice_session_id
                ]);
            }
            $response = array();
            foreach($result['list_draw_models'] as $model){
                $response[] = [
                    "draw_model_id" => $model->draw_model_id,
                    "draw_model_name" => $model->draw_model
                ];
            }
            return response()->json([
                "status" => "OK",
                "list_draw_models" => $response
            ]);
        }catch(\Exception $ex1){
            return response()->json([
                "status" => "NOK",
                "backoffice_session_id" => $backoffice_session_id
            ]);
        }
    }
}
