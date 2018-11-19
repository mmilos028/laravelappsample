<?php

namespace App\Http\Controllers\Authenticated\Administration\Version_Setup;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Postgres\ApplicationVersionSetupModel;

class VersionSetupController extends Controller
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

    public function versionSetup(Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListApplicationVersion = ApplicationVersionSetupModel::listApplicationVersionSet($backoffice_session_id);

        if($request->isMethod("POST")){

            //validation rules
            $rules = [
                'application_name' => 'required|min:1|max:100',
                'application_version' => 'required|min:1|max:100',
            ];

            $messages = [
            ];

            $attributes = [
                'application_name' => __("authenticated.Application Name"),
                'application_version' => __("authenticated.Application Version")
            ];

            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save_application_version')){

                $application_name = strtoupper($request->get('application_name'));
                $application_version = $request->get('application_version');

                $resultAddApplicationVersion = ApplicationVersionSetupModel::addApplicationAndVersion($backoffice_session_id, $application_name, $application_version);
                if($resultAddApplicationVersion['status'] == 'OK') {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/version-setup")
                        ->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/version-setup")
                ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
            return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/version-setup")
                ->with("error_message", __("authenticated.Changes not saved"));
        }

        return view(
            '/authenticated/administration/version-setup/version-setup',
            [
                "list_application_version_set" => $resultListApplicationVersion['list_application_version_set']
            ]
        );
    }

    public function updateApplicationVersion($application_name, $version, Request $request){

        return view(
            '/authenticated/administration/version-setup/update-application-version',
            [
                "application_name" => $application_name,
                "version" => $version
            ]
        );
    }

    public function doUpdateApplicationVersion(Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        if($request->isMethod("POST")){

            if($request->has('cancel_update_application_version')){
                return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/version-setup");
            }

            $application_name = $request->get('application_name');
            $application_version = $request->get('application_version');

            //validation rules
            $rules = [
                'application_name' => 'required|min:1|max:100',
                'application_version' => 'required|min:1|max:100',
            ];

            $messages = [
            ];

            $attributes = [
                'application_name' => __("authenticated.Application Name"),
                'application_version' => __("authenticated.Application Version")
            ];

            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save_update_application_version')){

                $application_name = strtoupper($request->get('application_name'));
                $application_version = $request->get('application_version');

                $resultAddApplicationVersion = ApplicationVersionSetupModel::updateApplicationAndVersion($backoffice_session_id, $application_name, $application_version);
                if($resultAddApplicationVersion['status'] == 'OK') {
                    return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/update-application-version/application_name/{$application_name}/version/{$application_version}")
                        ->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/update-application-version/application_name/{$application_name}/version/{$application_version}")
                        ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
            return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/update-application-version/application_name/{$application_name}/version/{$application_version}")
                ->with("error_message", __("authenticated.Changes not saved"));
        }else{
           return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/version-setup");
        }
    }

    public function deleteApplicationVersion($application_name, Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultRemoveApplicationVersion = ApplicationVersionSetupModel::deleteApplicationAndVersion($backoffice_session_id, $application_name);
        if($resultRemoveApplicationVersion['status'] == 'OK') {
            return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/version-setup")
                ->with("success_message", __("authenticated.Record successfully deleted"));
        }else{
            return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/version-setup")
                ->with("error_message", __("authenticated.Record not deleted"));
        }
            return \Redirect::to('/' . app()->getLocale() . "/administration/version-setup/version-setup")
                ->with("error_message", __("authenticated.Record not deleted"));
    }

}
