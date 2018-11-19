<?php

namespace App\Http\Controllers\Authenticated\Administration\Parameter_Setup;

use App\Models\Postgres\CurrencyModel;
use App\Models\Postgres\DrawModelSetupModel;
use App\Models\Postgres\StructureEntityModel;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\LaravelLocalization;

use App\Http\Controllers\Controller;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\ParameterModel;
use App\Helpers\ArrayHelper;
use App\Helpers\NumberHelper;

class EntityParameterSetupController extends Controller
{
    public function __construct()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            $this->layout = View::make('layouts.mobile_layout');
        }
        if ($agent->isTablet()) {
            $this->layout = View::make('layouts.desktop_layout');
        } else {
            $this->layout = View::make('layouts.desktop_layout');
        }
    }

    /**
     * @param Request $request
     * @return View
     */
    public function listEntities(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $parent_user_id = $authSessionData['parent_id'];

        //$resultListUsers = CustomerModel::listCustomers($backoffice_session_id);
        //$list_entities = $resultListUsers['list_customers'];
        /*$resultListUsers = StructureEntityModel::searchEntity($backoffice_session_id,  null, null,
        null, null, null,null, null, null, null, null, $parent_user_id);
        $list_entities = $resultListUsers['list_users'];*/
        //dd($resultListUsers);

        return view(
            '/authenticated/administration/parameter-setup/entity/list-entities',
            [
                //"list_entities" => $list_entities,
            ]
        );
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return View
     */
    public function entityParameterSetup($user_id, Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultUserInformation = UserModel::userInformation($user_id);
        $resultListSystemParameters = ParameterModel::listParameters();

        if($authSessionData['username'] != "ROOT MASTER" && in_array($resultUserInformation['user']['subject_type'], array( config("constants.CLIENT_TYPE_NAME"), config("constants.OPERATER_TYPE_NAME") ))){
            //$resultListUserParameters = ParameterModel::listUserParametersForClientAndOperater($user_id);
            $resultListUserParameters = ParameterModel::listUserParameters($user_id);
        }else {
            $resultListUserParameters = ParameterModel::listUserParameters($user_id);
        }

        //dd($resultListUserParameters);

        //$resultListCurrency = CurrencyModel::listCurrencies($backoffice_session_id);
        $currencyObj = new \stdClass();
        $currencyObj->currency = $resultUserInformation['user']['currency'];
        $resultListCurrency["list_currency"][] = $currencyObj;

        $drawModelDetails = DrawModelSetupModel::getDrawModelDetailsForAff($user_id);

        //dd($resultListCurrency);
        //dd($resultUserInformation);
        //dd($authSessionData);

        $enable_add_new_parameter = false;
        //if($resultUserInformation['user']['parent_id'] == "1" || $authSessionData['username'] == "ROOT MASTER"){
        //if($authSessionData['parent_id'] == "1" || $authSessionData['username'] == "ROOT MASTER"){
        if($user_id == "1"){
            $enable_add_new_parameter = true;
        }

        $enable_delete_parameter = false;
        if($user_id == "1" || in_array($authSessionData['subject_type_id'], array(config("constants.MASTER_SYSTEM_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID")))){
            $enable_delete_parameter = true;
        }

        if($request->isMethod("POST")) {
            //validation rules
            $rules = [
                'parameter' => 'required',
                'parameter_value' => 'required|min:1|max:200',
            ];

            $messages = [

            ];

            $attributes = [
                'parameter' => __("authenticated.Parameter"),
                'parameter_value' => __("authenticated.Parameter Value"),
            ];

            $validator =  Validator::make($request->all(), $rules, $messages, $attributes);
            $messages = $validator->errors();

            if($validator->fails()){
                return view(
                    '/authenticated/administration/parameter-setup/entity/entity-parameter-setup',
                    [
                        "user_id" => $user_id,
                        "current_user" => $resultUserInformation['user'],
                        "list_system_parameters" => $resultListSystemParameters['list_parameters'],
                        "list_entity_parameters" => $resultListUserParameters['list_parameters'],
                        "list_currency" => $resultListCurrency['list_currency'],
                        "enable_add_new_parameter" => $enable_add_new_parameter,
                        "enable_delete_parameter" => $enable_delete_parameter,
                        "draw_model_details" => $drawModelDetails["result"]
                    ]
                )->with("messages", $messages);
            }

            if($request->has('save')) {

                $details = [
                    'user_id' => $user_id,
                    'parameter_id' => $request->get('parameter'),
                    'currency' => $request->get('currency'),
                    'parameter_value' => $request->get('parameter_value')
                ];

                $resultAddUserParameter = ParameterModel::addNewUserParameter($details);

                if ($resultAddUserParameter['status'] == "OK") {
                    if($authSessionData['username'] != "ROOT MASTER" && in_array($resultUserInformation['user']['subject_type'], array( config("constants.CLIENT_TYPE_NAME"), config("constants.OPERATER_TYPE_NAME") ))){
                        $resultListUserParameters = ParameterModel::listUserParametersForClientAndOperater($user_id);
                    }else {
                        $resultListUserParameters = ParameterModel::listUserParameters($user_id);
                    }
                    return view(
                        '/authenticated/administration/parameter-setup/entity/entity-parameter-setup',
                        [
                            "user_id" => $user_id,
                            "current_user" => $resultUserInformation['user'],
                            "list_system_parameters" => $resultListSystemParameters['list_parameters'],
                            "list_entity_parameters" => $resultListUserParameters['list_parameters'],
                            "list_currency" => $resultListCurrency['list_currency'],
                            "enable_add_new_parameter" => $enable_add_new_parameter,
                            "enable_delete_parameter" => $enable_delete_parameter,
                            "draw_model_details" => $drawModelDetails["result"]
                        ]
                    )->with("success_message", __("authenticated.Changes saved"));
                } else {
                    if($authSessionData['username'] != "ROOT MASTER" && in_array($resultUserInformation['user']['subject_type'], array( config("constants.CLIENT_TYPE_NAME"), config("constants.OPERATER_TYPE_NAME") ))){
                        $resultListUserParameters = ParameterModel::listUserParametersForClientAndOperater($user_id);
                    }else {
                        $resultListUserParameters = ParameterModel::listUserParameters($user_id);
                    }
                    return view(
                        '/authenticated/administration/parameter-setup/entity/entity-parameter-setup',
                        [
                            "user_id" => $user_id,
                            "current_user" => $resultUserInformation['user'],
                            "list_system_parameters" => $resultListSystemParameters['list_parameters'],
                            "list_entity_parameters" => $resultListUserParameters['list_parameters'],
                            "list_currency" => $resultListCurrency['list_currency'],
                            "enable_add_new_parameter" => $enable_add_new_parameter,
                            "enable_delete_parameter" => $enable_delete_parameter,
                            "draw_model_details" => $drawModelDetails["result"]
                        ]
                    )->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        //dd($resultListUserParameters['list_parameters']);

        return view(
            '/authenticated/administration/parameter-setup/entity/entity-parameter-setup',
            [
                "user_id" => $user_id,
                "current_user" => $resultUserInformation['user'],
                "list_system_parameters" => $resultListSystemParameters['list_parameters'],
                "list_entity_parameters" => $resultListUserParameters['list_parameters'],
                "list_currency" => $resultListCurrency['list_currency'],
                "enable_add_new_parameter" => $enable_add_new_parameter,
                "enable_delete_parameter" => $enable_delete_parameter,
                "draw_model_details" => $drawModelDetails["result"]
            ]
        );
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return View
     */
    public function manageEntityParameterSetup($user_id, Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        //list currencies parameter_id -> currency
        $currency_parameters = $request->input('currency');
        //list parameter values parameter_id -> parameter_value
        $parameter_values = $request->input('parameter_value');
        //list parameters parameter_id -> user_parameter_value_id
        $selected_user_parameters = $request->input('selected_entity_parameters');
        $user_parameters_for_update = $request->input('entity_parameters_for_update');
        $user_parameter_values = $request->input('entity_parameter_value');

        //dd($selected_user_parameters);

        if($request->isMethod("POST")){
            if($request->has('SAVE_SELECTED_PARAMETERS')){
               // dd($parameter_values);

                $details = array();
                if(count($selected_user_parameters) <= 0){
                    return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                        ->with("warning_message", __("authenticated.Select parameters on checkbox to save"));
                }
                foreach($selected_user_parameters as $key=>$parameter){

                    $parameter_values[$parameter] = trim($parameter_values[$parameter]);
                    $temp1 = str_replace(',','', $parameter_values[$parameter]);
                    if(is_numeric($temp1)){
                        $parameter_values[$parameter] = $temp1;
                    }
                    if(is_numeric($parameter_values[$parameter])){
                        $parameter_values[$parameter] += 0;
                        //$parameter_values[$parameter] = doubleval($parameter_values[$parameter]);
                        if(is_int($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_long($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_integer($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_float($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_double($parameter_values[$parameter]);
                        }
                        else if(is_double($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_double($parameter_values[$parameter]);
                        }else{
                            $param_value_unformatted = $parameter_values[$parameter];
                        }
                    }else{
                        $param_value_unformatted = $parameter_values[$parameter];
                    }
                    $details[] = array(
                        "user_parameter_value_id"=>$user_parameter_values[$parameter],
                        "user_id"=>$user_id,
                        "parameter_id"=>$parameter,
                        "parameter_value"=>$param_value_unformatted,
                        "currency"=>$currency_parameters[$parameter],
                    );
                }
                //dd($details);
                $updateUserParameterResult = ParameterModel::updateUserParameter($details);
                if($updateUserParameterResult['status'] == "OK") {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                        ->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                        ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
            if($request->has('SAVE_ALL_PARAMETERS')){
                $details = array();
                foreach($user_parameters_for_update as $parameter){
                    $parameter_values[$parameter] = trim($parameter_values[$parameter]);
                    $temp1 = str_replace(',','', $parameter_values[$parameter]);
                    if(is_numeric($temp1)){
                        $parameter_values[$parameter] = $temp1;
                    }
                    if(is_numeric($parameter_values[$parameter])){
                        $parameter_values[$parameter] += 0;
                        //$parameter_values[$parameter] = doubleval($parameter_values[$parameter]);
                        if(is_int($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_long($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_integer($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_float($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_double($parameter_values[$parameter]);
                        }
                        else if(is_double($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_double($parameter_values[$parameter]);
                        }else{
                            $param_value_unformatted = $parameter_values[$parameter];
                        }
                    }else{
                        $param_value_unformatted = $parameter_values[$parameter];
                    }
                    $details[] = array(
                        "user_parameter_value_id"=>$user_parameter_values[$parameter],
                        "user_id"=>$user_id,
                        "parameter_id"=>$parameter,
                        "parameter_value"=>$param_value_unformatted,
                        "currency"=>$currency_parameters[$parameter],
                    );
                }
                //dd($details);
                $updateUserParameterResult = ParameterModel::updateUserParameter($details);
                if($updateUserParameterResult['status'] == "OK") {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                        ->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                        ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
            if($request->has('DELETE_PARAMETERS')){
                if(count($selected_user_parameters) == 0){
                    return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                        ->with("warning_message", __("authenticated.Select parameters on checkbox to delete"));
                }else{

                    $details = array();
                    foreach($selected_user_parameters as $parameter){
                        if(is_numeric($parameter_values[$parameter])){
                        $parameter_values[$parameter] += 0;
                        if(is_int($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_long($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_integer($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_integer($parameter_values[$parameter]);
                        }
                        else if(is_float($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::convert_double($parameter_values[$parameter]);
                        }
                        else if(is_double($parameter_values[$parameter])){
                            $param_value_unformatted = NumberHelper::format_double($parameter_values[$parameter]);
                        }else{
                            $param_value_unformatted = $parameter_values[$parameter];
                        }
                    }else{
                        $param_value_unformatted = $parameter_values[$parameter];
                    }
                        $details[] = array(
                            "user_parameter_value_id"=>$user_parameter_values[$parameter],
                            "user_id"=>$user_id,
                            "parameter_id"=>$parameter,
                            "parameter_value"=>$param_value_unformatted,
                            "parameter_name"=>$param_value_unformatted,
                            "currency"=>$currency_parameters[$parameter],
                        );
                    }
                    $deleteUserParameterResult = ParameterModel::deleteUserParameter($details);
                    if($deleteUserParameterResult['status'] == "OK") {
                        $deleted = $deleteUserParameterResult['deleted'];
                        $notDeleted = $deleteUserParameterResult['notDeleted'];
                        if($deleted > 0 && $notDeleted == 0){
                            return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                                ->with("success_message", __("authenticated.Changes saved"));
                        }elseif($deleted > 0 && $notDeleted > 0){
                            return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                                ->with("error_message", __("authenticated.Some of the parameters are not deleted"));
                        }elseif($deleted == 0 && $notDeleted > 0){
                            return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                                ->with("error_message", __("authenticated.None of the parameters are deleted"));
                        }elseif($deleted == 0 && $notDeleted == 0){
                            return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                                ->with("error_message", __("authenticated.None of the parameters are deleted"));
                        }
                    }else{
                        return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                            ->with("error_message", __("authenticated.Changes not saved"));
                    }
                }
            }
            return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                ->with("error_message", __("authenticated.Changes not saved"));
        }else{
            return \Redirect::to('/' . app()->getLocale() . "/administration/entity-parameter-setup/parameter-setup/user_id/{$user_id}")
                ->with("error_message", __("authenticated.Changes not saved"));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStructureEntityTreeForParameterSetup(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $parent_id = $authSessionData['parent_id'];
            $user_id = $authSessionData['user_id'];
            $arr3 = array();
            /*if(in_array($authSessionData['subject_type_id'], array(config("constants.ADMINISTRATOR_OPERATER_ID")))){
                $tree_type = 1;
                $result = UserModel::getSubjectTree($parent_id, $tree_type);
            }else {
                $result = StructureEntityModel::getStructureEntityTreeForEntityParameterSetup($parent_id);
            }*/
            $tree_type = 1;
            $result = UserModel::getSubjectTreeForParameterSetup($parent_id, $tree_type);

            $i3 = 0;
            $laravelLocalized = new LaravelLocalization();
            foreach($result['result'] as $data){
                $subject_type = $data->child_dtype;

                $properties = $this->determineTreeGridProperties($subject_type);

                $color = $properties["color"];
                $url = $properties["url"];
                $url_disabled = $properties["url_disabled"];

                $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$data->child_id);

                if($data->child_id == $parent_id){
                   $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = '<span style="font-weight: bold;">' .$data->child_name. '</span>';
                    $arr3[$i3]['parentId'] = 0;
                    $arr3[$i3]['parent_name'] = 0;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type_id'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['draw_model'] = $data->draw_model;

                    if($data->draw_under_regulation == CONTROL){
                        $arr3[$i3]['control_free'] = "<label class='label label-danger'>Control</label>";
                    }elseif ($data->draw_under_regulation == FREE){
                        $arr3[$i3]['control_free'] = "<label class='label label-success'>Free</label>";
                    }

                    $arr3[$i3]['credits'] = NumberHelper::convert_double($data->credits);
                    $arr3[$i3]['credits_formatted'] = NumberHelper::convert_double($data->credits);
                    $arr3[$i3]['currency'] = $data->currency;
                    $arr3[$i3]['subject_type_name_colourful'] = '<span style="color:'.$color.';">' .$data->child_dtype_bo_name. '</span>';
                        //if($authSessionData['username'] == $data->child_name){
                        if(in_array($authSessionData['subject_type_id'], array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"), config('constants.ADMINISTRATOR_OPERATER_ID'), config('constants.ADMINISTRATOR_CLIENT_ID')))){
                            $arr3[$i3]['action_column'] = '<a class="btn btn-primary" href="'.$url.'">'
                            . '<i class=\'fa fa-wrench\'></i> </a>';
                        }else{
                            $arr3[$i3]['action_column'] = "";
                        }
                }else{
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = '<span style="font-weight: bold;">' .$data->child_name. '</span>';
                    $arr3[$i3]['parentId'] = $data->parent_id;
                    $arr3[$i3]['parent_name'] = $data->parent_name;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type_id'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['draw_model'] = $data->draw_model;

                    if($data->draw_under_regulation == CONTROL){
                        $arr3[$i3]['control_free'] = "<label class='label label-danger'>Control</label>";
                    }elseif ($data->draw_under_regulation == FREE){
                        $arr3[$i3]['control_free'] = "<label class='label label-success'>Free</label>";
                    }

                    $arr3[$i3]['credits'] = NumberHelper::convert_double($data->credits);
                    $arr3[$i3]['credits_formatted'] = NumberHelper::convert_double($data->credits);
                    $arr3[$i3]['currency'] = $data->currency;
                    $arr3[$i3]['subject_type_name_colourful'] = '<span style="color:'.$color.';">' .$data->child_dtype_bo_name. '</span>';
                        $arr3[$i3]['action_column'] = '<a class="btn btn-primary" href="'.$url.'">'
                            . '<i class=\'fa fa-wrench\'></i> </a>';
                }
                $i3++;
            }

            $count = 0;
            foreach($arr3 as $r){
                $count++;
            }
            if($count > 1){
                $tree = $this->buildTree($arr3, 'parentId', 'id');
                $response = $tree;
                return response()->json(
                    [$response]
                );
            }elseif($count <= 1){
                return response()->json([
                    'result' => $arr3,
                    'status' => 1,
                    'count' => $count
                ]);
            }

        }catch(\PDOException $ex1){
            return response()->json([
            ]);
        }catch(\Exception $ex2){
            return response()->json([

            ]);
        }
    }

    function buildTree($flat, $pidKey, $idKey = null){
        $grouped = array();
        foreach ($flat as $sub){
            $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling[$idKey];
                if(isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }

            return $siblings;
        };
        $tree = $fnBuilder($grouped[0]);

        return $tree;
    }

    function determineTreeGridProperties($subject_type){
        $color = "";
        $url = "";
        $url_disabled = true;
        if($subject_type == config('constants.ROLE_CLIENT')){
            $url = "/administration/entity-parameter-setup/parameter-setup/user_id/";
            $url_disabled = false;
            $color = "#FF00FF";
        }elseif ($subject_type == config('constants.ROLE_ADMINISTRATOR') || $subject_type == config('constants.ADMINISTRATOR_SYSTEM') || $subject_type == config('constants.ADMINISTRATOR_CLIENT') || $subject_type == config('constants.ADMINISTRATOR_LOCATION') || $subject_type == config('constants.ADMINISTRATOR_OPERATER')){
            $url = "";
            $url_disabled = true;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_LOCATION')){
            $url = "/administration/entity-parameter-setup/parameter-setup/user_id/";
            $url_disabled = false;
            $color = "#0000FF";
        }elseif ($subject_type == config('constants.ROLE_OPERATER')){
            $url = "/administration/entity-parameter-setup/parameter-setup/user_id/";
            $url_disabled = false;
            $color = "#A349A4";
        }elseif ($subject_type == config('constants.ROLE_CASHIER_TERMINAL') || $subject_type == config('constants.TERMINAL_TV') || $subject_type == config('constants.TERMINAL_SALES')){
            if($subject_type == config('constants.ROLE_CASHIER_TERMINAL'))
                $url = "";
            else
                $url = "";

            $url_disabled = true;
            $color = "#8000FF";
        }elseif ($subject_type == config('constants.ROLE_PLAYER')){
            $url = "";
            $url_disabled = true;
            $color = "#7F7F7F";
        }elseif ($subject_type == config('constants.ROLE_CASHIER')){
            $url = "";
            $url_disabled = true;
            $color = "#000000";
        }elseif ($subject_type == config('constants.ROLE_COLLECTOR_LOCATION')){
            $url = "";
            $url_disabled = true;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_COLLECTOR_OPERATER')){
            $url = "";
            $url_disabled = true;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_COLLECTOR_CLIENT')){
            $url = "";
            $url_disabled = true;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_SUPPORT_CLIENT')){
            $url = "";
            $url_disabled = true;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_SUPPORT_SYSTEM')){
            $url = "";
            $url_disabled = true;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_SUPPORT_OPERATER')){
            $url = "";
            $url_disabled = true;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.MASTER_TYPE_NAME')){
            $url = "/administration/entity-parameter-setup/parameter-setup/user_id/";
            $url_disabled = false;
        }

        $result = array();

        $result["color"] = $color;
        $result["url"] = $url;
        $result["url_disabled"] = $url_disabled;

        return $result;
    }

}
