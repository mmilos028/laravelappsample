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
use App\Models\Postgres\AdministratorModel;
use App\Models\Postgres\TransferCreditModel;

use App\Helpers\PasswordHasherHelper;


class AdministratorController extends Controller
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

    public function changePassword($user_id, Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultUserInformation = UserModel::userInformation($user_id);

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                 $language = \App::getLocale();
                 return \Redirect::to('/'. $language .'/administrator/list-administrators');
            }

            //validation rules
            $rules = [
                'username' => 'required|min:2|max:20',
                'password' => 'required|min:4|max:15',
                'confirm_password' => 'required|min:4|max:15|same:password'
            ];

            $messages = [
                'confirm_password.same' => __("authenticated.The Confirm password and Password must match"),
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
                        '/authenticated/administrator/change-password',
                        [
                            'user_id' => $user_id,
                            'user'=>$resultUserInformation['user']
                        ]
                    )->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return view(
                        '/authenticated/administrator/change-password',
                        [
                            'user_id' => $user_id,
                            'user'=>$resultUserInformation['user']
                        ]
                    )->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return view(
            '/authenticated/administrator/change-password',
            [
                'user'=>$resultUserInformation['user'],
                'user_id' => $user_id,
            ]
        );
    }

    public function updateAdministrator($user_id, Request $request)
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
                return \Redirect::to('/'. $language .'/administrator/list-administrators');
            }

            Validator::extend('without_spaces', function($attr, $value){
                return preg_match('/^\S*$/u', $value);
            });

            //validation rules
            $rules = [
                'username' => 'required|without_spaces|min:2|max:20',
                'mobile_phone' => 'required|min:4|max:50',
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
                'username.required' => __("authenticated.Username is required."),
                'confirm_password.same' => __("authenticated.The Confirm Password and Password must match"),
            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'mobile_phone' => __("authenticated.Mobile Phone"),
                'email' => __("authenticated.Email"),
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
                        '/authenticated/administrator/update-administrator',
                        array(
                            "languages"=>$languages,
                            "account_active_options"=>$account_active_options,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "user" => $resultUserInformation['user'],
                            "list_countries"=>$list_countries,
                            'user_id' => $user_id,
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
                        '/authenticated/administrator/update-administrator',
                        array(
                            "languages"=>$languages,
                            "account_active_options"=>$account_active_options,
                            "list_currency"=>$resultPersonalInformation['list_currency'],
                            "user" => $resultUserInformation['user'],
                            "list_countries"=>$list_countries,
                            'user_id' => $user_id,
                        )
                    )->with("error_message", $error_message);
                }
            }
        }

        return view(
            '/authenticated/administrator/update-administrator',
            array(
                "languages"=>$languages,
                "account_active_options"=>$account_active_options,
                "list_currency"=>$resultPersonalInformation['list_currency'],
                "user" => $resultUserInformation['user'],
                "list_countries"=>$list_countries,
                'user_id' => $user_id,
            )
        );
    }

    /**
     * @param Request $request
     * @return View
     */
    public function listAdministrators(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListAdministrators = AdministratorModel::listAdministrators($backoffice_session_id);

        //dd($resultListAdministrators['list_administrators']);

        return view(
            '/authenticated/administrator/list-administrators',
            array(
                "list_administrators" => $resultListAdministrators['list_administrators'],
            )
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
          '/authenticated/administrator/details',
          array(
              "user" => $resultUserInformation['user']
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
