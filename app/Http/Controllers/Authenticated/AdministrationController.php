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
use App\Models\Postgres\CashierModel;
use App\Models\Postgres\CurrencyModel;
use App\Models\Postgres\CustomerModel;
use App\Models\Postgres\TerminalModel;
use App\Models\Postgres\DrawModelSetupModel;
use App\Models\Postgres\SubjectTypeModel;

use App\Helpers\PasswordHasherHelper;


class AdministrationController extends Controller
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
     * @return mixed
     */
    public function userDetails(Request $request)
    {
        $query = $request->all();
        $user_id = $query['user_id'];
        try {

            $resultUserInformation = UserModel::userInformation($user_id);

            return response()->json([
                "status" => "OK",
                "user_id" => $user_id,
                "user" => $resultUserInformation['user']
            ]);
        }catch(\PDOException $ex2){
            return response()->json([
                "status" => "NOK",
                "user_id" => $user_id,
                "user" => null
            ]);
        }catch(\Exception $ex4){
            return response()->json([
                "status" => "NOK",
                "user_id" => $user_id,
                "user" => null
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocationAddressInformation(Request $request){
      try {

          $query = $request->all();
          $location_id = $query['location_id'];

          $authSessionData = Session::get('auth');
          $backoffice_session_id = $authSessionData['backoffice_session_id'];

          $resultLocationAddressInformation = CashierModel::getLocationAddress($backoffice_session_id, $location_id);

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

        /*
        $list_subject_types = SubjectTypeModel::listAllSubjectTypesForAdministrationSearchUser();
        $subjectTypesResultProcessed = array();
        foreach($list_subject_types as $key => $value){
            $obj = new \stdClass();
            $obj->subject_type_id = $key;
            $obj->subject_type_name = $value;
            $subjectTypesResultProcessed[] = $obj;
        }
        */

        //$subjectTypes = SubjectTypeModel::listBOSubjectTypesForUserNewUser($logged_in_id);
        $subjectTypes = SubjectTypeModel::listSubjectTypesForAdministrationSearchUser($logged_in_id);

        //dd($subjectTypes);

        $subjectTypesResult = $subjectTypes["result"];
        $subjectTypesResultProcessed = array();
        $i = 0;
        //dd($subjectTypesResult);
        foreach ($subjectTypesResult as $r){
            $obj = new \stdClass();
            $obj->subject_type_id = $r->subject_dtype_id;
            $obj->subject_type_name = $r->subject_dtype_bo_name;
            $subjectTypesResultProcessed[] = $obj;
            $i++;

        }

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

          $resultSearchUsers = UserModel::administrationSearchUsers($backoffice_session_id, $username, $first_name,
            $last_name, $email, $city, $country_id, $mobile_phone, $currency, $show_banned, $subject_type_id, $affiliate_id);

         if($request->has('small')){
             $view_name = '/authenticated/administration/search-users-small';
         }
         else if($request->has('large')){
             $view_name = '/authenticated/administration/search-users';
         }
         else {
             $view_name = $request->exists('large_tag') ? '/authenticated/administration/search-users' : '/authenticated/administration/search-users-small';
         }

         //dd($resultSearchUsers['list_users']);

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAffiliatesFromRole(Request $request){
        try {

            $query = $request->all();
            $subject_type_id = $query['subject_type_id'];

            if(!isset($subject_type_id)){
                return response()->json([
                    "status" => "NOK",
                    "subject_type_id" => $subject_type_id
                ]);
            }

            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

            $subject_id = $authSessionData['user_id'];

            if($authSessionData['subject_type_id'] == config("constants.ADMINISTRATOR_LOCATION_ID")) {

                $listAffiliatesResult = [
                    "status" => "OK",
                    "list_affiliates" => [
                        [
                            "language" => $authSessionData['language'],
                            "subject_id_to" => $authSessionData['user_id'],
                            "subject_name_to" => $authSessionData['username'],
                            "currency" => $authSessionData['currency'],
                            "direct_parent_type" => "",
                            "order" => "",
                            "session_time_in_minutes" => "",
                            "sort_direct_parents" => "",
                            "subject_dtype" => "",
                            "subject_dtype_bo_name" => "",
                            "subject_dtype_id" => "",
                            "type" => "",
                        ]
                    ]
                ];
                //$listAffiliatesResult = UserModel::listAffiliatesBasedOnRole($backoffice_session_id, $subject_id, $subject_type_id);
            }else{
                $listAffiliatesResult = UserModel::listAffiliatesBasedOnRole($backoffice_session_id, $subject_id, $subject_type_id);
            }

            if($listAffiliatesResult['status'] == "OK"){
                return response()->json([
                    "status" => "OK",
                    "subject_id" => $subject_id,
                    "subject_type_id" => $subject_type_id,
                    "list_affiliates" => $listAffiliatesResult['list_affiliates']
                ]);
            }else{
                return response()->json([
                    "status" => "NOK"
                ]);
            }
        }catch(\PDOException $ex1){
            return response()->json([
                "status" => "NOK",
            ]);
        }catch(\Exception $ex2){
            return response()->json([
                "status" => "NOK",
            ]);
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
