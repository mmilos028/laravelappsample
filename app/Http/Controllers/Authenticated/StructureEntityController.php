<?php

namespace App\Http\Controllers\Authenticated;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\LaravelLocalization;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Postgres\UserModel;
use App\Models\Postgres\CommonModel;
use App\Models\Postgres\CurrencyModel;
use App\Models\Postgres\CustomerModel;
use App\Models\Postgres\DrawModelSetupModel;
use App\Models\Postgres\SubjectTypeModel;
use App\Models\Postgres\StructureEntityModel;
use App\Models\Postgres\TerminalModel;
use App\Models\Postgres\TransferCreditModel;

use App\Helpers\PasswordHasherHelper;
use App\Helpers\ErrorHelper;
use App\Helpers\ArrayHelper;
use stdClass;
use Crypt;

class StructureEntityController extends Controller
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

    public function returnNewStructureEntityView(){
        return view("authenticated/structure-entity.new-user-2");
    }

    public function getSubjectRolesForNewStructureEntityForm(){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $subjectTypes = SubjectTypeModel::listNewStructureEntitySubjectTypes($logged_in_id);
            $subjectTypesResult = $subjectTypes["result"];
            $subjectTypesResultProcessed = array();

            $i = 0;
            foreach ($subjectTypesResult as $r){
                $subjectTypesResultProcessed[$i]["subject_type_id"] = $r->subject_dtype_id;
                $subjectTypesResultProcessed[$i]["subject_type_bo_name"] = $r->subject_dtype_bo_name;
                $subjectTypesResultProcessed[$i]["subject_type"] = $r->subject_dtype;
                $subjectTypesResultProcessed[$i]["order"] = $r->order;
                $subjectTypesResultProcessed[$i]["type"] = $r->type;
                $i++;
            }
            $i = 0;

            return response()->json([
                "status" => "OK",
                "result" => $subjectTypesResultProcessed,
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

    public function getDrawModelForAff(Request $request){
        try {
            $aff_id = $request->input("affiliate_id");
            $draw_model = DrawModelSetupModel::getDrawModelForAff($aff_id);
            $draw_model_result = $draw_model["model_id"];
            $draw_model_status = $draw_model["status"];

            if($draw_model_status == "OK"){
                return response()->json([
                    "status" => "OK",
                    "result" => $draw_model_result,
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $draw_model_result,
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

    public function removeElementWithValue($array, $key, $value){
        foreach($array as $subKey => $subArray){
            if($subArray[$key] == $value){
                unset($array[$subKey]);
            }
        }
        return $array;
    }

    public function convertToObject($array) {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    public function listAllDrawModelsAjax(){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];
            $parent_id = $authSessionData['parent_id'];

            $resultListDrawModels = DrawModelSetupModel::listAllDrawModels($backoffice_session_id, $logged_in_id, $parent_id);
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

            $array = $this->removeElementWithValue($array, "rec_sts", -1);

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
    public function createNewStructureEntity(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $draw_model_types = array(config("constants.CLIENT_TYPE_ID"), config("constants.OPERATER_TYPE_ID"), config("constants.LOCATION_TYPE_ID"));

            $subject_type = $request->input("subject_type");
            $parent_affiliate = $request->input("parent_affiliate");
            $username = $request->input("username");
            $password = $request->input("password");
            $confirm_password = $request->input("confirm_password");
            $first_name = $request->input("first_name");
            $last_name = $request->input("last_name");
            $mobile_phone = $request->input("mobile_phone");
            $address = $request->input("address");
            $commercial_address = $request->input("commercial_address");
            $email = $request->input("email");
            $post_code = $request->input("post_code");
            $city = $request->input("city");
            $country = $request->input("country");
            $language = $request->input("language");
            $currency = $request->input("currency");
            $draw_model = $request->input("draw_model");

            Validator::extend('without_spaces', function($attr, $value){
                return preg_match('/^\S*$/u', $value);
            });

            //match
            // a-z and A-Z and 0-9 - _
            // in username as allowed character
            Validator::extend('characters_allowed', function($attr, $value){
                return preg_match('/^[a-zA-Z0-9-_]*$/u', $value);
            });

            if(in_array($request->get('subject_type'),
                array(config('constants.LOCATION_TYPE_ID')))
            ){
                if(strlen($request->get('address')) == 0){
                    $error_message = __("authenticated.Address is required field");
                    return response()->json([
                        'errors'=>[
                            $error_message
                        ],
                        "success" => false]
                    );
                }
                if(strlen($request->get('commercial_address')) == 0){
                    $error_message = __("authenticated.Address 2 is required field");
                    return response()->json([
                        'errors'=>[
                            $error_message
                        ],
                        "success" => false]
                    );
                }
                if(strlen($request->get('city')) == 0){
                    $error_message = __("authenticated.City is required field");
                    return response()->json([
                        'errors'=>[
                            $error_message
                        ],
                        "success" => false]
                    );
                }
            }

            if($subject_type == config("constants.SELF_SERVICE_TERMINAL_ID")){
                $usernameRequiredMessage = trans("authenticated.MAC Address is required.");
            }else{
                $usernameRequiredMessage = trans("authenticated.Username is required.");
            }

            if(in_array($subject_type, $draw_model_types)){
                $rules = [
                    'subject_type' => 'required',
                    'parent_affiliate' => 'required',
                    'username' => 'required|without_spaces|characters_allowed|min:2|max:40',
                    'password' => 'required|without_spaces|characters_allowed|min:4|max:40',
                    'confirm_password' => 'required|without_spaces|characters_allowed|min:4|max:40|same:password',
                    'mobile_phone' => 'required|min:2|max:50',
                    'email' => 'required|email|min:4|max:200',
                    'country' => 'required|min:1|max:40',
                    'language' => 'required|min:4|max:6',
                    'currency' => 'required|min:3|max:3',
                    'draw_model' => 'required',
                ];

                $messages = [
                    'subject_type.required' => __("authenticated.Subject Type field is required."),
                    'subject_type.parent_affiliate' => __("authenticated.Parent Affiliate field is required."),
                    'username.required' => $usernameRequiredMessage,
                    'username.min' => __("authenticated.Minimum character length for username is :min."),
                    'username.max' => __("authenticated.Maximum character length for username is :max."),
                    'username.without_spaces' => __("authenticated.:attribute is not allowed to contain empty spaces."),
                    'username.characters_allowed' => __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                    'password.required' => __("authenticated.Password is required."),
                    'password.min' => __("authenticated.Minimum character length for password is :min."),
                    'password.max' => __("authenticated.Maximum character length for password is :max."),
                    'password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                    'password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                    'confirm_password.required' => __("authenticated.Password confirmation is required."),
                    'confirm_password.min' => __("authenticated.Minimum character length for password confirmation is :min."),
                    'confirm_password.max' => __("authenticated.Maximum character length for password confirmation is :max."),
                    'confirm_password.same' => __("authenticated.The Confirm Password and Password must match."),
                    'confirm_password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                    'confirm_password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                    'mobile_phone.required' => __("authenticated.Mobile Phone is required."),
                    'mobile_phone.min' => __("authenticated.Minimum character length for mobile phone is :min."),
                    'mobile_phone.max' => __("authenticated.Maximum character length for mobile phone is :max."),
                    'email.required' => __("authenticated.Email is required."),
                    'email.min' => __("authenticated.Minimum character length for Email is :min."),
                    'email.max' => __("authenticated.Maximum character length for Email is :max."),
                    'email.email' => __("authenticated.Not a valid email format."),
                    'country.required' => __("authenticated.Country is required."),
                    'country.min' => __("authenticated.Minimum character length for Country is :min."),
                    'country.max' => __("authenticated.Maximum character length for Country is :max."),
                    'language.required' => __("authenticated.Language is required."),
                    'language.min' => __("authenticated.Minimum character length for Language is :min."),
                    'language.max' => __("authenticated.Maximum character length for Language is :max."),
                    'currency.required' => __("authenticated.Currency is required."),
                    'currency.min' => __("authenticated.Minimum character length for Currency is :min."),
                    'currency.max' => __("authenticated.Maximum character length for Currency is :max."),
                    'draw_model.required' => __("authenticated.Draw Model is required."),
                ];

                $attributes = [
                    'subject_type' => __("authenticated.Subject Type"),
                    'parent_affiliate' => __("authenticated.Parent Affiliate"),
                    'username' => __("authenticated.Username"),
                    'password' => __("authenticated.Password"),
                    'confirm_password' => __("authenticated.Confirm Password"),
                    'email' => __("authenticated.Email"),
                    'mobile_phone' => __("authenticated.Mobile Phone"),
                    'first_name' => __("authenticated.First Name"),
                    'last_name' => __("authenticated.Last Name"),
                    'address' => __("authenticated.Address"),
                    'commercial_address' => __("authenticated.Commercial Address"),
                    'city' => __("authenticated.City"),
                    'country' => __("authenticated.Country"),
                    'currency' => __("authenticated.Currency"),
                    'language' => __("authenticated.Language"),
                    'draw_model' => __("authenticated.Draw Model"),
                ];
            }else{
                //match
                // a-z and A-Z and 0-9 - _
                // in username as allowed character
                Validator::extend('characters_allowed', function($attr, $value){
                    return preg_match('/^[a-zA-Z0-9-_]*$/u', $value);
                });

                if($subject_type == config("constants.SELF_SERVICE_TERMINAL_ID")){
                    $rules = [
                        'subject_type' => 'required',
                        'parent_affiliate' => 'required',
                        'username' => 'required|without_spaces|characters_allowed|min:2|max:40',
                        'password' => 'nullable|without_spaces|characters_allowed|min:4|max:40',
                        'confirm_password' => 'nullable|without_spaces|characters_allowed|min:4|max:40|same:password',
                        'mobile_phone' => 'required|min:2|max:50',
                        'email' => 'required|email|min:4|max:200',
                        'country' => 'required|min:1|max:40',
                        'language' => 'required|min:4|max:6',
                        'currency' => 'required|min:3|max:3',
                    ];
                }else{
                    $rules = [
                        'subject_type' => 'required',
                        'parent_affiliate' => 'required',
                        'username' => 'required|without_spaces|characters_allowed|min:2|max:40',
                        'password' => 'required|without_spaces|characters_allowed|min:4|max:40',
                        'confirm_password' => 'required|without_spaces|characters_allowed|min:4|max:40|same:password',
                        'mobile_phone' => 'required|min:2|max:50',
                        'email' => 'required|email|min:4|max:200',
                        'country' => 'required|min:1|max:40',
                        'language' => 'required|min:4|max:6',
                        'currency' => 'required|min:3|max:3',
                    ];
                }

                $messages = [
                    'subject_type.required' => __("authenticated.Subject Type field is required."),
                    'subject_type.parent_affiliate' => __("authenticated.Parent Affiliate field is required."),
                    'username.required' => $usernameRequiredMessage,
                    'username.min' => __("authenticated.Minimum character length for username is :min."),
                    'username.max' => __("authenticated.Maximum character length for username is :max."),
                    'username.without_spaces' => __("authenticated.:attribute is not allowed to contain empty spaces."),
                    'username.characters_allowed' => __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                    'password.required' => __("authenticated.Password is required."),
                    'password.min' => __("authenticated.Minimum character length for password is :min."),
                    'password.max' => __("authenticated.Maximum character length for password is :max."),
                    'password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                    'password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                    'confirm_password.required' => __("authenticated.Password confirmation is required."),
                    'confirm_password.min' => __("authenticated.Minimum character length for password confirmation is :min."),
                    'confirm_password.max' => __("authenticated.Maximum character length for password confirmation is :max."),
                    'confirm_password.same' => __("authenticated.The Confirm Password and Password must match."),
                    'confirm_password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                    'confirm_password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                    'mobile_phone.required' => __("authenticated.Mobile Phone is required."),
                    'mobile_phone.min' => __("authenticated.Minimum character length for mobile phone is :min."),
                    'mobile_phone.max' => __("authenticated.Maximum character length for mobile phone is :max."),
                    'email.required' => __("authenticated.Email is required."),
                    'email.min' => __("authenticated.Minimum character length for Email is :min."),
                    'email.max' => __("authenticated.Maximum character length for Email is :max."),
                    'email.email' => __("authenticated.Not a valid email format."),
                    'country.required' => __("authenticated.Country is required."),
                    'country.min' => __("authenticated.Minimum character length for Country is :min."),
                    'country.max' => __("authenticated.Maximum character length for Country is :max."),
                    'language.required' => __("authenticated.Language is required."),
                    'language.min' => __("authenticated.Minimum character length for Language is :min."),
                    'language.max' => __("authenticated.Maximum character length for Language is :max."),
                    'currency.required' => __("authenticated.Currency is required."),
                    'currency.min' => __("authenticated.Minimum character length for Currency is :min."),
                    'currency.max' => __("authenticated.Maximum character length for Currency is :max."),
                ];

                $attributes = [
                    'subject_type' => __("authenticated.Subject Type"),
                    'parent_affiliate' => __("authenticated.Parent Affiliate"),
                    'username' => __("authenticated.Username"),
                    'password' => __("authenticated.Password"),
                    'confirm_password' => __("authenticated.Confirm Password"),
                    'email' => __("authenticated.Email"),
                    'mobile_phone' => __("authenticated.Mobile Phone"),
                    'first_name' => __("authenticated.First Name"),
                    'last_name' => __("authenticated.Last Name"),
                    'address' => __("authenticated.Address"),
                    'commercial_address' => __("authenticated.Commercial Address"),
                    'city' => __("authenticated.City"),
                    'country' => __("authenticated.Country"),
                    'currency' => __("authenticated.Currency"),
                    'language' => __("authenticated.Language"),
                ];
            }

            $validator = Validator::make($request->all(),$rules, $messages, $attributes);

            if ($validator->fails()){
                return response()->json(['errors'=>$validator->errors()->all(), "success" => false]);
            }else{
                if($subject_type == config('constants.TERMINAL_TV_TYPE_ID') || $subject_type == config('constants.TERMINAL_SALES_TYPE_ID') || $subject_type == config('constants.SELF_SERVICE_TERMINAL_ID')){
                    $hashed_password = $password;
                }else{
                    $hashed_password = PasswordHasherHelper::make($password);
                }

                $user = array(
                    'username'=>$username,
                    'password'=>$hashed_password,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'currency'=>$currency,
                    'parent_id'=>$parent_affiliate,
                    'registered_by'=>$logged_in_id,
                    'subject_type_id'=>$subject_type,
                    'language'=>$language,
                    'email'=>$email,
                    'address'=>$address,
                    'city'=>$city,
                    'country'=>$country,
                    'mobile_phone'=>$mobile_phone,
                    'post_code'=>$post_code,
                    'commercial_address'=>$commercial_address,
                );

                $resultInsertUserInformation = UserModel::newUser2($user);

                if($resultInsertUserInformation['status'] == "OK"){
                    if($subject_type == config('constants.TERMINAL_CASHIER_TYPE_ID')){
                        $resultSetServiceKeyForTerminal = TerminalModel::setServiceKeyForTerminal($resultInsertUserInformation['subject_id']);
                        if($resultSetServiceKeyForTerminal['status'] == "OK") {
                            return response()->json([
                                "status" => "OK",
                                "message" => __("authenticated.Success"),
                                "subject_id" => $resultInsertUserInformation['subject_id'],
                                "success" =>  true
                            ]);
                        }
                        else{
                            return response()->json([
                                "status" => "NOK",
                                "message" => __("authenticated.Terminal created, but service key not set !"),
                                "subject_id" => $resultInsertUserInformation['subject_id'],
                                "success" =>  true
                            ]);
                        }
                    }elseif(in_array($subject_type, $draw_model_types)) {
                        $resultDrawModelToAffiliate = DrawModelSetupModel::addDrawModelToAffiliate($backoffice_session_id, $resultInsertUserInformation['subject_id'], $draw_model);
                        if($resultDrawModelToAffiliate['status'] == 'OK') {
                            return response()->json([
                                "status" => "OK",
                                "subject_id" => $resultInsertUserInformation['subject_id'],
                                "message" => __("authenticated.Success"),
                                "success" =>  true
                            ]);
                        }else{
                            return response()->json([
                                "status" => "NOK",
                                "subject_id" => $resultInsertUserInformation['subject_id'],
                                "message" => __("authenticated.User created, but adding draw model was unsuccessful."),
                                "success" =>  true
                            ]);
                        }
                    }else{
                        return response()->json([
                            "status" => "OK",
                            "subject_id" => $resultInsertUserInformation['subject_id'],
                            "message" => __("authenticated.Success"),
                            "success" =>  true
                        ]);
                    }

                }else{
                    if($resultInsertUserInformation["message"] == "GENERAL_ERROR"){
                        $error_message = __("authenticated.Changes not saved");
                    }
                    elseif($resultInsertUserInformation["message"] == "EMAIL NOT AVAILABLE"){
                        $error_message = __("authenticated.Email is not available");
                    }
                    elseif($resultInsertUserInformation["message"] == "USERNAME NOT AVAILABLE"){
                        $error_message = __("authenticated.Username is not available");
                    }else{
                        $error_message = __("authenticated.Changes not saved");
                    }

                    return response()->json([
                        "status" => "NOK",
                        "subject_id" => null,
                        "message" => $error_message,
                        "success" =>  true
                    ]);
                }
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

    public function newUser(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        $languages = UserModel::listLanguages();
        $countries = CommonModel::listCountries($backoffice_session_id);
        $subSubjects = UserModel::listAffiliates($backoffice_session_id);
        $subjectTypes = SubjectTypeModel::listStructureEntitySubjectTypes();
        $subjectTypesResult = $subjectTypes["result"];
        $subjectTypesResultProcessed = array();

        $i = 0;
        foreach ($subjectTypesResult as $r){
            $subjectTypesResultProcessed[$i]["subject_type_id"] = $r->subject_dtype_id;
            $subjectTypesResultProcessed[$i]["subject_type_bo_name"] = $r->subject_dtype_bo_name;
            $subjectTypesResultProcessed[$i]["subject_type"] = $r->subject_dtype;
            $subjectTypesResultProcessed[$i]["order"] = $r->order;
            $subjectTypesResultProcessed[$i]["type"] = $r->type;
            $i++;
        }

        $listCountries = [];
        foreach($countries['list_countries'] as $country) {
            $listCountries[$country->country_code] = $country->name;
        }

        $resultListDrawModels = DrawModelSetupModel::listDrawModels($backoffice_session_id);

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                $language = \App::getLocale();
                return \Redirect::to('/'. $language .'/structure-entity/new-user');
            }

            Validator::extend('without_spaces', function($attr, $value){
                return preg_match('/^\S*$/u', $value);
            });

            //match
            // a-z and A-Z and 0-9 - _
            // in username as allowed character
            Validator::extend('characters_allowed', function($attr, $value){
                return preg_match('/^[a-zA-Z0-9-_]*$/u', $value);
            });

            //validation rules
            $rules = [
                'username' => 'required|without_spaces|characters_allowed|min:2|max:40',
                'password' => 'required|without_spaces|characters_allowed|min:4|max:40',
                'confirm_password' => 'required|without_spaces|characters_allowed|min:4|max:40|same:password',
                'mobile_phone' => 'required|min:2|max:50',
                'email' => 'required|email|min:4|max:200',
                //'first_name' => 'required|min:2|max:20',
                //'last_name' => 'required|min:2|max:40',
                //'address' => 'required|min:2|max:40',
                //'city' => 'required|min:2|max:40',
                'country' => 'required|min:1|max:40',
                'language' => 'required|min:4|max:6',
                'currency' => 'required|min:3|max:3',
            ];

            $messages = [
                'username.without_spaces' => __("authenticated.Field is not allowed to contain empty spaces."),
                'confirm_password.same' => __("authenticated.The Confirm Password and Password must match"),
                'username.characters_allowed' => __("authenticated.Username characters violation rule"),
                'password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                'password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                'confirm_password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                'confirm_password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'password' => __("authenticated.Password"),
                'confirm_password' => __("authenticated.Confirm Password"),
                'email' => __("authenticated.Email"),
                'mobile_phone' => __("authenticated.Mobile Phone"),
                'first_name' => __("authenticated.First Name"),
                'last_name' => __("authenticated.Last Name"),
                'address' => __("authenticated.Address"),
                'commercial_address' => __("authenticated.Commercial Address"),
                'city' => __("authenticated.City"),
                'country' => __("authenticated.Country"),
                'currency' => __("authenticated.Currency"),
                'language' => __("authenticated.Language"),
            ];

            $this->validate($request, $rules, $messages, $attributes);

            $this->validate($request, $rules, $messages, $attributes);

            if(!in_array($request->get('subject_type'),
                array(config('constants.TERMINAL_CASHIER_TYPE_ID'), config('constants.TERMINAL_TYPE_ID'), config('constants.PLAYER_TYPE_ID')))
            ){
                $hashed_password = PasswordHasherHelper::make($request->get('password'));
            }else{
                $hashed_password = $request->get('password');
            }

            if($request->has('save')){
                $user = array(
                    'username'=>$request->get('username'),
                    'password'=>$hashed_password,
                    'first_name'=>$request->get('first_name'),
                    'last_name'=>$request->get('last_name'),
                    'currency'=>$request->get('currency'),
                    'parent_name'=>$resultPersonalInformation['user']['username'],
                    'registered_by'=>$resultPersonalInformation['user']['username'],
                    'subject_type_id'=>$request->get('subject_type'),
                    'player_type_name'=>'',
                    'language'=>$request->get('language'),
                    'email'=>$request->get('email'),
                    'address'=>$request->get('address'),
                    'city'=>$request->get('city'),
                    'country'=>$request->get('country'),
                    'mobile_phone'=>$request->get('mobile_phone'),
                    'post_code'=>$request->get('post_code'),
                    'commercial_address'=>$request->get('commercial_address'),
                );

                $resultInsertUserInformation = UserModel::newUser($user);
                if($resultInsertUserInformation['status'] == "OK"){
                    $subject_type_id = $request->get('subject_type');
                    if($subject_type_id == config('constants.AFFILIATE_TYPE_ID')) {
                        $draw_model_id = $request->get('draw_model_id');

                        $resultDrawModelToAffiliate = DrawModelSetupModel::addDrawModelToAffiliate($backoffice_session_id, $resultInsertUserInformation['subject_id'], $draw_model_id);
                        if($resultDrawModelToAffiliate['status'] == 'OK') {
                            return view(
                                '/authenticated/structure-entity/new-user',
                                array(
                                    "languages"=>$languages,
                                    "list_currency"=>$resultPersonalInformation['list_currency'],
                                    "logged_in_user"=>$resultPersonalInformation['user'],
                                    "list_subject_types"=>$subjectTypesResultProcessed,
                                    "list_countries"=>$listCountries,
                                    "list_draw_models"=>$resultListDrawModels['list_draw_models']
                                )
                            )
                                ->with("success_message", __("authenticated.Changes saved"));
                        }else{
                            return view(
                                '/authenticated/structure-entity/new-user',
                                array(
                                    "languages"=>$languages,
                                    "list_currency"=>$resultPersonalInformation['list_currency'],
                                    "logged_in_user"=>$resultPersonalInformation['user'],
                                    "list_subject_types"=>$subjectTypesResultProcessed,
                                    "list_countries"=>$listCountries,
                                    "user" => $user,
                                    "list_draw_models"=>$resultListDrawModels['list_draw_models']
                                )
                            )
                                ->with("success_message", __("authenticated.Affiliate created, but draw model not connected !"));
                        }
                    }


                }else{
                    if($resultInsertUserInformation["message"] == "GENERAL_ERROR"){
                        $error_message = __("authenticated.Changes not saved");
                    }
                    if($resultInsertUserInformation["message"] == "EMAIL NOT AVAILABLE"){
                        $error_message = __("authenticated.Email is not available");
                    }
                    if($resultInsertUserInformation["message"] == "USERNAME NOT AVAILABLE"){
                        $error_message = __("authenticated.Username is not available");
                    }

                    return view(
                        '/authenticated/structure-entity/new-user',
                        array(
                            "languages"=>$languages,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "logged_in_user"=>$resultPersonalInformation['user'],
                            "list_subject_types"=>$subjectTypesResultProcessed,
                            "list_countries"=>$listCountries,
                            "list_draw_models"=>$resultListDrawModels['list_draw_models']
                        )
                    )->with("error_message", $error_message);
                }
            }
        }

        return view(
            '/authenticated/structure-entity/new-user',
            array(
                "languages"=>$languages,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "logged_in_user"=>$resultPersonalInformation['user'],
                "list_subject_types"=>$subjectTypesResultProcessed,
                "list_countries"=>$listCountries,
                "list_draw_models"=>$resultListDrawModels['list_draw_models']
            )
        );
    }

    public function listUsersTree(Request $request){
        return view(
            '/authenticated/structure-entity/list-users-tree',
            array(

            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subjectTree(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $parent_id = $authSessionData['parent_id'];
            $user_id = $authSessionData['user_id'];
            $treeType = 1;

            $showTerminals = $request->input("showTerminals"); // show: 1 / don't show: -1

            $arr3 = array();

            $result = UserModel::getSubjectTree($parent_id, $treeType, $showTerminals);

            $i3 = 0;

            $laravelLocalized = new LaravelLocalization();
            $arrayHelper = new ArrayHelper();

            foreach($result['result'] as $data){
                $subject_type = $data->child_dtype;

                $properties = $arrayHelper->determineTreeGridProperties($subject_type);

                $color = $properties["color"];
                $url = $properties["url"];
                $url_disabled = $properties["url_disabled"];
                $btn_class = "btn btn-primary";

                $uer_id_crypt = Crypt::encrypt($data->child_id);
                $subject_type_crypt = Crypt::encrypt($subject_type);

                $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$data->child_id);

                if($data->child_id == $parent_id){
                   $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = 0;
                    $arr3[$i3]['parent_name'] = 0;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type_id'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['subject_type_name_colourful'] = '<span style="color:'.$color.';">' .$data->child_dtype_bo_name. '</span>';
                    if($url_disabled){
                        $arr3[$i3]['action_column'] = "";
                    }else{
                        $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'"><span class="fa fa-info">&nbsp;</span>'.'</a>';
                    }
                }else{
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = $data->parent_id;
                    $arr3[$i3]['parent_name'] = $data->parent_name;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type_id'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['subject_type_name_colourful'] = '<span style="color:'.$color.';">' .$data->child_dtype_bo_name. '</span>';

                    if($url_disabled){
                        $arr3[$i3]['action_column'] = "";
                    }else{
                        if($subject_type == config('constants.ROLE_CASHIER_TERMINAL') || $subject_type == config('constants.SELF_SERVICE_TERMINAL') || $subject_type == config('constants.TERMINAL_TV')){
                            $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'/'.$subject_type.'"><span class="fa fa-info">&nbsp;</span>'.'</a>';
                        }else{
                            $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'"><span class="fa fa-info">&nbsp;</span>'.'</a>';
                        }
                    }
                }
                $i3++;
            }

            $count = 0;
            foreach($arr3 as $r){
                $count++;
            }
            if($count > 1){
                $tree = $this->buildTree($arr3, 'parentId', 'id');
                //$tree2 = $this->buildTree2($arr3, 0);
                $response = array();

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

    public function subjectTree2(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $parent_id = $authSessionData['parent_id'];
            $user_id = $authSessionData['user_id'];
            $treeType = 2;
            $showTerminals = 1;

            $arr3 = array();

            $result = UserModel::getSubjectTree($parent_id, $treeType, $showTerminals);

            $i3 = 0;

            $laravelLocalized = new LaravelLocalization();
            $arrayHelper = new ArrayHelper();

            foreach($result['result'] as $data){
                $subject_type = $data->child_dtype;

                $properties = $arrayHelper->determineTreeGridProperties($subject_type);

                $color = $properties["color"];
                $url = $properties["url"];
                $url_disabled = $properties["url_disabled"];
                $btn_class = "btn btn-primary";

                $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$data->child_id);

                if($data->child_id == $parent_id){
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = 0;
                    $arr3[$i3]['parent_name'] = 0;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_id'] = $data->child_subject_type_id;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['subject_type_name_colourful'] = '<span style="color:'.$color.';">' .$data->child_dtype_bo_name. '</span>';
                    if($url_disabled){
                        $arr3[$i3]['action_column'] = "";
                    }else{
                        $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'"><span class="fa fa-info">&nbsp;</span>'.'</a>';
                    }
                }else{
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = $data->parent_id;
                    $arr3[$i3]['parent_name'] = $data->parent_name;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_id'] = $data->child_subject_type_id;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['subject_type_name_colourful'] = '<span style="color:'.$color.';">' .$data->child_dtype_bo_name. '</span>';
                    if($url_disabled){
                        $arr3[$i3]['action_column'] = "";
                    }else{
                        if($subject_type == config('constants.ROLE_CASHIER_TERMINAL') || $subject_type == config('constants.SELF_SERVICE_TERMINAL') || $subject_type == config('constants.TERMINAL_TV')
                        || $subject_type == config('constants.ROLE_CASHIER') || $subject_type == config('constants.SHIFT_CASHIER')){
                            $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'/'.$subject_type.'"><span class="fa fa-info">&nbsp;</span>'.'</a>';
                        }else{
                            $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'"><span class="fa fa-info">&nbsp;</span>'.'</a>';
                        }
                    }
                }
                $i3++;
            }

            $count = 0;
            foreach($arr3 as $r){
                $count++;
            }
            if($count > 1){
                $tree = $this->buildTree($arr3, 'parentId', 'id');
                //$tree2 = $this->buildTree2($arr3, 0);
                $response = array();

                $response = $tree;

                return response()->json(
                    [$response]
                );

                /*return response()->json([
                    'result' => $list_affiliates,
                    'status' => 1,
                    'count' => $count
                ]);*/
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

    function buildTree2(array $elements, $parentId) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parentId'] == $parentId) {
                $children = $this->buildTree2($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;

            }
        }

        return $branch;
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

    private function arraytotree(&$inArray, &$outArray, $currentParentId = 1){
        if(!is_array($inArray))return;
        if(!is_array($outArray))return;
        foreach($inArray as $key => $tuple){
            if($tuple['id'] == $currentParentId) {
                $tuple['children'] = array();
                $tuple['leaf'] = false;
                $this->arraytotree($inArray, $tuple['children'], $tuple['id']);
                if(count($tuple['children']) == 0){
                    $tuple['leaf'] = true;
                }
                $outArray[] = $tuple;
            }
        }
    }

    private function objectstotree(&$inArray, &$outArray, $currentParentId = 0){
        if(!is_array($inArray))return;
        if(!is_array($outArray))return;
        foreach($inArray as $key => $tuple){
            if($tuple->subject_id_to == $currentParentId) {
                $tuple['children'] = array();
                $tuple['leaf'] = false;
                $this->arraytotree($inArray, $tuple['children'], $tuple->subject_id_to);
                if(count($tuple['children']) == 0){
                    $tuple['leaf'] = true;
                }
                $outArray[] = $tuple;
            }
        }
    }

    public function searchEntity(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $parent_user_id = $authSessionData['parent_id'];
        $logged_in_id = $authSessionData['user_id'];

        $username = $request->get('username');
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $city = $request->get('city');
        $country_id = $request->get('country_id');
        $mobile_phone = $request->get('mobile_phone');
        $currency = $request->get('currency');
        //$banned_status = $request->get('banned_status');
        $subject_type_id = $request->get('subject_type');
        $affiliate_id = $request->get('affiliate_id', $parent_user_id);
        $show_banned = $request->get('show_banned');

        //$subjectTypes = SubjectTypeModel::listStructureEntitySubjectTypes();
        $subjectTypes = SubjectTypeModel::listNewStructureEntitySubjectTypes($logged_in_id);
        $subjectTypesResult = $subjectTypes["result"];
        $list_subject_types = [];
        //dd($subjectTypesResult);
            foreach ($subjectTypesResult as $r){
                $obj = new \stdClass();
                $obj->subject_type_id = $r->subject_dtype_id;
                $obj->subject_type_name = $r->subject_dtype_bo_name;
                $list_subject_types[] = $obj;
            }

        if(strlen($affiliate_id) == 0) {
            $affiliate_id = $parent_user_id;
        }

        $resultCurrencyList = CurrencyModel::listCurrencies($backoffice_session_id);
        $list_currencies = array();
        foreach($resultCurrencyList['list_currency'] as $curr){
          $list_currencies[$curr->currency] = $curr->currency;
        }

        $countries = CommonModel::listCountries($backoffice_session_id);
        $list_countries = [];

        foreach($countries['list_countries'] as $country) {
            $list_countries[$country->country_code] = $country->name;
        }

        $list_show_banned = [
          "" => trans("authenticated.All"),
          "1" => trans("authenticated.Active"),
          "-1" => trans("authenticated.Inactive"),
        ];

         $resultListFilterUsers = CustomerModel::listCustomers($backoffice_session_id);
         $list_filter_users = [];
         foreach($resultListFilterUsers['list_customers'] as $user){
           $list_filter_users[$user->subject_id] = $user->username;
         }

          $resultSearchUsers = StructureEntityModel::searchEntity($backoffice_session_id, $username, $first_name,
            $last_name, $email, $city, $country_id, $mobile_phone, $currency, $show_banned, $subject_type_id, $affiliate_id);

         if($request->has('small')){
             $view_name = '/authenticated/structure-entity/search-entity-small';
         }
         else if($request->has('large')){
             $view_name = '/authenticated/structure-entity/search-entity';
         }
         else {
             $view_name = $request->exists('large_tag') ? '/authenticated/structure-entity/search-entity' : '/authenticated/structure-entity/search-entity-small';
         }

         //dd($subject_type_id);

          return view(
              $view_name,
              array(
                  "username" => $username,
                  "first_name" => $first_name,
                  "last_name" => $last_name,
                  "email" => $email,
                  "city" => $city,
                  "mobile_phone" => $mobile_phone,
                  "subject_type" => $subject_type_id,
                  "country_id" => $country_id,
                  "affiliate_id" => $affiliate_id,
                  "currency" => $currency,
                  "show_banned" => $show_banned,

                  "list_filter_users" => $list_filter_users,
                  "list_show_banned" => $list_show_banned,
                  "list_subject_types" => $list_subject_types,
                  "list_currency" => $list_currencies,
                  "list_countries" => $list_countries,
                  "list_users" => $resultSearchUsers['list_users'],
              )
          );
    }

    public function updateEntity($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        $languages = UserModel::listLanguages();
        $account_active_options = UserModel::listAccountActiveOptions();
        $resultUserInformation = UserModel::userInformation($user_id);
        $countries = CommonModel::listCountries($backoffice_session_id);

        $list_countries = [];
        foreach($countries['list_countries'] as $country) {
            $list_countries[$country->country_code] = $country->name;
        }

        //dd($resultUserInformation['user']['subject_type']);

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                $language = \App::getLocale();
                return \Redirect::to('/'. $language .'/structure-entity/search-entity');
            }

            //validation rules
            if($resultUserInformation['user']['subject_type'] == config("constants.LOCATION_TYPE_NAME")){
                $rules = [
                    'username' => 'required|min:2|max:20',
                    'email' => 'required|email|min:4|max:50',
                    'mobile_phone' => 'required|min:2|max:20',
                    'address' => 'required|min:2|max:40',
                    'commercial_address' => 'required|min:2|max:40',
                    'city' => 'required|min:2|max:40',
                    'country' => 'required|min:1|max:40',
                    'language' => 'required|min:4|max:6',
                    'currency' => 'required|min:3|max:3',
                ];
            }else {
                $rules = [
                    'username' => 'required|min:2|max:20',
                    'email' => 'required|email|min:4|max:50',
                    'mobile_phone' => 'required|min:2|max:20',
                    //'last_name' => 'required|min:2|max:40',
                    //'address' => 'required|min:2|max:40',
                    //'city' => 'required|min:2|max:40',
                    'country' => 'required|min:1|max:40',
                    'language' => 'required|min:4|max:6',
                    'currency' => 'required|min:3|max:3',
                ];
            }

            $messages = [
                'confirm_password.same' => __("authenticated.The Confirm Password and Password must match"),
            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'mobile_phone' => __("authenticated.Mobile Phone"),
                'email' => __("authenticated.Email"),
                'first_name' => __("authenticated.First Name"),
                'last_name' => __("authenticated.Last Name"),
                'address' => __("authenticated.Address"),
                'commercial_address' => __("authenticated.Address 2"),
                'city' => __("authenticated.City"),
                'country' => __("authenticated.Country"),
                'currency' => __("authenticated.Currency"),
                'language' => __("authenticated.Language"),
            ];

            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){
                $user = array(
                    'username'=>$request->get('username'),
                    'email'=>$request->get('email'),
                    'first_name'=>$request->get('first_name'),
                    'last_name'=>$request->get('last_name'),
                    'currency'=>$request->get('currency'),
                    'parent_name'=>$resultPersonalInformation['user']['username'],
                    'registered_by'=>$resultPersonalInformation['user']['username'],
                    'subject_type_id'=>config("constants.PLAYER_TYPE_ID"),
                    'subject_type_name'=>$resultPersonalInformation['user']['subject_type'],
                    'language'=>$request->get('language'),
                    'edited_by'=>$resultPersonalInformation['user']['user_id'],
                    'user_id'=>$user_id,
                    'active'=>$request->get('account_active'),
                    'address'=>$request->get('address'),
                    'city'=>$request->get('city'),
                    'country'=>$request->get('country'),
                    'mobile_phone'=>$request->get('mobile_phone'),
                    'post_code'=>$request->get('post_code'),
                    'commercial_address'=>$request->get('commercial_address'),
                );

                $resultUpdateUserInformation = UserModel::updateUser($user);
                if($resultUpdateUserInformation['status'] == "OK"){

                    $resultUserInformation = UserModel::userInformation($user_id);
                    return view(
                        '/authenticated/structure-entity/update-entity',
                        array(
                            "user_id" => $user_id,
                            "languages"=>$languages,
                            "account_active_options"=>$account_active_options,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "user" => $resultUserInformation['user'],
                            "list_countries"=>$list_countries
                        )
                    )->with("success_message", __("authenticated.Changes saved"));
                }else{
                    $resultUserInformation = UserModel::userInformation($user_id);

					if($resultUpdateUserInformation["message"] == "GENERAL_ERROR"){
						$error_message = __("authenticated.Changes not saved");
					}
					if($resultUpdateUserInformation["message"] == "EMAIL NOT AVAILABLE"){
						$error_message = __("authenticated.Email is not available");
					}
					if($resultUpdateUserInformation["message"] == "USERNAME NOT AVAILABLE"){
						$error_message = __("authenticated.Username is not available");
					}

                    return view(
                        '/authenticated/structure-entity/update-entity',
                        array(
                            "user_id" => $user_id,
                            "languages"=>$languages,
                            "account_active_options"=>$account_active_options,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "user" => $resultUserInformation['user'],
                            "list_countries"=>$list_countries
                        )
                    )->with("error_message", $error_message);
                }
            }
        }

        //dd($resultUserInformation['user']);

        return view(
            '/authenticated/structure-entity/update-entity',
            array(
                "user_id" => $user_id,
                "languages"=>$languages,
                "account_active_options"=>$account_active_options,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "user" => $resultUserInformation['user'],
                "list_countries"=>$list_countries,
            )
        );
    }

    public function changePassword($user_id, Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultUserInformation = UserModel::userInformation($user_id);

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                $language = \App::getLocale();
                return \Redirect::to('/'. $language .'/structure-entity/search-entity');
            }

            Validator::extend('without_spaces', function($attr, $value){
                return preg_match('/^\S*$/u', $value);
            });

            //match
            // a-z and A-Z and 0-9 - _
            // in username as allowed character
            Validator::extend('characters_allowed', function($attr, $value){
                return preg_match('/^[a-zA-Z0-9-_]*$/u', $value);
            });

            //validation rules
            $rules = [
                'username' => 'required|min:2|max:20',
                'password' => 'required|without_spaces|characters_allowed|min:4|max:40',
                'confirm_password' => 'required|without_spaces|characters_allowed|min:4|max:40|same:password'
            ];

            $messages = [
                'confirm_password.same' => __("authenticated.The Confirm password and Password must match"),
                'password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                'password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                'confirm_password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                'confirm_password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'password' => __("authenticated.Password"),
                'confirm_password' => __("authenticated.Confirm Password"),
            ];

            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){
                $hashed_password = PasswordHasherHelper::make($request->get('password'));

                $details = array(
                    'user_id'=>$request->get('user_id'),
                    'backoffice_session_id'=>$backoffice_session_id,
                    'password'=>$hashed_password
                );

                $resultChangeUserPassword = UserModel::changePassword($details);
                if($resultChangeUserPassword['status'] == "OK"){
                    return view(
                        '/authenticated/structure-entity/change-password',
                        [
                            'user_id'=>$request->get('user_id'),
                            'user'=>$resultUserInformation['user']
                        ]
                    )->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return view(
                        '/authenticated/structure-entity/change-password',
                        [
                            'user_id'=>$request->get('user_id'),
                            'user'=>$resultUserInformation['user']
                        ]
                    )->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return view(
            '/authenticated/structure-entity/change-password',
            [
                'user_id'=>$request->get('user_id'),
                'user'=>$resultUserInformation['user']
            ]
        );
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeUserAccountStatus($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultUserInformation = UserModel::userInformation($user_id);

        $account_status = $resultUserInformation["user"]["active"];
        if($account_status == "1"){
            $account_status = "-1";
        }else{
            $account_status = "1";
        }

        $user = array(
            'user_id'=>$user_id,
            'active'=>$account_status,
        );

        $resultUpdateUserInformation = UserModel::updateSubjectState($user);
        if($resultUpdateUserInformation['status'] == "OK"){
            return redirect()->back();
        }else{
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function details($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        //$user_id_decrypt = Crypt::decrypt($user_id);

        $resultUserInformation = UserModel::userInformation($user_id);

        $resultCredits = TransferCreditModel::getCredits($user_id);

        $resultUserInformation['user']['credits'] = $resultCredits['credits'];

        //dd($resultUserInformation['user']);

        return view(
          '/authenticated/structure-entity/details',
          array(
              "user" => $resultUserInformation['user']
          )
        );
    }
}
