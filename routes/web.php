<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//default route
Route::get('/', 'AuthController@showLoginForm');

//Localized URL's and not protected (public) routes
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . "/auth",
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ],
    ],
    function()
    {
        //routes under /en/auth/**
        Route::post('/login', 'AuthController@login');
        Route::get('/login', 'AuthController@showLoginForm');
        Route::get('/logout', 'AuthController@logout');
        Route::get('/hash/{password}', 'AuthController@hash');
    }
);

//routes without session validation call
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'isUserAuthenticated', 'localeSessionRedirect', 'localizationRedirect',
            /*'saveUserDefaultDate',*/ 'checkBackofficeUserPermissions', 'localize' ],
        'namespace' => 'Authenticated',
        'before' => ['isUserAuthenticated', 'checkBackofficeUserPermissions']
    ],
    function(){
        Route::match(array('GET', 'POST'), '/getSessionRemainingTime', 'SessionValidationController@getSessionRemainingTime');
        Route::match(array('GET', 'POST'), '/validateSessionModal', 'SessionValidationController@validateSession');
        Route::match(array('GET', 'POST'),'/session-validation/ping-session', 'SessionValidationController@pingSession');
    }
);

//Localized URL's and protected for authenticated users
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'isUserAuthenticated', 'validateSession', 'localeSessionRedirect', 'localizationRedirect',
            /*'saveUserDefaultDate',*/ 'checkBackofficeUserPermissions', 'localize' ],
        'namespace' => 'Authenticated',
        'before' => ['isUserAuthenticated', 'checkBackofficeUserPermissions']
    ],
    function()
    {
        Route::get('/messages/index', 'MessagesController@index');
        //Mobile Menu
        //Route::get(LaravelLocalization::transRoute('/mobilni-meni/index'), 'MobileMenuController@index');
        //Route::get(LaravelLocalization::transRoute('routes.mobile-menu/index'), 'MobileMenuController@index');
        //Route::get(LaravelLocalization::transRoute('routes.mobilni-meni/index'), 'MobileMenuController@index');
        Route::get('/mobile-menu/index', 'MobileMenuController@index');
        Route::get('/mobile-menu/administration', 'MobileMenuController@administration');
        Route::get('/mobile-menu/my-account', 'MobileMenuController@myAccount');
        Route::get('/mobile-menu/language', 'MobileMenuController@language');
        Route::get('/mobile-menu/player', 'MobileMenuController@player');
        Route::get('/mobile-menu/terminal', 'MobileMenuController@terminal');
        Route::get('/mobile-menu/structure-entity', 'MobileMenuController@structureEntity');
        Route::get('/mobile-menu/user', 'MobileMenuController@user');
        Route::get('/mobile-menu/ticket', 'MobileMenuController@ticket');
		Route::get('/mobile-menu/report', 'MobileMenuController@report');
		Route::get('/mobile-menu/credit-transfers', 'MobileMenuController@creditTransfers');
        //My Account
        Route::match(array('GET', 'POST'), '/my-account/my-personal-data', 'MyAccountController@myPersonalData');
        Route::match(array('GET', 'POST'), '/my-account/change-password', 'MyAccountController@changePassword');

        ///STRUCTURE ENTITY
        Route::match(array('GET', 'POST'), '/structure-entity/search-entity', 'StructureEntityController@searchEntity');

        ////Administration
        Route::match(array('GET', 'POST'), '/administration/get-affiliates-from-role', 'AdministrationController@getAffiliatesFromRole');
        Route::match(array('GET', 'POST'), '/administration/search-users', 'AdministrationController@searchUsers');

        Route::match(array('GET', 'POST'), '/administration/user-details/user_id/{user_id}', 'AdministrationController@userDetails');
        Route::match(array('GET', 'POST'), '/administration/user-details', 'AdministrationController@userDetails');
        Route::match(array('GET', 'POST'), '/administration/change-user-account-status/user_id/{user_id}', 'AdministrationController@changeUserAccountStatus');


        Route::match(array('GET', 'POST'), '/administration/get-location-address-information', 'AdministrationController@getLocationAddressInformation');

        //Version setup
        Route::match(array('GET', 'POST'), '/administration/version-setup/version-setup', 'Administration\Version_Setup\VersionSetupController@versionSetup');
        Route::match(array('GET', 'POST'), '/administration/version-setup/delete-application-version/application_name/{application_name}', 'Administration\Version_Setup\VersionSetupController@deleteApplicationVersion');
        Route::match(array('GET', 'POST'), '/administration/version-setup/update-application-version/application_name/{application_name}/version/{version}', 'Administration\Version_Setup\VersionSetupController@updateApplicationVersion');
        Route::match(array('GET', 'POST'), '/administration/version-setup/do-update-application-version', 'Administration\Version_Setup\VersionSetupController@doUpdateApplicationVersion');

        //parameter setup
        Route::match(array('GET', 'POST'), '/administration/parameter-setup/add-new-parameter', 'Administration\Parameter_Setup\ParameterSetupController@addNewParameter');
        Route::match(array('GET', 'POST'), '/administration/parameter-setup/update-parameters', 'Administration\Parameter_Setup\ParameterSetupController@updateParameters');

        //entity parameter setup
        Route::match(array('GET', 'POST'), '/administration/entity-parameter-setup/list-entities', 'Administration\Parameter_Setup\EntityParameterSetupController@listEntities');
        Route::match(array('GET', 'POST'), '/administration/entity-parameter-setup/parameter-setup/user_id/{user_id}', 'Administration\Parameter_Setup\EntityParameterSetupController@entityParameterSetup');
        Route::match(array('GET', 'POST'), '/administration/entity-parameter-setup/manage-parameter-setup/user_id/{user_id}', 'Administration\Parameter_Setup\EntityParameterSetupController@manageEntityParameterSetup');
        Route::match(array('GET', 'POST'), '/administration/entity-parameter-setup/get-structure-entity-tree-for-parameter-setup', 'Administration\Parameter_Setup\EntityParameterSetupController@getStructureEntityTreeForParameterSetup');

        //currency setup
        //Route::match(array('GET', 'POST'), '/administration/currency-setup/list-locations', 'Administration\Currency_Setup\UserCurrencySetupController@listLocations');
        //Route::match(array('GET', 'POST'), '/administration/currency-setup/add-currency-to-location/user_id/{user_id}', 'Administration\Currency_Setup\UserCurrencySetupController@addCurrencyToLocation');

        //Route::match(array('GET', 'POST'), '/administration/currency-setup/list-affiliates', 'Administration\Currency_Setup\UserCurrencySetupController@listAffiliates');
        //Route::match(array('GET', 'POST'), '/administration/currency-setup/add-currency-to-affiliate/user_id/{user_id}', 'Administration\Currency_Setup\UserCurrencySetupController@addCurrencyToAffiliate');

        //language setup
        Route::match(array('GET', 'POST'), '/administration/language-setup/list-language-file-for-login', 'Administration\Language_Setup\LanguageFileSetupController@listLanguageFileForLogin');
        Route::match(array('GET', 'POST'), '/administration/language-setup/list-language-file-for-authenticated', 'Administration\Language_Setup\LanguageFileSetupController@listLanguageFileForAuthenticated');
        Route::match(array('GET', 'POST'), '/administration/language-setup/list-language-file-for-validation', 'Administration\Language_Setup\LanguageFileSetupController@listLanguageFileForValidation');

        //draw model setup
        Route::match(array('GET', 'POST'), '/administration/list-draw-models', 'Administration\DrawModel_Setup\DrawModelSetupController@listDrawModels');
        Route::match(array('GET', 'POST'), '/administration/create-draw-model', 'Administration\DrawModel_Setup\DrawModelSetupController@createDrawModel');
        Route::match(array('GET', 'POST'), '/administration/update-draw-model/draw_model_id/{draw_model_id}', 'Administration\DrawModel_Setup\DrawModelSetupController@updateDrawModel');
        Route::match(array('GET', 'POST'), '/administration/delete-draw-model/draw_model_id/{draw_model_id}', 'Administration\DrawModel_Setup\DrawModelSetupController@deleteDrawModel');
        Route::match(array('GET', 'POST'), '/administration/entities-for-draw-model/draw_model_id/{draw_model_id}', 'Administration\DrawModel_Setup\DrawModelSetupController@entitiesForDrawModel');
        Route::match(array('GET', 'POST'), '/administration/entity-to-draw-model/draw_model_id/{draw_model_id}', 'Administration\DrawModel_Setup\DrawModelSetupController@entityToDrawModel');

        //Player
        Route::match(array('GET', 'POST'), '/player/new-player', 'PlayerController@newPlayer');
        Route::match(array('GET', 'POST'), '/player/update-player/user_id/{user_id}', 'PlayerController@updatePlayer');
        Route::match(array('GET', 'POST'), '/player/change-password/user_id/{user_id}', 'PlayerController@changePassword');
        Route::match(array('GET', 'POST'), '/player/list-players', 'PlayerController@listPlayers');
		Route::match(array('GET', 'POST'), '/player/details/user_id/{user_id}', 'PlayerController@details');
		Route::match(array('GET', 'POST'), '/player/change-user-account-status/user_id/{user_id}', 'PlayerController@changeUserAccountStatus');
		//Player Reports
		Route::match(array('GET', 'POST'), '/player/report/list-money-transactions/user_id/{user_id}', 'Player\Report\PlayerReportController@listMoneyTransactions');
		Route::match(array('GET', 'POST'), '/player/report/list-player-tickets/user_id/{user_id}', 'Player\Report\PlayerReportController@listPlayerTickets');
		Route::match(array('GET', 'POST'), '/player/report/list-login-history/user_id/{user_id}', 'Player\Report\PlayerReportController@listLoginHistory');
		//Player Excel
        Route::match(array('GET', 'POST'), '/player/list-players-excel', 'Player\Excel\PlayerController@listPlayersExcel');

        //Terminal
        Route::match(array('GET', 'POST'), '/terminal/new-terminal', 'TerminalController@newTerminal');
        Route::match(array('GET', 'POST'), '/terminal/update-terminal/user_id/{user_id}/{user_type?}', 'TerminalController@updateTerminal');
        Route::match(array('GET', 'POST'), '/terminal/change-password/user_id/{user_id}', 'TerminalController@changePassword');
        Route::match(array('GET', 'POST'), '/terminal/list-terminals', 'TerminalController@listTerminals');
		Route::match(array('GET', 'POST'), '/terminal/details/user_id/{user_id}/{user_type?}', 'TerminalController@details');
		Route::match(array('GET', 'POST'), '/terminal/check-service-code', 'TerminalController@checkServiceCode');
		Route::match(array('GET', 'POST'), '/terminal/code-list/user_id/{user_id}/{user_type?}', 'TerminalController@codeList');
		Route::match(array('GET', 'POST'), '/terminal/create-new-code/user_id/{user_id}', 'TerminalController@createNewCode');
		Route::match(array('GET', 'POST'), '/terminal/change-user-account-status/user_id/{user_id}', 'TerminalController@changeUserAccountStatus');
		//Terminal Reports
		Route::match(array('GET', 'POST'), '/terminal/report/list-money-transactions/user_id/{user_id}', 'Terminal\Report\TerminalReportController@listMoneyTransactions');
		Route::match(array('GET', 'POST'), '/terminal/report/list-player-tickets/user_id/{user_id}', 'Terminal\Report\TerminalReportController@listPlayerTickets');
		Route::match(array('GET', 'POST'), '/terminal/report/list-login-history/user_id/{user_id}', 'Terminal\Report\TerminalReportController@listLoginHistory');
		//Terminal Excel
        Route::match(array('GET', 'POST'), '/terminal/list-terminals-excel', 'Terminal\Excel\TerminalController@listTerminalsExcel');
        Route::match(array('GET', 'POST'), '/terminal/list-deactivated-terminals-excel', 'Terminal\Excel\TerminalController@listDeactivatedTerminalsExcel');

        //Structure Entity
        Route::match(array('GET', 'POST'), '/structure-entity/new-user', 'StructureEntityController@newUser');
        Route::match(array('GET', 'POST'), '/structure-entity/list-users-tree', 'StructureEntityController@listUsersTree');
        Route::match(array('GET', 'POST'), '/structure-entity/get-affiliates-from-role', 'StructureEntityController@getAffiliatesFromRole');
        Route::match(array('GET', 'POST'), '/structure-entity/change-user-account-status/user_id/{user_id}', 'StructureEntityController@changeUserAccountStatus');
        Route::match(array('GET', 'POST'), '/structure-entity/update-entity/user_id/{user_id}', 'StructureEntityController@updateEntity');
        Route::match(array('GET', 'POST'), '/structure-entity/change-password/user_id/{user_id}', 'StructureEntityController@changePassword');
        Route::match(array('GET', 'POST'), '/structure-entity/details/user_id/{user_id}/{user_type?}', 'StructureEntityController@details');

        //User
        Route::match(array('GET', 'POST'), '/user/new-user', 'UserController@newUser');
        Route::match(array('GET', 'POST'), '/user/get-location-address-information', 'UserController@getLocationAddressInformation');
        Route::match(array('GET', 'POST'), '/user/search-users', 'UserController@searchUsers');
        Route::match(array('GET', 'POST'), '/user/change-user-account-status/user_id/{user_id}', 'UserController@changeUserAccountStatus');
        Route::match(array('GET', 'POST'), '/user/update-user/user_id/{user_id}', 'UserController@updateUser');
        Route::match(array('GET', 'POST'), '/user/change-password/user_id/{user_id}', 'UserController@changePassword');
        Route::match(array('GET', 'POST'), '/user/details/user_id/{user_id}', 'UserController@details');
        //User reports
        Route::match(array('GET', 'POST'), '/user/report/list-login-history/user_id/{user_id}', 'User\Report\UserReportController@listLoginHistory');

        //Administrator
        Route::match(array('GET', 'POST'), '/administrator/change-password/user_id/{user_id}', 'AdministratorController@changePassword');
        Route::match(array('GET', 'POST'), '/administrator/update-administrator/user_id/{user_id}', 'AdministratorController@updateAdministrator');
        Route::match(array('GET', 'POST'), '/administrator/details/user_id/{user_id}', 'AdministratorController@details');
        Route::match(array('GET', 'POST'), '/administrator/list-administrators', 'AdministratorController@listAdministrators');
        Route::match(array('GET', 'POST'), '/administrator/change-user-account-status/user_id/{user_id}', 'AdministratorController@changeUserAccountStatus');
        //Administrator reports
        Route::match(array('GET', 'POST'), '/administrator/report/list-login-history/user_id/{user_id}', 'Administrator\Report\AdministratorReportController@listLoginHistory');

        //Cashiers
        Route::match(array('GET', 'POST'), '/cashier/list-cashiers', 'CashierController@listCashiers');
        Route::match(array('GET', 'POST'), '/cashier/change-password/user_id/{user_id}/{user_type?}', 'CashierController@changePassword');
        Route::match(array('GET', 'POST'), '/cashier/change-pin-code/user_id/{user_id}/{user_type?}', 'CashierController@changePinCode');
        Route::match(array('GET', 'POST'), '/cashier/update-cashier/user_id/{user_id}/{user_type?}', 'CashierController@updateCashier');
        Route::match(array('GET', 'POST'), '/cashier/details/user_id/{user_id}/{user_type?}', 'CashierController@details');
        Route::match(array('GET', 'POST'), '/cashier/change-user-account-status/user_id/{user_id}', 'CashierController@changeUserAccountStatus');
        //Route::match(array('GET', 'POST'), '/cashier/details/user_id/{user_id}', 'CashierController@details');
        //Administrator reports
        Route::match(array('GET', 'POST'), '/cashier/report/list-login-history/user_id/{user_id}', 'Cashier\Report\CashierReportController@listLoginHistory');

        //TRANSFER CREDIT
        Route::match(array('GET', 'POST'), '/transfer-credit/deposit-list', 'TransferCreditController@depositList');
        Route::match(array('GET', 'POST'), '/transfer-credit/cashier-player-deposit/user_id/{user_id}', 'TransferCreditController@cashierPlayerDeposit');
        Route::match(array('GET', 'POST'), '/transfer-credit/cashier-player-deposit-completed/user_id/{user_id}', 'TransferCreditController@cashierPlayerDepositCompleted');

        Route::match(array('GET', 'POST'), '/transfer-credit/withdraw-list', 'TransferCreditController@withdrawList');
        Route::match(array('GET', 'POST'), '/transfer-credit/cashier-player-withdraw/user_id/{user_id}', 'TransferCreditController@cashierPlayerWithdraw');
        Route::match(array('GET', 'POST'), '/transfer-credit/cashier-player-withdraw-completed/user_id/{user_id}', 'TransferCreditController@cashierPlayerWithdrawCompleted');

        //tree
        Route::match(array('GET', 'POST'), '/transfer-credit/deposit-subject-tree', 'TransferCreditController@depositSubjectTree');
        Route::match(array('GET', 'POST'), '/transfer-credit/deposit-user-structure-view', 'TransferCreditController@depositUserStructureView');
        Route::match(array('GET', 'POST'), '/transfer-credit/withdraw-subject-tree', 'TransferCreditController@withdrawSubjectTree');
        Route::match(array('GET', 'POST'), '/transfer-credit/withdraw-user-structure-view', 'TransferCreditController@withdrawUserStructureView');

        //Ticket
        Route::match(array('GET', 'POST'), '/ticket/check-ticket-details-with-serial-number', 'TicketController@checkTicketDetailsWithSerialNumber');
        Route::match(array('GET', 'POST'), '/ticket/check-ticket-details-with-ticket-id', 'TicketController@checkTicketDetailsWithTicketId');
        Route::match(array('GET', 'POST'), '/ticket/check-ticket-details-with-draw-id', 'TicketController@checkTicketDetailsWithDrawId');
        Route::match(array('GET', 'POST'), '/ticket/check-ticket-details-with-barcode', 'TicketController@checkTicketDetailsWithBarcode');
        Route::match(array('GET', 'POST'), '/ticket/search-tickets', 'TicketController@searchTickets');

        Route::match(array('GET', 'POST'), '/ticket/list-anonymous-tickets', 'TicketController@listAnonymousTickets');
        Route::match(array('GET', 'POST'), '/ticket/list-temporary-tickets', 'TicketController@listTemporaryTickets');
		Route::match(array('GET', 'POST'), '/ticket/temporary-to-real', 'TicketController@temporaryToReal');
		Route::match(array('GET', 'POST'), '/ticket/ticket-details/ticket_id/{ticket_id}', 'TicketController@ticketDetails');
		Route::match(array('GET', 'POST'), '/ticket/ticket-details-with-serial-number/ticket_serial_number/{ticket_serial_number}', 'TicketController@ticketDetailsWithSerialNumber');
		Route::match(array('GET', 'POST'), '/ticket/list-wins-for-ticket/ticket_id/{ticket_id}', 'TicketController@listWinsForTicket');

		Route::match(array('GET', 'POST'), '/ticket/control-preferred-ticket/ticket_serial_number/{ticket_serial_number}/barcode/{barcode}/status/{status}/parent_id/{parent_id}', 'TicketController@controlPreferredTicket');

		//Ticket Excel exports
		Route::match(array('GET', 'POST'), '/ticket/excel/ticket-details/ticket_serial_number/{ticket_serial_number}', 'Ticket\Excel\TicketController@ticketDetails');
		Route::match(array('GET', 'POST'), '/ticket/excel/search-tickets', 'Ticket\Excel\TicketController@searchTickets');
		
		//Report
		Route::match(array('GET', 'POST'), '/report/daily-report', 'ReportController@dailyReport');
        Route::match(array('GET', 'POST'), 'dailyReportAjax', 'ReportController@dailyReportAjax');
		Route::match(array('GET', 'POST'), '/report/ticket-list', 'ReportController@ticketList');
		Route::match(array('GET', 'POST'), '/report/ticket-details/ticket_serial_number/{ticket_serial_number}', 'ReportController@ticketDetails');
		Route::match(array('GET', 'POST'), '/report/ticket-details-per-draw', 'ReportController@ticketDetailsPerDraw');
		Route::match(array('GET', 'POST'), '/report/ticket-draw-details/ticket_serial_number/{ticket_serial_number}/draw_serial_number/{draw_serial_number}/draw_id/{draw_id}', 'ReportController@ticketDrawDetails');
		Route::match(array('GET', 'POST'), '/report/draw-details/draw_id/{draw_id}', 'ReportController@drawDetails');
		Route::match(array('GET', 'POST'), '/report/draw-list', 'ReportController@drawList');
		Route::match(array('GET', 'POST'), '/report/financial-report', 'ReportController@returnFinancialReport');
		Route::match(array('GET', 'POST'), '/report/list-financial-report-for-user', 'ReportController@listFinancialReportForUser');
		Route::match(array('GET', 'POST'), '/report/list-financial-report-for-user-small', 'ReportController@listFinancialReportForUserSmall');
		Route::match(array('GET', 'POST'), '/report/financial-report-get-subject-tree-users', 'ReportController@financialReportSubjectTree');
		Route::match(array('GET', 'POST'), '/report/list-login-history', 'ReportController@listLoginHistory');
		Route::match(array('GET', 'POST'), '/report/affiliate-monthly-summary-report', 'ReportController@returnListAffiliateMonthlySummaryReport');
		Route::match(array('GET', 'POST'), '/report/list-affiliate-monthly-summary-report', 'ReportController@listAffiliateMonthlySummaryReport');		//login history ajax
        Route::match(array('GET', 'POST'), '/listLoginHistory', 'ReportController@listLoginHistoryReport');
        Route::match(array('GET', 'POST'), '/report/history-of-preferred-tickets', 'ReportController@historyOfPreferredTicketsReport');

        Route::match(array('GET', 'POST'), '/home_page', 'MyAccountController@homePage');

        Route::match(array('GET', 'POST'), '/getPersonalInfoAjax', 'UserController@personalInformationForHomePage');
        Route::match(array('GET', 'POST'), '/getLanguagesAjax', 'UserController@personalInformationLanguages');
        Route::match(array('GET', 'POST'), '/setSessionStartDateAjax', 'UserController@setSessionStartDate');
        Route::match(array('GET', 'POST'), '/setSessionEndDateAjax', 'UserController@setSessionEndDate');
        Route::match(array('GET', 'POST'), '/setLanguageAjax', 'UserController@setLanguage');
        Route::match(array('GET', 'POST'), '/createNewUser', 'UserController@createNewUser');
        Route::match(array('GET', 'POST'), '/listCountries', 'UserController@listCountries');
        Route::match(array('GET', 'POST'), '/listCountries2', 'UserController@listCountries2');
        Route::match(array('GET', 'POST'), '/listCurrencies', 'UserController@listCurrencies');
        Route::match(array('GET', 'POST'), '/listUsersTree', 'UserController@returnUsersStructureView');
        Route::match(array('GET', 'POST'), '/getSubjectRolesForNewUserForm', 'UserController@getSubjectRolesForNewUserForm');
        Route::match(array('GET', 'POST'), '/getSubjectTreeUsers', 'StructureEntityController@subjectTree2');
        Route::match(array('GET', 'POST'), '/newUser2', 'UserController@returnNewUserView');
        Route::match(array('GET', 'POST'), '/getSubjectTree', 'StructureEntityController@subjectTree');
        Route::match(array('GET', 'POST'), '/newStructureEntity2', 'StructureEntityController@returnNewStructureEntityView');
        Route::match(array('GET', 'POST'), '/getSubjectRolesForNewStructureEntityForm', 'StructureEntityController@getSubjectRolesForNewStructureEntityForm');
        Route::match(array('GET', 'POST'), '/listDrawModels', 'Administration\DrawModel_Setup\DrawModelSetupController@listDrawModelsAjax');
        Route::match(array('GET', 'POST'), '/listDrawModelsForCurrency', 'Administration\DrawModel_Setup\DrawModelSetupController@listDrawModelsForCurrencyAjax');
        Route::match(array('GET', 'POST'), '/listAllDrawModels', 'StructureEntityController@listAllDrawModelsAjax');
        Route::match(array('GET', 'POST'), '/getDrawModelForAff', 'StructureEntityController@getDrawModelForAff');
        Route::match(array('GET', 'POST'), '/createNewStructureEntity', 'StructureEntityController@createNewStructureEntity');
        Route::match(array('GET', 'POST'), '/jackPotSetup', 'Administration\Jackpot_Setup\JackPotController@returnJackPotSetupView');
        Route::match(array('GET', 'POST'), '/jackPotUpdate', 'Administration\Jackpot_Setup\JackPotController@returnJackPotUpdateView');
        Route::match(array('GET', 'POST'), '/getJpModels', 'Administration\Jackpot_Setup\JackPotController@getJpModels');
        Route::match(array('GET', 'POST'), '/createNewJPModel', 'Administration\Jackpot_Setup\JackPotController@createJPSpecification');
        Route::match(array('GET', 'POST'), '/deleteJPModel', 'Administration\Jackpot_Setup\JackPotController@deleteJPModel');
        Route::match(array('GET', 'POST'), '/getJPModelDetails', 'Administration\Jackpot_Setup\JackPotController@getJpModelDetails');
        Route::match(array('GET', 'POST'), '/updateJPModel', 'Administration\Jackpot_Setup\JackPotController@updateJPSpecification');
        Route::match(array('GET', 'POST'), '/getEnabledSubjectsForJPModel', 'Administration\Jackpot_Setup\JackPotController@getEnabledSubjectsForJPModel');
        Route::match(array('GET', 'POST'), '/getDisabledSubjectsForJPModel', 'Administration\Jackpot_Setup\JackPotController@getDisabledSubjectsForJPModel');
        Route::match(array('GET', 'POST'), '/deleteJpModelForSubject', 'Administration\Jackpot_Setup\JackPotController@deleteJpModelForSubject');
        Route::match(array('GET', 'POST'), '/addJpModelForSubject', 'Administration\Jackpot_Setup\JackPotController@addJpModelForSubject');
        Route::match(array('GET', 'POST'), '/listSubjectsForGlobalJP', 'Administration\Jackpot_Setup\JackPotController@listSubjectsForGlobalJP');
        Route::match(array('GET', 'POST'), '/getAffJPModelSettings', 'Administration\Jackpot_Setup\JackPotController@getAffJPModelSettings');
        Route::match(array('GET', 'POST'), '/dailyCashierReport', 'ReportController@returnCashierDailyReport');
        Route::match(array('GET', 'POST'), '/cashierDailyReportAjax', 'ReportController@cashierDailyReport');
        Route::match(array('GET', 'POST'), '/financialReport', 'ReportController@financialReport2');
        Route::match(array('GET', 'POST'), '/report/transaction-report', 'ReportController@returnTransactionReport');
        Route::match(array('GET', 'POST'), 'transactionReportAjax', 'ReportController@transactionReport');
        Route::match(array('GET', 'POST'), 'listCurrenciesForStartEndDateAjax', 'UserController@listCurrenciesForStartEndDate');
        Route::match(array('GET', 'POST'), '/report/collector-transaction-report', 'ReportController@returnCollectorTransactionReport');
        Route::match(array('GET', 'POST'), 'collectorTransactionReportAjax', 'ReportController@collectorTransactionReport');
        Route::match(array('GET', 'POST'), '/report/player-liability-report', 'ReportController@returnPlayerLiabilityReport');
        Route::match(array('GET', 'POST'), '/playerLiabilityAjax', 'ReportController@playerLiabilityReport');
        Route::match(array('GET', 'POST'), '/playerTransactionsAjax', 'ReportController@playerTransactionsReport');
        Route::match(array('GET', 'POST'), '/allTransactionsReport', 'ReportController@returnAllTransactionsReport');
        Route::match(array('GET', 'POST'), '/allTransactionsReportAjax', 'ReportController@allTransactionReport');
        Route::match(array('GET', 'POST'), '/allMachineKeysAndCodesReportAjax', 'ReportController@allMachineKeysAndCodesReport');
        Route::match(array('GET', 'POST'), '/machineKeysAndCodes', 'ReportController@returnMachineKeysAndCodesReport');
        Route::match(array('GET', 'POST'), '/deactivatedTerminals', 'TerminalController@returnDeactivatedTerminals');
        Route::match(array('GET', 'POST'), '/disconnectTerminalAjax', 'TerminalController@disconnectTerminal');
        Route::match(array('GET', 'POST'), '/listDisconnectedTerminals', 'TerminalController@listDisconnectedTerminals');
        Route::match(array('GET', 'POST'), '/connectTerminalAjax', 'TerminalController@connectTerminal');
        Route::match(array('GET', 'POST'), '/deactivateTerminalAjax', 'TerminalController@deactivateTerminal');
        Route::match(array('GET', 'POST'), '/draw-list', 'ReportController@returnDrawList');
        Route::match(array('GET', 'POST'), '/list-affiliates', 'ReportController@listAffiliates');
        Route::match(array('GET', 'POST'), '/draw-list-report', 'ReportController@drawList2');
        Route::match(array('GET', 'POST'), '/ticket-list', 'ReportController@returnTicketList');
        Route::match(array('GET', 'POST'), '/ticket-list-statuses', 'ReportController@ticketStatusesList');
        Route::match(array('GET', 'POST'), '/ticket-list-report', 'ReportController@ticketList2');
        Route::match(array('GET', 'POST'), 'ticketDetailsPerDrawAjax', 'ReportController@ticketDetailsPerDrawAjax');
        Route::match(array('GET', 'POST'), '/administration/list-draw-model-affiliates', 'Administration\DrawModel_Setup\DrawModelSetupController@returnDrawModelAffiliates');
        Route::match(array('GET', 'POST'), 'drawModelAffiliates', 'Administration\DrawModel_Setup\DrawModelSetupController@listDrawModelAffiliates');
        Route::match(array('GET', 'POST'), 'addDrawModelToAffiliate', 'Administration\DrawModel_Setup\DrawModelSetupController@addDrawModelToAffiliate');
        Route::match(array('GET', 'POST'), '/updateJPModelDetailsForAffiliate', 'Administration\Jackpot_Setup\JackPotController@updateJPModelDetailsForAff');
        Route::match(array('GET', 'POST'), '/cashier-shift-report', 'ReportController@returnCashierShiftReport');
        Route::match(array('GET', 'POST'), '/list-cashier-shift-report', 'ReportController@listCashierShiftReport');
        Route::match(array('GET', 'POST'), '/list-shift-cashiers', 'ReportController@listShiftCashiers');

        //report tests
        Route::match(array('GET', 'POST'), '/compareProfitAndCollected', 'TestingController@compareProfitAndCollected');
        Route::match(array('GET', 'POST'), '/returnCompareProfitAndCollected', function (){
            return view("authenticated/mail.compare_profit_and_collected");
        });
        Route::match(array('GET', 'POST'), '/compareProfitOverview', 'TestingController@compareProfitOverview');
});
