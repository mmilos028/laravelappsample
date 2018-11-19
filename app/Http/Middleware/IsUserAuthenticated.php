<?php
namespace App\Http\Middleware;

use App\Helpers\DateTimeHelper;
use Closure;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;

class IsUserAuthenticated {

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->session()->exists('auth')) {
            return redirect('/' . LaravelLocalization::getCurrentLocale() . '/auth/login');
        }else{
            $oldSessionData = Session::get('auth');
            $newSessionData = $oldSessionData;
            $newSessionData['duration_interval'] = DateTimeHelper::differenceBetweenDates($oldSessionData['session_start']);
            Session::put('auth', $newSessionData);
        }

        return $next($request);
    }

}
