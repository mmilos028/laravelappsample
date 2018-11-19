<?php

namespace App\Http\Controllers\Authenticated\Administration\DrawModel_Setup;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Postgres\CustomerModel;
use App\Models\Postgres\DrawModelSetupModel;
use App\Models\Postgres\CurrencyModel;
use Validator;
use App\Helpers\ErrorHelper;
use App\Http\Controllers\Authenticated\StructureEntityController;

class DrawModelSetupController extends Controller
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

    function returnDrawModelAffiliates(){
        return view('/authenticated/administration/draw-model-setup/list-draw-model-affiliates');
    }

    public function listDrawModels(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListDrawModels = DrawModelSetupModel::listDrawModels($backoffice_session_id);
        //dd($resultListDrawModels);

        return view(
            '/authenticated/administration/draw-model-setup/list-draw-models',
            array(
                "list_draw_models" => $resultListDrawModels['list_draw_models'],
            )
        );
    }
    public function listDrawModelsForCurrencyAjax(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $currency = $request->input("currency");
            $active = $request->input("active");

            $resultListDrawModels = DrawModelSetupModel::listAllDrawModelsForCurrency($backoffice_session_id, $currency);
            $resultListDrawModelsResult = $resultListDrawModels["list_draw_models"];
            $array = array();

            $i = 0;
            foreach ($resultListDrawModelsResult as $r){
                $array[$i]["draw_model_id"] = $r->draw_model_id;
                $array[$i]["draw_model"] = $r->draw_model;
                $array[$i]["rec_sts"] = $r->rec_sts;

                if($r->rec_sts == 1){
                    $array[$i]["draw_model_activity"] = trans("authenticated.Active");
                }else{
                    $array[$i]["draw_model_activity"] = trans("authenticated.Inactive");
                }

                $array[$i]["rec_tmstp"] = $r->rec_tmstp;
                $array[$i]["currency"] = $r->currency;
                $array[$i]["draw_active_from_hour_minutes"] = $r->draw_active_from_hour_minutes;
                $array[$i]["draw_active_to_hour_minutes"] = $r->draw_active_to_hour_minutes;
                $array[$i]["draw_under_regulation"] = $r->draw_under_regulation;
                $array[$i]["rec_edit_user"] = $r->rec_edit_user;
                $array[$i]["draw_sequence_in_minutes"] = $r->draw_sequence_in_minutes;
                $array[$i]["bet_win"] = $r->payback_percent;
                $i++;
            }

            if(!$active){
                $structure_entity_controller = new StructureEntityController();
                $array = $structure_entity_controller->removeElementWithValue($array, "rec_sts", -1);
            }

            return response()->json([
                "status" => "OK",
                "result" => $array,
                "count" => $i
            ]);
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
    public function listDrawModelsAjax(){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $resultListDrawModels = DrawModelSetupModel::listDrawModels($backoffice_session_id);
            $resultListDrawModelsResult = $resultListDrawModels["list_draw_models"];
            $array = array();

            $i = 0;
            foreach ($resultListDrawModelsResult as $r){
                $array[$i]["draw_model_id"] = $r->draw_model_id;
                $array[$i]["draw_model"] = $r->draw_model;
                $array[$i]["rec_sts"] = $r->rec_sts;
                $array[$i]["rec_tmstp"] = $r->rec_tmstp;
                $array[$i]["currency"] = $r->currency;
                $array[$i]["draw_active_from_hour_minutes"] = $r->draw_active_from_hour_minutes;
                $array[$i]["draw_active_to_hour_minutes"] = $r->draw_active_to_hour_minutes;
                $array[$i]["draw_under_regulation"] = $r->draw_under_regulation;
                $array[$i]["rec_edit_user"] = $r->rec_edit_user;
                $array[$i]["draw_sequence_in_minutes"] = $r->draw_sequence_in_minutes;
                $array[$i]["bet_win"] = $r->payback_percent;
                $i++;
            }
            $i = 0;

            $structure_entity_controller = new StructureEntityController();
            $array = $structure_entity_controller->removeElementWithValue($array, "rec_sts", -1);

            return response()->json([
                "status" => "OK",
                "result" => $array,
            ]);
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

    public function createDrawModel(Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $auth_user_id = $authSessionData['user_id'];

        $resultListFeedsModel = DrawModelSetupModel::listFeeds($backoffice_session_id);
        $currencies = CurrencyModel::listCurrencies($backoffice_session_id);

        $super_draw = $request->get('super_draw');

        if($super_draw == 1){
            $rules = [
                'draw_model_name' => 'required|min:3|max:50',
                "super_draw" => "required",
                "super_draw_frequency" => "required|numeric|digits_between:1,4",
                "super_draw_coefficient" => "required",
                'active_period_from_h' => "draw_model_time_validation:active_period_from_min,active_period_to_h,active_period_to_min"
            ];
        }else{
            $rules = [
                'draw_model_name' => 'required|min:3|max:50',
                "super_draw" => "required",
                "super_draw_frequency" => "nullable|numeric|digits_between:1,4",
                "super_draw_coefficient" => "nullable",
                'active_period_from_h' => "draw_model_time_validation:active_period_from_min,active_period_to_h,active_period_to_min"
            ];
        }

        $messages = [
            "super_draw_frequency.required" => trans("authenticated.The :attribute field is required."),
            "super_draw_frequency.numeric" => trans("authenticated.The :attribute field must be a number."),
            "super_draw_frequency.digits_between" => trans("authenticated.The :attribute field must be a number with maximum of 4 digits."),
            "active_period_from_h.draw_model_time_validation" => trans("authenticated.To Value can not be lesser or equal to From Value.")
        ];

        $attributes = [
            'draw_model_name' => __("authenticated.Draw Model Name"),
            'super_draw_frequency' => __("authenticated.Super Draw Frequency")
        ];

        if($request->isMethod("POST")) {
            $this->validate($request, $rules, $messages, $attributes);

            if ($request->has('cancel')) {
                return \Redirect::to('/' . app()->getLocale() . '/administration/create-draw-model');
            }

            $draw_model_active_from_h = $request->get('active_period_from_h');
            $active_period_from_min = $request->get('active_period_from_min');

            $draw_model_active_from_total = $draw_model_active_from_h*60 + $active_period_from_min;

            $active_period_to_h = $request->get('active_period_to_h');
            $active_period_to_min = $request->get('active_period_to_min');

            $draw_model_active_to_total = $active_period_to_h*60 + $active_period_to_min;

            //validation rules
            $this->validate($request, $rules, $messages, $attributes);

            //$validator = Validator::make($request->all(),$rules, $messages, $attributes);


            if ($request->has('save')) {
                $draw_model_name = $request->get('draw_model_name');
                $currency = $request->get('currency');
                $draw_model_status = $request->get('draw_model_status');
                $draw_model_active_from = $draw_model_active_from_h.":".$active_period_from_min;
                $draw_model_active_to= $active_period_to_h.":".$active_period_to_min;
                $draw_model_sequence = $request->get('sequence');
                $control_free = $request->get('control_free');
                $bet_win = $request->get('bet_win');

                $super_draw_coefficient = $request->get('super_draw_coefficient');
                $super_draw_frequency = $request->get('super_draw_frequency');

                if($control_free == FREE)
                    $bet_win = null;

                $draw_model_feed_id = $request->get('feed_id');

                $resultCreateDrawModel = DrawModelSetupModel::createNewDrawModel($backoffice_session_id, $auth_user_id, $draw_model_name, $currency,
                    $draw_model_status, $draw_model_sequence, $draw_model_active_from, $draw_model_active_to, $control_free, $bet_win, $super_draw,
                    $super_draw_coefficient, $super_draw_frequency);

                if($resultCreateDrawModel['status'] == 'OK' && $resultCreateDrawModel['code'] == 1) {
                    return \Redirect::to('/' . app()->getLocale() . '/administration/create-draw-model')
                        ->with("success_message", __("authenticated.Changes saved"));
                }else if($resultCreateDrawModel['status'] == 'OK' && $resultCreateDrawModel['code'] == -4) {
                    return \Redirect::to('/' . app()->getLocale() . '/administration/create-draw-model')
                        ->with("success_message", __("authenticated.Changes saved") . " " . __("authenticated.Time frame for draw model is expired, draws will be generated by midnight with the rest of draw models."));
                }else if($resultCreateDrawModel['status'] == 'OK' && $resultCreateDrawModel['code'] == -3) {
                    return \Redirect::to('/' . app()->getLocale() . '/administration/create-draw-model')
                        ->with("success_message", __("authenticated.Changes saved") . " " . __("Draws haven't been generated due to unexpected error but they will be generated by midnight with the rest of draw models."));
                }else if($resultCreateDrawModel['status'] == 'NOK' && $resultCreateDrawModel['code'] == -2) {
                    return view(
                        '/authenticated/administration/draw-model-setup/create-draw-model',
                        [
                            "list_feeds" => $resultListFeedsModel['list_feeds'],
                            "currencies" => $currencies['list_currency']
                        ]
                    )->with("error_message", __("authenticated.Model name already exists"));
                }else {
                    return view(
                        '/authenticated/administration/draw-model-setup/create-draw-model',
                        [
                            "list_feeds" => $resultListFeedsModel['list_feeds'],
                            "currencies" => $currencies['list_currency']
                        ]
                    )->with("error_message", __("authenticated.Changes not saved"));
                }
            }else{
                return view(
                    '/authenticated/administration/draw-model-setup/create-draw-model',
                    [
                        "list_feeds" => $resultListFeedsModel['list_feeds'],
                        "currencies" => $currencies['list_currency']
                    ]
                );
            }
        }else {
            return view(
                '/authenticated/administration/draw-model-setup/create-draw-model',
                [
                    "list_feeds" => $resultListFeedsModel['list_feeds'],
                    "currencies" => $currencies['list_currency']
                ]
            );
        }
    }

    public function deleteDrawModel($draw_model_id, Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $auth_user_id = $authSessionData['user_id'];

        $deleteDrawModelResult = DrawModelSetupModel::updateDrawModel($backoffice_session_id, $auth_user_id, $draw_model_id, '', -1 );

        if($deleteDrawModelResult['status'] == OK){
            return \Redirect::to('/' . app()->getLocale() . '/administration/list-draw-models')
                ->with("success_message", __("authenticated.Draw Model successfully deleted."));
        }else{
            return \Redirect::to('/' . app()->getLocale() . '/administration/list-draw-models')
                ->with("error_message", __("authenticated.Draw Model not deleted."));
        }

        return \Redirect::to('/' . app()->getLocale() . '/administration/list-draw-models');
    }

    public function addDrawModelToAffiliate(Request $request){
        $authSessionData = Session::get('auth');
        $session_id = $authSessionData['backoffice_session_id'];
        $logged_id = $authSessionData['user_id'];
        $parent_id = $authSessionData['parent_id'];

        $affiliate_id = $request->input("affiliate_id");
        $draw_model_id = $request->input("draw_model_id");

        $result = DrawModelSetupModel::addDrawModelToAffiliate($session_id, $affiliate_id, $draw_model_id);

        if($result["status"] == "OK"){
            return response()->json([
                "status" => $result['status'],
                "message" => trans("authenticated.Success.")
            ]);
        }else{
            return response()->json([
                "status" => $result['status'],
                "message" => $result['message']
            ]);
        }
    }

    public function listDrawModelAffiliates(Request $request){
        $authSessionData = Session::get('auth');
        $session_id = $authSessionData['backoffice_session_id'];
        $logged_id = $authSessionData['user_id'];
        $parent_id = $authSessionData['parent_id'];

        $result = DrawModelSetupModel::listDrawModelAffiliates($session_id, $logged_id, $parent_id);

        if($result["status"] == "OK"){
            $resultProcessed = array();
            $i=0;

            foreach ($result['result'] as $r){
                $resultProcessed[$i]["draw_model_id"] = $r->draw_model_id;
                $resultProcessed[$i]["draw_model_name"] = $r->draw_model;
                $resultProcessed[$i]["rec_sts"] = $r->rec_sts;

                if($r->rec_sts == 1){
                    $resultProcessed[$i]["draw_model_activity"] = "<br><br><label style='display: block !important;' class='label label-success'>".trans("authenticated.Active")."</label>";
                }else{
                    $resultProcessed[$i]["draw_model_activity"] = "<br><br><label style='display: block !important;' class='label label-danger'>".trans("authenticated.Inactive")."</label>";
                }

                $resultProcessed[$i]["subject_state"] = $r->subject_state;
                $resultProcessed[$i]["time"] = $r->rec_tmstp;
                $resultProcessed[$i]["currency"] = $r->currency;
                $resultProcessed[$i]["draw_active_from_hour_minutes"] = $r->draw_active_from_hour_minutes;
                $resultProcessed[$i]["draw_active_to_hour_minutes"] = $r->draw_active_to_hour_minutes;
                $resultProcessed[$i]["draw_under_regulation"] = $r->draw_under_regulation;
                $resultProcessed[$i]["edited_by_id"] = $r->rec_edit_user;
                $resultProcessed[$i]["draw_sequence_in_minutes"] = $r->draw_sequence_in_minutes;
                $resultProcessed[$i]["payback_percent"] = $r->payback_percent;
                $resultProcessed[$i]["super_draw"] = $r->super_draw;
                $resultProcessed[$i]["super_draw_coeficient"] = $r->super_draw_coeficient;
                $resultProcessed[$i]["super_draw_frequency"] = $r->super_draw_frequency;
                $resultProcessed[$i]["subject_id"] = $r->aff_id;
                $resultProcessed[$i]["subject_name"] = $r->subject_name_to;
                $resultProcessed[$i]["jp_model_id"] = $r->jp_model_id;
                $resultProcessed[$i]["subject_tree_id"] = $r->subjects_tree_id;
                $resultProcessed[$i]["subject_role_id"] = $r->subject_type_id_to;
                $resultProcessed[$i]["subject_role_name"] = $r->super_role_to;
                $resultProcessed[$i]["parent_id"] = $r->subject_id_for;
                $resultProcessed[$i]["parent_name"] = $r->parent_name;
                $resultProcessed[$i]["parent_role_id"] = $r->parent_dtype_id;
                $resultProcessed[$i]["parent_role_name"] = $r->parent_dtype_bo_name;
                $resultProcessed[$i]["subject_path"] = $r->subject_path;
                $resultProcessed[$i]["subject_level"] = $r->subject_level;
                $i++;
            }

            return response()->json([
                "status" => $result['status'],
                "result" => $resultProcessed
            ]);
        }else{
            return response()->json([
                "status" => $result['status'],
                "result" => $result['result']
            ]);
        }
    }

    public function updateDrawModel($draw_model_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $auth_user_id = $authSessionData['user_id'];

        $resultListFeedsModel = DrawModelSetupModel::listFeeds($backoffice_session_id);

        $drawModelDetails = DrawModelSetupModel::drawModelDetails($backoffice_session_id, $draw_model_id);

        $currencies = CurrencyModel::listCurrencies($backoffice_session_id);

        $active_from = $drawModelDetails['draw_model_details']->draw_active_from_hour_minutes;
        $active_to = $drawModelDetails['draw_model_details']->draw_active_to_hour_minutes;

        $active_from = explode(":", $active_from);
        $active_to = explode(":", $active_to);

        $super_draw = $request->get('super_draw');

        if($super_draw == 1){
            $rules = [
                'draw_model_name' => 'required|min:3|max:50',
                "super_draw" => "required",
                "super_draw_frequency" => "required|numeric|digits_between:1,4",
                "super_draw_coefficient" => "required",
                'active_period_from_h' => "draw_model_time_validation:active_period_from_min,active_period_to_h,active_period_to_min"
            ];
        }else{
            $rules = [
                'draw_model_name' => 'required|min:3|max:50',
                "super_draw" => "required",
                "super_draw_frequency" => "nullable|numeric|digits_between:1,4",
                "super_draw_coefficient" => "nullable",
                'active_period_from_h' => "draw_model_time_validation:active_period_from_min,active_period_to_h,active_period_to_min"
            ];
        }

        $messages = [
            "super_draw_frequency.required" => trans("authenticated.The :attribute field is required."),
            "super_draw_frequency.numeric" => trans("authenticated.The :attribute field must be a number."),
            "super_draw_frequency.digits_between" => trans("authenticated.The :attribute field must be a number with maximum of 4 digits."),
            "active_period_from_h.draw_model_time_validation" => trans("authenticated.To Value can not be lesser or equal to From Value.")
        ];

        $attributes = [
            'draw_model_name' => __("authenticated.Draw Model Name"),
            'super_draw_frequency' => __("authenticated.Super Draw Frequency")
        ];

        if($request->isMethod("POST")) {
            if ($request->has('cancel_update_draw_model')) {
                return \Redirect::to('/' . app()->getLocale() . '/administration/list-draw-models');
            }

            $draw_model_active_from_h = $request->get('active_period_from_h');
            $active_period_from_min = $request->get('active_period_from_min');

            $draw_model_active_from_total = $draw_model_active_from_h*60 + $active_period_from_min;

            $active_period_to_h = $request->get('active_period_to_h');
            $active_period_to_min = $request->get('active_period_to_min');

            $draw_model_active_to_total = $active_period_to_h*60 + $active_period_to_min;


            $draw_model_name = $request->get('draw_model_name');
            $draw_model_status = $request->get('draw_model_status');
            $draw_model_active_from = $draw_model_active_from_h.":".$active_period_from_min;
            $draw_model_active_to= $active_period_to_h.":".$active_period_to_min;
            $draw_model_sequence = $request->get('sequence');
            $control_free = $request->get('control_free');
            $bet_win = $request->get('bet_win');
            if($control_free == FREE)
                $bet_win = null;
            $draw_model_feed_id = $request->get('feed_id');

            $super_draw_coefficient = $request->get('super_draw_coefficient');
            $super_draw_frequency = $request->get('super_draw_frequency');

            if($request->has('delete_draw_model')) {
                $resultCreateDrawModel = DrawModelSetupModel::updateDrawModel($backoffice_session_id, $auth_user_id, $draw_model_id, $drawModelDetails['draw_model_details']->draw_model, -1,
                    $drawModelDetails['draw_model_details']->draw_sequence_in_minutes, $active_from, $active_to, $drawModelDetails['draw_model_details']->draw_under_regulation,
                    $drawModelDetails['draw_model_details']->payback_percent, $drawModelDetails['draw_model_details']->super_draw, $drawModelDetails['draw_model_details']->super_draw_coefficient,
                    $drawModelDetails['draw_model_details']->super_draw_frequency);

                if($resultCreateDrawModel['status'] == 'OK') {
                    return \Redirect::to('/' . app()->getLocale() . '/administration/list-draw-models')
                        ->with("success_message", __("authenticated.Draw Model successfully deactivated."));
                }else {
                    return \Redirect::to('/' . app()->getLocale() . '/administration/list-draw-models')
                        ->with("error_message", __("authenticated.Draw Model not successfully deactivated."));
                }
            }

            if ($request->has('save_update_draw_model')) {

                $this->validate($request, $rules, $messages, $attributes);

                $resultCreateDrawModel = DrawModelSetupModel::updateDrawModel($backoffice_session_id, $auth_user_id, $draw_model_id, $draw_model_name, $draw_model_status,
                    $drawModelDetails['draw_model_details']->draw_sequence_in_minutes, $draw_model_active_from, $draw_model_active_to, $control_free, $bet_win,
                    $super_draw, $super_draw_coefficient, $super_draw_frequency);

                if($resultCreateDrawModel['status'] == 'OK' && $resultCreateDrawModel['code'] == 1) {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/update-draw-model/draw_model_id/{$draw_model_id}")
                        ->with("success_message", __("authenticated.Changes saved"));
                }else if($resultCreateDrawModel['status'] == 'OK' && $resultCreateDrawModel['code'] == -4) {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/update-draw-model/draw_model_id/{$draw_model_id}")
                        ->with("success_message", __("authenticated.Changes saved") . " " . __("authenticated.Time frame for draw model is expired, draws will be generated by midnight with the rest of draw models."));
                }else if($resultCreateDrawModel['status'] == 'OK' && $resultCreateDrawModel['code'] == -3) {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/update-draw-model/draw_model_id/{$draw_model_id}")
                        ->with("success_message", __("authenticated.Changes saved") . " " . __("Draws haven't been generated due to unexpected error but they will be generated by midnight with the rest of draw models."));
                }else if($resultCreateDrawModel['status'] == 'NOK' && $resultCreateDrawModel['code'] == -2) {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/update-draw-model/draw_model_id/{$draw_model_id}")
                        ->with("error_message", __("authenticated.Model name already exists"));
                }else {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/update-draw-model/draw_model_id/{$draw_model_id}")
                        ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }else {
            //dd($drawModelDetails['draw_model_details']);
            $super_draw_frequency = $drawModelDetails['draw_model_details']->super_draw_frequency;
            return view(
                '/authenticated/administration/draw-model-setup/update-draw-model',
                [
                    'draw_model_id' => $draw_model_id,
                    'draw_model_name' => $drawModelDetails['draw_model_details']->draw_model,
                    'super_draw' => $drawModelDetails['draw_model_details']->super_draw,
                    'super_draw_coefficient' => $drawModelDetails['draw_model_details']->super_draw_coeficient,
                    'super_draw_frequency' => $super_draw_frequency,
                    'active_inactive' => $drawModelDetails['draw_model_details']->rec_sts,
                    'model_currency' => $drawModelDetails['draw_model_details']->currency,
                    'bet_win' => $drawModelDetails['draw_model_details']->payback_percent,
                    "active_from_h" => $active_from[0],
                    "active_from_min" => $active_from[1],
                    "active_to_h" => $active_to[0],
                    "active_to_min" => $active_to[1],
                    'control_free' => $drawModelDetails['draw_model_details']->draw_under_regulation,
                    'sequence' => $drawModelDetails['draw_model_details']->draw_sequence_in_minutes,
                    "list_feeds" => $resultListFeedsModel['list_feeds'],
                    "currencies" => $currencies['list_currency']
                ]
            );
        }
    }

    public function entitiesForDrawModel($draw_model_id, Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $auth_user_id = $authSessionData['user_id'];

        $drawModelDetails = DrawModelSetupModel::drawModelDetails($backoffice_session_id, $draw_model_id);

        $resultListAffiliates = CustomerModel::listCustomers($backoffice_session_id);

        //dd($resultListAffiliates);

        return view(
            '/authenticated/administration/draw-model-setup/entities-for-draw-model',
            [
                'draw_model_id' => $draw_model_id,
                'draw_model_name' => $drawModelDetails['draw_model_details']->draw_model,
                "list_enabled_users" => $resultListAffiliates['list_customers'],
                "list_disabled_users" => $resultListAffiliates['list_customers'],
            ]
        );
    }

    public function entityToDrawModel($draw_model_id, Request $request){

        if ($request->has('enableSubjectForDrawModelBtn')) {
            if(count($request->get('disabled_affiliates')) == 0){
                return redirect()->back()
                    ->with("warning_message", __("authenticated.Select Affiliates From Disabled List"));
            }else{


                return redirect()->back()
                    ->with("success_message", __("authenticated.Selected Affiliates Enabled"));
            }

        }

        if($request->has('disableSubjectForDrawModelBtn')){
            if(count($request->get('enabled_affiliates')) == 0){
                return redirect()->back()
                    ->with("warning_message", __("authenticated.Select Affiliates From Enabled List"));
            }else{


                return redirect()->back()
                    ->with("success_message", __("authenticated.Selected Affiliates Disabled"));
            }
        }

        return redirect()->back();
    }

}
