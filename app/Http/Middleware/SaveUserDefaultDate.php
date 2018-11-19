<?php
namespace App\Http\Middleware;

use App\Helpers\DateTimeHelper;
use Closure;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;

class SaveUserDefaultDate {

    /**
     * This middleware takes care of start_date and end_date changes saved in user's session information for entire user's life time in app
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->exists('auth')) {
            $authSessionData = Session::get('auth');

            $start_date = $request->get('report_start_date', $authSessionData['report_start_date']);
            $end_date = $request->get('report_end_date', $authSessionData['report_end_date']);
            if($start_date != $authSessionData['report_start_date']){
              $authSessionData['report_start_date'] = $start_date;
              Session::put('auth', $authSessionData);
            }
            if($end_date != $authSessionData['report_end_date']){
              $authSessionData['report_end_date'] = $end_date;
              Session::put('auth', $authSessionData);
            }
        }

        return $next($request);
    }

}
