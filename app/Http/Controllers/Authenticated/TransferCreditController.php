<?php

namespace App\Http\Controllers\Authenticated;

use App\Helpers\NumberHelper;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Illuminate\Support\Facades\URL;

use App\Models\Postgres\TerminalModel;
use App\Models\Postgres\TransferCreditModel;
use App\Models\Postgres\UserModel;

class TransferCreditController extends Controller
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

    //DEPOSIT LIST

    public function depositList(Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        //$resultListTerminals = TerminalModel::listTerminals($backoffice_session_id);
        $result = TransferCreditModel::listSubjectsForDepositWithdraw($backoffice_session_id);
        //$resultListCashiers = UserModel::listPlayersByType($backoffice_session_id, config("constants.CASHIER_TYPE_ID"));

        //$resultArray = array_merge($resultListTerminals['list_users'], $resultListCashiers['list_users']);

        //dd($result);

        return view(
            '/authenticated/transfer-credit/deposit-list',
            array(
                "list_users" => $result["list_users"],
            )
        );
    }

    public function cashierPlayerDeposit($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $personalInformationResult = UserModel::personalInformation($backoffice_session_id);
        $logged_user_id = $personalInformationResult['user']['user_id'];
        $user_username = $personalInformationResult['user']['username'];

        $userCreditsResult = TransferCreditModel::getCredits($logged_user_id);
        $user_credits = NumberHelper::convert_double($userCreditsResult['credits']);
        $user_credits_formatted = NumberHelper::format_double($userCreditsResult['credits']);

        $playerInformationResult = TerminalModel::terminalInformation($user_id);
        $player_username = $playerInformationResult['user']['username'];
        $currency = $playerInformationResult['user']['currency'];

        $playerCreditsResult = TransferCreditModel::getCredits($user_id);
        $player_credits = NumberHelper::convert_double($playerCreditsResult['credits']);
        $player_credits_formatted = NumberHelper::format_double($playerCreditsResult['credits']);

        if($request->isMethod("POST")) {
            if($request->has('PREVIOUS_PAGE')){
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/deposit-list');
            }
            //validation rules
            $rules = [
                'DIRECT_PLAYER_NAME' => 'required|min:2|max:20',
                'PLAYER_CREDIT_STATUS' => 'required|min:2|max:50',
                'PLAYER_CURRENCY' => 'required|min:2|max:4',
                'TRANSFER_AMOUNT' => 'required|numeric',
            ];

            $messages = [
            ];

            $attributes = [
                'DIRECT_PLAYER_NAME' => __("authenticated.Player Name"),
                'PLAYER_CREDIT_STATUS' => __("authenticated.Player Credit Status"),
                'PLAYER_CURRENCY' => __("authenticated.Currency"),
                'TRANSFER_AMOUNT' => __("authenticated.Transfer Amount"),
            ];

            $this->validate($request, $rules, $messages, $attributes);

            $transaction_sign = "1";
            $transfer_amount = NumberHelper::convert_double($request->get('TRANSFER_AMOUNT_HIDDEN'));
            $transfer_amount_formatted = NumberHelper::format_double($request->get('TRANSFER_AMOUNT_HIDDEN'));
            if(!is_numeric($transfer_amount)){
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-deposit/user_id/' . $user_id)
                    ->with("error_message", __("authenticated.Transfer amount is not a number !"));
            }
            if($transfer_amount <= 0){
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-deposit/user_id/' . $user_id)
                    ->with("error_message",  __("authenticated.Transfer amount must be greater than 0 !"));
            }
            /*if($transfer_amount > $user_credits){
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-withdraw/user_id/' . $user_id)
                    ->with("error_message",  __("authenticated.Value cannot be bigger than affiliate balance !"));
            }*/
            $transactionResult = TransferCreditModel::transferCredits($backoffice_session_id, $logged_user_id, $user_id, $transaction_sign, $transfer_amount);
            if($transactionResult['status'] === 'OK' && $transactionResult['status_out'] == "1") {
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-deposit-completed/user_id/' . $user_id);
            }else{
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-deposit/user_id/' . $user_id)
                    ->with("error_message",  __("authenticated.Player deposit transaction failed !"));
            }
        }else {
            return view(
                '/authenticated/transfer-credit/cashier-player-deposit',
                [
                    "logged_user_id" => $logged_user_id,
                    "user_username" => $user_username,
                    "user_credits" => $user_credits,
                    "user_credits_formatted" => $user_credits_formatted,

                    "user_id" => $user_id,
                    "player_username" => $player_username,
                    "player_credits" => $player_credits,
                    "player_credits_formatted" => $player_credits_formatted,
                    "player_currency" => $currency,
                ]
            );
        }
    }

    public function cashierPlayerDepositCompleted($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $personalInformationResult = UserModel::personalInformation($backoffice_session_id);
        $logged_user_id = $personalInformationResult['user']['user_id'];
        $user_username = $personalInformationResult['user']['username'];

        $userCreditsResult = TransferCreditModel::getCredits($logged_user_id);
        $user_credits = NumberHelper::convert_double($userCreditsResult['credits']);
        $user_credits_formatted = NumberHelper::format_double($userCreditsResult['credits']);

        $playerInformationResult = TerminalModel::terminalInformation($user_id);
        $player_username = $playerInformationResult['user']['username'];
        $currency = $playerInformationResult['user']['currency'];

        $playerCreditsResult = TransferCreditModel::getCredits($user_id);
        $player_credits = NumberHelper::convert_double($playerCreditsResult['credits']);
        $player_credits_formatted = NumberHelper::format_double($playerCreditsResult['credits']);

        if($request->isMethod("POST")) {
            return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/deposit-list');
        }else {
            return view(
                '/authenticated/transfer-credit/cashier-player-deposit-completed',
                [
                    "logged_user_id" => $logged_user_id,
                    "user_username" => $user_username,
                    "user_credits" => $user_credits,
                    "user_credits_formatted" => $user_credits_formatted,

                    "user_id" => $user_id,
                    "player_username" => $player_username,
                    "player_credits" => $player_credits,
                    "player_credits_formatted" => $player_credits_formatted,
                    "player_currency" => $currency
                ]
            )->with("success_message", __("authenticated.Transaction Successfully Completed"));
        }
    }

    //WITHDRAW LIST

    public function withdrawList(Request $request)
    {

        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        //$resultListTerminals = TerminalModel::listTerminals($backoffice_session_id);
        $result = TransferCreditModel::listSubjectsForDepositWithdraw($backoffice_session_id);

        //$resultArray = array_merge($resultListTerminals['list_users'], $resultListCashiers['list_users']);


        return view(
            '/authenticated/transfer-credit/withdraw-list',
            array(
                "list_users" => $result["list_users"],
            )
        );
    }

    public function cashierPlayerWithdraw($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];
        $logged_in_id = $authSessionData['user_id'];

        $personalInformationResult = UserModel::personalInformation($backoffice_session_id);
        $logged_user_id = $personalInformationResult['user']['user_id'];
        $user_username = $personalInformationResult['user']['username'];

        $userCreditsResult = TransferCreditModel::getCredits($logged_user_id);

        $user_credits = NumberHelper::convert_double($userCreditsResult['credits']);
        $user_credits_formatted = NumberHelper::format_double($userCreditsResult['credits']);

        $playerInformationResult = TerminalModel::terminalInformation($user_id);
        $player_username = $playerInformationResult['user']['username'];
        $currency = $playerInformationResult['user']['currency'];

        $playerCreditsResult = TransferCreditModel::getCredits($user_id);
        $player_credits = NumberHelper::convert_double($playerCreditsResult['credits']);
        $player_credits_formatted = NumberHelper::format_double($playerCreditsResult['credits']);

        if($request->isMethod("POST")) {
            if($request->has('PREVIOUS_PAGE')){
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/withdraw-list');
            }

            //validation rules
            $rules = [
                'DIRECT_PLAYER_NAME' => 'required|min:2|max:20',
                'PLAYER_CREDIT_STATUS' => 'required|min:2|max:50',
                'PLAYER_CURRENCY' => 'required|min:2|max:4',
                'CREDIT_AMOUNT' => 'required|numeric',
            ];

            $messages = [
            ];

            $attributes = [
                'DIRECT_PLAYER_NAME' => __("authenticated.Player Name"),
                'PLAYER_CREDIT_STATUS' => __("authenticated.Player Credit Status"),
                'PLAYER_CURRENCY' => __("authenticated.Currency"),
                'CREDIT_AMOUNT' => __("authenticated.Credit Amount"),
            ];

            $this->validate($request, $rules, $messages, $attributes);

            ///$collectorArray = array(config('constants.ROLE_COLLECTOR_LOCATION'), config('constants.ROLE_COLLECTOR_OPERATER'), config('constants.ROLE_COLLECTOR_CLIENT'));

            $transaction_sign = "-1";

            $transfer_amount = $request->get('CREDIT_AMOUNT_HIDDEN');
            if(!is_numeric($transfer_amount)){
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-withdraw/user_id/' . $user_id)
                    ->with("error_message", __("authenticated.Credit amount is not a number !"));
            }
            if($transfer_amount <= 0){
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-withdraw/user_id/' . $user_id)
                    ->with("error_message",  __("authenticated.Credit amount must be greater than 0 !"));
            }
            if($transfer_amount > $player_credits){
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-withdraw/user_id/' . $user_id)
                    ->with("error_message",  __("authenticated.Value cannot be bigger than player balance !"));
            }

            $transactionResult = TransferCreditModel::transferCredits($backoffice_session_id, $user_id, $logged_in_id, $transaction_sign, $transfer_amount);

            if($transactionResult['status'] === 'OK' && $transactionResult['status_out'] == "1") {
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-withdraw-completed/user_id/' . $user_id);
            }else{
                return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/cashier-player-withdraw/user_id/' . $user_id)
                    ->with("error_message",  __("authenticated.Player deposit transaction failed !"));
            }
        }else {

            return view(
                '/authenticated/transfer-credit/cashier-player-withdraw',
                [
                    "logged_user_id" => $logged_user_id,
                    "user_username" => $user_username,
                    "user_credits" => $user_credits,
                    "user_credits_formatted" => $user_credits_formatted,

                    "user_id" => $user_id,
                    "player_username" => $player_username,
                    "player_credits" => $player_credits,
                    "player_credits_formatted" => $player_credits_formatted,
                    "player_currency" => $currency
                ]
            );
        }
    }

    public function cashierPlayerWithdrawCompleted($user_id, Request $request)
    {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $personalInformationResult = UserModel::personalInformation($backoffice_session_id);
        $logged_user_id = $personalInformationResult['user']['user_id'];
        $user_username = $personalInformationResult['user']['username'];

        $userCreditsResult = TransferCreditModel::getCredits($logged_user_id);
        $user_credits = NumberHelper::convert_double($userCreditsResult['credits']);
        $user_credits_formatted = NumberHelper::format_double($userCreditsResult['credits']);

        $playerInformationResult = TerminalModel::terminalInformation($user_id);
        $player_username = $playerInformationResult['user']['username'];
        $currency = $playerInformationResult['user']['currency'];

        $playerCreditsResult = TransferCreditModel::getCredits($user_id);
        $player_credits = NumberHelper::convert_double($playerCreditsResult['credits']);
        $player_credits_formatted = NumberHelper::format_double($playerCreditsResult['credits']);

        if($request->isMethod("POST")) {
            return \Redirect::to('/' . app()->getLocale() . '/transfer-credit/withdraw-list');
        }else {
            return view(
                '/authenticated/transfer-credit/cashier-player-withdraw-completed',
                [
                    "logged_user_id" => $logged_user_id,
                    "user_username" => $user_username,
                    "user_credits" => $user_credits,
                    "user_credits_formatted" => $user_credits_formatted,

                    "user_id" => $user_id,
                    "player_username" => $player_username,
                    "player_credits" => $player_credits,
                    "player_credits_formatted" => $player_credits_formatted,
                    "player_currency" => $currency
                ]
            )->with("success_message", __("authenticated.Transaction Successfully Completed"));
        }
    }

    function getDepositTreeProperties($subject_type){
        $authSessionData = Session::get('auth');
        $logged_in_subject_dtype = $authSessionData['subject_dtype'];

        if($subject_type == config('constants.ROLE_CLIENT')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }
        else if ($subject_type == config('constants.COLLECTOR_TYPE_NAME')) {
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-success";
        }
        else if($subject_type == config("constants.ROLE_ADMINISTRATOR")){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-success";
        }
        else if($subject_type == config("constants.ROLE_ADMINISTRATOR_OPERATER")){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-success";
        }
        else if($subject_type == config("constants.ROLE_ADMINISTRATOR_SYSTEM")){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-success";
        }
        else if($subject_type == config("constants.ROLE_ADMINISTRATOR_CLIENT")){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-success";
        }
        else if($subject_type == config("constants.ROLE_ADMINISTRATOR_LOCATION")){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-success";
        }
        else if($subject_type == config('constants.ROLE_LOCATION')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }
        else if ($subject_type == config('constants.ROLE_OPERATER')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }
        else if ($subject_type == config('constants.ROLE_CASHIER_TERMINAL')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }
        else if ($subject_type == config('constants.TERMINAL_TV')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }
        else if ($subject_type == config('constants.ROLE_PLAYER')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";

            if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")){
                $url_disabled = true;
            }else{
                $url_disabled = false;
            }
            $btn_class = "btn btn-info";
        }else if ($subject_type == config('constants.ROLE_CASHIER') || $subject_type == config("constants.SHIFT_CASHIER")){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-primary";
        }else if ($subject_type == config('constants.ROLE_SUPPORT_CLIENT')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.ROLE_SUPPORT_SYSTEM')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.ROLE_SUPPORT_OPERATER')){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config("constants.ROOT_MASTER")){
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }
        else{
            $url = "/transfer-credit/cashier-player-deposit/user_id/";
            $url_disabled = true;
        }

        //collector cannot deposit to administrator
        if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")) {
            if(in_array($subject_type, array(config("constants.ROLE_ADMINISTRATOR_OPERATER"), config("constants.ROLE_ADMINISTRATOR_LOCATION"),
                    config("constants.ROLE_ADMINISTRATOR"), config("constants.ROLE_ADMINISTRATOR_CLIENT")
                )
            )){
                $url_disabled = true;
            }
        }

        return [
            "url" => $url,
            "url_disabled" => $url_disabled,
            "btn_class" => $btn_class
        ];
    }

    ///TREE DEPOSIT
    public function depositSubjectTree(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $logged_in_subject_dtype = $authSessionData['subject_dtype'];
            $parent_id = $authSessionData['parent_id'];
            $user_id = $authSessionData['user_id'];
            $treeType = 2;

            $arr3 = array();

            $result = UserModel::getDepositWithdrawSubjectTree($parent_id, $treeType, $user_id);

            //dd($result);

            $i3 = 0;

            $laravelLocalized = new LaravelLocalization();

            foreach($result['result'] as $data){
                $subject_type = $data->child_dtype;

                $properties = $this->getDepositTreeProperties($subject_type);

                $url = $properties["url"];
                $url_disabled = $properties["url_disabled"];
                $btn_class = $properties["btn_class"];

                $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$data->child_id);

                if($data->child_id == $parent_id){
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = 0;
                    $arr3[$i3]['parent_name'] = 0;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_id'] = $data->child_subject_type_id;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['currency'] = $data->currency;
                    $arr3[$i3]['credits'] = NumberHelper::convert_double($data->credits);
                    $arr3[$i3]['credits_formatted'] = NumberHelper::format_double($data->credits);
                    if($url_disabled){
                        $arr3[$i3]['action_column'] = "";
                    }else{
                        $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'">'. __("authenticated.Deposit").'</a>';
                    }
                }else{
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = $data->parent_id;
                    $arr3[$i3]['parent_name'] = $data->parent_name;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_id'] = $data->child_subject_type_id;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['currency'] = $data->currency;
                    $arr3[$i3]['credits'] = NumberHelper::convert_double($data->credits);
                    $arr3[$i3]['credits_formatted'] = NumberHelper::format_double($data->credits);
                    if($url_disabled){
                        $arr3[$i3]['action_column'] = "";
                    }else{
                        $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'">'. __("authenticated.Deposit").'</a>';
                    }
                }
                $i3++;
            }

            $count = 0;
            foreach($arr3 as $r){
                $count++;
            }
            if($count > 1){
                $tree = $this->buildTree($arr3, 'parentId', 'id');
                $response = $tree;
                return response()->json(
                    [$response]
                );
            }elseif($count <= 1){
                return response()->json([
                    'result' => $arr3,
                    'status' => 1,
                    'count' => $count
                ]);
            }else{
                return response()->json([
                    'result' => $arr3,
                    'status' => 1,
                    'count' => $count
                ]);
            }

        }catch(\PDOException $ex1){
            return response()->json([
            ]);
        }catch(\Exception $ex2){
            return response()->json([

            ]);
        }
    }

    public function depositUserStructureView(Request $request)
    {
        return view(
            '/authenticated/transfer-credit/deposit-user-structure-view',
            [

            ]
        );
    }

    //WITHDRAW TREE STRUCTURE

    function getWithdrawTreeProperties($subject_type){
        $authSessionData = Session::get('auth');
        $logged_in_subject_dtype = $authSessionData['subject_dtype'];

        if($subject_type == config('constants.ROLE_CLIENT')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.COLLECTOR_TYPE_NAME')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-orange";
        }else if ($subject_type == config('constants.ROLE_ADMINISTRATOR')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-orange";
        }else if ($subject_type == config('constants.ROLE_ADMINISTRATOR_SYSTEM')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-orange";
        }else if ($subject_type == config('constants.ROLE_ADMINISTRATOR_CLIENT')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-orange";
        }else if ($subject_type == config('constants.ROLE_ADMINISTRATOR_LOCATION')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-orange";
        }else if ($subject_type == config('constants.ROLE_ADMINISTRATOR_OPERATER')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-orange";
        }else if ($subject_type == config('constants.ROLE_LOCATION')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.ROLE_OPERATER')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.ROLE_CASHIER_TERMINAL')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.TERMINAL_TV')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.ROLE_PLAYER')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")){
                $url_disabled = true;
            }else{
                $url_disabled = false;
            }
            $btn_class = "btn btn-pink";
        }else if ($subject_type == config('constants.ROLE_CASHIER') || $subject_type == config('constants.SHIFT_CASHIER')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = false;
            $btn_class = "btn btn-red";
        }else if ($subject_type == config('constants.ROLE_SUPPORT_CLIENT')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.ROLE_SUPPORT_SYSTEM')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config('constants.ROLE_SUPPORT_OPERATER')){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else if ($subject_type == config("constants.ROOT_MASTER")){
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }else{
            $url = "/transfer-credit/cashier-player-withdraw/user_id/";
            $url_disabled = true;
        }

        if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")) {
            if(in_array($subject_type, array(config("constants.ROLE_ADMINISTRATOR_OPERATER"), config("constants.ROLE_ADMINISTRATOR_LOCATION"),
                    config("constants.ROLE_ADMINISTRATOR"), config("constants.ROLE_ADMINISTRATOR_CLIENT")
                )
            )){
                $url_disabled = true;
            }
        }

        return [
            "url" => $url,
            "url_disabled" => $url_disabled,
            "btn_class" => $btn_class
        ];
    }

    ///TREE DEPOSIT
    public function withdrawSubjectTree(Request $request){
        try {
            $authSessionData = Session::get('auth');
            $parent_id = $authSessionData['parent_id'];
            $user_id = $authSessionData['user_id'];
            $logged_in_subject_dtype = $authSessionData['subject_dtype'];
            $treeType = 2;

            $arr3 = array();

            $result = UserModel::getDepositWithdrawSubjectTree($parent_id, $treeType, $user_id);

            $i3 = 0;

            $laravelLocalized = new LaravelLocalization();

            foreach($result['result'] as $data){
                $subject_type = $data->child_dtype;

                $properties = $this->getWithdrawTreeProperties($subject_type);
                $url = $properties["url"];
                $url_disabled = $properties["url_disabled"];
                $btn_class = $properties["btn_class"];


                $url = $laravelLocalized->getLocalizedURL($laravelLocalized->getCurrentLocale(), $url.$data->child_id);

                if($data->child_id == $parent_id){
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = 0;
                    $arr3[$i3]['parent_name'] = 0;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_id'] = $data->child_subject_type_id;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['currency'] = $data->currency;
                    $arr3[$i3]['credits'] = NumberHelper::convert_double($data->credits);
                    $arr3[$i3]['credits_formatted'] = NumberHelper::format_double($data->credits);
                    if($url_disabled || $data->credits <= 0){
                        $arr3[$i3]['action_column'] = "";
                    }else{
                        $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'">'. __("authenticated.Withdraw") .'</a>';
                    }
                }else{
                    $arr3[$i3]['id'] = $data->child_id;
                    $arr3[$i3]['name'] = $data->child_name;
                    $arr3[$i3]['parentId'] = $data->parent_id;
                    $arr3[$i3]['parent_name'] = $data->parent_name;
                    $arr3[$i3]['trueParentId'] = $data->parent_id;
                    $arr3[$i3]['true_parent_name'] = $data->parent_name;
                    $arr3[$i3]['subject_type'] = $data->child_dtype;
                    $arr3[$i3]['subject_type_id'] = $data->child_subject_type_id;
                    $arr3[$i3]['subject_type_name'] = $data->child_dtype_bo_name;
                    $arr3[$i3]['currency'] = $data->currency;
                    $arr3[$i3]['credits'] = NumberHelper::convert_double($data->credits);
                    $arr3[$i3]['credits_formatted'] = NumberHelper::format_double($data->credits);
                    if($url_disabled || $data->credits <= 0){
                        $arr3[$i3]['action_column'] = "";
                    }else{
                        $arr3[$i3]['action_column'] = '<a class="'.$btn_class.'" href="'.$url.'">'. __("authenticated.Withdraw") .'</a>';
                    }
                }
                $i3++;
            }

            $count = 0;
            foreach($arr3 as $r){
                $count++;
            }
            if($count > 1){
                $tree = $this->buildTree($arr3, 'parentId', 'id');
                $response = $tree;
                return response()->json(
                    [$response]
                );
            }elseif($count <= 1){
                return response()->json([
                    'result' => $arr3,
                    'status' => 1,
                    'count' => $count
                ]);
            }

        }catch(\PDOException $ex1){
            return response()->json([
            ]);
        }catch(\Exception $ex2){
            return response()->json([

            ]);
        }
    }

    public function withdrawUserStructureView(Request $request)
    {
        return view(
            '/authenticated/transfer-credit/withdraw-user-structure-view',
            [

            ]
        );
    }

    private function buildTree($flat, $pidKey, $idKey = null){
        $grouped = array();
        foreach ($flat as $sub){
            $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling[$idKey];
                if(isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }

            return $siblings;
        };
        $tree = $fnBuilder($grouped[0]);

        return $tree;
    }

}