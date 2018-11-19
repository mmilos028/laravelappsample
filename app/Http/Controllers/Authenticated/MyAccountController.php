<?php

namespace App\Http\Controllers\Authenticated;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\Controller;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\CommonModel;

use App\Helpers\PasswordHasherHelper;


class MyAccountController extends Controller
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

    public function homePage(){
        return view("home");
    }

    public function myPersonalData(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        //dd($resultPersonalInformation['user']['active']);

        $languages = UserModel::listLanguages();
        $countries = CommonModel::listCountries($backoffice_session_id);

        $list_countries = [];
        foreach($countries['list_countries'] as $country) {
            $list_countries[$country->country_code] = $country->name;
        }

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                $language = \App::getLocale();
                return \Redirect::to('/' . $language .'/my-account/my-personal-data');
            }

            //validation rules
            $rules = [
                'username' => 'required|min:2|max:20',
                'mobile_phone' => 'required|min:2|max:20',
                //'first_name' => 'required|min:2|max:20',
                //'last_name' => 'required|min:2|max:40',
                'email' => 'required|email|min:4|max:50',
                'language' => 'required|min:4|max:6',
                //'account_active' => 'required',
                'currency' => 'required|min:3|max:3',
                //'address' => 'required|min:2|max:40',
                //'city' => 'required|min:2|max:40',
                'country' => 'required|min:1|max:40',
            ];

            $messages = [
            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'mobile_phone' => __("authenticated.Mobile Phone"),
                'first_name' => __("authenticated.First Name"),
                'last_name' => __("authenticated.Last Name"),
                'currency' => __("authenticated.Currency"),
                'email' => __("authenticated.Email"),
                //'account_active' => __("authenticated.Account Active"),
                'language' => __("authenticated.Language"),
                'address' => __("authenticated.Address"),
                'commercial_address' => __("authenticated.Address 2"),
                'post_code' => __("authenticated.Post Code"),
                'city' => __("authenticated.City"),
                'country' => __("authenticated.Country"),
            ];

            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){
                $user = array(
                    'user_id'=>$request->get('user_id'),
					'username'=>$request->get('username'),
                    'first_name'=>$request->get('first_name'),
                    'last_name'=>$request->get('last_name'),
                    'currency'=>$request->get('currency'),
                    'email'=>$request->get('email'),
                    'edited_by'=>$request->get('user_id'),
                    'player_type'=>$request->get('subject_type'),
                    'subject_state'=>$resultPersonalInformation['user']['active'],
                    //'language'=>$request->get('language'),
                    "language" => $request->get('language'),
                    'address'=>$request->get('address'),
                    'commercial_address'=>$request->get('commercial_address'),
                    'city'=>$request->get('city'),
                    'country'=>$request->get('country'),
                    'mobile_phone'=>$request->get('mobile_phone'),
                    'post_code'=>$request->get('post_code')
                );

                $resultUpdatePersonalInformation = UserModel::updateUser($user);
                if($resultUpdatePersonalInformation['status'] == "OK"){

                    $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);

                    if(isset($resultPersonalInformation['user']['language'])) {
                        $localeSaved = explode('_', $resultPersonalInformation['user']['language']);
                        $language = $localeSaved[0];

                    }else{
                        $language = "en";
                    }

                    \LaravelLocalization::setLocale($language);
                    \App::setLocale($language);

                    return \Redirect::to('/' . $language . '/my-account/my-personal-data')
                        ->with("success_message", __("authenticated.Changes saved"));
                }else{

					if($resultUpdatePersonalInformation["message"] == "GENERAL_ERROR"){
						$error_message = __("authenticated.Changes not saved");
					}
					else if($resultUpdatePersonalInformation["message"] == "EMAIL NOT AVAILABLE"){
						$error_message = __("authenticated.Email is not available");
					}
					else if($resultUpdatePersonalInformation["message"] == "USERNAME NOT AVAILABLE"){
						$error_message = __("authenticated.Username is not available");
					}else{
                        $error_message = __("authenticated.Changes not saved");
                    }

                    $language = \App::getLocale();
                    return \Redirect::to('/' .$language .'/my-account/my-personal-data')
                        ->with("error_message", $error_message);
                }
            }
        }

        return view(
            '/authenticated/my-account/my-personal-data',
            array(
                "languages"=>$languages,
                "user" => $resultPersonalInformation['user'],
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "list_countries"=>$list_countries
            )
        );
    }

    public function changePassword(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $user_id = $request->get('user_id');
        $username = $request->get('username');
        $password = $request->get('password');
        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);

        if($request->isMethod("POST")) {
            if($request->has('cancel')){
                $language = \App::getLocale();
                return \Redirect::to('/' . $language . '/my-account/change-password');
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

            $rules = [
                'username' => 'required|min:2|max:15',
                'password' => 'required|without_spaces|characters_allowed|min:4|max:15',
                'confirm_password' => 'required|without_spaces|characters_allowed|min:4|max:15|same:password'
            ];

            $messages = [
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
                'confirm_password.same' => __("authenticated.The Confirm Password and Password must match."),
                'confirm_password.without_spaces'=> __("authenticated.:attribute is not allowed to contain empty spaces."),
                'confirm_password.characters_allowed' =>  __("authenticated.:attribute can contain only characters: a-z, A-Z, 0-9, _, -")
            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'password' => __("authenticated.Password"),
                'confirm_password' => __("authenticated.Confirm Password"),
            ];

            //validation rules
            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){
                $hashed_password = PasswordHasherHelper::make($password);
                $details = array(
                    'user_id'=>$user_id,
                    'backoffice_session_id'=>$backoffice_session_id,
                    'username'=>$username,
                    'password'=>$hashed_password
                );
                $resultChangePassword = UserModel::changePassword($details);
                if($resultChangePassword['status'] == "OK"){
                    $language = \App::getLocale();
                    return \Redirect::to('/' . $language .'/my-account/change-password')
                        ->with("success_message", __("authenticated.Changes saved"));
                }else{
                    $language = \App::getLocale();
                    return \Redirect::to('/' . $language .'/my-account/change-password')
                        ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return view(
            '/authenticated/my-account/change-password',
            array(
                "user" => $resultPersonalInformation['user']
            )
        );
    }


}
