<?php
namespace App\Helpers;


class LanguageHelper {

    public static function getListSupportedLanguages(){
        return [
            "en_GB" => __("authenticated.English"),
            "de_DE" => __("authenticated.German"),
            "se_SE" => __("authenticated.Swedish"),
            "da_DK" => __("authenticated.Danish"),
            "it_IT" => __("authenticated.Italian"),
            "ru_RU" => __("authenticated.Russian"),
            "pl_PL" => __("authenticated.Polish"),
            "hr_HR" => __("authenticated.Croatian"),
            "rs_RS" => __("authenticated.Serbian"),
            "tr_TR" => __("authenticated.Turkish"),
            "cs_CZ" => __("authenticated.Czeck"),
        ];
    }

    public static function isSupportedLanugage($key){
        return array_key_exists($key, self::getListSupportedLanguages());
    }

    public static function getDefaultLanguage(){
        return "en_GB";
    }
}