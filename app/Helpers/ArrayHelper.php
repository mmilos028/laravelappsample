<?php
/* Helper class to data conversion from Oracle database ref cursor into php arrays */
namespace App\Helpers;

class ArrayHelper {
    public function __construct(){
    }

    //sort array by key element
    public static function aasort ($array, $key, $direction = 'ASC') {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        if(strtoupper($direction) == 'ASC')
            asort($sorter);
        else{
            arsort($sorter);
        }
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
        return $ret;
    }

    public static function sortMultiDimArray($arrData, $key_name){
        $sort_by = array();
        foreach ($arrData as $key => $data) {
            $sort_by[$key] = $data[$key_name];
        }
        //array_multisort($sort_by, SORT_ASC, SORT_STRING, $arrData);
        array_multisort($sort_by, SORT_STRING | SORT_FLAG_CASE, $arrData);
        return $arrData;
    }

    public function determineTreeGridProperties($subject_type){
        $color = "";
        $url = "";
        $url_disabled = true;
        if($subject_type == config('constants.ROLE_CLIENT')){
            $url = "/structure-entity/details/user_id/";
            $url_disabled = false;
            $color = "#FF00FF";
        }elseif ($subject_type == config('constants.ROLE_ADMINISTRATOR') || $subject_type == config('constants.ADMINISTRATOR_SYSTEM') || $subject_type == config('constants.ADMINISTRATOR_CLIENT') || $subject_type == config('constants.ADMINISTRATOR_LOCATION') || $subject_type == config('constants.ADMINISTRATOR_OPERATER')){
            $url = "/administrator/details/user_id/";
            $url_disabled = false;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_LOCATION')){
            $url = "/structure-entity/details/user_id/";
            $url_disabled = false;
            $color = "#0000FF";
        }elseif ($subject_type == config('constants.ROLE_OPERATER')){
            $url = "/structure-entity/details/user_id/";
            $url_disabled = false;
            $color = "#A349A4";
        }elseif ($subject_type == config('constants.ROLE_CASHIER_TERMINAL') || $subject_type == config('constants.TERMINAL_TV') || $subject_type == config('constants.TERMINAL_SALES') || $subject_type == config('constants.SELF_SERVICE_TERMINAL')){
            $url = "/terminal/details/user_id/";

            $url_disabled = false;
            $color = "#8000FF";
        }elseif ($subject_type == config('constants.ROLE_PLAYER')){
            $url = "/player/details/user_id/";
            $url_disabled = false;
            $color = "#7F7F7F";
        }elseif ($subject_type == config('constants.ROLE_CASHIER') || $subject_type == config('constants.SHIFT_CASHIER')){
            $url = "/cashier/details/user_id/";
            $url_disabled = false;
            $color = "#000000";
        }elseif ($subject_type == config('constants.COLLECTOR_TYPE_NAME')){
            $url = "/user/details/user_id/";
            $url_disabled = false;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_SUPPORT_CLIENT')){
            $url = "/user/details/user_id/";
            $url_disabled = false;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_SUPPORT_SYSTEM')){
            $url = "/user/details/user_id/";
            $url_disabled = false;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_SUPPORT_OPERATER')){
            $url = "/user/details/user_id/";
            $url_disabled = false;
            $color = "#3F48CC";
        }elseif ($subject_type == config('constants.ROLE_MASTER')){
            $url = "/user/details/user_id/";
            //$url = "";
            $url_disabled = false;
            $color = "";
        }

        $result = array();

        $result["color"] = $color;
        $result["url"] = $url;
        $result["url_disabled"] = $url_disabled;

        return $result;
    }

    public function determineBallColor($ball_number){
        $result = array();
        $color = "";
        $color_name = "";

        if(in_array($ball_number, config("constants.RED_BALL"))){
            $color = "#ED1C24";
            $color_name = trans("authenticated.RED");
        }elseif (in_array($ball_number, config("constants.GREEN_BALL"))){
            $color = "#0B9444";
            $color_name = trans("authenticated.GREEN");
        }elseif (in_array($ball_number, config("constants.BLUE_BALL"))){
            $color = "#152987";
            $color_name = trans("authenticated.BLUE");
        }elseif (in_array($ball_number, config("constants.PURPLE_BALL"))){
            $color = "#6250A2";
            $color_name = trans("authenticated.PURPLE");
        }elseif (in_array($ball_number, config("constants.BROWN_BALL"))){
            $color = "#693E17";
            $color_name = trans("authenticated.BROWN");
        }elseif (in_array($ball_number, config("constants.YELLOW_BALL"))){
            $color = "#C9D436";
            $color_name = trans("authenticated.YELLOW");
        }elseif (in_array($ball_number, config("constants.ORANGE_BALL"))){
            $color = "#D96427";
            $color_name = trans("authenticated.ORANGE");
        }elseif (in_array($ball_number, config("constants.BLACK_BALL"))){
            $color = "#000000";
            $color_name = trans("authenticated.BLACK");
        }

        $result["color"] = $color;
        $result["color_name"] = $color_name;

        return $result;
    }

    public static function sortDatatableReportString($arrData, $column, $direction){
        $sort_by = array();
        foreach ($arrData as $key => $data) {
            $sort_by[$key] = $data[$column];
        }
        if($direction == 'asc' || $direction == 'ASC'){
            array_multisort($sort_by, SORT_ASC, SORT_STRING | SORT_FLAG_CASE, $arrData);
        }else {
            array_multisort($sort_by, SORT_DESC, SORT_STRING | SORT_FLAG_CASE, $arrData);
        }
        return $arrData;
    }

    public static function sortDatatableReportNumberInteger($arrData, $column, $direction){
        $sort_by = array();
        foreach ($arrData as $key => $data) {
            $temp = str_replace(',', '', $data[$column]);
            $sort_by[$key] = intval($temp);
        }
        if($direction == 'asc' || $direction == 'ASC'){
            array_multisort($sort_by, SORT_ASC, SORT_REGULAR, $arrData);
        }else {
            array_multisort($sort_by, SORT_DESC, SORT_REGULAR, $arrData);
        }
        return $arrData;
    }

    public static function sortDatatableReportNumberDouble($arrData, $column, $direction){
        $sort_by = array();
        foreach ($arrData as $key => $data) {
            $temp = str_replace(',', '', $data[$column]);
            $sort_by[$key] = doubleval($temp);
        }
        //print_r($sort_by);
        if($direction == 'asc' || $direction == 'ASC'){
            array_multisort($sort_by, SORT_ASC, SORT_NUMERIC, $arrData);
        }else {
            array_multisort($sort_by, SORT_DESC, SORT_NUMERIC, $arrData);
        }
        return $arrData;
    }

    public static function sortDatatableReportDate($arrData, $column, $direction){
        $sort_by = array();
        foreach ($arrData as $key => $data) {
            $sort_by[$key] = $data[$column];
        }
        if($direction == 'asc' || $direction == 'ASC'){
            array_multisort($sort_by, SORT_ASC, SORT_REGULAR, $arrData);
        }else {
            array_multisort($sort_by, SORT_DESC, SORT_REGULAR, $arrData);
        }
        return $arrData;
    }
}