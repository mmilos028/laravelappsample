<?php
return [
    define("URL_API_KEY", "eedfd514ca879816f4821d551d060574c2b9d87517c0db9842022a0b4a1786bc"),
    define("UNDER", 1),
    define("OVER", 2),
    define("NUMBER_SUM_LIMIT", 122.5),
    define("NUMBER_LIMIT", 24.5),
    define("FREE", -1),
    define("CONTROL", 1),
    define("ACTIVE", 1),
    define("INACTIVE", -1),
    define("BET_WIN_START_POINT", 80),
    define("BET_WIN_END_POINT", 99),
    define("DRAW_MODEL_HOURS_START_POINT", 0),
    define("DRAW_MODEL_HOURS_END_POINT", 23),
    define("DRAW_MODEL_MIN_START_POINT", 0),
    define("DRAW_MODEL_MIN_END_POINT", 55),
    define("DRAW_MODEL_MIN_SEQUENCE", 5),
    //params
    define("MIN_BET_PER_TICKET_PARAMETER", 2),
    define("MAX_BET_PER_TICKET_PARAMETER", 3),
    define("WAITING_MINUTES_NEXT_DRAW_PARAMETER", 4),
    define("MIN_BET_PER_COMBINATION_PARAMETER", 9),
    define("MAX_BET_PER_COMBINATION_PARAMETER", 10),
    define("MAX_PAYOUT_VALUE_PARAMETER", 11),
    define("START_TIME_PER_DAY_FIRST_DRAW_PARAMETER", 12),
    define("FINISHING_TIM_STAMP_LAST_DRAW_PARAMETER", 13),
    define("PRINT_CONTROL_TICKET_PARAMETER", 15),
    define("CONTROL_PREFERRED_TICKET_PARAMETER", 16),
    define("MAX_POSSIBLE_WIN_REAL_PARAMETER", 18),
    define("CONTROL_FILTER_MAX_WIN_PER_TICKET_PARAMETER", 19),
    define("CONTROL_FILTER_ALWAYS_POSITIVE_BET_PARAMETER", 20),
    define("TAB_DAILY_REPORT_PARAMETER", 21),
    define("TAB_MONTHLY_REPORT_PARAMETER", 22),
    define("TAB_CASHIER_TRANSFER_PARAMETER", 23),
    define("VIRTUAL_KEYBOARD_PARAMETER", 24),

    define("PARAMS_FORBIDDEN_FOR_DELETION",
        array(
            MIN_BET_PER_TICKET_PARAMETER, MAX_BET_PER_TICKET_PARAMETER, WAITING_MINUTES_NEXT_DRAW_PARAMETER, MIN_BET_PER_COMBINATION_PARAMETER,
            MAX_BET_PER_COMBINATION_PARAMETER, MAX_PAYOUT_VALUE_PARAMETER, START_TIME_PER_DAY_FIRST_DRAW_PARAMETER, FINISHING_TIM_STAMP_LAST_DRAW_PARAMETER
        )
    ),

    define("ORDER_OF_DRAWN_BALL", array(6,7,8,9,10,11,12,13,14,15)),
    define("QUOTA", array(10000,7500,5000,2500,1000,500,300,200,150,100)),
    define("ORDER_OF_DRAWN_BALL_2", array(16,17,18,19,20,21,22,23,24,25)),
    define("QUOTA_2", array(90,80,70,60,50,40,30,25,20,15)),
    define("ORDER_OF_DRAWN_BALL_3", array(26,27,28,29,30,31,32,33,34,35)),
    define("QUOTA_3", array(10,9,8,7,6,5,4,3,2,1)),

    define("COEFFICIENTS",array(
        array("name" => "COLOR GAME", "value" => 7.2),
        array("name" => "SUM FIRST FIVE", "value" => 1.8),
        array("name" => "EVEN/ODD", "value" => 1.8),
        array("name" => "UNDER/OVER", "value" => 1.8),
        array("name" => "FIRST BALL COLOR", "value" => 7.2),
        array("name" => "FIRST BALL NUMBER", "value" => 43.2),
        array("name" => "FREQUENT COLORS", "value" => 7.2),
        array("name" => "LAST BALL COLOR", "value" => 7.2),
        array("name" => "LAST BALL NUMBER", "value" => 43.2)
    )),

    "ROOT_MASTER_ID" => 1,
    "ROOT_MASTER" => "MASTER",
    "LUCKY_SIX_ID" => 50,
    //combination types
    "normal_6_48_id" => 1,
    "system_game_7_id" => 2,
    "system_game_8_id" => 3,
    "system_game_9_id" => 4,
    "system_game_10_id" => 5,
    "color_game" => 6,
    "sum_first_5" => 7,
    "first_5_even_odd" => 8,
    "first_ball_hi_low" => 9,
    "first_ball_even_odd" => 10,
    "first_ball_color" => 11,
    "first_ball_number" => 12,
    "more_even_odd" => 13,
    "frequent_colors" => 14,
    "last_ball_hi_low" => 15,
    "last_ball_even_odd" => 16,
    "last_ball_color" => 17,
    "last_ball_number" => 18,
    //combination types end
    //transaction types
    "PAY-IN" => "PAY-IN",
    "PAY-OUT" => "PAY-OUT",
    "CREATE TICKET" => "CREATE TICKET",
    "TICKET STORNO" => "TICKET STORNO",
    "BUY TICKET" => "BUY TICKET",
    "SELL TICKET" => "SELL TICKET",
    "CASHIER PAY OUT" => "CASHIER PAY OUT",
    "TRANSFER_TO_CASHIER" => "TRANSFER_TO_CASHIER",
    "TRANSFER_FROM_CASHIER" => "TRANSFER_FROM_CASHIER",
    "TRANSFER_ALL_FROM_CASHIER" => "TRANSFER_ALL_FROM_CASHIER",
    //transaction types end
    "priority_100" => 1, //100%
    "priority_50" => 2, //50%
    "priority_0" => 3, //0%
    "ADMINISTRATOR_SYSTEM" => "ADMINISTRATOR_SYSTEM",
    "ADMINISTRATOR_SYSTEM_ID" => 4,
    "ADMINISTRATOR_CLIENT" => "ADMINISTRATOR_CLIENT",
    "ADMINISTRATOR_CLIENT_ID" => 13,
    "ADMINISTRATOR_LOCATION" => "ADMINISTRATOR_LOCATION",
    "ADMINISTRATOR_OPERATER" => "ADMINISTRATOR_OPERATER",
    "ADMINISTRATOR_OPERATER_ID" => 19,
    'MASTER_TYPE_ID' => 1,
    'MASTER_TYPE_NAME' => 'MASTER',
    'AFFILIATE_TYPE_ID' => 2,
    'CLIENT_TYPE_ID' => 2,
    'CLIENT_TYPE_NAME' => 'CLIENT',
    'LOCATION_TYPE_ID' => 3,
    'LOCATION_TYPE_NAME' => 'LOCATION',
    'ADMINISTRATOR_TYPE_ID' => 4,
    'ADMINISTRATOR_TYPE_NAME' => 'ADMINISTRATOR',
    'PLAYER_TYPE_ID' => 5,
    'PLAYER_TYPE_NAME' => 'PLAYER',
    'CASHIER_TYPE_ID' => 6,
    'CASHIER_TYPE_NAME' => 'CASHIER',
    'COLLECTOR_TYPE_ID'=>7,
    'COLLECTOR_TYPE_NAME'=>'COLLECTOR',
    'SUPPORT_TYPE_ID'=>8,
    'SUPPORT_TYPE_NAME'=>'SUPPORT',
    'OPERATER_TYPE_ID' => 9,
    'SHIFT_CASHIER_TYPE_ID' => 23,
    'SHIFT_CASHIER' => "SHIFT_CASHIER",
    'OPERATER_TYPE_NAME' => 'OPERATER',
	'TERMINAL_TYPE_NAME' => 'TERMINAL',
	'TERMINAL_TYPE_ID' => 10,
	'TERMINAL_CASHIER_TYPE_NAME' => 'TERMINAL CASHIER',
	'TERMINAL_CASHIER_TYPE_ID' => 11,
    'TERMINAL_SALES_TYPE_ID' => 12,
    'SELF_SERVICE_TERMINAL_ID' => 22,
    'SELF_SERVICE_TERMINAL' => "SELF_SERVICE",
    "TERMINAL_SALES" => "TERMINAL_SALES",
    'TERMINAL_TV_TYPE_ID' => 21,
    'TERMINAL_TV' => "TERMINAL_TV",
	'TERMINAL_APP_NAME' => 'TERMINAL APP',
	'TERMINAL_APP_ID' => 10,
    'BACKOFFICE_SUBJECT_TYPE_ID' => 0,
    'PLAYER_SUBJECT_TYPE_ID' => 5,
    'ADMINISTRATOR_LOCATION_ID' => 17,
    'SUPPORT_OPERATER_TYPE_ID' => 16,
    'TERMINAL_SELF_SERVICE_ID' => 22,
    'TABLE_STATE_SAVE' => false,
    'TABLE_STATE_DURATION' => -1,
    'ROLE_MASTER' => 'MASTER',
    'ROLE_CLIENT' => 'CLIENT',
    'ROLE_LOCATION' => 'LOCATION',
    'ROLE_CASHIER' => 'CASHIER',
    'ROLE_PLAYER' => 'PLAYER',
    'ROLE_ADMINISTRATOR' => 'ADMINISTRATOR',
    'ROLE_OPERATER' => 'OPERATER',
	'ROLE_TERMINAL' => 'TERMINAL_APP',
	'ROLE_CASHIER_TERMINAL' => 'CASHIER_TERMINAL',
    'ROLE_SUPPORT' => 'SUPPORT',
    'ROLE_SUPPORT_SYSTEM' => 'SUPPORT_SYSTEM',
    'ROLE_ADMINISTRATOR_CLIENT' => 'ADMINISTRATOR_CLIENT',
    'ROLE_ADMINISTRATOR_LOCATION' => 'ADMINISTRATOR_LOCATION',
    'ROLE_ADMINISTRATOR_OPERATER' => 'ADMINISTRATOR_OPERATER',
    'ROLE_ADMINISTRATOR_SYSTEM' => 'ADMINISTRATOR_SYSTEM',
    'ROLE_SUPPORT_CLIENT' => 'SUPPORT_CLIENT',
    'ROLE_SUPPORT_OPERATER' => 'SUPPORT_OPERATER',
    'ROLE_TERMINAL_TV' => 'TERMINAL_TV',
    'ROLE_TERMINAL_SELF_SERVICE' => 'SELF_SERVICE',
    "MASTER_SYSTEM_ID" => 1,
    "LOCAL_POT" => 1,
    "GLOBAL_POT" => 2,
    //DEVICES
    "PC" => 1,
    "REST" => 2,
    //BALL COLORS
    "RED_BALL" => array(1,9,17,25,33,41),
    "GREEN_BALL" => array(2,10,18,26,34,42),
    "BLUE_BALL" => array(3,11,19,27,35,43),
    "PURPLE_BALL" => array(4,12,20,28,36,44),
    "BROWN_BALL" => array(5,13,21,29,37,45),
    "YELLOW_BALL" => array(6,14,22,30,38,46),
    "ORANGE_BALL" => array(7,15,23,31,39,47),
    "BLACK_BALL" => array(8,16,24,32,40,48),
];
