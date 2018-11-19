<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

use App\Helpers\DateTimeHelper;
use App\Helpers\IPAddressHelper;
use App\Helpers\LanguageHelper;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\AuthModel;

use App\Helpers\PasswordHasherHelper;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $username = \Request::json()->get('username');
        $password = \Request::json()->get('password');

        $hashed_password = PasswordHasherHelper::make($password);

        $ip_address = IPAddressHelper::getRealIPAddress();

        try{
            ini_set('default_socket_timeout', 10);
            $result = @file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=".URL_API_KEY."&ip=".$ip_address."&format=json");
            $result = json_decode($result);

            $country = $result->countryName;
            $city = $result->cityName;
            $zip = $result->zipCode;
        }catch(\Exception $ex){
            $country = "";
            $city = "";
            $zip = "";
        }

        $device = "";

        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");

        if($Android || $iPhone || $iPad){
            $device = config("constants.REST");
        }else{
            $device = config("constants.PC");
        }
      //if($request->isMethod("POST")) {
            $result = AuthModel::loginUser(
                $username, $hashed_password, $ip_address, $city, $country, $device
            );
            if ($result['status'] == "OK" && $result['user'] != null) {

                $userData = UserModel::personalInformation($result['user']['backoffice_session_id']);
                if(LanguageHelper::isSupportedLanugage($userData['user']['language'])){
                    $user_language = explode('_', $userData['user']['language']);
                }else{
                    $user_language = explode('_', LanguageHelper::getDefaultLanguage());
                }

                $session_start_time = DateTimeHelper::returnCurrentDateTimeFormatted();
                $duration_interval = DateTimeHelper::differenceBetweenDates($session_start_time);
                $last_login_date_time = "25-Dec-2018 / 22:15:34";
                $last_login_ip_address_country = IPAddressHelper::getRealIPAddress() . ' / ' . 'RESERVED';

                return response()->json([
                    'status' => "OK",
                    'username' => $username,
                    'backoffice_session_id' => $result['user']['backoffice_session_id'],
                    'user_id' => $userData['user']['user_id'],
                    'session_start'=> $session_start_time,
                    'duration_interval' => $duration_interval,
                    'last_login_date_time' => $last_login_date_time,
                    'last_login_ip_address_country' => $last_login_ip_address_country,
                    'last_login_ip_country' => $country,
                    'last_login_ip_city' => $city,
                    'last_login_ip_zip' => $zip,
                    'report_start_date' => DateTimeHelper::returnFirstDayOfMonthDateFormatted(),
                    'report_end_date' => DateTimeHelper::returnCurrentDateFormatted(),
                    'report_date_months_in_past' => env('REPORT_DATE_MONTHS_IN_PAST'),
                    'table_state_save' => env('TABLE_STATE_SAVE'),
                    'table_state_duration' => env('TABLE_STATE_DURATION'),
                    'currency' => $userData['user']['currency'],
                    'country_code' => $userData['user']['country_code'],
                    'country_name' => $userData['user']['country_name'],
                    'session_validation_times' => 0,
                    'language' => $userData['user']['language'],
                    'actual_balance' => $userData['user']['credits_formatted'],
                ]);
          }else{
            return response()->json([
                "status" => "NOK",
                'username' => $username
            ]);
          }
      //}
    }

    public function logout(Request $request)
    {
        $backoffice_session_id = \Request::json()->get('backoffice_session_id');

        $result = AuthModel::logoutUser(
            $backoffice_session_id
        );
        if ($result['status'] == "OK") {

            return response()->json([
                "status" => "OK",
                'backoffice_session_id' => $backoffice_session_id
            ]);
        }else{
          return response()->json([
              "status" => "NOK",
              "backoffice_session_id" => $backoffice_session_id
          ]);
        }
    }

}
