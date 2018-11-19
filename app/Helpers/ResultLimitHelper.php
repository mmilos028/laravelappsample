<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class ResultLimitHelper {
    public function __construct(){
    }

    public static function getLimitsPerPage(){
        $authSessionData = Session::get('auth');
        $default_limit_per_page = 200;
        if(!isset($authSessionData['default_limit_per_page'])) {
            $authSessionData['default_limit_per_page'] = 200;
            Session::put($authSessionData);
        }else{
            $default_limit_per_page = $authSessionData['default_limit_per_page'];
        }

        $limits = [
            10 => "10",
            25 => "25",
            50 => "50",
            100 => "100",
            200 => "200",
            500 => "500",
            1000 => "1000",
            1000000 => "ALL"
        ];
        return [
            "default_limit" => $default_limit_per_page,
            "limits" => $limits
        ];
    }

    public static function listLimitsPerPageAndUpdate($new_default_limit_per_page = 200){
        $authSessionData = Session::get('auth');
        $default_limit_per_page = 200;
        if(!isset($authSessionData['default_limit_per_page'])) {
            $authSessionData['default_limit_per_page'] = 200;
            Session::put($authSessionData);
        }
        if(isset($new_default_limit_per_page) && is_numeric($new_default_limit_per_page)) {
            $authSessionData['default_limit_per_page'] = $new_default_limit_per_page;
            Session::put($authSessionData);
        }

        $limits = [
            10 => "10",
            25 => "25",
            50 => "50",
            100 => "100",
            200 => "200",
            500 => "500",
            1000 => "1000",
            1000000 => "ALL"
        ];
        $authSessionData = Session::get('auth');
        $default_limit_per_page = $authSessionData['default_limit_per_page'];
        return [
            "default_limit" => $default_limit_per_page,
            "limits" => $limits
        ];
    }

    public static function getDefaultLimit(){
        $authSessionData = Session::get('auth');
        if(!isset($authSessionData['default_limit_per_page'])) {
            $default_limit_per_page = 200;
        }else{
            $default_limit_per_page = $authSessionData['default_limit_per_page'];
        }
        return $default_limit_per_page;
    }
}