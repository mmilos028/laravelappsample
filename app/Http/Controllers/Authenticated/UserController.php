<?php

namespace App\Http\Controllers\Authenticated;

use App\Helpers\NumberHelper;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

use App\Models\Postgres\UserModel;
use App\Models\Postgres\CommonModel;
use App\Models\Postgres\CashierModel;
use App\Models\Postgres\CurrencyModel;
use App\Models\Postgres\CustomerModel;
use App\Models\Postgres\DrawModelSetupModel;
use App\Models\Postgres\SubjectTypeModel;
use App\Models\Postgres\TransferCreditModel;

use App\Helpers\PasswordHasherHelper;
use App\Helpers\ErrorHelper;

class UserController extends Controller
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

    public function returnNewUserView(){
        return view("authenticated/user.new-user-2");
    }
    public function returnUsersStructureView(){
        return view("authenticated/user.list-users-tree");
    }

    public function newUser2(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $logged_in_id = $authSessionData['user_id'];
        $language = \App::getLocale();

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);

        if($request->ajax()) {

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
                //'mobile_phone' => 'required|min:2|max:50',
                //'email' => 'required|email|min:4|max:200',
                //'first_name' => 'required|min:2|max:20',
                //'last_name' => 'required|min:2|max:40',
                //'address' => 'required|min:2|max:40',
                //'city' => 'required|min:2|max:40',
                'country' => 'required|min:1|max:40',
                'language' => 'required|min:4|max:6',
                'currency_hidden' => 'required|min:3|max:3',
                'currency' => 'required|min:3|max:3',
            ];

            $messages = [
                'username.required' => __("authenticated.Username is required."),
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
            $user = array(
                'username'=>$request->get('username'),
                'password'=>$hashed_password,
                'first_name'=>$request->get('first_name'),
                'last_name'=>$request->get('last_name'),
                'currency'=>$request->get('currency_hidden'),
                //'parent_name'=>$resultPersonalInformation['user']['username'],
                'parent_name'=>$request->get('sub_subject_hidden'),
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

            //var_dump($resultInsertUserInformation);

            if($resultInsertUserInformation['status'] == "OK"){
                $subject_type_id = $request->get('subject_type');

                if(in_array($request->get('subject_type'),
                    array(config('constants.CASHIER_TYPE_ID'))
                )){
                    $user_id = $resultInsertUserInformation['subject_id'];
                    $resultSetCashierPinCode = CashierModel::setCashierPinCode($backoffice_session_id, $user_id);
                    if($resultSetCashierPinCode['status'] == "OK"){
                        $resultGetCashierPinCode = CashierModel::getCashierPinCode($backoffice_session_id, $user_id);
                        $information_message = __("authenticated.User successfully created.") . " " . __("authenticated.Cashier PIN Code") . ": " . $resultGetCashierPinCode['cashier_pin_code'];
                        return \Redirect::to('/' .$language .'/user/new-user')
                            ->with("information_message", $information_message);
                    }else{
                        $error_message = __("authenticated.User is created, but cashier pin code not generated successfully.");
                        return \Redirect::to('/' .$language .'/user/new-user')
                            ->with("error_message", $error_message);
                    }
                }
                $success_message = __("authenticated.User successfully created.");
                //var_dump($resultInsertUserInformation['status']);
                return \Redirect::to('/' .$language .'/user/new-user')
                    ->with("success_message", $success_message);
            }else{
                //var_dump($resultInsertUserInformation['status']);
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
                return \Redirect::to('/' .$language .'/user/new-user')
                    ->with("error_message", $error_message);
            }
        }
    }


    public function newUser(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $logged_in_id = $authSessionData['user_id'];
        $language = \App::getLocale();

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        $languages = UserModel::listLanguages();
        $subSubjects = UserModel::listAffiliates($backoffice_session_id);
        $subjectTypes = SubjectTypeModel::listBOSubjectTypesForUserNewUser($logged_in_id);
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

        $countries = CommonModel::listCountries($backoffice_session_id);

        $listCountries = [];
        foreach($countries['list_countries'] as $country) {
            $listCountries[$country->country_code] = $country->name;
        }

        $resultListDrawModels = DrawModelSetupModel::listDrawModels($backoffice_session_id);

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                /*return view(
                    '/authenticated/user/new-user',
                    array(
                        "languages"=>$languages,
                        "list_currency"=>$resultPersonalInformation['list_currency'],
                        "logged_in_user"=>$resultPersonalInformation['user'],
                        "list_subject_types"=>$subjectTypesResultProcessed,
                        "list_countries"=>$listCountries,
                        "list_draw_models"=>$resultListDrawModels['list_draw_models']
                    )
                );*/

                return \Redirect::to('/' .$language .'/user/new-user');
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
                'username.required' => __("authenticated.Username is required."),
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

            if(!in_array($request->get('subject_type'),
                array(config('constants.TERMINAL_CASHIER_TYPE_ID'), config('constants.TERMINAL_TYPE_ID'), config('constants.PLAYER_TYPE_ID')))
            ){
                $hashed_password = PasswordHasherHelper::make($request->get('password'));
            }else{
                $hashed_password = $request->get('password');
            }

            if(in_array($request->get('subject_type'),
                array(config('constants.CASHIER_TYPE_ID')))
            ){
                if(strlen($request->get('city')) == 0){
                    $error_message = __("authenticated.City is required field");
                    return \Redirect::to('/' .$language .'/user/new-user')
                        ->with("error_message", $error_message);
                }
                if(strlen($request->get('address'))){
                    $error_message = __("authenticated.Address is required field");
                    return \Redirect::to('/' .$language .'/user/new-user')
                        ->with("error_message", $error_message);
                }
                if(strlen($request->get('commercial_address'))){
                    $error_message = __("authenticated.Address 2 is required field");
                    return \Redirect::to('/' .$language .'/user/new-user')
                        ->with("error_message", $error_message);
                }
            }


            if($request->has('save')){
                $user = array(
                    'username'=>$request->get('username'),
                    'password'=>$hashed_password,
                    'first_name'=>$request->get('first_name'),
                    'last_name'=>$request->get('last_name'),
                    'currency'=>$request->get('currency_hidden'),
                    //'parent_name'=>$resultPersonalInformation['user']['username'],
                    'parent_name'=>$request->get('sub_subject_hidden'),
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

                    if(in_array($request->get('subject_type'),
                        array(config('constants.CASHIER_TYPE_ID'))
                    )){
                        $user_id = $resultInsertUserInformation['subject_id'];
                        $resultSetCashierPinCode = CashierModel::setCashierPinCode($backoffice_session_id, $user_id);
                        if($resultSetCashierPinCode['status'] == "OK"){
                            $resultGetCashierPinCode = CashierModel::getCashierPinCode($backoffice_session_id, $user_id);
                            $information_message = __("authenticated.User successfully created.") . " " . __("authenticated.Cashier PIN Code") . ": " . $resultGetCashierPinCode['cashier_pin_code'];
                            return \Redirect::to('/' .$language .'/user/new-user')
                                ->with("information_message", $information_message);
                        }else{
                            $error_message = __("authenticated.User is created, but cashier pin code not generated successfully.");
                            return \Redirect::to('/' .$language .'/user/new-user')
                                ->with("error_message", $error_message);
                        }
                    }

                    $success_message = __("authenticated.User successfully created.");

                    //var_dump($resultInsertUserInformation['status']);

                    return \Redirect::to('/' .$language .'/user/new-user')
                        ->with("success_message", $success_message);


                    /*if($subject_type_id == config('constants.AFFILIATE_TYPE_ID')) {
                        $draw_model_id = $request->get('draw_model_id');

                        $resultDrawModelToAffiliate = DrawModelSetupModel::addDrawModelToAffiliate($backoffice_session_id, $resultInsertUserInformation['subject_id'], $draw_model_id);
                        if($resultDrawModelToAffiliate['status'] == 'OK') {

                            return \Redirect::to('/' .$language .'/user/new-user')
                                ->with("success_message", __("authenticated.Changes saved"));

                            return view(
                                '/authenticated/user/new-user',
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
                            return \Redirect::to('/' .$language .'/user/new-user')
                                ->with("success_message", __("authenticated.Affiliate created, but draw model not connected !"));
                            return view(
                                '/authenticated/user/new-user',
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
                    }else{
                        return \Redirect::to('/' .$language .'/user/new-user')
                            ->with("success_message", __("authenticated.Changes saved"));
                    }*/
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

                    return \Redirect::to('/' .$language .'/user/new-user')
                        ->with("error_message", $error_message);

                    /*return view(
                        '/authenticated/user/new-user',
                        array(
                            "languages"=>$languages,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "logged_in_user"=>$resultPersonalInformation['user'],
                            "list_subject_types"=>$subjectTypesResultProcessed,
                            "list_countries"=>$listCountries,
                            "list_draw_models"=>$resultListDrawModels['list_draw_models']
                        )
                    )->with("error_message", $error_message);*/
                }
            }
        }
        return view(
            '/authenticated/user/new-user',
            array(
                "languages"=>$languages,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "logged_in_user"=>$resultPersonalInformation['user'],
                "list_subject_types"=>$subjectTypesResultProcessed,
                "list_countries"=>$listCountries,
                "list_sub_subjects"=>$subSubjects['list_affiliates'],
                "list_draw_models"=>$resultListDrawModels['list_draw_models']
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocationAddressInformation(Request $request){
        try {

            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
            $location_id = $resultPersonalInformation['user']['user_id'];
            //dd($resultPersonalInformation);

            $resultLocationAddressInformation = CashierModel::getLocationAddress($backoffice_session_id, $location_id);

            //var_dump($resultLocationAddressInformation);

            if($resultLocationAddressInformation['status'] == "OK"){
                return response()->json([
                    "status" => "OK",
                    "location_id" => $location_id,
                    "city" => $resultLocationAddressInformation['city'],
                    "address" => $resultLocationAddressInformation['address'],
                    "commercial_address" => $resultLocationAddressInformation['commercial_address']
                ]);
            }else{
                return response()->json([
                    "status" => "NOK"
                ]);
            }
        }catch(\PDOException $ex2){
            return response()->json([
                "status" => "NOK",
            ]);
        }catch(\Exception $ex4){
            return response()->json([
                "status" => "NOK",
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchUsers(Request $request){
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
        $affiliate_id = $request->get('affiliate_id');
        $show_banned = $request->get('show_banned');

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $logged_in_id = $authSessionData['user_id'];

        //$listSubjectTypes = SubjectTypeModel::listSubjectTypesForUserSearchUser();
        $subjectTypes = SubjectTypeModel::listBOSubjectTypesForUserNewUser($logged_in_id);
        $subjectTypesResult = $subjectTypes["result"];
        $subjectTypesResultProcessed = array();

        $i = 0;
        //dd($subjectTypesResult);
        foreach ($subjectTypesResult as $r){
            $obj = new \stdClass();
            $obj->subject_type_id = $r->subject_dtype_id;
            $obj->subject_type_name = $r->subject_dtype_bo_name;
            if($r->subject_dtype != config("constants.PLAYER_TYPE_NAME")){
                $subjectTypesResultProcessed[] = $obj;
                $i++;
            }
        }
        $i = 0;

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

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

        $resultSearchUsers = UserModel::searchUsers($backoffice_session_id, $username, $first_name,
            $last_name, $email, $city, $country_id, $mobile_phone, $currency, $show_banned, $subject_type_id, $affiliate_id);

        //dd($resultSearchUsers);

        if($request->has('small')){
            $view_name = '/authenticated/user/search-users-small';
        }
        else if($request->has('large')){
            $view_name = '/authenticated/user/search-users';
        }else {
            $view_name = $request->exists('large_tag') ? '/authenticated/user/search-users' : '/authenticated/user/search-users-small';
        }

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
                "list_subject_types" => $subjectTypesResultProcessed,
                "list_currency" => $list_currencies,
                "list_countries" => $list_countries,
                "list_users" => $resultSearchUsers['list_users']
            )
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

    public function personalInformationForHomePage(){
        try {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $resultPersonalInformation = UserModel::personalInformationForHomePage($backoffice_session_id);

            $personalInfoResult = array();

            $i = 0;
            foreach ($resultPersonalInformation["cur_result"] as $r){
                $personalInfoResult[$i]["subject_id"] = $r->subject_id;
                $personalInfoResult[$i]["username"] = $r->username;
                $personalInfoResult[$i]["first_name"] = $r->first_name;
                $personalInfoResult[$i]["last_name"] = $r->last_name;
                $personalInfoResult[$i]["email"] = $r->email;
                $personalInfoResult[$i]["registration_date"] = $r->registration_date;
                $personalInfoResult[$i]["subject_type"] = $r->subject_dtype;
                $personalInfoResult[$i]["subject_state"] = $r->subject_state;
                $personalInfoResult[$i]["language"] = $r->language;
                $personalInfoResult[$i]["parent_id"] = $r->parent_id;
                $personalInfoResult[$i]["parent_username"] = $r->parent_username;
                $personalInfoResult[$i]["mobile_phone"] = $r->mobile_phone;
                $personalInfoResult[$i]["post_code"] = $r->post_code;
                $personalInfoResult[$i]["country_id"] = $r->country_id;
                $personalInfoResult[$i]["address"] = $r->address;
                $personalInfoResult[$i]["city"] = $r->city;
                $personalInfoResult[$i]["country_name"] = $r->country_name;
                $personalInfoResult[$i]["credits"] = $r->credits;
                $personalInfoResult[$i]["commercial_address"] = $r->commercial_address;
                $personalInfoResult[$i]["currency"] = $r->currency;
                $personalInfoResult[$i]["last_login_date"] = $r->last_login_tmstp;
                $personalInfoResult[$i]["credits"] = $r->credits;
                $personalInfoResult[$i]["credits_formatted"] = NumberHelper::format_double($r->credits);

                $pos = strpos($r->last_login_tmstp, " ");
                $date_formatted = $r->last_login_tmstp;
                $date_formatted = substr_replace($date_formatted,"          ",$pos,1);

                $personalInfoResult[$i]["last_login_date_formatted"] = $date_formatted;

                $personalInfoResult[$i]["last_login_ip"] = $r->last_login_ip;
                if(empty($r->last_login_city)){
                    $personalInfoResult[$i]["last_login_city"] = "UNKNOWN";
                }else{
                    $personalInfoResult[$i]["last_login_city"] = $r->last_login_city;
                }
                if(empty($r->last_login_country)){
                    $personalInfoResult[$i]["last_login_country"] = "UNKNOWN";
                }else{
                    $personalInfoResult[$i]["last_login_country"] = $r->last_login_country;
                }
                $personalInfoResult[$i]["last_session_id"] = $r->last_session_id;
                $personalInfoResult[$i]["current_session_ip"] = $r->current_sess_ip;
                if(empty($r->current_sess_city)){
                    $personalInfoResult[$i]["current_session_city"] = "UNKNOWN";
                }else{
                    $personalInfoResult[$i]["current_session_city"] = $r->current_sess_city;
                }
                if(empty($r->current_sess_country)){
                    $personalInfoResult[$i]["current_session_country"] = "UNKNOWN";
                }else{
                    $personalInfoResult[$i]["current_session_country"] = $r->current_sess_country;
                }
                $personalInfoResult[$i]["current_session_country"] = $r->current_sess_country;
                $i++;
            }
            $i = 0;

            if($resultPersonalInformation['status'] == "OK"){

                return response()->json([
                    "status" => "OK",
                    "result" => $personalInfoResult,
                    "currency_result" => $resultPersonalInformation['cur_result_currency'],
                ]);


                /*return response()->json([
                    "status" => "OK",
                    "location_id" => $location_id,
                    "city" => $resultLocationAddressInformation['city'],
                    "address" => $resultLocationAddressInformation['address'],
                    "commercial_address" => $resultLocationAddressInformation['commercial_address']
                ]);*/
            }else{
                return response()->json([
                    "status" => "NOK",
                    "result" => null
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

    public function getSubjectRolesForNewUserForm(){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $subjectTypes = SubjectTypeModel::listBOSubjectTypesForUserNewUser($logged_in_id);
            $subjectTypesResult = $subjectTypes["result"];
            $subjectTypesResultProcessed = array();

            $i = 0;
            foreach ($subjectTypesResult as $r){
                /*if(
                    $authSessionData['subject_type_id'] == config("constants.ADMINISTRATOR_LOCATION_ID") &&
                    in_array($r->subject_dtype, array(config("contants.ROLE_ADMINISTRATOR_OPERATER"), config("constants.ROLE_SUPPORT_OPERATER"), config("constants.ROLE_SUPPORT_OPERATER")))){
                    continue;
                }
                */
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

    public function listCountries2(){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $countries = CommonModel::listCountries($backoffice_session_id);

            if($authSessionData['subject_type_id'] == config("constants.ADMINISTRATOR_LOCATION_ID")){
                $listCountries[$authSessionData['country_code']] = $authSessionData['country_name'];
            }else {
                $listCountries = [];
                foreach ($countries['list_countries'] as $country) {
                    $listCountries[$country->country_code] = $country->name;
                }
            }

            return response()->json([
                "status" => "OK",
                "result" => $countries['list_countries'],
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

    public function listCountries(){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $countries = CommonModel::listCountries($backoffice_session_id);

            if($authSessionData['subject_type_id'] == config("constants.ADMINISTRATOR_LOCATION_ID")){
                $listCountries[$authSessionData['country_code']] = $authSessionData['country_name'];
            }else {
                $listCountries = [];
                foreach ($countries['list_countries'] as $country) {
                    $listCountries[$country->country_code] = $country->name;
                }
            }

            return response()->json([
                "status" => "OK",
                "result" => $listCountries,
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

    public function listCurrencies(){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $backoffice_session_id = $authSessionData['backoffice_session_id'];


            if($authSessionData['subject_type_id'] == config("constants.ADMINISTRATOR_LOCATION_ID")) {
                $resultCurrencyList = [
                    "status" => "OK",
                    "list_currency" => [
                        [
                            "currency_id" => $authSessionData['currency'],
                            "currency" => $authSessionData['currency']
                        ]
                    ]
                ];
            }else{
                $resultCurrencyList = CurrencyModel::listCurrencies($backoffice_session_id);
            }

            return response()->json([
                "status" => "OK",
                "result" => $resultCurrencyList["list_currency"],
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

    public function listCurrenciesForStartEndDate(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_id = $authSessionData['user_id'];
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $startDate = $request->input("start_date");
            $endDate = $request->input("end_date");

            $resultCurrencyList = CurrencyModel::listCurrenciesForStartEndDate($backoffice_session_id, $startDate, $endDate);

            return response()->json([
                "status" => "OK",
                "result" => $resultCurrencyList["list_currency"],
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


    public function personalInformationLanguages(){
        try {

            $languages = UserModel::listLanguages();
            return response()->json([
                "status" => "OK",
                "result" => $languages,
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

    public function setSessionStartDate(Request $request){
        try {
            $start_date = $request->input("start_date");

            Session::put("auth.report_start_date", $start_date);

            return response()->json([
                "status" => "OK",
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

    public function setSessionEndDate(Request $request){
        try {
            $end_date = $request->input("end_date");

            Session::put("auth.report_end_date", $end_date);

            return response()->json([
                "status" => "OK",
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

    public function setLanguage(Request $request){
        try {
            $subject_id = session("auth.user_id");
            $language = $request->input("language");

            $locale = explode('_', $language);
            $locale = $locale[0];

            $result = UserModel::updateUserLanguage($subject_id, $language);
            $status = $result["status"];

            if($status == 1){
                \LaravelLocalization::setLocale($locale);
                \App::setLocale($locale);
                $current_url = env('APP_URL').$locale."/home_page";

                return response()->json([
                    "status" => "OK",
                    "subject_id" => $subject_id,
                    "url" => $current_url
                ]);
            }else{
                return response()->json([
                    "status" => "NOK",
                    "subject_id" => $subject_id,
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

    public function createNewUser(Request $request){
        try {
            //$message = "UserController::createNewUser(" . print_r($request->all(), true) . ")";
            //ErrorHelper::writeInfo($message, $message);

            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];
            $logged_in_id = $authSessionData['user_id'];

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

            Validator::extend('without_spaces', function($attr, $value){
                return preg_match('/^\S*$/u', $value);
            });

            //match
            // a-z and A-Z and 0-9 - _
            // in username as allowed character
            Validator::extend('characters_allowed', function($attr, $value){
                return preg_match('/^[a-zA-Z0-9-_]*$/u', $value);
            });

            /*if(in_array($request->get('subject_type'),
                array(config('constants.CASHIER_TYPE_ID')))
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
            }*/

            $rules = [
                'subject_type' => 'required',
                'parent_affiliate' => 'required',
                'username' => 'required|without_spaces|characters_allowed|min:2|max:40',
                'password' => 'required|without_spaces|characters_allowed|min:4|max:40',
                'confirm_password' => 'required|without_spaces|characters_allowed|min:4|max:40|same:password',
                //'mobile_phone' => 'required|min:2|max:50',
                //'email' => 'required|email|min:4|max:200',
                'country' => 'required|min:1|max:40',
                'language' => 'required|min:4|max:6',
                'currency' => 'required|min:3|max:3',
            ];

            $messages = [
                'subject_type.required' => __("authenticated.Subject Type field is required."),
                'subject_type.parent_affiliate' => __("authenticated.Parent Affiliate field is required."),
                'username.required' => __("authenticated.Username is required."),
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

            $validator = Validator::make($request->all(),$rules, $messages, $attributes);

            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all(), "success" => false]);
            }else{
                if($subject_type == config('constants.TERMINAL_TV_TYPE_ID')){
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

                    if(in_array($request->get('subject_type'),
                        array(config('constants.CASHIER_TYPE_ID'))
                    )){
                        $user_id = $resultInsertUserInformation['subject_id'];
                        $resultSetCashierPinCode = CashierModel::setCashierPinCode($backoffice_session_id, $user_id);
                        if($resultSetCashierPinCode['status'] == "OK"){
                            $resultGetCashierPinCode = CashierModel::getCashierPinCode($backoffice_session_id, $user_id);
                            $information_message = __("authenticated.User successfully created.") . " " . __("authenticated.Cashier PIN Code") . ": " . $resultGetCashierPinCode['cashier_pin_code'];

                            return response()->json([
                                "status" => "OK",
                                "subject_id" => $resultInsertUserInformation['subject_id'],
                                "message" => $information_message,
                                "success" =>  true
                            ]);
                        }else{
                            $error_message = __("authenticated.User is created, but cashier pin code not generated successfully.");

                            return response()->json([
                                "status" => "NOK",
                                "subject_id" => null,
                                "message" => $error_message,
                                "success" =>  true,
                                "true_status" => $resultInsertUserInformation["true_status"]
                            ]);
                        }
                    }

                    return response()->json([
                        "status" => "OK",
                        "subject_id" => $resultInsertUserInformation['subject_id'],
                        "message" => __("authenticated.Success"),
                        "success" =>  true
                    ]);

                }else{
                    if($resultInsertUserInformation["message"] == "GENERAL_ERROR"){
                        $error_message = __("authenticated.Changes not saved");
                    }
                    else if($resultInsertUserInformation["message"] == "EMAIL NOT AVAILABLE"){
                        $error_message = __("authenticated.Email is not available");
                    }
                    else if($resultInsertUserInformation["message"] == "USERNAME NOT AVAILABLE"){
                        $error_message = __("authenticated.Username is not available");
                    }else{
                        $error_message = __("authenticated.Changes not saved");
                    }

                    return response()->json([
                        "status" => "NOK",
                        "subject_id" => null,
                        "message" => $error_message,
                        "success" =>  true,
                        "true_status" => $resultInsertUserInformation["true_status"]
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

    public function updateUser($user_id, Request $request)
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

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                $language = \App::getLocale();
                return \Redirect::to('/'. $language .'/user/search-users');
            }

            //validation rules
            $rules = [
                'username' => 'required|min:2|max:40',
                'mobile_phone' => 'required|min:2|max:50',
                'email' => 'required|email|min:4|max:50',
                //'first_name' => 'required|min:2|max:20',
                //'last_name' => 'required|min:2|max:40',
                //'address' => 'required|min:2|max:40',
                //'city' => 'required|min:2|max:40',
                'country' => 'required|min:1|max:40',
                'language' => 'required|min:4|max:6',
                'currency' => 'required|min:3|max:3',
            ];

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
                        '/authenticated/user/update-user',
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
                        '/authenticated/user/update-user',
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
            '/authenticated/user/update-user',
            array(
                "user_id" => $user_id,
                "languages"=>$languages,
                "account_active_options"=>$account_active_options,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "user" => $resultUserInformation['user'],
                "list_countries"=>$list_countries
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
                return \Redirect::to('/'. $language .'/user/search-users');
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
                'username' => 'required|min:2|max:40',
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
                        '/authenticated/user/change-password',
                        [
                            'user_id'=>$request->get('user_id'),
                            'user'=>$resultUserInformation['user']
                        ]
                    )->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return view(
                        '/authenticated/user/change-password',
                        [
                            'user_id'=>$request->get('user_id'),
                            'user'=>$resultUserInformation['user']
                        ]
                    )->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return view(
            '/authenticated/user/change-password',
            [
                'user_id'=>$request->get('user_id'),
                'user'=>$resultUserInformation['user']
            ]
        );
    }

    public function details($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        //$resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);

        $resultUserInformation = UserModel::userInformation($user_id);

        $resultCredits = TransferCreditModel::getCredits($user_id);

        $resultUserInformation['user']['credits'] = $resultCredits['credits'];

        //dd($resultUserInformation['user']);

        return view(
          '/authenticated/user/details',
          array(
              "user" => $resultUserInformation['user']
          )
        );
    }

}
