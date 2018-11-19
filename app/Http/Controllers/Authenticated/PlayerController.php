<?php

namespace App\Http\Controllers\Authenticated;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\Controller;
use App\Models\Postgres\PlayerModel;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\CommonModel;
use App\Models\Postgres\TransferCreditModel;

use App\Helpers\NumberHelper;

use Maatwebsite\Excel\Facades\Excel;

class PlayerController extends Controller
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

    public function changePassword($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultPlayerInformation = PlayerModel::playerInformation($user_id);

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                return \Redirect::to('/' . app()->getLocale() . '/player/list-players');
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
                'password' => 'required|without_spaces|characters_allowed|min:4|max:20',
                'confirm_password' => 'required|without_spaces|characters_allowed|min:4|max:20|same:password'
            ];

            $messages = [
                'confirm_password.same' => __("authenticated.The confirm password and password must match"),
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

                //$hashed_password = PasswordHasherHelper::make($request->get('password'));
				$hashed_password = $request->get('password');

                $details = array(
                    'user_id'=>$request->get('user_id'),
                    'backoffice_session_id'=>$backoffice_session_id,
                    'password'=>$hashed_password
                );

                $resultChangePlayerPassword = PlayerModel::changePassword($details);
                if($resultChangePlayerPassword['status'] == "OK"){
                    return view(
                        '/authenticated/player/change-password',
                        [
                            'user'=>$resultPlayerInformation['user']
                        ]
                    )->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return view(
                        '/authenticated/player/change-password',
                        [
                            'user'=>$resultPlayerInformation['user']
                        ]
                    )->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return view(
            '/authenticated/player/change-password',
            [
                'user'=>$resultPlayerInformation['user']
            ]
        );
    }

    public function updatePlayer($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        $languages = UserModel::listLanguages();

        $account_active_options = UserModel::listAccountActiveOptions();
        $resultPlayerInformation = PlayerModel::playerInformation($user_id);
        $countries = CommonModel::listCountries($backoffice_session_id);

        $list_countries = [];
        foreach($countries['list_countries'] as $country) {
            $list_countries[$country->country_code] = $country->name;
        }

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                return \Redirect::to('/' . app()->getLocale() . '/player/list-players');
            }

            //validation rules
            $rules = [
                'username' => 'required|min:2|max:40',
                'mobile_phone' => 'required|min:2|max:50',
                'email' => 'required|email|min:4|max:50',
                'first_name' => 'required|min:2|max:20',
                'last_name' => 'required|min:2|max:40',
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

                $resultUpdatePlayerInformation = PlayerModel::updatePlayer($user);
                if($resultUpdatePlayerInformation['status'] == "OK"){
                    $resultPlayerInformation = PlayerModel::playerInformation($user_id);
                    return view(
                        '/authenticated/player/update-player',
                        array(
                            "languages"=>$languages,
                            "account_active_options"=>$account_active_options,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "user" => $resultPlayerInformation['user'],
                            "list_countries"=>$list_countries
                        )
                    )->with("success_message", __("authenticated.Changes saved"));
                }else{
                    $resultPlayerInformation = PlayerModel::playerInformation($user_id);
					
					if($resultUpdatePlayerInformation["message"] == "GENERAL_ERROR"){
						$error_message = __("authenticated.Changes not saved");
					}
					if($resultUpdatePlayerInformation["message"] == "EMAIL NOT AVAILABLE"){
						$error_message = __("authenticated.Email is not available");
					}
					if($resultUpdatePlayerInformation["message"] == "USERNAME NOT AVAILABLE"){
						$error_message = __("authenticated.Username is not available");
					}
                    return view(
                        '/authenticated/player/update-player',
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
            '/authenticated/player/update-player',
            array(
                "languages"=>$languages,
                "account_active_options"=>$account_active_options,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "user" => $resultPlayerInformation['user'],
                "list_countries"=>$list_countries
            )
        );
    }

    public function newPlayer(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);
        $languages = UserModel::listLanguages();
        $countries = CommonModel::listCountries($backoffice_session_id);

        $list_countries = [];
        foreach($countries['list_countries'] as $country) {
            $list_countries[$country->country_code] = $country->name;
        }

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                $language = \App::getLocale();
                return \Redirect::to('/'. $language .'/player/list-players');
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
                'password' => 'required|min:4|max:40',
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
                    'subject_type_id'=>config("constants.PLAYER_TYPE_ID"),
                    'player_type_name'=>config("constants.PLAYER_TYPE_NAME"),
                    'language'=>$request->get('language'),
                    'address'=>$request->get('address'),
                    'city'=>$request->get('city'),
                    'country'=>$request->get('country'),
                    'mobile_phone'=>$request->get('mobile_phone'),
                    'post_code'=>$request->get('post_code'),
                    'commercial_address'=>''
                );

                $resultInsertPlayerInformation = PlayerModel::createUser($user);
                if($resultInsertPlayerInformation['status'] == "OK"){
					$resultSetServiceKeyForTerminal = TerminalModel::setServiceKeyForTerminal($resultInsertPlayerInformation['subject_id']);
					if($resultSetServiceKeyForTerminal['status'] == "OK") {
						return view(
							'/authenticated/player/new-player',
							array(
								"languages"=>$languages,
								"list_currency"=>$resultPersonalInformation['list_currency'],
								"logged_in_user"=>$resultPersonalInformation['user'],
								"list_countries"=>$list_countries,
								"user" => $user
							)
						)->with("success_message", __("authenticated.Changes saved"));
					}else {
						return view(
							'/authenticated/terminal/new-terminal',
							array(
								"languages"=>$languages,
								"list_currency"=>$resultPersonalInformation['list_currency'],
								"logged_in_user"=>$resultPersonalInformation['user'],
								"list_countries"=>$list_countries,
								"user" => $user
							)
						)->with("success_message", __("authenticated.Terminal created, but service key not set !"));
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
                        '/authenticated/player/new-player',
                        array(
                            "languages"=>$languages,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "logged_in_user"=>$resultPersonalInformation['user'],
                            "list_countries"=>$list_countries,
							"user" => $user
                        )
                    )->with("error_message", $error_message);
                }
            }
        }

        return view(
            '/authenticated/player/new-player',
            array(
                "languages"=>$languages,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "logged_in_user"=>$resultPersonalInformation['user'],
                "list_countries"=>$list_countries
            )
        );
    }

    public function listPlayers(Request $request){

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        //$resultListPlayers = PlayerModel::listPlayers($backoffice_session_id);
        $resultListPlayers = UserModel::listPlayersByType($backoffice_session_id, config("constants.PLAYER_TYPE_ID"));

        //dd($resultListPlayers['list_users']);

        return view(
            '/authenticated/player/list-players',
            array(
                "list_players" => $resultListPlayers['list_users'],
            )
        );
    }

    public function details($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        //$resultPersonalInformation = UserModel::personalInformation($backoffice_session_id);

        $resultPlayerInformation = PlayerModel::playerInformation($user_id);

        //dd($resultPlayerInformation);

        $resultCredits = TransferCreditModel::getCredits($user_id);

        $resultPlayerInformation['user']['credits'] = $resultCredits['credits'];

        return view(
          '/authenticated/player/details',
          array(
              "user" => $resultPlayerInformation['user']
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

}
