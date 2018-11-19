<div class="container-fluid">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav">
            <li <?php if(isset($controller) && ($controller == 'MyAccountController' && $action == 'homePage')): ?>class='active' <?php endif; ?>>
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "home_page")); ?>">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="dropdown <?php if(isset($controller) && ($controller == 'MyAccountController' && $action != 'homePage')): ?> active <?php endif; ?>">
                <a class="dropdown-toggle noblockui" data-toggle="dropdown">
                    <i class="fa fa-user">&nbsp;</i><?php echo e(__("authenticated.My Account")); ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-left">
                    <li <?php if(isset($controller) && ($controller == 'MyAccountController' && $action == 'myPersonalData')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/my-account/my-personal-data")); ?>">
                            <i class="fa fa-user"></i>
                            <span><?php echo e(__("authenticated.My Personal Data")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller) && ($controller == 'MyAccountController' && $action == 'changePassword')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/my-account/change-password")); ?>">
                            <i class="fa fa-key"></i>
                            <span><?php echo e(__("authenticated.Change Password")); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

        <?php if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID")))): ?>
            <!-- ADMINISTRATION -->
                <li class="dropdown <?php if((isset($controller) && in_array($controller, ['JackPotController','AdministrationController', 'UserCurrencySetupController', 'VersionSetupController', 'ParameterSetupController', 'UserParameterSetupController', 'EntityParameterSetupController', 'LanguageFileSetupController', 'DrawModelSetupController'])) || (isset($controller) && $controller == 'ReportController' && $action == 'returnMachineKeysAndCodesReport')): ?>active <?php endif; ?>">
                    <a class="dropdown-toggle noblockui" data-toggle="dropdown">
                        <i class="fa fa-wrench">&nbsp;</i><?php echo e(__("authenticated.Administration")); ?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        <li <?php if(isset($controller) && ($controller == 'AdministrationController' && $action=='searchUsers')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/search-users")); ?>">
                                <i class="fa fa-search"></i>
                                <span><?php echo e(__("authenticated.Search All Entities & Users")); ?></span>
                            </a>
                        </li>
                        <?php if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID")))): ?>
                            <?php if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID")))): ?>
                                <li class="dropdown-submenu <?php if(isset($controller) && in_array($controller, ['LanguageFileSetupController'])): ?>active <?php endif; ?>">
                                    <a data-toggle="dropdown" class="dropdown-toggle noblockui" style="background-color: white !important; pointer-events: none !important;">
                                        <i class="fa fa-cog">&nbsp;</i><?php echo e(__("authenticated.Translation")); ?>

                                    </a>
                                    <ul class="dropdown-menu" style="float: right !important;">
                                        <li class="<?php if(isset($controller) && $controller == 'LanguageFileSetupController' && $action == "listLanguageFileForLogin"): ?>active <?php endif; ?>">
                                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/language-setup/list-language-file-for-login")); ?>">
                                                <i class="fa fa-cog"></i>
                                                <span><?php echo e(__("authenticated.Login Form")); ?></span>
                                            </a>
                                        </li>
                                        <li class="<?php if(isset($controller) && $controller == 'LanguageFileSetupController' && $action == "listLanguageFileForAuthenticated"): ?>active <?php endif; ?>">
                                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/language-setup/list-language-file-for-authenticated")); ?>">
                                                <i class="fa fa-cog"></i>
                                                <span><?php echo e(__("authenticated.Other")); ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <?php if(in_array(session("auth.subject_type_id"), array(config("constants.MASTER_TYPE_ID")))): ?>
                                <li <?php if(isset($controller) && ($controller == 'VersionSetupController')): ?>class='active' <?php endif; ?>>
                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/version-setup/version-setup")); ?>">
                                        <i class="fa fa-cog"></i>
                                        <span><?php echo e(__("authenticated.Version Setup")); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID")))): ?>
                                <li class="dropdown-submenu <?php if(isset($controller) && in_array($controller,
                                  [ 'ParameterSetupController', 'EntityParameterSetupController'])): ?>active <?php endif; ?>">
                                    <a class="dropdown-toggle noblockui" data-toggle="dropdown" style="background-color: white !important; pointer-events: none !important;">
                                        <i class="fa fa-cog">&nbsp;</i><?php echo e(__("authenticated.Parameter Setup")); ?>

                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if(in_array(session("auth.subject_type_id"),
                                          array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID")))): ?>
                                            <li class="<?php if(isset($controller) && $controller == 'ParameterSetupController'): ?>active <?php endif; ?>">
                                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/parameter-setup/add-new-parameter")); ?>">
                                                    <i class="fa fa-plus"></i>
                                                    <span><?php echo e(__("authenticated.Add New Parameter")); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <li class="<?php if(isset($controller) && $controller == 'EntityParameterSetupController'): ?>active <?php endif; ?>">
                                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/list-entities")); ?>">
                                                <i class="fa fa-cog"></i>
                                                <span><?php echo e(__("authenticated.Entity List - Parameter Setup")); ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID")))): ?>
                            <li <?php if(isset($controller) && ($controller == 'DrawModelSetupController')): ?>class='active' <?php endif; ?>>
                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models")); ?>">
                                    <i class="fa fa-money"></i>
                                    <span><?php echo e(__("authenticated.Draw Model Setup")); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li <?php if(isset($controller) && ($controller == 'JackPotController' && $action=='returnJackPotSetupView')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "jackPotSetup")); ?>">
                                <i class="fa fa-money"></i>
                                <span><?php echo e(__("authenticated.JackPot Setup")); ?></span>
                            </a>
                        </li>

                        <?php if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID")))): ?>
                            <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnMachineKeysAndCodesReport')): ?>class='active' <?php endif; ?>>
                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "machineKeysAndCodes")); ?>">
                                    <i class="fa fa-bar-chart"></i>
                                    <span> <?php echo e(__("authenticated.All Cashier Terminal Codes")); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID")))): ?>
                <li class="dropdown <?php if(isset($controller) && in_array($controller, array('StructureEntityController')) || (in_array($controller, array("TerminalController")) && $action == "details")): ?>active <?php endif; ?>">
                    <a class="dropdown-toggle noblockui" data-toggle="dropdown">
                        <i class="fa fa-users"></i> <?php echo e(__("authenticated.Structure Entity")); ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-left">

                        <?php if(session("auth.subject_type_id") != config("constants.COLLECTOR_LOCATION_TYPE_ID")): ?>
                            <li <?php if(isset($controller) && ($controller == 'StructureEntityController' && $action=='returnNewStructureEntityView')): ?>class='active' <?php endif; ?>>
                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "newStructureEntity2")); ?>">
                                    <i class="fa fa-user-plus"></i>
                                    <span><?php echo e(__("authenticated.New Entity")); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li <?php if(isset($controller) && ($controller == 'StructureEntityController' && $action=='searchEntity')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/search-entity")); ?>">
                                <i class="fa fa-search"></i>
                                <span><?php echo e(__("authenticated.Search Entity")); ?></span>
                            </a>
                        </li>

                        <?php if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_LOCATION_ID")))): ?>
                            <li <?php if(isset($controller) && ($controller == 'StructureEntityController' && $action=='listUsersTree')): ?>class='active' <?php endif; ?>>
                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/list-users-tree")); ?>">
                                    <i class="fa fa-tree"></i>
                                    <span><?php echo e(__("authenticated.Structure View")); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID")))): ?>
                <li class="dropdown <?php if(isset($controller) && in_array($controller, array('UserController', 'UserReportController', 'AdministratorController', 'AdministratorReportController', 'CashierController', 'CashierReportController', 'PlayerController', 'PlayerReportController', 'TerminalReportController')) || (in_array($controller, array("TerminalController")) && $action != "details")): ?>active <?php endif; ?>">
                    <a class="dropdown-toggle noblockui" data-toggle="dropdown">
                        <i class="fa fa-users"></i> <?php echo e(__("authenticated.Users")); ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        <?php if(session("auth.subject_type_id") != config("constants.COLLECTOR_LOCATION_TYPE_ID")): ?>
                            <li <?php if(isset($controller) && ($controller == 'UserController' && $action=='returnNewUserView')): ?>class='active' <?php endif; ?>>
                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/newUser2")); ?>">
                                    <i class="fa fa-user-plus"></i>
                                    <span><?php echo e(__("authenticated.New User")); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li <?php if(isset($controller) && ($controller == 'UserController' && $action=='searchUsers')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/search-users")); ?>">
                                <i class="fa fa-search"></i>
                                <span><?php echo e(__("authenticated.Search Users")); ?></span>
                            </a>
                        </li>
                        <li <?php if(isset($controller) && ($controller == 'UserController' && $action=='returnUsersStructureView')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listUsersTree")); ?>">
                                <i class="fa fa-tree"></i>
                                <span><?php echo e(__("authenticated.Structure View")); ?></span>
                            </a>
                        </li>
                        <li <?php if(isset($controller) && ($controller == 'AdministratorController' && in_array($action, array('listAdministrators', 'changePassword', 'updateAdministrator')))): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/list-administrators")); ?>">
                                <i class="fa fa-list"></i>
                                <span><?php echo e(__("authenticated.List Administrators")); ?></span>
                            </a>
                        </li>
                        <li <?php if(isset($controller) && ($controller == 'TerminalController' && $action=='listTerminals')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/list-terminals")); ?>">
                                <i class="fa fa-list"></i>
                                <span><?php echo e(__("authenticated.List Terminals")); ?></span>
                            </a>
                        </li>
                        <li <?php if(isset($controller) && ($controller == 'TerminalController' && $action=='returnDeactivatedTerminals')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "deactivatedTerminals")); ?>">
                                <i class="fa fa-list"></i>
                                <span><?php echo e(__("authenticated.List Deactivated Terminals")); ?></span>
                            </a>
                        </li>
                        <li <?php if(isset($controller) && ($controller == 'PlayerController' && $action=='listPlayers')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/list-players")); ?>">
                                <i class="fa fa-list"></i>
                                <span><?php echo e(__("authenticated.List Players")); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <li class="dropdown <?php if(isset($controller) && in_array($controller, array('TransferCreditController'))): ?>active <?php endif; ?>">
                <a class="dropdown-toggle noblockui" data-toggle="dropdown">
                    <i class="fa fa-money"></i> <?php echo e(__("authenticated.Credit Transfers")); ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-left">
                    <li <?php if(isset($controller) && ($controller == 'TransferCreditController' && $action=='depositList')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/deposit-list")); ?>">
                            <i class="fa fa-plus"></i>
                            <span><?php echo e(__("authenticated.Deposit")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller) && ($controller == 'TransferCreditController' && $action=='withdrawList')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/withdraw-list")); ?>">
                            <i class="fa fa-minus"></i>
                            <span><?php echo e(__("authenticated.Withdraw")); ?></span>
                        </a>
                    </li>

                    <li <?php if(isset($controller) && ($controller == 'TransferCreditController' && $action=='depositUserStructureView')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/deposit-user-structure-view")); ?>">
                            <i class="fa fa-plus"></i>
                            <i class="fa fa-tree"></i>
                            <span><?php echo e(__("authenticated.Deposit - Structure View")); ?></span>
                        </a>
                    </li>

                    <li <?php if(isset($controller) && ($controller == 'TransferCreditController' && $action=='withdrawUserStructureView')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/withdraw-user-structure-view")); ?>">
                            <i class="fa fa-minus"></i>
                            <i class="fa fa-tree"></i>
                            <span><?php echo e(__("authenticated.Withdraw - Structure View")); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID")))): ?>
                <li class="dropdown <?php if(isset($controller) && ($controller == 'TicketController' && $action=='searchTickets')): ?>active <?php endif; ?>">
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets")); ?>">
                        <i class="fa fa-ticket"></i> <span><?php echo e(__("authenticated.Tickets")); ?></span>
                    </a>

                <!--<ul class="treeview-menu">

                <li <?php if(isset($controller) && ($controller == 'TicketController' && $action=='searchTickets')): ?>class='active' <?php endif; ?>>
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets")); ?>">
                        <i class="fa fa-search"></i>
                        <span><?php echo e(__("authenticated.Search Tickets")); ?></span>
                    </a>
                </li>

                <li style="display: none;" <?php if(isset($controller) && ($controller == 'TicketController' && $action=='listTemporaryTickets')): ?>class='active' <?php endif; ?>>
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/list-temporary-tickets")); ?>">
                        <i class="fa fa-search"></i>
                        <span><?php echo e(__("authenticated.Search Temporary Tickets")); ?></span>
                    </a>
                </li>
              </ul>-->
                </li>
            <?php endif; ?>
            <li class="dropdown <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController') && ($action != 'returnMachineKeysAndCodesReport')): ?>active <?php endif; ?>">
                <a class="dropdown-toggle noblockui" data-toggle="dropdown">
                    <i class="fa fa-bar-chart"></i> <?php echo e(__("authenticated.Reports")); ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-left">
                <!--<li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='dailyReport')): ?>class='active' <?php endif; ?>>
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/daily-report")); ?>">
                        <i class="fa fa-bar-chart"></i>
                        <span><?php echo e(__("authenticated.Daily Report")); ?></span>
                    </a>
                </li>-->
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnTicketList')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket-list")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span><?php echo e(__("authenticated.Ticket List")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnDrawList')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "draw-list")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span><?php echo e(__("authenticated.Draw List")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnAllTransactionsReport')): ?>class='active' <?php endif; ?>>
                        <a id="allTransactionsReportLink" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "allTransactionsReport")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span><?php echo e(__("authenticated.All Transactions")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnFinancialReport')): ?>class='active' <?php endif; ?>>
                        <a id="profitReportLink" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/financial-report")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span><?php echo e(__("authenticated.Profit Transactions")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnCollectorTransactionReport')): ?>class='active' <?php endif; ?>>
                        <a id="collectorTransactionsReportLink" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/collector-transaction-report")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span><?php echo e(__("authenticated.Collector Transactions")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnTransactionReport')): ?>class='active' <?php endif; ?>>
                        <a id="profitAndCollectedReportLink" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/transaction-report")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span><?php echo e(__("authenticated.Profit & Collected")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnPlayerLiabilityReport')): ?>class='active' <?php endif; ?>>
                        <a id="playerLiabilityReportLink" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/player-liability-report")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span><?php echo e(__("authenticated.Player Liability")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnCashierDailyReport')): ?>class='active' <?php endif; ?>>
                        <a id="dailyCashierReport" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "dailyCashierReport")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span> <?php echo e(__("authenticated.Daily Report Cashier View")); ?></span>
                        </a>
                    </li>
                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='listLoginHistory')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/list-login-history")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span> <?php echo e(__("authenticated.List Login History")); ?></span>
                        </a>
                    </li>

                    <?php if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID")))): ?>
                        <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnListAffiliateMonthlySummaryReport')): ?>class='active' <?php endif; ?>>
                            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/affiliate-monthly-summary-report")); ?>">
                                <i class="fa fa-bar-chart"></i>
                                <span> <?php echo e(__("authenticated.List Affiliate Monthly Summary Report")); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnCashierShiftReport')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier-shift-report")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span> <?php echo e(__("authenticated.Cashier Shift Report")); ?></span>
                        </a>
                    </li>

                    <li <?php if(isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnHistoryOfPreferredTicketsReport')): ?>class='active' <?php endif; ?>>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/history-of-preferred-tickets")); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <span> <?php echo e(__("authenticated.History Of Preferred Tickets")); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown <?php if(isset($controller) && ($controller == 'LanguagesController')): ?> active <?php endif; ?>">
                <a class="dropdown-toggle noblockui" data-toggle="dropdown">
                    <i class="fa ion-earth"></i> <?php echo e(__("authenticated.Languages")); ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-left">
                    <li>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL("en")); ?>">
                            <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "en")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="<?php echo e(__("authenticated.English")); ?>" src="<?php echo e(asset('images/languages/uk.png')); ?>">
                            <span><?php echo e(__("authenticated.English")); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL("de")); ?>">
                            <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "de")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="<?php echo e(__("authenticated.German")); ?>" src="<?php echo e(asset('images/languages/germany.png')); ?>">
                            <span><?php echo e(__("authenticated.German")); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL("rs")); ?>">
                            <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "rs")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="<?php echo e(__("authenticated.Serbian")); ?>" src="<?php echo e(asset('images/languages/serbia.png')); ?>">
                            <span><?php echo e(__("authenticated.Serbian")); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL("sq")); ?>">
                            <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "sq")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="<?php echo e(__("authenticated.Albanian")); ?>" src="<?php echo e(asset('images/languages/albania.png')); ?>">
                            <span><?php echo e(__("authenticated.Albanian")); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL("cs")); ?>">
                            <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "cs")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="<?php echo e(__("authenticated.Czeck")); ?>" src="<?php echo e(asset('images/languages/czech.png')); ?>">
                            <span><?php echo e(__("authenticated.Czeck")); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(LaravelLocalization::getLocalizedURL("sv")); ?>">
                            <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "sv")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="<?php echo e(__("authenticated.Swedish")); ?>" src="<?php echo e(asset('images/languages/sweden.png')); ?>">
                            <span><?php echo e(__("authenticated.Swedish")); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li style="background-color: #B22222 !important;">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/auth/logout")); ?>">
                    <i class="fa fa-sign-out"></i>
                    <span><?php echo e(__("authenticated.Logout")); ?></span>
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function(){
    });
</script>