<?php
function getRealIPAddress(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    //if there are ip addresses with , separated as CSV string
    $ip_addresses = explode(",", $ip);
    $ip = $ip_addresses[0];
    return $ip;
}

if(getRealIPAddress() == "192.168.3.63"){
    header("Location: http://192.168.3.63/backoffice-tombola/public/");
}else {
    header("Location: http://www.example.com/tombolabackoffice/public/");
}