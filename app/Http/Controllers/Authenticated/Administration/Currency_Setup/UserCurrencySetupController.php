<?php

namespace App\Http\Controllers\Authenticated\Administration\Currency_Setup;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\CurrencyModel;
use App\Models\Postgres\CustomerModel;
use App\Models\Postgres\LocationModel;

class UserCurrencySetupController extends Controller
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

    public function listLocations(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListLocations = LocationModel::listLocations($backoffice_session_id);

        return view(
            '/authenticated/administration/currency-setup/list-locations',
            array(
                "list_locations" => $resultListLocations['list_locations'],
            )
        );
    }

    public function listAffiliates(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListAffiliates = CustomerModel::listCustomers($backoffice_session_id);

        return view(
            '/authenticated/administration/currency-setup/list-affiliates',
            array(
                "list_affiliates" => $resultListAffiliates['list_customers'],
            )
        );
    }

    public function addCurrencyToLocation($user_id, Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $resultUserInformation = UserModel::userInformation($user_id);

        $resultListCurrencies = CurrencyModel::listCurrencies($backoffice_session_id);

        if($request->has('cancel') || $resultUserInformation['status'] != 'OK'){
            return \Redirect::to('/' . app()->getLocale() . '/administration/currency-setup/list-locations');
        }

        if($request->isMethod("POST")) {

            $rules = [
                'username' => 'required',
                'currency' => 'required|min:3|max:3',
            ];

            $messages = [

            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'currency' => __("authenticated.List Currency"),
            ];

            //validation rules
            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){
                $details = array(
                    'user_id'=>$request->get('user_id'),
                    'backoffice_session_id'=>$backoffice_session_id,
                    'username'=>$request->get('username'),
                    'currency'=>$request->get('currency')
                );

                $resultAddCurrencyToUser = CurrencyModel::addCurrencyToSubject($details);
                //dd($resultAddCurrencyToUser);

                if($resultAddCurrencyToUser['status'] == "OK"){
                    $resultUserInformation = UserModel::userInformation($user_id);
                    return view(
                        '/authenticated/administration/currency-setup/add-currency-to-location',
                        array(
                            "user" => $resultUserInformation['user'],
                            "list_currency"=>$resultListCurrencies['list_currency']
                        )
                    )->with("success_message", __("authenticated.Changes saved"));
                }
                else if($resultAddCurrencyToUser['status'] != "OK" && $resultAddCurrencyToUser['code'] == "P0001"){
                    return \Redirect::to('/' . app()->getLocale() . "/administration/currency-setup/add-currency-to-location/user_id/{$user_id}")
                        ->with("error_message", __("authenticated.Currency is not added or already exists."));
                }
                else{
                   return \Redirect::to('/' . app()->getLocale() . "/administration/currency-setup/add-currency-to-location/user_id/{$user_id}")
                       ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return view(
            '/authenticated/administration/currency-setup/add-currency-to-location',
            array(
                "user" => $resultUserInformation['user'],
                "list_currency"=>$resultListCurrencies['list_currency']
            )
        );
    }

    public function addCurrencyToAffiliate($user_id, Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $resultUserInformation = UserModel::userInformation($user_id);

        $resultListCurrencies = CurrencyModel::listCurrencies($backoffice_session_id);

        if($request->has('cancel') || $resultUserInformation['status'] != 'OK'){
            return \Redirect::to('/' . app()->getLocale() . '/administration/currency-setup/list-affiliates');
        }

        if($request->isMethod("POST")) {

            $rules = [
                'username' => 'required',
                'currency' => 'required|min:3|max:3',
            ];

            $messages = [

            ];

            $attributes = [
                'username' => __("authenticated.Username"),
                'currency' => __("authenticated.List Currency"),
            ];

            //validation rules
            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){
                $details = array(
                    'user_id'=>$request->get('user_id'),
                    'backoffice_session_id'=>$backoffice_session_id,
                    'username'=>$request->get('username'),
                    'currency'=>$request->get('currency')
                );

                $resultAddCurrencyToUser = CurrencyModel::addCurrencyToSubject($details);

                if($resultAddCurrencyToUser['status'] == "OK"){
                    $resultUserInformation = UserModel::userInformation($user_id);
                    return view(
                        '/authenticated/administration/currency-setup/add-currency-to-affiliate',
                        array(
                            "user" => $resultUserInformation['user'],
                            "list_currency"=>$resultListCurrencies['list_currency']
                        )
                    )->with("success_message", __("authenticated.Changes saved"));
                }
                else if($resultAddCurrencyToUser['status'] != "OK" && $resultAddCurrencyToUser['code'] == "P0001"){
                    return \Redirect::to('/' . app()->getLocale() . "/administration/currency-setup/add-currency-to-affiliate/user_id/{$user_id}")
                        ->with("error_message", __("authenticated.Currency is not added or already exists."));
                }
                else{
                    return \Redirect::to('/' . app()->getLocale() . "/administration/currency-setup/add-currency-to-affiliate/user_id/{$user_id}")
                        ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return view(
            '/authenticated/administration/currency-setup/add-currency-to-affiliate',
            array(
                "user" => $resultUserInformation['user'],
                "list_currency"=>$resultListCurrencies['list_currency']
            )
        );
    }

}
