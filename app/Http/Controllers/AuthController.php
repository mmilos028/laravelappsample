<?php

namespace App\Http\Controllers;

use App\Helpers\DateTimeHelper;
use App\Helpers\IPAddressHelper;
use App\Helpers\LanguageHelper;
use App\Models\Postgres\UserModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Config;

use App\Models\Postgres\AuthModel;
use App\Helpers\PasswordHasherHelper;
use App\Helpers\ErrorHelper;

class AuthController extends Controller
{

    protected $startPageAfterLogin = '/home_page';
    protected $loginPage = '/en/auth/login';
    protected $captchaOn = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->startPageAfterLogin = '/' . app()->getLocale() . env('HOME_PAGE', '/home_page');
        $this->loginPage = '/' . app()->getLocale() . '/auth/login';

        $this->captchaOn = env('USE_CAPTCHA_ON_LOGIN_FORM', true);

        if(!$this->captchaOn) {
            Session::put('unsucessful_logins', 0);
            Session::put('show_captcha', false);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Session::has('auth')){
            return \Redirect::to($this->startPageAfterLogin);
        }
        return $this->showLoginForm($request);
    }

    public function detectDevice(){
        try{
            $iPod = false;
            $iPhone = false;
            $iPad = false;
            $iOS = false;
            $webOSPhone = false;
            $webOSTablet = false;
            $webOS = false;
            $BlackBerry9down = false;
            $BlackBerry10 = false;
            $RimTablet = false;
            $BlackBerry = false;
            $NokiaSymbian = false;
            $Symbian = false;
            $AndroidTablet = false;
            $AndroidPhone = false;
            $Android = false;
            $WindowsPhone = false;
            $WindowsTablet = false;
            $Windows = false;
            $Tablet = false;
            $Phone = false;

            //Detect special conditions devices & types (tablet/phone form factor)
            if(stripos($_SERVER['HTTP_USER_AGENT'],"iPod")){
                $iPod = true;
                $Phone = true;
                $iOS = true;
            }
            if(stripos($_SERVER['HTTP_USER_AGENT'],"iPhone")){
                $iPhone = true;
                $Phone = true;
                $iOS = true;
            }
            if(stripos($_SERVER['HTTP_USER_AGENT'],"iPad")){
                $iPad = true;
                $Tablet = true;
                $iOS = true;
            }
            if(stripos($_SERVER['HTTP_USER_AGENT'],"webOS")){
                $webOS = true;
                if(stripos($_SERVER['HTTP_USER_AGENT'],"Pre") || stripos($_SERVER['HTTP_USER_AGENT'],"Pixi")){
                    $webOSPhone = true;
                    $Phone = true;
                }
                if(stripos($_SERVER['HTTP_USER_AGENT'],"TouchPad")){
                    $webOSTablet = true;
                    $Tablet = true;
                }
            }
            if(stripos($_SERVER['HTTP_USER_AGENT'],"BlackBerry")) {
                $BlackBerry = true;
                $BlackBerry9down = true;
                $Phone = true;
                {
                    if (stripos($_SERVER['HTTP_USER_AGENT'], "BB10")) {
                        $BlackBerry = true;
                        $BlackBerry10 = true;
                        $Phone = true;
                        {
                            if (stripos($_SERVER['HTTP_USER_AGENT'], "RIM Tablet")) {
                                $BlackBerry = true;
                                $RimTablet = true;
                                $Tablet = true;
                            }
                            if (stripos($_SERVER['HTTP_USER_AGENT'], "SymbianOS")) {
                                $Symbian = true;
                                $NokiaSymbian = true;
                                $Phone = true;
                            }
                            if (stripos($_SERVER['HTTP_USER_AGENT'], "Android")) {
                                $Android = true;
                                if (stripos($_SERVER['HTTP_USER_AGENT'], "mobile")) {
                                    $AndroidPhone = true;
                                    $Phone = true;
                                } else {
                                    $AndroidTablet = true;
                                    $Tablet = true;
                                }
                            }
                            if (stripos($_SERVER['HTTP_USER_AGENT'], "Windows")) {
                                $Windows = true;
                                if (stripos($_SERVER['HTTP_USER_AGENT'], "Touch")) {
                                    $WindowsTablet = true;
                                    $Tablet = true;
                                }
                                if (stripos($_SERVER['HTTP_USER_AGENT'], "Windows Phone")) {
                                    $WindowsPhone = true;
                                    $Phone = true;
                                }
                            }
                        }
                    }
                }
            }

            if( $Phone ){
                return config("constants.REST");
            }else if( $Tablet ){
                return config("constants.REST");
            }else{
                return config("constants.PC");
            }
        }catch(\Exception $ex){
            return -1;
        }
    }

    public function login(Request $request)
    {
		try{
			if(Session::has('auth')){
				return \Redirect::to($this->startPageAfterLogin);
			}

			$this->validateLogin($request);

			$username = $request->get("username");
			$password = $request->get("password");
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

			if($request->isMethod("POST")) {
				$hashed_password = PasswordHasherHelper::make($password);
				$result = AuthModel::loginUser(
					$username, $hashed_password, $ip_address, $city, $country, $device
				);
				if ($result['status'] == "OK" && $result['user'] != null) {

					$userData = UserModel::personalInformation($result['user']['backoffice_session_id']);
					if(LanguageHelper::isSupportedLanugage($userData['user']['language'])){
						$user_language = explode('_', $userData['user']['language']);
						\App::setLocale($user_language[0]);
					}else{
						$user_language = explode('_', LanguageHelper::getDefaultLanguage());
						\App::setLocale($user_language[0]);
					}
					$this->startPageAfterLogin = '/' . app()->getLocale() . env('HOME_PAGE', '/my-account/my-personal-data');

					$session_start_time = DateTimeHelper::returnCurrentDateTimeFormatted();
					$duration_interval = DateTimeHelper::differenceBetweenDates($session_start_time);
					$last_login_date_time = "25-Dec-2018 / 22:15:34";
					$last_login_ip_address_country = IPAddressHelper::getRealIPAddress() . ' / ' . $country;
					$authSessionData = array(
						'username' => $username,
						'parent_id' => $userData['user']['parent_id'],
                        'subject_type_id' => $userData['user']['subject_type_id'],
                        'subject_dtype' => $userData['user']['subject_type'],
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
					);

                    Session::put('auth', $authSessionData);

					if($authSessionData["subject_type_id"] == config("constants.CASHIER_TYPE_ID") || $authSessionData["subject_type_id"] == config("constants.PLAYER_SUBJECT_TYPE_ID")
                        || $authSessionData["subject_type_id"] == config("constants.TERMINAL_TV_TYPE_ID") || $authSessionData["subject_type_id"] == config("constants.SHIFT_CASHIER_TYPE_ID")){
                        /*$this->logout();*/ //this subjects can not login, database won't allow
                    }else{
                        $request->session()->put('unsucessful_logins', 0);
                        $request->session()->put('show_captcha', false);

                        return \Redirect::to($this->startPageAfterLogin);
                    }
				}
			}

			if(!$request->session()->has('unsucessful_logins')){
				$request->session()->put('unsucessful_logins', 0);
				$request->session()->put('show_captcha', false);
			}else{
				$request->session()->put('unsucessful_logins', $request->session()->get('unsucessful_logins') + 1);
			}
			if($request->session()->get('unsucessful_logins') >= env('CAPTCHA_ON_LOGIN_FORM_UNSUCESSFUL_LOGINS', 3)){
				$request->session()->put('show_captcha', true);
			}else{
				$request->session()->put('show_captcha', false);
			}
			return $this->sendFailedLoginResponse($request);
		}catch(\Exception $ex){
			return \Redirect::to($this->loginPage);	
		}
    }


    public function logout()
    {
        try {
            $authSessionData = Session::get('auth');
            AuthModel::logoutUser($authSessionData['backoffice_session_id']);
        }catch(\Exception $ex){
			Session::flush();
            Session::regenerate();
            return \Redirect::to($this->loginPage);
        }finally {
            Session::flush();
            Session::regenerate();
            return \Redirect::to($this->loginPage);
        }
    }

    public function hash($password)
    {
        try {
            $hashed_password = PasswordHasherHelper::make($password);
        }catch(\Exception $ex){

        }finally {

        }
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        if(Session::get('show_captcha') == true){
           $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
                'captcha' => 'required|captcha'
            ]);
        }else {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required'
            ]);
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = ['errors' => trans('login.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withErrors($errors);
    }

    /**
     * Show the application's login form.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        if(!$request->session()->has('unsucessful_logins')) {
            $request->session()->put('unsucessful_logins', 0);
            $request->session()->put('show_captcha', false);
        }

        if(!$this->captchaOn) {
            Session::put('unsucessful_logins', 0);
            Session::put('show_captcha', false);
        }

        if(Session::has('auth')){
            return \Redirect::to($this->startPageAfterLogin);
        }
		
		Session::regenerate();

        return view('auth.login');
    }
}
