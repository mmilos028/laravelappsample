<?php

namespace App\Http\Controllers\Authenticated;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\Controller;
use App\Models\Postgres\PlayerModel;
use App\Models\Postgres\TerminalModel;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\CommonModel;
use App\Models\Postgres\TransferCreditModel;

use App\Helpers\PasswordHasherHelper;
use App\Helpers\NumberHelper;
use App\Helpers\ErrorHelper;
use Mcamara\LaravelLocalization\LaravelLocalization;

use Maatwebsite\Excel\Facades\Excel;

class TerminalController extends Controller
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

    public function returnDeactivatedTerminals(){
        return view("authenticated/terminal.list_deactivated_terminals");
    }

    public function listDisconnectedTerminals(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

            $result = TerminalModel::listDisconnectedTerminals($backoffice_session_id);
            $resultResult = $result["result"];
            $resultStatus = $result["status"];

            $result_processed = array();
            $laravelLocalized = new LaravelLocalization();

            if($resultStatus == "OK"){
                $i = 0;
                foreach ($resultResult as $result){
                    $url = "/terminal/details/user_id/";
                    $link = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$result->subject_id."/".$result->subject_dtype);
                    $result_processed[$i]["link"] = $link;
                    $result_processed[$i]["subject_id"] = $result->subject_id;
                    $result_processed[$i]["username"] = $result->username;
                    $result_processed[$i]["password"] = $result->password;
                    $result_processed[$i]["first_name"] = $result->first_name;
                    $result_processed[$i]["last_name"] = $result->last_name;
                    $result_processed[$i]["credits"] = $result->credits;
                    $result_processed[$i]["currency"] = $result->currency;
                    $result_processed[$i]["registration_date"] = $result->registration_date;
                    $result_processed[$i]["registered_by"] = $result->registered_by;
                    $result_processed[$i]["subject_dtype"] = $result->subject_dtype;
                    $result_processed[$i]["subject_dtype_id"] = $result->subject_dtype_id;
                    $result_processed[$i]["last_session_id"] = $result->last_session_id;
                    $result_processed[$i]["player_dtype"] = $result->player_dtype;
                    $result_processed[$i]["subject_state"] = $result->subject_state;
                    $result_processed[$i]["language"] = $result->language;
                    $result_processed[$i]["edited_by"] = $result->edited_by;
                    $result_processed[$i]["parent_id"] = $result->parent_id;
                    $result_processed[$i]["edit_datetime"] = $result->edit_datetime;
                    $result_processed[$i]["email"] = $result->email;
                    $result_processed[$i]["address"] = $result->address;
                    $result_processed[$i]["city"] = $result->city;
                    $result_processed[$i]["country"] = $result->country;
                    $result_processed[$i]["mobile_phone"] = $result->mobile_phone;
                    $result_processed[$i]["post_code"] = $result->post_code;
                    $result_processed[$i]["commercial_address"] = $result->commercial_address;
                    $result_processed[$i]["rec_create_user"] = $result->rec_create_user;
                    $result_processed[$i]["parent_username"] = $result->parent_username;
                    $result_processed[$i]["subject_path"] = $result->subject_path;
                    $result_processed[$i]["subject_dtype_bo_name"] = $result->subject_dtype_bo_name;
                    $i++;
                }
                $i = 0;

                return response()->json([
                    "status" => "OK",
                    "result" => $result_processed,
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => $resultResult,
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

    public function deactivateTerminal(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $subject_id = $request->input("subject_id");
            $mac_address = $request->input("mac_address");

            $terminal_model = new TerminalModel();
            $result = $terminal_model->deactivateTerminal($backoffice_session_id, $subject_id, $mac_address);

            if($result["status"] == "OK"){
                return response()->json([
                    "status" => $result["status"],
                    "message" => trans("authenticated.Success")
                ]);
            }else{
                return response()->json([
                    "status" => $result["status"],
                    "message" => trans("authenticated.Fail")
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "message" => trans("authenticated.Fail")
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "message" => trans("authenticated.Fail")
            ]);
        }
    }

    public function connectTerminal(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $subject_id = $request->input("subject_id");
            $mac_address = $request->input("mac_address");

            $rules = [
                "mac_address" => "required|regex:/^[0-9A-F]{2}(?=([-]?))(?:\\1[0-9A-F]{2}){5}$/"//
            ];
            $attributes = [
                "mac_address" => trans("authenticated.Mac Address")
            ];
            $messages = [
                "mac_address.required" => trans("authenticated.The :attribute field is required."),
                "mac_address.regex" => trans("authenticated.Invalid format for the :attribute field. Valid format is e.g. 00-1B-63-84-45-E6.")
            ];

            $validator = Validator::make($request->all(),$rules, $messages, $attributes);

            if ($validator->fails()){
                return response()->json(['message'=>$validator->errors()->all(), "success" => false]);
            }else{
                $terminal_model = new TerminalModel();
                $result = $terminal_model->connectTerminal($backoffice_session_id, $subject_id, $mac_address);

                if($result["status"] == "OK"){
                    return response()->json([
                        "status" => $result["status"],
                        "message" => trans("authenticated.Success.")
                    ]);
                }elseif($result["status"] == "TAKEN"){
                    return response()->json([
                        "status" => $result["status"],
                        "message" => trans("authenticated.Mad Address taken.")
                    ]);
                }else{
                    return response()->json([
                        "status" => $result["status"],
                        "message" => trans("authenticated.Fail.")
                    ]);
                }
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "message" => trans("authenticated.Fail")
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "message" => trans("authenticated.Fail")
            ]);
        }
    }

    public function disconnectTerminal(Request $request){
        try {
            $service_code = $request->input("service_code");

            $terminal_model = new TerminalModel();
            $result = $terminal_model->disconnectTerminal($service_code);

            if($result["status"] == "OK"){
                return response()->json([
                    "status" => $result["status"],
                    "message" => trans("authenticated.Success")
                ]);
            }else{
                return response()->json([
                    "status" => $result["status"],
                    "message" => trans("authenticated.Fail")
                ]);
            }
        }catch(\PDOException $ex1){
            $message = $ex1->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "message" => trans("authenticated.Fail")
            ]);
        }catch(\Exception $ex2){
            $message = $ex2->getMessage();
            ErrorHelper::writeError($message, $message);

            return response()->json([
                "status" => "NOK",
                "message" => trans("authenticated.Fail")
            ]);
        }
    }

    public function changePassword($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultTerminalInformation = TerminalModel::terminalInformation($user_id);

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                return \Redirect::to('/' . app()->getLocale() . '/terminal/list-terminals');
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
                'username' => 'required',
                'password' => 'required|without_spaces|characters_allowed|min:4|max:40',
                'confirm_password' => 'required|without_spaces|characters_allowed|min:4|max:40|same:password'
            ];

            $messages = [
                'confirm_password.same' => __("authenticated.The confirm password and password must match"),
            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'password' => __("authenticated.Password"),
                'confirm_password' => __("authenticated.Confirm Password"),
            ];

            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){

                //$hashed_password = PasswordHasherHelper::make($request->get('password'));
				$hashed_password = $request->get('password');

                $details = array(
                    'user_id'=>$request->get('user_id'),
                    'backoffice_session_id'=>$backoffice_session_id,
                    'password'=>$hashed_password
                );

                $resultChangeTerminalPassword = TerminalModel::changePassword($details);
                if($resultChangeTerminalPassword['status'] == "OK"){
                    return view(
                        '/authenticated/terminal/change-password',
                        [
                            'user'=>$resultTerminalInformation['user']
                        ]
                    )->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return view(
                        '/authenticated/terminal/change-password',
                        [
                            'user'=>$resultTerminalInformation['user']
                        ]
                    )->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return view(
            '/authenticated/terminal/change-password',
            [
                'user'=>$resultTerminalInformation['user']
            ]
        );
    }

    public function updateTerminal($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        $languages = UserModel::listLanguages();

        $account_active_options = UserModel::listAccountActiveOptions();
        $resultTerminalInformation = TerminalModel::terminalInformation($user_id);
        $countries = CommonModel::listCountries($backoffice_session_id);

        $list_countries = [];
        foreach($countries['list_countries'] as $country) {
            $list_countries[$country->country_code] = $country->name;
        }

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                return \Redirect::to('/' . app()->getLocale() . '/terminal/list-terminals');
            }

            //validation rules
            $rules = [
                'username' => 'required|min:2|max:40',
                'mobile_phone' => 'required|min:2|max:50',
                'email' => 'required|email|min:4|max:50',
                'first_name' => 'nullable|min:2|max:20',
                'last_name' => 'nullable|min:2|max:40',
                'language' => 'required|min:4|max:6',
                'currency' => 'required|min:3|max:3',
                //'address' => 'required|min:2|max:40',
                //'city' => 'required|min:2|max:40',
                'country' => 'required',
            ];

            $messages = [
                'confirm_password.same' => __("authenticated.The confirm password and password must match"),
            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'mobile_phone' => __("authenticated.Mobile Phone"),
                'email' => __("authenticated.Email"),
                'first_name' => __("authenticated.First Name"),
                'last_name' => __("authenticated.Last Name"),
                'address' => __("authenticated.Address"),
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
                    'player_type_name'=>config("constants.PLAYER_TYPE_NAME"),
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

                $resultUpdateTerminalInformation = TerminalModel::updateTerminal($user);
                if($resultUpdateTerminalInformation['status'] == "OK"){
                    $resultTerminalInformation = TerminalModel::terminalInformation($user_id);
                    return view(
                        '/authenticated/terminal/update-terminal',
                        array(
                            "languages"=>$languages,
                            "account_active_options"=>$account_active_options,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "user" => $resultTerminalInformation['user'],
                            "list_countries"=>$list_countries,
                        )
                    )->with("success_message", __("authenticated.Changes saved"));
                }else{
                    $resultPlayerInformation = TerminalModel::terminalInformation($user_id);
					
					if($resultUpdateTerminalInformation["message"] == "GENERAL_ERROR"){
						$error_message = __("authenticated.Changes not saved");
					}
					if($resultUpdateTerminalInformation["message"] == "EMAIL NOT AVAILABLE"){
						$error_message = __("authenticated.Email is not available");
					}
					if($resultUpdateTerminalInformation["message"] == "USERNAME NOT AVAILABLE"){
						$error_message = __("authenticated.Username is not available");
					}
                    return view(
                        '/authenticated/terminal/update-terminal',
                        array(
                            "languages"=>$languages,
                            "account_active_options"=>$account_active_options,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "user" => $resultPlayerInformation['user'],
                            "list_countries"=>$list_countries
                        )
                    )->with("error_message", $error_message);
                }
            }
        }

        return view(
            '/authenticated/terminal/update-terminal',
            array(
                "user_type" => $resultTerminalInformation['user']["subject_type"],
                "languages"=>$languages,
                "account_active_options"=>$account_active_options,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "user" => $resultTerminalInformation['user'],
                "list_countries"=>$list_countries
            )
        );
    }

    public function newTerminal(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        $languages = UserModel::listLanguages();
        $countries = CommonModel::listCountries($backoffice_session_id);
		
		$subject_types = UserModel::listTerminalSubjectTypes();

        $list_countries = [];
        foreach($countries['list_countries'] as $country) {
            $list_countries[$country->country_code] = $country->name;
        }

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                $language = \App::getLocale();
                return \Redirect::to('/'. $language .'/terminal/list-terminals');
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
                'email' => 'required|email|min:4|max:50',
                'first_name' => 'required|min:2|max:20',
                'last_name' => 'required|min:2|max:40',
                'language' => 'required|min:4|max:6',
                'currency' => 'required|min:3|max:3',
                //'address' => 'required|min:2|max:40',
                //'city' => 'required|min:2|max:40',
                'country' => 'required|min:2|max:40',
            ];

            $messages = [
                'confirm_password.same' => __("authenticated.The confirm password and password must match"),
                'username.without_spaces' => __("authenticated.:attribute is not allowed to contain empty spaces."),
                'username.characters_allowed' => __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                'subject_type.required' => __("authenticated.Subject Type field is required."),
                'subject_type.parent_affiliate' => __("authenticated.Parent Affiliate field is required."),
                'username.required' => __("authenticated.Username is required."),
                'username.min' => __("authenticated.Minimum character length for username is :min."),
                'username.max' => __("authenticated.Maximum character length for username is :max."),
                'password.required' => __("authenticated.Password is required."),
                'password.min' => __("authenticated.Minimum character length for password is :min."),
                'password.max' => __("authenticated.Maximum character length for password is :max."),
                'password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                'password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -"),
                'confirm_password.required' => __("authenticated.Password confirmation is required."),
                'confirm_password.min' => __("authenticated.Minimum character length for password confirmation is :min."),
                'confirm_password.max' => __("authenticated.Maximum character length for password confirmation is :max."),
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
                'username' => __("authenticated.Username"),
                'password' => __("authenticated.Password"),
                'confirm_password' => __("authenticated.Confirm Password"),
                'mobile_phone' => __("authenticated.Mobile Phone"),
                'email' => __("authenticated.Email"),
                'first_name' => __("authenticated.First Name"),
                'last_name' => __("authenticated.Last Name"),
                'currency' => __("authenticated.Currency"),
                'language' => __("authenticated.Language"),
                'address' => __("authenticated.Address"),
                'city' => __("authenticated.City"),
                'country' => __("authenticated.Country"),
            ];

            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){

                //$hashed_password = PasswordHasherHelper::make($request->get('password'));
				$hashed_password = $request->get('password');

                $user = array(
                    'username'=>$request->get('username'),
                    'password'=>$hashed_password,
                    'email'=>$request->get('email'),
                    'first_name'=>$request->get('first_name'),
                    'last_name'=>$request->get('last_name'),
                    'currency'=>$request->get('currency'),
                    'parent_name'=>$resultPersonalInformation['user']['username'],
                    'registered_by'=>$resultPersonalInformation['user']['username'],
                    'subject_type_id'=>$request->get('subject_type'),
                    'player_type_name'=>config("constants.PLAYER_TYPE_NAME"),
                    'language'=>$request->get('language'),
                    'address'=>$request->get('address'),
                    'city'=>$request->get('city'),
                    'country'=>$request->get('country'),
                    'mobile_phone'=>$request->get('mobile_phone'),
                    'post_code'=>$request->get('post_code'),
                    'commercial_address'=>''
                );

                $resultInsertPlayerInformation = TerminalModel::createUser($user);				
                if($resultInsertPlayerInformation['status'] == "OK"){
					$subject_type_id = $request->get('subject_type');
					if($subject_type_id == config('constants.TERMINAL_CASHIER_TYPE_ID')){
						$resultSetServiceKeyForTerminal = TerminalModel::setServiceKeyForTerminal($resultInsertPlayerInformation['subject_id']);
						if($resultSetServiceKeyForTerminal['status'] == "OK") {
							return view(
								'/authenticated/terminal/new-terminal',
								array(
									"languages"=>$languages,
									"list_currency"=>$resultPersonalInformation['list_currency'],
									"logged_in_user"=>$resultPersonalInformation['user'],
									"list_countries"=>$list_countries,
									"list_subject_types"=>$subject_types,
									"user" => $user
								)
							)->with("success_message", __("authenticated.Changes saved"));
						}else{
							return view(
								'/authenticated/terminal/new-terminal',
								array(
									"languages"=>$languages,
									"list_currency"=>$resultPersonalInformation['list_currency'],
									"logged_in_user"=>$resultPersonalInformation['user'],
									"list_countries"=>$list_countries,
									"list_subject_types"=>$subject_types,
									"user" => $user
								)
							)->with("success_message", __("authenticated.Terminal created, but service key not set !"));
						}
					}else{
						return view(
							'/authenticated/terminal/new-terminal',
							array(
								"languages"=>$languages,
								"list_currency"=>$resultPersonalInformation['list_currency'],
								"logged_in_user"=>$resultPersonalInformation['user'],
								"list_countries"=>$list_countries,
								"list_subject_types"=>$subject_types,
								"user" => $user
							)
						)->with("success_message", __("authenticated.Changes saved"));
					}
                }else{
					if($resultInsertPlayerInformation["message"] == "GENERAL_ERROR"){
						$error_message = __("authenticated.Changes not saved");
					}
					if($resultInsertPlayerInformation["message"] == "EMAIL NOT AVAILABLE"){
						$error_message = __("authenticated.Email is not available");
					}
					if($resultInsertPlayerInformation["message"] == "USERNAME NOT AVAILABLE"){
						$error_message = __("authenticated.Username is not available");
					}
					
                    return view(
                        '/authenticated/terminal/new-terminal',
                        array(
                            "languages"=>$languages,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "logged_in_user"=>$resultPersonalInformation['user'],
                            "list_countries"=>$list_countries,
							"list_subject_types"=>$subject_types,
							"user" => $user
                        )
                    )->with("error_message", $error_message)->with_input();
                }
            }
        }

        return view(
            '/authenticated/terminal/new-terminal',
            array(
                "languages"=>$languages,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "logged_in_user"=>$resultPersonalInformation['user'],
                "list_countries"=>$list_countries,
				"list_subject_types"=>$subject_types,
            )
        );
    }

    public function listTerminals(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListTerminals = UserModel::listPlayersByType($backoffice_session_id, config("constants.TERMINAL_TV_TYPE_ID"));
        //dd($resultListTerminals['list_users']);
        return view(
            '/authenticated/terminal/list-terminals',
            array(
                "list_terminals" => $resultListTerminals['list_users'],
            )
        );
    }

    public function details($user_id, $subject_type, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultTerminalInformation = TerminalModel::terminalInformation($user_id);

        $terminalCodes = TerminalModel::listTerminalMaschineKeyAndCodes($backoffice_session_id, $user_id);

        $resultCredits = TransferCreditModel::getCredits($user_id);

        $resultTerminalInformation['user']['credits'] = $resultCredits['credits'];

		return view(
			'/authenticated/terminal/details',
			array(
			    "user_id" => $user_id,
				"subject_type" => $subject_type,
				"user" => $resultTerminalInformation['user'],
                "terminal_keys_codes" => $terminalCodes["list_terminal_maschine_key_and_codes"],
                "subject_state" => $resultTerminalInformation["result"][0]->subject_state
			)
		);
    }
	
	public function checkServiceCode(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];


        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                return \Redirect::to('/' . app()->getLocale() . '/terminal/list-terminals');
            }

            //validation rules
            $rules = [
                'service_code' => 'required',
                'maschine_key' => 'required',
            ];

            $messages = [ ];

            $attributes = [
                'service_code' => __("authenticated.Service Code"),
                'maschine_key' => __("authenticated.Maschine Key")
            ];

            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('check')){
                
				$service_code = $request->get('service_code');
				$maschine_key = $request->get('maschine_key');

                $resultCheckServiceCode = TerminalModel::checkServiceCode($backoffice_session_id, $service_code, $maschine_key);
				// dd($resultCheckServiceCode);
                if($resultCheckServiceCode['status'] == "OK"){
					switch($resultCheckServiceCode['check_status']){
						case 1:
							$info_message = __("authenticated.Service code is valid");
							break;
						case -1:
							$info_message = __("authenticated.Terminal does not exist");
							break;
						case -2:
							$info_message = __("authenticated.Terminal is not registered");
							break;
						case -99:
							$info_message = __("authenticated.Unknown error occurred, please try again !");
							break;
						default:
							$info_message = __("authenticated.Unknown error occurred, please try again !");
							break;
					}	
					
                    return view(
                        '/authenticated/terminal/check-service-code',
						[
							'service_code' => $service_code,
							'maschine_key' => $maschine_key
						]
                    )->with("information_message", $info_message);
                }else{
                    return view(
                        '/authenticated/terminal/check-service-code'
                    )->with("error_message", __("authenticated.Unknown error occurred, please try again !"));
                }
            }
        }

        return view(
            '/authenticated/terminal/check-service-code'
        );
    }

    public function codeList($user_id, $user_type, Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListMaschineKeyCodes = TerminalModel::listTerminalMaschineKeyAndCodes($backoffice_session_id, $user_id);
        return view(
            '/authenticated/terminal/code-list',
            array(
                "user_id" => $user_id,
                "list_report" => $resultListMaschineKeyCodes['list_terminal_maschine_key_and_codes'],
            )
        );
    }

    public function createNewCode($user_id, Request $request){
        $resultSetServiceKeyForTerminal = TerminalModel::setServiceKeyForTerminal($user_id);
        if($resultSetServiceKeyForTerminal['status'] == "OK"){
            $success_message = __("authenticated.Service Key for terminal recreated");
            return redirect()->back()
            ->with("success_message", $success_message);
        }else{
            $error_message = __("authenticated.Changes not saved");
            return redirect()->back()
            ->with("error_message", $error_message);
        }
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

}
