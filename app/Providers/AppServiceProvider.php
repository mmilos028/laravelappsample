<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Validator;
use Session;
use App\Models\Postgres\UserModel;

use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //log error levels - production

        error_reporting(env('PHP_SETTINGS_ERROR_REPORTING', 0));
        ini_set('log_errors', env('PHP_SETTINGS_LOG_ERRORS', 0));
        ini_set('display_errors', env('PHP_SETTINGS_DISPLAY_ERRORS', 0));

        //log error levels - development

        /*
        error_reporting(E_ALL | E_STRICT);
        ini_set("display_errors", 1);
        ini_set("display_startup_errors", 1);
        */

        //dd(view());

        Validator::extend('draw_model_time_validation', function($attribute, $value, $parameters, $validator) {
            $passed_field_name1 = $parameters[0];
            $passed_field_name2 = $parameters[1];
            $passed_field_name3 = $parameters[2];
            $data = $validator->getData();

            $passed_field_value_active_period_from_h = $value;
            $passed_field_value_active_period_from_min = $data[$passed_field_name1];
            $passed_field_value_active_period_to_h = $data[$passed_field_name2];
            $passed_field_value_active_period_to_min = $data[$passed_field_name3];

            $from_time = $passed_field_value_active_period_from_h*60 + $passed_field_value_active_period_from_min;
            $to_time = $passed_field_value_active_period_to_h*60 + $passed_field_value_active_period_to_min;

            if($from_time >= $to_time){
                return false;
            }else{
                return true;
            }
        });
        Validator::replacer('draw_model_time_validation', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });


        //Stefan: custom validator to prohibit that the certain field value is lesser than the passed field value
        Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
            $passed_filed_name = $parameters[0];
            $data = $validator->getData();
            $passed_field_value = intval($data[$passed_filed_name]);

            //dd($passed_field_value);

            if($value > $passed_field_value){
                return true;
            }else{
                return false;
            }
        });
        Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });

        Validator::extend('lesser_than_field', function($attribute, $value, $parameters, $validator) {
            $passed_filed_name = $parameters[0];
            $data = $validator->getData();
            $passed_field_value = intval($data[$passed_filed_name]);

            //dd($passed_field_value);

            if($value < $passed_field_value){
                return true;
            }else{
                return false;
            }
        });
        Validator::replacer('lesser_than_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });

        //Stefan: custom validator for integer numbers which are positive
        Validator::extend('positive_integer_number', function($attribute, $value, $parameters, $validator) {
            $passed_filed_name = $parameters[0];
            $data = $validator->getData();
            $passed_field_value = $data[$passed_filed_name];

            if (is_numeric($value) && $value >= 1 && $value == round($value)) {
                return true;
            }else{
                return false;
            }
        });
        Validator::replacer('positive_integer_number', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });

        //set controller, action variables with current active route controller and action names
        view()->composer('layouts.mobile_layout.header_navigation', function($view)
            {
                if(app('request')->route() != null){
                    $action = app('request')->route()->getAction();

                    $controller_full_path = $action['controller'];
					list($controller, $action) = explode('@', $controller_full_path);
					$temp_controller_full_path = $controller;
                    $controller = class_basename($controller);

                    $flag_terminal_menu = false;

                    if($controller === "TerminalController"){
                      switch ($action){
                        case "details":
                        case "updateTerminal":
                        case "changePassword":
                        case "codeList":
                          $flag_terminal_menu = true;
                          break;
                        default:
                          $flag_terminal_menu = false;
                      }
                    }
					
					if(strpos($controller_full_path, 'Authenticated\Terminal\Report\TerminalReportController') !== false){
						switch($action){
							case 'listMoneyTransactions':
							case 'listPlayerTickets':
							case 'listLoginHistory':
								$flag_terminal_menu = true;
								break;								
							default: 
								$flag_terminal_menu = false;
						}
					}
					
					if($controller === "PlayerController"){
                      switch ($action){
                        case "details":
                        case "updatePlayer":
                        case "changePassword":
                          $flag_player_menu = true;
                          break;
                        default:
                          $flag_player_menu = false;
                      }
                    }
					
					if(strpos($controller_full_path, 'Authenticated\Player\Report\PlayerReportController') !== false){
						switch($action){
							case 'listMoneyTransactions':
							case 'listPlayerTickets':
                            case 'listLoginHistory':
								$flag_player_menu = true;
								break;
							default: 
								$flag_player_menu = false;
						}
					}
					
					if($controller === "TicketController"){
                      switch ($action){
                        case "ticketDetails":
                        case "ticketDetailsWithSerialNumber":
						case "listWinsForTicket":
                          $flag_ticket_details_menu = true;
                          break;
                        default:
                          $flag_ticket_details_menu = false;
                      }
                    }

                    if($controller === "AdministratorController"){
                        switch ($action){
                            case "details":
                            case "updateAdministrator":
                            case "changePassword":
                            $flag_administrator_menu = true;
                            break;
                            default:
                            $flag_administrator_menu = false;
                        }
                    }

                    if(strpos($controller_full_path, 'Authenticated\Administrator\Report\AdministratorReportController') !== false){
                        switch ($action){
                            case "listLoginHistory":
                            $flag_administrator_menu = true;
                            break;
                            default:
                            $flag_administrator_menu = false;
                        }
                    }

                    if($controller === "UserController"){
                        switch ($action){
                            case "details":
                            case "updateUser":
                            case "changePassword":
                            $flag_user_menu = true;
                            break;
                            default:
                            $flag_user_menu = false;
                        }
                    }

                    if(strpos($controller_full_path, 'Authenticated\User\Report\UserReportController') !== false){
                        switch ($action){
                            case "listLoginHistory":
                            $flag_user_menu = true;
                            break;
                            default:
                            $flag_user_menu = false;
                        }
                    }

                    if($controller === "CashierController"){
                        switch ($action){
                            case "details":
                            case "updateCashier":
                            case "changePassword":
                            case "changePinCode":
                            $flag_cashier_menu = true;
                            break;
                            default:
                            $flag_cashier_menu = false;
                        }
                    }

                    if(strpos($controller_full_path, 'Authenticated\Cashier\Report\CashierReportController') !== false){
						switch($action){
                            case 'listLoginHistory':
								$flag_cashier_menu = true;
								break;
							default:
								$flag_cashier_menu = false;
						}
					}

                    if($controller === "StructureEntityController"){
                        switch ($action){
                            case "details":
                            case "updateEntity":
                            case "changePassword":
                            $flag_structure_entity_menu = true;
                            break;
                            default:
                            $flag_structure_entity_menu = false;
                        }
                    }

                    if(strpos($controller_full_path, 'Authenticated\Administration\DrawModel_Setup\DrawModelSetupController') !== false){
                        $flag_draw_model_setup_menu = true;

					}else{
                        $flag_draw_model_setup_menu = false;
                    }

                    $view->with([
                        "user_id" => $this->app->request->route('user_id'),
                        "user_type" => $this->app->request->route('user_type'),
                        "controller" => $controller,
					    "controller_full_path" => $controller_full_path,
                        "action" => $action,
                        "show_terminal_menu" => $flag_terminal_menu,
					    "show_player_menu" => $flag_player_menu,
					    "show_ticket_details_menu" => $flag_ticket_details_menu,
                        "show_draw_model_setup_menu" => $flag_draw_model_setup_menu,
                        "show_administrator_menu" => $flag_administrator_menu,
                        "show_user_menu" => $flag_user_menu,
                        "show_cashier_menu" => $flag_cashier_menu,
                        "show_structure_entity_menu" => $flag_structure_entity_menu
                    ]);
                }
            }
        );

        view()->composer('layouts.desktop_layout.left_sidebar_menu', function($view)
            {
                if(app('request')->route() != null){
                    $action = app('request')->route()->getAction();

					$controller_full_path = $action['controller'];
					list($controller, $action) = explode('@', $controller_full_path);
					$temp_controller_full_path = $controller;
                    $controller = class_basename($controller);
					
					// dd($temp_controller_full_path);

                    $view->with([
                      "user_id" => $this->app->request->route('user_id'),
                      "controller" => $controller,
					  "controller_full_path" => $temp_controller_full_path,
                      "action" => $action
                    ]);
                }
            }
        );

        view()->composer('layouts.desktop_layout.header_navigation_second', function($view)
        {
            if(app('request')->route() != null){
                $action = app('request')->route()->getAction();

                $controller_full_path = $action['controller'];
                list($controller, $action) = explode('@', $controller_full_path);
                $temp_controller_full_path = $controller;
                $controller = class_basename($controller);

                $flag_terminal_menu = false;

                if($controller === "TerminalController"){
                    switch ($action){
                        case "details":
                        case "updateTerminal":
                        case "changePassword":
                        case "codeList":
                            $flag_terminal_menu = true;
                            break;
                        default:
                            $flag_terminal_menu = false;
                    }
                }

                if(strpos($controller_full_path, 'Authenticated\Terminal\Report\TerminalReportController') !== false){
                    switch($action){
                        case 'listMoneyTransactions':
                        case 'listPlayerTickets':
                        case 'listLoginHistory':
                            $flag_terminal_menu = true;
                            break;
                        default:
                            $flag_terminal_menu = false;
                    }
                }

                $flag_player_menu = false;

                if($controller === "PlayerController"){
                    switch ($action){
                        case "details":
                        case "updatePlayer":
                        case "changePassword":
                            $flag_player_menu = true;
                            break;
                        default:
                            $flag_player_menu = false;
                    }
                }

                if(strpos($controller_full_path, 'Authenticated\Player\Report\PlayerReportController') !== false){
                    switch($action){
                        case 'listMoneyTransactions':
                        case 'listPlayerTickets':
                        case 'listLoginHistory':
                            $flag_player_menu = true;
                            break;
                        default:
                            $flag_player_menu = false;
                    }
                }

                if($controller === "TicketController"){
                    switch ($action){
                        case "ticketDetails":
                        case "ticketDetailsWithSerialNumber":
                        case "listWinsForTicket":
                            $flag_ticket_details_menu = true;
                            break;
                        default:
                            $flag_ticket_details_menu = false;
                    }
                }

                if($controller === "AdministratorController"){
                    switch ($action){
                        case "details":
                        case "updateAdministrator":
                        case "changePassword":
                            $flag_administrator_menu = true;
                            break;
                        default:
                            $flag_administrator_menu = false;
                    }
                }

                if(strpos($controller_full_path, 'Authenticated\Administrator\Report\AdministratorReportController') !== false){
                    switch ($action){
                        case "listLoginHistory":
                            $flag_administrator_menu = true;
                            break;
                        default:
                            $flag_administrator_menu = false;
                    }
                }

                if($controller === "UserController"){
                    switch ($action){
                        case "details":
                        case "updateUser":
                        case "changePassword":
                            $flag_user_menu = true;
                            break;
                        default:
                            $flag_user_menu = false;
                    }
                }

                if(strpos($controller_full_path, 'Authenticated\User\Report\UserReportController') !== false){
                    switch ($action){
                        case "listLoginHistory":
                            $flag_user_menu = true;
                            break;
                        default:
                            $flag_user_menu = false;
                    }
                }

                if($controller === "CashierController"){
                    switch ($action){
                        case "details":
                        case "updateCashier":
                        case "changePassword":
                        case "changePinCode":
                            $flag_cashier_menu = true;
                            break;
                        default:
                            $flag_cashier_menu = false;
                    }
                }

                if(strpos($controller_full_path, 'Authenticated\Cashier\Report\CashierReportController') !== false){
                    switch($action){
                        case 'listLoginHistory':
                            $flag_cashier_menu = true;
                            break;
                        default:
                            $flag_cashier_menu = false;
                    }
                }

                if($controller === "StructureEntityController"){
                    switch ($action){
                        case "details":
                        case "updateEntity":
                        case "changePassword":
                            $flag_structure_entity_menu = true;
                            break;
                        default:
                            $flag_structure_entity_menu = false;
                    }
                }

                if(strpos($controller_full_path, 'Authenticated\Administration\DrawModel_Setup\DrawModelSetupController') !== false){
                    $flag_draw_model_setup_menu = true;

                }else{
                    $flag_draw_model_setup_menu = false;
                }

                $view->with([
                    "user_id" => $this->app->request->route('user_id'),
                    "user_type" => $this->app->request->route('user_type'),
                    "controller" => $controller,
                    "controller_full_path" => $temp_controller_full_path,
                    "action" => $action,
                    "show_terminal_menu" => $flag_terminal_menu,
                    "show_player_menu" => $flag_player_menu,
                    "show_ticket_details_menu" => $flag_ticket_details_menu,
                    "show_draw_model_setup_menu" => $flag_draw_model_setup_menu,
                    "show_administrator_menu" => $flag_administrator_menu,
                    "show_user_menu" => $flag_user_menu,
                    "show_cashier_menu" => $flag_cashier_menu,
                    "show_structure_entity_menu" => $flag_structure_entity_menu
                ]);
            }
        }
        );
		
        view()->composer('layouts.desktop_layout.header', function($view)
            {
                if(app('request')->route() != null){
                    $action = app('request')->route()->getAction();

					$controller_full_path = $action['controller'];
					list($controller, $action) = explode('@', $controller_full_path);
					$temp_controller_full_path = $controller;
                    $controller = class_basename($controller);

                    $flag_terminal_menu = false;

                    if($controller === "TerminalController"){
                      switch ($action){
                        case "details":
                        case "updateTerminal":
                        case "changePassword":
                        case "codeList":
                          $flag_terminal_menu = true;
                          break;
                        default:
                          $flag_terminal_menu = false;
                      }
                    }
					
					if(strpos($controller_full_path, 'Authenticated\Terminal\Report\TerminalReportController') !== false){
						switch($action){
							case 'listMoneyTransactions':
							case 'listPlayerTickets':
							case 'listLoginHistory':
								$flag_terminal_menu = true;
								break;								
							default: 
								$flag_terminal_menu = false;
						}
					}

                    $flag_player_menu = false;

                    if($controller === "PlayerController"){
                      switch ($action){
                        case "details":
                        case "updatePlayer":
                        case "changePassword":
                          $flag_player_menu = true;
                          break;
                        default:
                          $flag_player_menu = false;
                      }
                    }
					
					if(strpos($controller_full_path, 'Authenticated\Player\Report\PlayerReportController') !== false){
						switch($action){
							case 'listMoneyTransactions':
							case 'listPlayerTickets':
							case 'listLoginHistory':
								$flag_player_menu = true;
								break;
							default: 
								$flag_player_menu = false;
						}
					}
					
					if($controller === "TicketController"){
                      switch ($action){
                        case "ticketDetails":
                        case "ticketDetailsWithSerialNumber":
						case "listWinsForTicket":
                          $flag_ticket_details_menu = true;
                          break;
                        default:
                          $flag_ticket_details_menu = false;
                      }
                    }

                    if($controller === "AdministratorController"){
                      switch ($action){
                        case "details":
                        case "updateAdministrator":
                        case "changePassword":
                          $flag_administrator_menu = true;
                          break;
                        default:
                          $flag_administrator_menu = false;
                      }
                    }

                    if(strpos($controller_full_path, 'Authenticated\Administrator\Report\AdministratorReportController') !== false){
                        switch ($action){
                            case "listLoginHistory":
                            $flag_administrator_menu = true;
                            break;
                            default:
                            $flag_administrator_menu = false;
                        }
                    }

                    if($controller === "UserController"){
                      switch ($action){
                        case "details":
                        case "updateUser":
                        case "changePassword":
                          $flag_user_menu = true;
                          break;
                        default:
                          $flag_user_menu = false;
                      }
                    }

                    if(strpos($controller_full_path, 'Authenticated\User\Report\UserReportController') !== false){
                        switch ($action){
                            case "listLoginHistory":
                            $flag_user_menu = true;
                            break;
                            default:
                            $flag_user_menu = false;
                        }
                    }

                    if($controller === "CashierController"){
                        switch ($action){
                            case "details":
                            case "updateCashier":
                            case "changePassword":
                            case "changePinCode":
                            $flag_cashier_menu = true;
                            break;
                            default:
                            $flag_cashier_menu = false;
                        }
                    }

                    if(strpos($controller_full_path, 'Authenticated\Cashier\Report\CashierReportController') !== false){
						switch($action){
                            case 'listLoginHistory':
								$flag_cashier_menu = true;
								break;
							default:
								$flag_cashier_menu = false;
						}
					}

                    if($controller === "StructureEntityController"){
                        switch ($action){
                            case "details":
                            case "updateEntity":
                            case "changePassword":
                            $flag_structure_entity_menu = true;
                            break;
                            default:
                            $flag_structure_entity_menu = false;
                        }
                    }

                    if(strpos($controller_full_path, 'Authenticated\Administration\DrawModel_Setup\DrawModelSetupController') !== false){
                        $flag_draw_model_setup_menu = true;

					}else{
                        $flag_draw_model_setup_menu = false;
                    }

                    $view->with([
                        "user_id" => $this->app->request->route('user_id'),
                        "user_type" => $this->app->request->route('user_type'),
                        "controller" => $controller,
                        "controller_full_path" => $temp_controller_full_path,
                        "action" => $action,
                        "show_terminal_menu" => $flag_terminal_menu,
                        "show_player_menu" => $flag_player_menu,
                        "show_ticket_details_menu" => $flag_ticket_details_menu,
                        "show_draw_model_setup_menu" => $flag_draw_model_setup_menu,
                        "show_administrator_menu" => $flag_administrator_menu,
                        "show_user_menu" => $flag_user_menu,
                        "show_cashier_menu" => $flag_cashier_menu,
                        "show_structure_entity_menu" => $flag_structure_entity_menu
                    ]);
                }
            }
        );

        // Database listener to firebug logs.

        if (env('DB_WRITE_TO_FIREBUG', false) == true) {
            \Illuminate\Support\Facades\DB::listen(
                function ($query) {
                    $sql_call = $query->sql;
                    //var_dump($sql_call);
                    $parameters = "";
                    foreach ($query->bindings as $key => $param) {
                        $parameters .= "{$key} = {$param}  ";
                    }
                    //var_dump($parameters);
                    /*
                    $monolog = Log::getMonolog();
                    $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
                    */
                    $monolog = new \Monolog\Logger('firephp');
                    // Now add some handlers
                    $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());

                    $needle = "fetch all in";
                    if (strpos($sql_call, $needle) === false) {
                        $time = date("d-m-Y H:i:s u");
                        $message = "{$sql_call}";
                        ///$monolog->addInfo($message, array('query' => $query));
                        $monolog->info(" ");
                        $monolog->info("-------------------------------- BEGIN -----------------------------------------------");
                        $monolog->info("CALL TIME >>> " . $time);
                        if(strlen($message) != 0) {
                            $monolog->info("CALL PROCEDURE >>> " . $message);
                        }
                        if(strlen($parameters) != 0) {
                            $monolog->info("PROCEDURE PARAMETERS >>> " . $parameters);
                        }
                        $monolog->info("--------------------------------- END ---------------------------------------------");
                        $monolog->info(" ");
                        $monolog->info(" ");
                    }
                }
            );

        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        // ...
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
            //$this->app->register(\Staudenmeir\DuskUpdater\DuskServiceProvider::class);
        }
    }
}
