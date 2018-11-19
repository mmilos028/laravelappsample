<?php

namespace App\Http\Controllers\Authenticated\Administration\Jackpot_Setup;

use App\Helpers\NumberHelper;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postgres\JackPotModel;
use Validator;
use App\Helpers\ErrorHelper;

class JackPotController extends Controller
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
    public function returnJackPotSetupView(){
        return view("authenticated/administration/jackpot-setup.jackpot-setup");
    }
    public function returnJackPotUpdateView(){
        return view("authenticated/administration/jackpot-setup.jackpot-update");
    }

    public function updateJPModelDetailsForAff(Request $request){
        try {
            $authSessionData = Session::get('auth');

            $logged_in_id = $authSessionData['user_id'];
            $session_id = $authSessionData['backoffice_session_id'];

            $subject_id = $request->input("subject_id");
            $model_id = $request->input("model_id");
            $priority = $request->input("priority");
            $local_level_on_off = $request->input("local_level_on_off");
            $global_level_on_off = $request->input("global_level_on_off");
            $current_amount = $request->input("current_amount");
            $inherit_from = $request->input("inherited_from");

            if($local_level_on_off == -1 && $global_level_on_off == -1){
                return response()->json([
                    "status" => "NOK",
                    "true_status" => "NOK",
                    "message" => __ ("authenticate.At least one Jack-Pot must be active."),
                    "success" => true
                ]);
            }else{
                $result = JackPotModel::updateJPModelDetailsForAff($subject_id, $model_id, $priority, $local_level_on_off, $global_level_on_off, $current_amount, $inherit_from);

                if($result["status"] == 1){
                    return response()->json([
                        "status" => "OK",
                        "true_status" => $result["status"],
                        "success" => true,
                        "message" => __ ("authenticate.Success"),
                    ]);
                }else{
                    return response()->json([
                        "status" => "NOK",
                        "true_status" => $result["status"],
                        "success" => true,
                        "message" => __ ("authenticate.Fail"),
                    ]);
                }
            }

        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
                "message" => __("authenticated.Changes not saved"),
            ]);
        }
    }

    public function getAffJPModelSettings(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $subject_id = $request->input("subject_id");

            $result = JackPotModel::getAffJPModelSettings($subject_id);

            $resultResult = $result["result"];
            $resultStatus = $result["status"];

            $resultProcessed = array();

            if($resultStatus == "OK"){
                $i = 0;
                foreach ($resultResult as $r){
                    $resultProcessed[$i]["jp_model_id"] = $r->jp_model_id;
                    $resultProcessed[$i]["jp_model"] = $r->jp_model;
                    $resultProcessed[$i]["currency"] = $r->currency;
                    $resultProcessed[$i]["local_level_type"] = $r->local_level_type;
                    $resultProcessed[$i]["global_level_type"] = $r->global_level_type;
                    $resultProcessed[$i]["jp_time_active_from"] = $r->jp_time_active_from;
                    $resultProcessed[$i]["jp_time_active_to"] = $r->jp_time_active_to;
                    $resultProcessed[$i]["local_level_percent_from_bet"] = $r->local_level_percent_from_bet;
                    $resultProcessed[$i]["global_level_percent_from_bet"] = $r->global_level_percent_from_bet;
                    $resultProcessed[$i]["local_win_probability"] = $r->local_win_probability;
                    $resultProcessed[$i]["global_win_probability"] = $r->global_win_probability;
                    $resultProcessed[$i]["local_min_bet"] = $r->local_min_bet;
                    $resultProcessed[$i]["global_min_bet"] = $r->global_min_bet;
                    $resultProcessed[$i]["local_pot_start_value"] = $r->local_pot_start_value;
                    $resultProcessed[$i]["global_pot_start_value"] = $r->global_pot_start_value;
                    $resultProcessed[$i]["win_whole_pot"] = $r->win_whole_pot;
                    $resultProcessed[$i]["min_tickets_to_win"] = $r->min_tickets_to_win;
                    $resultProcessed[$i]["local_level_value"] = $r->local_level_value;
                    $resultProcessed[$i]["global_level_value"] = $r->global_level_value;
                    $resultProcessed[$i]["local_forced_win_before"] = $r->local_forced_win_before;
                    $resultProcessed[$i]["global_forced_win_before"] = $r->global_forced_win_before;
                    $resultProcessed[$i]["rec_create_user"] = $r->rec_create_user;
                    $resultProcessed[$i]["rec_create_tmstp"] = $r->rec_create_tmstp;
                    $resultProcessed[$i]["rec_edit_user"] = $r->rec_edit_user;
                    $resultProcessed[$i]["rec_edit_tmstp"] = $r->rec_edit_tmstp;
                    $resultProcessed[$i]["aff_id"] = $r->aff_id;
                    $resultProcessed[$i]["entity_name"] = $r->entity_name;
                    $resultProcessed[$i]["priority"] = $r->priority;
                    $resultProcessed[$i]["subject_dtype"] = $r->subject_dtype;
                    $resultProcessed[$i]["subject_dtype_bo_name"] = $r->subject_dtype_bo_name;
                    $resultProcessed[$i]["subject_path"] = $r->subject_path;
                    $resultProcessed[$i]["global_jp_inherited_from_id"] = $r->global_jp_inherited_from_id;
                    $resultProcessed[$i]["global_jp_inherited_from_name"] = $r->global_jp_inherited_from_name;
                    $resultProcessed[$i]["local_level_on_off"] = $r->local_level_on_off;
                    $resultProcessed[$i]["global_level_on_off"] = $r->global_level_on_off;
                    $resultProcessed[$i]["local_current_level"] = NumberHelper::format_double($r->local_current_level);
                    $resultProcessed[$i]["global_current_level"] = NumberHelper::format_double($r->global_current_level);

                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
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

    public function deleteJpModel(Request $request){
        try {
            $authSessionData = Session::get('auth');

            $logged_in_id = $authSessionData['user_id'];
            $session_id = $authSessionData['backoffice_session_id'];

            $model_id = $request->input("model_id");

            $result = JackPotModel::deleteJPModel($session_id, $logged_in_id, $model_id);

                if($result["status"] == 1){
                    return response()->json([
                        "status" => "OK",
                        "true_status" => $result["status"],
                        "success" => true
                    ]);
                }else{
                    return response()->json([
                        "status" => "NOK",
                        "true_status" => $result["status"],
                        "success" => true
                    ]);
                }

        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
                "message" => __("authenticated.Changes not saved"),
            ]);
        }
    }

    public function addJpModelForSubject(Request $request){
        try {
            $authSessionData = Session::get('auth');

            $logged_in_id = $authSessionData['user_id'];
            $session_id = $authSessionData['backoffice_session_id'];

            $subject_id = $request->input("subject_id");
            $model_id = $request->input("model_id");
            $inherited_from = $request->input("inherited_from");
            $priority = $request->input("priority");
            $local_level_on_off = $request->input("local_level_on_off");
            $global_level_on_off = $request->input("global_level_on_off");
            $payout_percent = $request->input("payout_percent");
            $subject_type_id = $request->input("subject_type_id");

            $rules = [
                'inherited_from' => 'required',
            ];
            $attributes = [
                'inherited_from' => __("authenticated.Inherit From"),
            ];
            $messages = [
                'inherited_from.required' => __("authenticated.:attribute is required."),
            ];

            $validator = Validator::make($request->all(),$rules, $messages, $attributes);

            if($subject_type_id == config("constants.LOCATION_TYPE_ID")){
                if($local_level_on_off == -1 && $global_level_on_off == -1){
                    return response()->json([
                        "status" => "NOK",
                        "true_status" => "NOK",
                        "message" => __ ("authenticate.At least one Jack-Pot must be active."),
                        "success" => true
                    ]);
                }else{
                    if($global_level_on_off == -1){
                        $inherited_from = null;
                    }

                    $result = JackPotModel::addJPModelForSubject($session_id, $logged_in_id, $subject_id, $model_id, $inherited_from, $priority, $local_level_on_off,
                        $global_level_on_off, $payout_percent);

                    if($result["status"] == 1){
                        return response()->json([
                            "status" => "OK",
                            "true_status" => $result["status"],
                            "success" => true,
                            "message" => __ ("authenticate.Success"),
                        ]);
                    }else{
                        return response()->json([
                            "status" => "NOK",
                            "true_status" => $result["status"],
                            "success" => true,
                            "message" => __ ("authenticate.Fail"),
                        ]);
                    }
                }
            }else{
                $inherited_from = $subject_id;
                $priority = 1;

                $result = JackPotModel::addJPModelForSubject($session_id, $logged_in_id, $subject_id, $model_id, $inherited_from, $priority, $local_level_on_off,
                    $global_level_on_off, $payout_percent);

                if($result["status"] == 1){
                    return response()->json([
                        "status" => "OK",
                        "true_status" => $result["status"],
                        "success" => true,
                        "message" => __ ("authenticate.Success"),
                    ]);
                }else{
                    return response()->json([
                        "status" => "NOK",
                        "true_status" => $result["status"],
                        "success" => true,
                        "message" => __ ("authenticate.Fail"),
                    ]);
                }
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
                "message" => __("authenticated.Changes not saved"),
            ]);
        }
    }

    public function deleteJpModelForSubject(Request $request){
        try {
            $authSessionData = Session::get('auth');

            $logged_in_id = $authSessionData['user_id'];
            $session_id = $authSessionData['backoffice_session_id'];

            $subject_id = $request->input("subject_id");

            $result = JackPotModel::deleteJPModelForSubject($session_id, $logged_in_id, $subject_id);

            if($result["status"] == 1){
                return response()->json([
                    "status" => "OK",
                    "true_status" => $result["status"],
                    "success" => true
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "true_status" => $result["status"],
                    "success" => true
                ]);
            }

        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
                "message" => __("authenticated.Changes not saved"),
            ]);
        }
    }

    public function updateJPSpecification(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $session_id = $authSessionData['backoffice_session_id'];

            $model_id = $request->input("model_id");
            $model_name = $request->input("model_name");
            $currency = $request->input("currency");
            $minNoTickets = $request->input("minNoTickets");
            $fromHours = $request->input("fromHours");
            $toHours = $request->input("toHours");
            $winPriceLocal = $request->input("winPriceLocal");
            $winPriceGlobal = $request->input("winPriceGlobal");
            $winProbabilityLocal = $request->input("winProbabilityLocal");
            $winProbabilityGlobal = $request->input("winProbabilityGlobal");
            $winBeforeLocal = $request->input("winBeforeLocal");
            $winBeforeGlobal = $request->input("winBeforeGlobal");
            $minBetLocal = $request->input("minBetLocal");
            $minBetGlobal = $request->input("minBetGlobal");
            $wholePot = $request->input("wholePot");
            $fromBetToJpLocal = $request->input("fromBetToJpLocal");
            $fromBetToJpGlobal = $request->input("fromBetToJpGlobal");
            $startValueLocal = $request->input("startValueLocal");
            $startValueGlobal = $request->input("startValueGlobal");
            $global_on_off = $request->input("global_on_off");
            $local_on_off = $request->input("local_on_off");

            if ($global_on_off == -1 && $local_on_off == -1){
                return response()->json(['errors'=>array(trans("authenticated.At least one Jack-Pot must be active.")), "success" => false, "status" => "NOK"]);
            }else{
                $rules = [
                    'model_name' => 'required|max:40',
                    'currency' => 'required',
                    'global_on_off' => 'required',
                    'local_on_off' => 'required',
                    'minNoTickets' => 'nullable|positive_integer_number',
                    'fromHours' => 'nullable|positive_integer_number|numeric|min:0|max:24|lesser_than_field:toHours',
                    'toHours' => 'nullable|positive_integer_number|numeric|min:0|max:24|greater_than_field:fromHours',
                    'winPriceLocal' => 'required|numeric|min:0',
                    'winPriceGlobal' => 'required|numeric|min:0',
                    'winProbabilityLocal' => 'required|positive_integer_number|min:1',
                    'winProbabilityGlobal' => 'required|positive_integer_number|min:1',
                    'winBeforeLocal' => 'nullable|numeric|min:0',
                    'winBeforeGlobal' => 'nullable|numeric|min:0',
                    "minBetLocal" => 'required|numeric|min:0',
                    "minBetGlobal" => 'required|numeric|min:0',
                    "wholePot" => 'required',
                    "fromBetToJpLocal" => 'required|positive_integer_number|min:0|max:100',
                    "fromBetToJpGlobal" => 'required|positive_integer_number|min:0|max:100',
                    "startValueLocal" => 'required|numeric|min:0',
                    "startValueGlobal" => 'required|numeric|min:0'
                ];

                $attributes = [
                    'model_name' => __("authenticated.Name"),
                    'currency' => __("authenticated.Currency"),
                    'global_on_off' => __("authenticated.Global JP"),
                    'local_on_off' => __("authenticated.Local JP"),
                    "minNoTickets" => __("authenticated.Minimum Number of Tickets"),
                    'fromHours' => __("authenticated.From value of range of hours in which JackPot can be won"),
                    'toHours' => __("authenticated.To value of range of hours in which JackPot can be won"),
                    'winPriceLocal' => __("authenticated.Local Win Price"),
                    'winPriceGlobal' => __("authenticated.Global Win Price"),
                    'winProbabilityLocal' => __("authenticated.Local Win Probability"),
                    'winProbabilityGlobal' => __("authenticated.Global Win Probability"),
                    'winBeforeLocal' => __("authenticated.Local Win Before"),
                    'winBeforeGlobal' => __("authenticated.Global Win Before"),
                    'minBetLocal' => __("authenticated.Local Min. Bet To Win JP"),
                    'minBetGlobal' => __("authenticated.Global Min. Bet To Win JP"),
                    'wholePot' => __("authenticated.Win Whole Pot"),
                    'fromBetToJpLocal' => __("authenticated.Local From Bet To JP POT"),
                    'fromBetToJpGlobal' => __("authenticated.Global From Bet To JP POT"),
                    'startValueLocal' => __("authenticated.Local JP POT Start Value"),
                    'startValueGlobal' => __("authenticated.Global JP POT Start Value")
                ];

                $messages = [
                    'model_name.required' => __("authenticated.The :attribute is required."),
                    'global_on_off.required' => __("authenticated.The :attribute is required."),
                    'local_on_off.required' => __("authenticated.The :attribute is required."),
                    'model_name.max' => __("authenticated.The :attribute maximum character length is :max."),
                    'currency.required' => __("authenticated.The :attribute is required."),
                    'minNoTickets.required' => __("authenticated.The :attribute is required."),
                    'minNoTickets.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'fromHours.required' => __("authenticated.The :attribute in between which JackPot can be won is required."),
                    'fromHours.max' => __("authenticated.The :attribute in between which JackPot can be won must be between 0 and :max."),
                    'fromHours.min' => __("authenticated.The :attribute in between which JackPot can be won must be between :min and 24."),
                    'fromHours.positive_integer_number' => __("authenticated.The :attribute in between which JackPot can be won must be positive, whole number."),
                    'fromHours.lesser_than_field' => __("authenticated.The :attribute must be lesser than To Hours Value."),
                    'toHours.required' => __("authenticated.The :attribute is required."),
                    'toHours.max' => __("authenticated.To value of Range of Hours in between which JackPot can be won must be between 0 and :max."),
                    'toHours.min' => __("authenticated.To value of range of Hours in between which JackPot can be won must be between :min and 24."),
                    'toHours.positive_integer_number' => __("authenticated.To value of range of Hours in between which JackPot can be won must be positive, whole number."),
                    'toHours.greater_than_field' => __("authenticated.The :attribute must be greater than From Hours Value."),
                    'wholePot.required' => __("authenticated.The :attribute is required."),
                    'winPriceLocal.required' => __("authenticated.The :attribute is required."),
                    'winPriceLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winPriceGlobal.required' => __("authenticated.The :attribute is required."),
                    'winPriceGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winProbabilityLocal.required' => __("authenticated.The :attribute is required."),
                    'winProbabilityLocal.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'winProbabilityLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winProbabilityGlobal.required' => __("authenticated.The :attribute is required."),
                    'winProbabilityGlobal.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'winProbabilityGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winBeforeLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winBeforeGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'minBetLocal.required' => __("authenticated.The :attribute is required."),
                    'minBetLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'minBetGlobal.required' => __("authenticated.The :attribute is required."),
                    'minBetGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'fromBetToJpLocal.required' => __("authenticated.The :attribute is required."),
                    'fromBetToJpLocal.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'fromBetToJpLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'fromBetToJpLocal.max' => __("authenticated.The :attribute maximum value is :max."),
                    'fromBetToJpGlobal.required' => __("authenticated.The :attribute is required."),
                    'fromBetToJpGlobal.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'fromBetToJpGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'fromBetToJpGlobal.max' => __("authenticated.The :attribute maximum value is :max."),
                    'startValueLocal.required' => __("authenticated.The :attribute is required."),
                    'startValueLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'startValueGlobal.required' => __("authenticated.The :attribute is required."),
                    'startValueGlobal.min' => __("authenticated.The :attribute minimum value is :min.")
                ];

                $validator = Validator::make($request->all(),$rules, $messages, $attributes);

                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()->all(), "success" => false]);
                }else{
                    $result = JackPotModel::editJPModel($session_id, $logged_in_id, $model_id, $model_name,$currency, $winPriceLocal, $winPriceGlobal, $fromHours, $toHours,
                        $fromBetToJpLocal, $fromBetToJpGlobal, $winProbabilityLocal, $winProbabilityGlobal, $minBetLocal, $minBetGlobal, $startValueLocal,
                        $startValueGlobal, $winBeforeLocal, $winBeforeGlobal, $wholePot, $minNoTickets, $global_on_off, $local_on_off);

                    if($result["status"] == 1){
                        return response()->json([
                            "status" => "OK",
                            "true_status" => $result["status"],
                            "message" => __("authenticated.Changes saved"),
                            "success" => true
                        ]);
                    }elseif($result["status"] == -2){
                        return response()->json([
                            "status" => "NOK",
                            "true_status" => $result["status"],
                            "message" => __("authenticated.Model Name taken."),
                            "success" => true
                        ]);
                    }else{
                        return response()->json([
                            "status" => "NOK",
                            "true_status" => $result["status"],
                            "message" => __("authenticated.Changes not saved"),
                            "success" => true
                        ]);
                    }
                }
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
                "message" => __("authenticated.Changes not saved"),
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
                "message" => __("authenticated.Changes not saved"),
            ]);
        }
    }

    public function createJPSpecification(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $session_id = $authSessionData['backoffice_session_id'];

            $model_name = $request->input("model_name");
            $currency = $request->input("currency");
            $minNoTickets = $request->input("minNoTickets");
            $fromHours = $request->input("fromHours");
            $toHours = $request->input("toHours");
            $winPriceLocal = $request->input("winPriceLocal");
            $winPriceGlobal = $request->input("winPriceGlobal");
            $winProbabilityLocal = $request->input("winProbabilityLocal");
            $winProbabilityGlobal = $request->input("winProbabilityGlobal");
            $winBeforeLocal = $request->input("winBeforeLocal");
            $winBeforeGlobal = $request->input("winBeforeGlobal");
            $minBetLocal = $request->input("minBetLocal");
            $minBetGlobal = $request->input("minBetGlobal");
            $wholePot = $request->input("wholePot");
            $fromBetToJpLocal = $request->input("fromBetToJpLocal");
            $fromBetToJpGlobal = $request->input("fromBetToJpGlobal");
            $startValueLocal = $request->input("startValueLocal");
            $startValueGlobal = $request->input("startValueGlobal");
            $global_on_off = $request->input("global_on_off");
            $local_on_off = $request->input("local_on_off");

            if ($global_on_off == -1 && $local_on_off){
                return response()->json(['errors'=>array(trans("authenticated.At least one Jack-Pot must be active.")), "success" => false, "status" => "NOK"]);
            }else{
                $rules = [
                    'model_name' => 'required|max:40',
                    'currency' => 'required',
                    'global_on_off' => 'required',
                    'local_on_off' => 'required',
                    'minNoTickets' => 'nullable|positive_integer_number',
                    'fromHours' => 'nullable|positive_integer_number|numeric|min:0|max:24|lesser_than_field:toHours',
                    'toHours' => 'nullable|positive_integer_number|numeric|min:0|max:24|greater_than_field:fromHours',
                    'winPriceLocal' => 'required|numeric|min:0',
                    'winPriceGlobal' => 'required|numeric|min:0',
                    'winProbabilityLocal' => 'required|positive_integer_number|min:1',
                    'winProbabilityGlobal' => 'required|positive_integer_number|min:1',
                    'winBeforeLocal' => 'nullable|numeric|min:0',
                    'winBeforeGlobal' => 'nullable|numeric|min:0',
                    "minBetLocal" => 'required|numeric|min:0',
                    "minBetGlobal" => 'required|numeric|min:0',
                    "wholePot" => 'required',
                    "fromBetToJpLocal" => 'required|positive_integer_number|min:0|max:100',
                    "fromBetToJpGlobal" => 'required|positive_integer_number|min:0|max:100',
                    "startValueLocal" => 'required|numeric|min:0',
                    "startValueGlobal" => 'required|numeric|min:0'
                ];

                $attributes = [
                    'model_name' => __("authenticated.Name"),
                    'currency' => __("authenticated.Currency"),
                    'global_on_off' => __("authenticated.Global JP"),
                    'local_on_off' => __("authenticated.Local JP"),
                    "minNoTickets" => __("authenticated.Minimum Number of Tickets"),
                    'fromHours' => __("authenticated.From value of range of hours in which JackPot can be won"),
                    'toHours' => __("authenticated.To value of range of hours in which JackPot can be won"),
                    'winPriceLocal' => __("authenticated.Local Win Price"),
                    'winPriceGlobal' => __("authenticated.Global Win Price"),
                    'winProbabilityLocal' => __("authenticated.Local Win Probability"),
                    'winProbabilityGlobal' => __("authenticated.Global Win Probability"),
                    'winBeforeLocal' => __("authenticated.Local Win Before"),
                    'winBeforeGlobal' => __("authenticated.Global Win Before"),
                    'minBetLocal' => __("authenticated.Local Min. Bet To Win JP"),
                    'minBetGlobal' => __("authenticated.Global Min. Bet To Win JP"),
                    'wholePot' => __("authenticated.Win Whole Pot"),
                    'fromBetToJpLocal' => __("authenticated.Local From Bet To JP POT"),
                    'fromBetToJpGlobal' => __("authenticated.Global From Bet To JP POT"),
                    'startValueLocal' => __("authenticated.Local JP POT Start Value"),
                    'startValueGlobal' => __("authenticated.Global JP POT Start Value")
                ];

                $messages = [
                    'model_name.required' => __("authenticated.The :attribute is required."),
                    'global_on_off.required' => __("authenticated.The :attribute is required."),
                    'local_on_off.required' => __("authenticated.The :attribute is required."),
                    'model_name.max' => __("authenticated.The :attribute maximum character length is :max."),
                    'currency.required' => __("authenticated.The :attribute is required."),
                    'minNoTickets.required' => __("authenticated.The :attribute is required."),
                    'minNoTickets.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'fromHours.required' => __("authenticated.The :attribute in between which JackPot can be won is required."),
                    'fromHours.max' => __("authenticated.The :attribute in between which JackPot can be won must be between 0 and :max."),
                    'fromHours.min' => __("authenticated.The :attribute in between which JackPot can be won must be between :min and 24."),
                    'fromHours.positive_integer_number' => __("authenticated.The :attribute in between which JackPot can be won must be positive, whole number."),
                    'fromHours.lesser_than_field' => __("authenticated.The :attribute must be lesser than To Hours Value."),
                    'toHours.required' => __("authenticated.The :attribute is required."),
                    'toHours.max' => __("authenticated.To value of Range of Hours in between which JackPot can be won must be between 0 and :max."),
                    'toHours.min' => __("authenticated.To value of range of Hours in between which JackPot can be won must be between :min and 24."),
                    'toHours.positive_integer_number' => __("authenticated.To value of range of Hours in between which JackPot can be won must be positive, whole number."),
                    'toHours.greater_than_field' => __("authenticated.The :attribute must be greater than From Hours Value."),
                    'wholePot.required' => __("authenticated.The :attribute is required."),
                    'winPriceLocal.required' => __("authenticated.The :attribute is required."),
                    'winPriceLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winPriceGlobal.required' => __("authenticated.The :attribute is required."),
                    'winPriceGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winProbabilityLocal.required' => __("authenticated.The :attribute is required."),
                    'winProbabilityLocal.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'winProbabilityLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winProbabilityGlobal.required' => __("authenticated.The :attribute is required."),
                    'winProbabilityGlobal.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'winProbabilityGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winBeforeLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'winBeforeGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'minBetLocal.required' => __("authenticated.The :attribute is required."),
                    'minBetLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'minBetGlobal.required' => __("authenticated.The :attribute is required."),
                    'minBetGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'fromBetToJpLocal.required' => __("authenticated.The :attribute is required."),
                    'fromBetToJpLocal.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'fromBetToJpLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'fromBetToJpLocal.max' => __("authenticated.The :attribute maximum value is :max."),
                    'fromBetToJpGlobal.required' => __("authenticated.The :attribute is required."),
                    'fromBetToJpGlobal.positive_integer_number' => __("The :attribute value must be positive, whole number."),
                    'fromBetToJpGlobal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'fromBetToJpGlobal.max' => __("authenticated.The :attribute maximum value is :max."),
                    'startValueLocal.required' => __("authenticated.The :attribute is required."),
                    'startValueLocal.min' => __("authenticated.The :attribute minimum value is :min."),
                    'startValueGlobal.required' => __("authenticated.The :attribute is required."),
                    'startValueGlobal.min' => __("authenticated.The :attribute minimum value is :min.")
                ];

                $validator = Validator::make($request->all(),$rules, $messages, $attributes);

                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()->all(), "success" => false, "status" => "NOK"]);
                }else{
                    $result = JackPotModel::createJPModel($session_id, $logged_in_id, $model_name,$currency, $winPriceLocal, $winPriceGlobal, $fromHours, $toHours,
                        $fromBetToJpLocal, $fromBetToJpGlobal, $winProbabilityLocal, $winProbabilityGlobal, $minBetLocal, $minBetGlobal, $startValueLocal,
                        $startValueGlobal, $winBeforeLocal, $winBeforeGlobal, $wholePot, $minNoTickets, $global_on_off, $local_on_off);

                    if($result["status"] > 0){
                        return response()->json([
                            "status" => "OK",
                            "true_status" => $result["status"],
                            "message" => __("authenticated.Success."),
                            "success" => true
                        ]);
                    }elseif($result["status"] == -2){
                        return response()->json([
                            "status" => "NOK",
                            "true_status" => $result["status"],
                            "message" => __("authenticated.Model Name taken."),
                            "success" => true
                        ]);
                    }else{
                        return response()->json([
                            "status" => "NOK",
                            "true_status" => $result["status"],
                            "message" => __("authenticated.Fail."),
                            "success" => true
                        ]);
                    }
                }
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
                "message" => __("authenticated.Changes not saved"),
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "result" => null,
                "message" => __("authenticated.Changes not saved"),
            ]);
        }
    }

    public function listSubjectsForGlobalJP(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $subject_id = $request->input("subject_id");
            $model_id = $request->input("model_id");

            $result = JackPotModel::listSubjectsForGlobalJP($subject_id, $model_id);
            $resultResult = $result["result"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $i = 0;

            if($resultStatus == "OK"){
                /*foreach ($resultResult as $r){
                    //to
                    $resultProcessed[$i]["subject_id_to"] = $r->subject_id_to;
                    $resultProcessed[$i]["subject_name_to"] = $r->subject_name_to;
                    $resultProcessed[$i]["subject_type_id_to"] = $r->subject_type_id_to;
                    $resultProcessed[$i]["subject_type_name_to"] = $r->subject_type_name_to;
                    //for
                    $resultProcessed[$i]["subject_id_for"] = $r->subject_id_for;
                    $resultProcessed[$i]["subject_name_for"] = $r->subject_name_for;
                    $resultProcessed[$i]["subject_type_id_for"] = $r->subject_type_id_for;
                    $resultProcessed[$i]["subject_type_name_for"] = $r->subject_type_name_for;
                    //jp general
                    $resultProcessed[$i]["subject_path"] = $r->subject_path;
                    $i++;
                }
                $i = 0;*/

                return response()->json([
                    "status" => "OK",
                    "result" => $resultResult,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
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

    public function getDisabledSubjectsForJPModel(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $model_id = $request->input("model_id");

            $result = JackPotModel::getDisabledSubjectsForJPModel($backoffice_session_id, $model_id);
            $resultResult = $result["result"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $i = 0;

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    //to
                    $resultProcessed[$i]["subject_id_to"] = $r->subject_id_to;
                    $resultProcessed[$i]["subject_name_to"] = $r->subject_name_to;
                    $resultProcessed[$i]["subject_type_id_to"] = $r->subject_type_id_to;
                    $resultProcessed[$i]["subject_type_name_to"] = $r->subject_type_name_to;
                    //for
                    $resultProcessed[$i]["subject_id_for"] = $r->subject_id_for;
                    $resultProcessed[$i]["subject_name_for"] = $r->subject_name_for;
                    $resultProcessed[$i]["subject_type_id_for"] = $r->subject_type_id_for;
                    $resultProcessed[$i]["subject_type_name_for"] = $r->subject_type_name_for;
                    //jp general
                    $resultProcessed[$i]["subject_path"] = $r->subject_path;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
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

    public function getEnabledSubjectsForJPModel(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $model_id = $request->input("model_id");

            $result = JackPotModel::getEnabledSubjectsForJPModel($backoffice_session_id, $model_id);
            $resultResult = $result["result"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $i = 0;

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $resultProcessed[$i]["model_id"] = $r->jp_model_id;
                    $resultProcessed[$i]["model_name"] = $r->jp_model;
                    //to
                    $resultProcessed[$i]["subject_id_to"] = $r->subject_id_to;
                    $resultProcessed[$i]["subject_name_to"] = $r->subject_name_to;
                    $resultProcessed[$i]["subject_type_id_to"] = $r->subject_type_id_to;
                    $resultProcessed[$i]["subject_type_name_to"] = $r->subject_type_name_to;
                    //for
                    $resultProcessed[$i]["subject_id_for"] = $r->subject_id_for;
                    $resultProcessed[$i]["subject_name_for"] = $r->subject_name_for;
                    $resultProcessed[$i]["subject_type_id_for"] = $r->subject_type_id_for;
                    $resultProcessed[$i]["subject_type_name_for"] = $r->subject_type_name_for;
                    //jp general
                    $resultProcessed[$i]["subject_path"] = $r->subject_path;
                    $resultProcessed[$i]["priority"] = $r->priority;

                    if($r->priority == config("constants.priority_0")){
                        $resultProcessed[$i]["priority_text"] = "0%";
                    }elseif ($r->priority == config("constants.priority_50")){
                        $resultProcessed[$i]["priority_text"] = "50%";
                    }elseif ($r->priority == config("constants.priority_100")){
                        $resultProcessed[$i]["priority_text"] = "100%";
                    }else{
                        $resultProcessed[$i]["priority_text"] = "0%";
                    }

                    $resultProcessed[$i]["payout_percent"] = $r->priority;
                    //local
                    $resultProcessed[$i]["local_level_on_off"] = $r->local_level_on_off;
                    //global
                    $resultProcessed[$i]["global_level_on_off"] = $r->global_level_on_off;
                    $resultProcessed[$i]["global_jp_inherited_from_id"] = $r->global_jp_inherited_from_id;
                    $resultProcessed[$i]["global_jp_inherited_from_name"] = $r->global_jp_inherited_from;

                    if($r->local_level_on_off == 1){
                        $resultProcessed[$i]["local_level_on_off_text"] = "Local";
                    }else{
                        $resultProcessed[$i]["local_level_on_off_text"] = "-";
                    }
                    if($r->global_level_on_off == 1){
                        $resultProcessed[$i]["global_level_on_off_text"] = "Global";
                    }else{
                        $resultProcessed[$i]["global_level_on_off_text"] = "-";
                    }

                    $resultProcessed[$i]["local_current_level"] = $r->local_current_level;
                    $resultProcessed[$i]["global_current_level"] = $r->global_current_level;

                    if($r->subject_type_id_to == config("constants.LOCATION_TYPE_ID")){
                        $resultProcessed[$i]["pot"] = "L = ".$r->local_current_level;
                    }else{
                        $resultProcessed[$i]["pot"] = "G = ".$r->global_current_level;
                    }

                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
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

    public function getJpModels(){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $result = JackPotModel::getJpModels($backoffice_session_id, $logged_in_id);
            $resultResult = $result["result"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $i = 0;

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $resultProcessed[$i]["model_id"] = $r->jp_model_id;
                    $resultProcessed[$i]["model_name"] = $r->jp_model;
                    $resultProcessed[$i]["currency"] = $r->currency;
                    $resultProcessed[$i]["local_level_type"] = $r->local_level_type;
                    $resultProcessed[$i]["global_level_type"] = $r->global_level_type;
                    $resultProcessed[$i]["time_active_from"] = $r->jp_time_active_from;
                    $resultProcessed[$i]["time_active_to"] = $r->jp_time_active_to;
                    $resultProcessed[$i]["local_level_percent_from_bet"] = $r->local_level_percent_from_bet;
                    $resultProcessed[$i]["global_level_percent_from_bet"] = $r->global_level_percent_from_bet;
                    $resultProcessed[$i]["local_win_probability"] = $r->local_win_probability;
                    $resultProcessed[$i]["global_win_probability"] = $r->global_win_probability;
                    $resultProcessed[$i]["local_min_bet"] = $r->local_min_bet;
                    $resultProcessed[$i]["global_min_bet"] = $r->global_min_bet;
                    $resultProcessed[$i]["local_pot_start_value"] = $r->local_pot_start_value;
                    $resultProcessed[$i]["global_pot_start_value"] = $r->global_pot_start_value;
                    $resultProcessed[$i]["win_whole_pot"] = $r->win_whole_pot;
                    $resultProcessed[$i]["payout_percent"] = $r->payout_percent;
                    $resultProcessed[$i]["min_tickets_to_win"] = $r->min_tickets_to_win;
                    $resultProcessed[$i]["with_payback"] = $r->with_payback;
                    $resultProcessed[$i]["local_win_price"] = $r->local_level_value;
                    $resultProcessed[$i]["local_win_price_text"] = "L - ".$r->local_level_value;
                    $resultProcessed[$i]["global_win_price"] = $r->global_level_value;
                    $resultProcessed[$i]["global_win_price_text"] = "G - ".$r->global_level_value;
                    $resultProcessed[$i]["details"] = "L - ".$r->local_level_value." , "."G - ".$r->global_level_value;
                    $resultProcessed[$i]["local_forced_win_before"] = $r->local_forced_win_before;
                    $resultProcessed[$i]["global_forced_win_before"] = $r->global_forced_win_before;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
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

    public function getJpModelDetails(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $model_id = $request->input("model_id");

            $result = JackPotModel::getJpModelDetails($model_id);
            $resultResult = $result["result"];
            $resultStatus = $result["status"];

            $resultProcessed = array();
            $i = 0;

            if($resultStatus == "OK"){
                foreach ($resultResult as $r){
                    $resultProcessed[$i]["model_id"] = $r->jp_model_id;
                    $resultProcessed[$i]["model_name"] = $r->jp_model;
                    $resultProcessed[$i]["currency"] = $r->currency;
                    $resultProcessed[$i]["local_level_type"] = $r->local_level_type;
                    $resultProcessed[$i]["global_level_type"] = $r->global_level_type;
                    $resultProcessed[$i]["time_active_from"] = $r->jp_time_active_from;
                    $resultProcessed[$i]["time_active_to"] = $r->jp_time_active_to;
                    $resultProcessed[$i]["local_level_percent_from_bet"] = $r->local_level_percent_from_bet;
                    $resultProcessed[$i]["global_level_percent_from_bet"] = $r->global_level_percent_from_bet;
                    $resultProcessed[$i]["local_win_probability"] = $r->local_win_probability;
                    $resultProcessed[$i]["global_win_probability"] = $r->global_win_probability;
                    $resultProcessed[$i]["local_min_bet"] = $r->local_min_bet;
                    $resultProcessed[$i]["global_min_bet"] = $r->global_min_bet;
                    $resultProcessed[$i]["local_pot_start_value"] = $r->local_pot_start_value;
                    $resultProcessed[$i]["global_pot_start_value"] = $r->global_pot_start_value;
                    $resultProcessed[$i]["win_whole_pot"] = $r->win_whole_pot;
                    $resultProcessed[$i]["payout_percent"] = $r->payout_percent;
                    $resultProcessed[$i]["min_tickets_to_win"] = $r->min_tickets_to_win;
                    $resultProcessed[$i]["with_payback"] = $r->with_payback;
                    $resultProcessed[$i]["local_win_price"] = $r->local_level_value;
                    $resultProcessed[$i]["local_win_price_text"] = "L - ".$r->local_level_value;
                    $resultProcessed[$i]["global_win_price"] = $r->global_level_value;
                    $resultProcessed[$i]["global_win_price_text"] = "G - ".$r->global_level_value;
                    $resultProcessed[$i]["details"] = "L - ".$r->local_level_value." , "."G - ".$r->global_level_value;
                    $resultProcessed[$i]["local_forced_win_before"] = $r->local_forced_win_before;
                    $resultProcessed[$i]["global_forced_win_before"] = $r->global_forced_win_before;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $resultProcessed,
                ]);

            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $result,
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
