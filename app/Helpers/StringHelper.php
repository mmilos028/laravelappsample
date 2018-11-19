<?php
namespace App\Helpers;


class StringHelper {

    public static function randomString($prefix = '', $suffix = '', $number_of_letters = 4)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        $characters_length = strlen($characters);
        for ($i = 0; $i < $number_of_letters; $i++) {
            $randstring .= $characters[rand(0, $characters_length - 1)];
        }
        return $prefix . $randstring . $suffix;
    }

    public static function player_random_name($prefix = 'tstpl', $suffix = '', $number_of_letters = 4){
        return self::RandomString($prefix, $suffix, $number_of_letters);
    }
}