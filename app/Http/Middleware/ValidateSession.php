<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Postgres\SessionModel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ValidateSession {

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        //record session validation attempt, increment with 1
        $authSessionData['session_validation_times'] = $authSessionData['session_validation_times'] + 1;
        Session::put("auth", $authSessionData);

        if (env('SESSION_WRITE_TO_FIREBUG', false) == true) {
            //print session information to firebug
            $monolog = Log::getMonolog();
            $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
            $monolog->addInfo(print_r($authSessionData, true));
        }

        if(!$request->ajax()) { //if not AJAX REQUEST
            //record session validation attempt, increment with 1
            $validateSessionResult = SessionModel::validateSession($backoffice_session_id);
            if ($validateSessionResult['status'] != 'OK') {
                Session::flush();
                Session::regenerate();
                $errors = ['errors' => __("login.Your session has expired")];
                return \Redirect::to('/' . LaravelLocalization::getCurrentLocale() . '/auth/login')
                    ->withErrors($errors);
            }
        }else{ //if is AJAX REQUEST
            //AJAX requests with session validation are throttled to test after every 3 calls
            if($authSessionData['session_validation_times'] % 3 === 0) {
                $validateSessionResult = SessionModel::validateSession($backoffice_session_id);
                if ($validateSessionResult['status'] != 'OK') {
                    Session::flush();
                    Session::regenerate();
                    $errors = ['errors' => __("login.Your session has expired")];
                    return \Redirect::to('/' . LaravelLocalization::getCurrentLocale() . '/auth/login')
                        ->withErrors($errors);
                }
            }
        }

        return $next($request);
    }

}