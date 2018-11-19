<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CheckBackofficeUserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if(!$request->ajax()) {

            $authSessionData = Session::get('auth');

            $subject_type_id = $authSessionData['subject_type_id'];

            $action = $request->route()->getAction();
            $controller_full_path = $action['controller'];
            list($controller, $action) = explode('@', $controller_full_path);
            $temp_controller_full_path = $controller;
            $controller = class_basename($controller);

            $permission_denied_url = '/' . LaravelLocalization::getCurrentLocale() . "/messages/index";

            if (!in_array($subject_type_id, //if not ROOT MASTER
                array(
                    config("constants.MASTER_TYPE_ID"))
            )
            ) {
                //check administration/
                // VersionSetup is accessed
                if (in_array($controller, ['VersionSetupController'])) {
                    return redirect($permission_denied_url)
                        ->with("warning_message", __("Permission denied for user"));
                }
            }

            if (!in_array($subject_type_id, //if not ROOT MASTER or Administrator System
                array(
                    config("constants.MASTER_TYPE_ID"),
                    config("constants.ADMINISTRATOR_SYSTEM_ID")
                )
            )){
                if (in_array($controller, ['ParameterSetupController'])) {
                    return redirect($permission_denied_url)
                        ->with("warning_message", __("Permission denied for user"));
                }
            }

            //check if not ADMINISTRATOR_SYSTEM, ADMINISTRATOR_CLIENT, MASTER_TYPE
            if (!in_array($subject_type_id,
                array(
                    config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_LOCATION_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))
            )
            ) {
                //check administration/
                // JackpotController, AdministrationController, UserCurrencySetup, ParameterSetup, AffiliateParameterSetup, LocationParameterSetup, DrawModelSetup are accessed
                //if (in_array($controller, ['JackPotController', 'AdministrationController', 'UserCurrencySetupController', 'ParameterSetupController', 'AffiliateParameterSetupController', 'LocationParameterSetupController', 'DrawModelSetupController'])) {
                if (in_array($controller, ['JackPotController', 'AdministrationController', 'UserCurrencySetupController'])) {
                    return redirect($permission_denied_url)
                        ->with("warning_message", __("Permission denied for user"));
                }
            }

            //check if not ADMINISTRATOR_SYSTEM, ADMINISTRATOR_CLIENT, MASTER_TYPE
            if (!in_array($subject_type_id,
                array(
                    config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_LOCATION_ID"),
                    config("constants.ADMINISTRATOR_OPERATER_ID")
                )
            )
            ) {
                if (in_array($controller, ['DrawModelSetupController'])) {
                    return redirect($permission_denied_url)
                        ->with("warning_message", __("Permission denied for user"));
                }
            }

            //check if not ADMINISTRATOR_SYSTEM, MASTER_TYPE
            if (!in_array($subject_type_id,
                array(
                    config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"))
            )
            ) {
                //check if LanguageSetupController is accessed
                if (in_array($controller, ['LanguageSetupController'])) {
                    return redirect($permission_denied_url)
                        ->with("warning_message", __("Permission denied for user"));
                }
            }
        }

        return $next($request);
    }
}