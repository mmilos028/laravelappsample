<?php

namespace App\Http\Controllers\Authenticated\Administration\Language_Setup;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\CurrencyModel;

class LanguageFileSetupController extends Controller
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

    /*public function manageAuthenticatedLanguageFiles(Request $request)
    {

        if($request->isMethod("POST")) {
            if($request->has('change_language')) {
                $language_file = $request->get('select_language');
            }else{
                $language_file = "administration";
            }
        }else{
            $language_file = "administration";
        }

        $list_language_files = [
            'administration' => 'Administration',
            'player' => 'Player',
            'terminal' => 'Terminal',
            'user' => 'User',
            'errors' => 'Errors',
            'mobile_menu' => 'Mobile Menu',
            'ticket' => 'Ticket',
            'forms' => 'Forms',
        ];


        $locale = \App::getLocale();
        $english_public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . "en" . DIRECTORY_SEPARATOR . "authenticated" . DIRECTORY_SEPARATOR . $language_file . DIRECTORY_SEPARATOR;
        $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . "authenticated" . DIRECTORY_SEPARATOR . $language_file . DIRECTORY_SEPARATOR;
        $file_with_translations = "translation.php";
        $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . "authenticated" . DIRECTORY_SEPARATOR . $language_file . DIRECTORY_SEPARATOR;
        $backup_copy_file = "translation" . "_" . date('d-M-Y_H-i-s') . ".php";
        $view_location = '/authenticated/administration/language-setup/manage-authenticated-language-files';

        //if language file does not exist, then copy english language file to that location
        if(!file_exists($public_language_location . $file_with_translations)){
            mkdir($public_language_location, 0777, true);
            copy($english_public_language_location . $file_with_translations, $public_language_location . $file_with_translations);
        }

        if($request->isMethod("POST")) {
            if($request->has('cancel')){
                $translations = require_once($public_language_location . $file_with_translations);
                return view(
                   $view_location,
                   array(
                       "translations"=>$translations,
                       "list_languages" => $list_language_files,
                       "language_file"=>$language_file
                   )
                )->with("information_message", __("authenticated.Page has been refreshed"));
            }
            //add new translation key-value to language file
            if($request->has('add_new_language_key')) {
                $new_translation_key = $request->get('new_translation_key');
                $new_translation_value = $request->get('new_translation_value');

                $used_language_file = $request->get('used_language');
                if(!isset($used_language_file)){
                    $used_language_file = $language_file;
                }else{
                    $language_file = $used_language_file;
                }
                $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . "authenticated" . DIRECTORY_SEPARATOR . $used_language_file . DIRECTORY_SEPARATOR;
                $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . "authenticated" . DIRECTORY_SEPARATOR . $used_language_file . DIRECTORY_SEPARATOR;
                $backup_copy_file = "translation" . "_" . date('d-M-Y_H-i-s') . ".php";

                if (isset($new_translation_key) && isset($new_translation_value)) {
                    mkdir($public_backup_language_location, 0777, true);
                    copy($public_language_location . $file_with_translations, $public_backup_language_location . $backup_copy_file);

                    $translationvalue_array = require_once($public_language_location . $file_with_translations);

                    $data = "<?php\n\n";
                    $data .= "return [\n\n";
                    foreach ($translationvalue_array as $key => $value) {
                        $data .= "\t\"{$key}\"\t=>\t\"{$value}\",\n";
                    }
                    $data .= "\t\"{$new_translation_key}\"\t=>\t\"{$new_translation_value}\",\n";
                    $data .= "\n";
                    $data .= "];";
                    file_put_contents(($public_language_location . $file_with_translations), $data, LOCK_EX);
                    $translations = require_once($public_language_location . $file_with_translations);
                    return view(
                        $view_location,
                        array(
                            "translations" => $translations,
                            "list_languages" => $list_language_files,
                            "language_file"=>$language_file
                        )
                    )->with('success_message', __("authenticated.New Translation saved"));
                }
            }
            //save translation changes to language file
            if($request->has('save')) {
                $translationvalue_array = $request->get('translationvalue');

                $used_language_file = $request->get('used_language');
                if(!isset($used_language_file)){
                    $used_language_file = $language_file;
                }else{
                    $language_file = $used_language_file;
                }
                $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . "authenticated" . DIRECTORY_SEPARATOR . $used_language_file . DIRECTORY_SEPARATOR;
                $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . "authenticated" . DIRECTORY_SEPARATOR . $used_language_file . DIRECTORY_SEPARATOR;
                $backup_copy_file = "translation" . "_" . date('d-M-Y_H-i-s') . ".php";

                if (isset($translationvalue_array)) {
                    mkdir($public_backup_language_location, 0777, true);
                    copy($public_language_location . $file_with_translations, $public_backup_language_location . $backup_copy_file);
                    $data = "<?php\n\n";
                    $data .= "return [\n\n";
                    foreach ($translationvalue_array as $key => $value) {
                        $data .= "\t\"{$key}\"\t=>\t\"{$value}\",\n";
                    }
                    $data .= "\n";
                    $data .= "];";
                    file_put_contents(($public_language_location . $file_with_translations), $data);
                    $translations = require_once($public_language_location . $file_with_translations);
                    return view(
                        $view_location,
                        array(
                            "translations" => $translations,
                            "list_languages" => $list_language_files,
                            "language_file"=>$language_file
                        )
                    )->with('success_message', __("authenticated.Changes saved"));
                }
            }
        }else {
            $translations = require_once($public_language_location . $file_with_translations);
            return view(
                $view_location,
                array(
                    "translations" => $translations,
                    "list_languages" => $list_language_files,
                    "language_file"=>$language_file
                )
            );
        }
        $translations = require_once($public_language_location . $file_with_translations);
        return view(
            $view_location,
            array(
                "translations" => $translations,
                "list_languages" => $list_language_files,
                "language_file"=>$language_file
            )
        );
    }
    */

    /*public function manageNonauthenticatedLanguageFiles(Request $request)
    {
        if($request->isMethod("POST")) {
            if($request->has('change_language')) {
                $language_file = $request->get('select_language');
            }else{
                $language_file = "auth";
            }
        }else{
            $language_file = "auth";
        }

        $list_language_files = [
            'auth' => 'Authentication Screen',
            'desktop_layout' => 'Desktop Template Screen',
            'footer' => 'Footer',
            'forms' => 'Forms',
            'general_messages' => 'General Messages',
            'login_layout' => 'Login Layout',
            'menu' => 'Menu',
            'messages' => 'Messages',
            'page_title' => 'Page Title',
            'pagination' => 'Pagination',
            'passwords' => 'Passwords',
            'validation' => 'Validation'
        ];

        $locale = \App::getLocale();
        $english_public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . "en" . DIRECTORY_SEPARATOR . $language_file . DIRECTORY_SEPARATOR;
        $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $file_with_translations = $language_file . ".php";
        $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $backup_copy_file = $language_file . "_" . date('d-M-Y_H-i-s') . ".php";

        $view_location = '/authenticated/administration/language-setup/manage-nonauthenticated-language-files';

        //if language file does not exist, then copy english language file to that location
        if(!file_exists($public_language_location . $file_with_translations)){
            mkdir($public_language_location, 0777, true);
            copy($english_public_language_location . $file_with_translations, $public_language_location . $file_with_translations);
        }

        if($request->isMethod("POST")) {
            if($request->has('cancel')){
                $translations = require_once($public_language_location . $file_with_translations);
                return view(
                   $view_location,
                   array(
                       "translations"=>$translations,
                       "list_languages" => $list_language_files,
                       "language_file" => $language_file
                   )
                )->with("information_message", __("authenticated.Page has been refreshed"));
            }
            //add new translation key-value to language file
            if($request->has('add_new_language_key')) {
                $new_translation_key = $request->get('new_translation_key');
                $new_translation_value = $request->get('new_translation_value');

                $used_language_file = $request->get('used_language');
                if(!isset($used_language_file)){
                    $used_language_file = $language_file;
                }else{
                    $language_file = $used_language_file;
                }
                $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
                $file_with_translations = $language_file . ".php";
                $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
                $backup_copy_file = $language_file . "_" . date('d-M-Y_H-i-s') . ".php";

                if (isset($new_translation_key) && isset($new_translation_value)) {
                    mkdir($public_backup_language_location, 0777, true);
                    copy($public_language_location . $file_with_translations, $public_backup_language_location . $backup_copy_file);

                    $translationvalue_array = require_once($public_language_location . $file_with_translations);

                    $data = "<?php\n\n";
                    $data .= "return [\n\n";
                    foreach ($translationvalue_array as $key => $value) {
                        $data .= "\t\"{$key}\"\t=>\t\"{$value}\",\n";
                    }
                    $data .= "\t\"{$new_translation_key}\"\t=>\t\"{$new_translation_value}\",\n";
                    $data .= "\n";
                    $data .= "];";
                    file_put_contents(($public_language_location . $file_with_translations), $data, LOCK_EX);
                    $translations = require_once($public_language_location . $file_with_translations);
                    return view(
                        $view_location,
                        array(
                            "translations" => $translations,
                            "list_languages" => $list_language_files,
                            "language_file" => $language_file
                        )
                    )->with('success_message', __("authenticated.New Translation saved"));
                }
            }
            //save translation changes to language file
            if($request->has('save')) {
                $translationvalue_array = $request->get('translationvalue');

                $used_language_file = $request->get('used_language');
                if(!isset($used_language_file)){
                    $used_language_file = $language_file;
                }else{
                    $language_file = $used_language_file;
                }

                $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
                $file_with_translations = $language_file . ".php";
                $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
                $backup_copy_file = $language_file . "_" . date('d-M-Y_H-i-s') . ".php";

                if (isset($translationvalue_array)) {
                    mkdir($public_backup_language_location, 0777, true);
                    copy($public_language_location . $file_with_translations, $public_backup_language_location . $backup_copy_file);
                    $data = "<?php\n\n";
                    $data .= "return [\n\n";
                    foreach ($translationvalue_array as $key => $value) {
                        $data .= "\t\"{$key}\"\t=>\t\"{$value}\",\n";
                    }
                    $data .= "\n";
                    $data .= "];";
                    file_put_contents(($public_language_location . $file_with_translations), $data);
                    $translations = require_once($public_language_location . $file_with_translations);
                    return view(
                        $view_location,
                        array(
                            "translations" => $translations,
                            "list_languages" => $list_language_files,
                            "language_file" => $language_file
                        )
                    )->with('success_message', __("authenticated.Changes saved"));
                }
            }
        }else {
            $translations = require_once($public_language_location . $file_with_translations);
            return view(
                $view_location,
                array(
                    "translations" => $translations,
                    "list_languages" => $list_language_files,
                    "language_file" => $language_file
                )
            );
        }
        $translations = require_once($public_language_location . $file_with_translations);
        return view(
            $view_location,
            array(
                "translations" => $translations,
                "list_languages" => $list_language_files,
                "language_file" => $language_file
            )
        );
    }*/

    public function listLanguageFileForLogin(Request $request)
    {
        $locale = \App::getLocale();
        $english_public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . "en" . DIRECTORY_SEPARATOR;
        $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $file_with_translations = "login.php";
        $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $backup_copy_file = "login" . "_" . date('d-M-Y_H-i-s') . ".php";
        $view_location = '/authenticated/administration/language-setup/list-language-file-for-login';

        //if language file does not exist, then copy english language file to that location
        if(!file_exists($public_language_location . $file_with_translations)){
            mkdir($public_language_location, 0777, true);
            copy($english_public_language_location . $file_with_translations, $public_language_location . $file_with_translations);
        }

        if($request->isMethod("POST")) {

            if($request->has('cancel')){
                $translations = require_once($public_language_location . $file_with_translations);
                return view(
                   $view_location,
                   array(
                       "translations"=>$translations,
                   )
                )->with("information_message", __("authenticated.Page has been refreshed"));
            }

            $translationvalue_array = $request->get('translationvalue');
            if (isset($translationvalue_array)) {
                //create backup location and backup file with current date / time before changing file itself
                mkdir($public_backup_language_location, 0777, true);
                copy($public_language_location . $file_with_translations, $public_backup_language_location . $backup_copy_file);

                $data = "<?php\n\n";
                $data .= "return [\n\n";
                foreach ($translationvalue_array as $key => $value) {
                    $data .= "\t\"{$key}\"\t=>\t\"{$value}\",\n";
                }
                $data .= "\n";
                $data .= "];";
                file_put_contents(($public_language_location . $file_with_translations), $data);
                $translations = require_once($public_language_location . $file_with_translations);
                return view(
                    $view_location,
                    array(
                        "translations"=>$translations,
                    )
                 )->with('success_message', __("authenticated.Changes saved"));
            }
        }else {
            $translations = require_once($public_language_location . $file_with_translations);
            return view(
                $view_location,
                array(
                    "translations" => $translations,
                )
            );
        }
        $translations = require_once($public_language_location . $file_with_translations);
        return view(
            $view_location,
            array(
                "translations" => $translations,
            )
        );
    }

    public function listLanguageFileForAuthenticated(Request $request)
    {
        $locale = \App::getLocale();
        $english_public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . "en" . DIRECTORY_SEPARATOR;
        $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $file_with_translations = "authenticated.php";
        $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $backup_copy_file = "authenticated" . "_" . date('d-M-Y_H-i-s') . ".php";
        $view_location = '/authenticated/administration/language-setup/list-language-file-for-authenticated';

        //if language file does not exist, then copy english language file to that location
        if(!file_exists($public_language_location . $file_with_translations)){
            mkdir($public_language_location, 0777, true);
            copy($english_public_language_location . $file_with_translations, $public_language_location . $file_with_translations);
        }

        if($request->isMethod("POST")) {
            if($request->has('cancel')){
                $translations = require_once($public_language_location . $file_with_translations);
                return view(
                   $view_location,
                   array(
                       "translations"=>$translations,
                   )
                )->with("information_message", __("authenticated.Page has been refreshed"));
            }
            $translationvalue_array = $request->get('translationvalue');
            if (isset($translationvalue_array)) {
                mkdir($public_backup_language_location, 0777, true);
                copy($public_language_location . $file_with_translations, $public_backup_language_location . $backup_copy_file);
                $data = "<?php\n\n";
                $data .= "return [\n\n";
                foreach ($translationvalue_array as $key => $value) {
                    $data .= "\t\"{$key}\"\t=>\t\"{$value}\",\n";
                }
                $data .= "\n";
                $data .= "];";
                file_put_contents(($public_language_location . $file_with_translations), $data);
                $translations = require_once($public_language_location . $file_with_translations);
                return view(
                    $view_location,
                    array(
                        "translations"=>$translations,
                    )
                 )->with('success_message', __("authenticated.Changes saved"));
            }
        }else {
            $translations = require_once($public_language_location . $file_with_translations);
            return view(
                $view_location,
                array(
                    "translations" => $translations,
                )
            );
        }
        $translations = require_once($public_language_location . $file_with_translations);
        return view(
            $view_location,
            array(
                "translations" => $translations,
            )
        );
    }

    public function listLanguageFileForValidation(Request $request)
    {
        $locale = \App::getLocale();
        $english_public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . "en" . DIRECTORY_SEPARATOR;
        $public_language_location = resource_path() . DIRECTORY_SEPARATOR  . "lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $file_with_translations = "validation.php";
        $public_backup_language_location = resource_path() . DIRECTORY_SEPARATOR  . "backup_lang" . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $backup_copy_file = "validation" . "_" . date('d-M-Y_H-i-s') . ".php";
        $view_location = '/authenticated/administration/language-setup/list-language-file-for-validation';

        //if language file does not exist, then copy english language file to that location
        if(!file_exists($public_language_location . $file_with_translations)){
            mkdir($public_language_location, 0777, true);
            copy($english_public_language_location . $file_with_translations, $public_language_location . $file_with_translations);
        }

        if($request->isMethod("POST")) {
            if($request->has('cancel')){
                $translations = require_once($public_language_location . $file_with_translations);
                return view(
                   $view_location,
                   array(
                       "translations"=>$translations,
                   )
                )->with("information_message", __("authenticated.Page has been refreshed"));
            }
            $translationvalue_array = $request->get('translationvalue');
            if (isset($translationvalue_array)) {
                mkdir($public_backup_language_location, 0777, true);
                copy($public_language_location . $file_with_translations, $public_backup_language_location . $backup_copy_file);
                $data = "<?php\n\n";
                $data .= "return [\n\n";
                foreach ($translationvalue_array as $key => $value) {
                    $data .= "\t\"{$key}\"\t=>\t\"{$value}\",\n";
                }
                $data .= "\n";
                $data .= "];";
                file_put_contents(($public_language_location . $file_with_translations), $data);
                $translations = require_once($public_language_location . $file_with_translations);
                return view(
                    $view_location,
                    array(
                        "translations"=>$translations,
                    )
                 )->with('success_message', __("authenticated.Changes saved"));
            }
        }else {
            $translations = require_once($public_language_location . $file_with_translations);
            return view(
                $view_location,
                array(
                    "translations" => $translations,
                )
            );
        }
        $translations = require_once($public_language_location . $file_with_translations);
        return view(
            $view_location,
            array(
                "translations" => $translations,
            )
        );
    }

}
