<?php

namespace App\Http\Controllers\Authenticated\Administration\Parameter_Setup;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Postgres\ParameterModel;

class ParameterSetupController extends Controller
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

    public function addNewParameter(Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $resultListParameters = ParameterModel::listParameters();

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                return \Redirect::to('/' . app()->getLocale() . '/administration/parameter-setup/add-new-parameter');
            }

            $rules = [
                'parameter_name' => 'required|min:2',
                'backoffice_parameter_name' => 'required|min:2'
            ];

            $messages = [

            ];

            $attributes = [
                'parameter_name' => __("authenticated.Parameter Name"),
                'backoffice_parameter_name' => __("authenticated.Backoffice Parameter Name")
            ];

            //validation rules
            $this->validate($request, $rules, $messages, $attributes);

            if($request->has('save')){
                $details = array(
                    'backoffice_session_id'=>$backoffice_session_id,
                    'parameter_name'=>strtoupper($request->get('parameter_name')),
                    'backoffice_parameter_name'=>$request->get('backoffice_parameter_name')
                );

                $resultAddNewParameter = ParameterModel::addNewParameter($details);

                if($resultAddNewParameter['status'] == "OK"){
                    return \Redirect::to('/' . app()->getLocale() . '/administration/parameter-setup/add-new-parameter')
                        ->with("success_message", __("authenticated.Changes saved"))
                        ;
                }else{
                    return \Redirect::to('/' . app()->getLocale() . '/administration/parameter-setup/add-new-parameter')
                        ->with("error_message", __("authenticated.Changes not saved"))
                        ;
                }
            }
        }

        return view(
            '/authenticated/administration/parameter-setup/add-new-parameter',
            [
                'list_parameters'=>$resultListParameters['list_parameters']
            ]
        );
    }

    public function updateParameters(Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $selected_parameter_ids = $request->input('selected_parameters');
        $parameter_values = $request->input('parameter_value');
        $backoffice_parameter_values = $request->input('backoffice_parameter_value');

        if($request->isMethod("POST")) {

            if($request->has('save_selected_parameters')){
                $details = array();
                foreach($selected_parameter_ids as $key => $value){
                    $details[] = array(
                        "parameter_id"=>$value,
                        "parameter_name"=>$parameter_values[$value],
                        "backoffice_parameter_name"=>$backoffice_parameter_values[$key],
                    );
                }
                $result = ParameterModel::updateParameters($details);
                if($result['status'] == "OK"){
                    return \Redirect::to('/' . app()->getLocale() . '/administration/parameter-setup/add-new-parameter')
                        ->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return \Redirect::to('/' . app()->getLocale() . '/administration/parameter-setup/add-new-parameter')
                        ->with("error_message", __("authenticated.Changes not saved"));
                }
            }

            if($request->has('save_all_parameters')){
                $details = array();
                foreach($parameter_values as $key => $value){
                    $details[] = array(
                        "parameter_id"=>$key,
                        "parameter_name"=>$value,
                        "backoffice_parameter_name"=>$backoffice_parameter_values[$key],
                    );
                }
                $result = ParameterModel::updateParameters($details);
                if($result['status'] == "OK"){
                    return \Redirect::to('/' . app()->getLocale() . '/administration/parameter-setup/add-new-parameter')
                        ->with("success_message", __("authenticated.Changes saved"));
                }else{
                    return \Redirect::to('/' . app()->getLocale() . '/administration/parameter-setup/add-new-parameter')
                        ->with("error_message", __("authenticated.Changes not saved"));
                }
            }
        }

        return \Redirect::to('/' . app()->getLocale() . '/administration/parameter-setup/add-new-parameter');
    }

}
