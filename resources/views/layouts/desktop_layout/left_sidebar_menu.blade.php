<?php
// dd(get_defined_vars());
// dd($controller_full_path);
// dd($action);
?>

<!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/auth/logout")}}"><i class="fa fa-sign-out"></i>
                <span>{{ __("authenticated.Logout") }}</span></a>
            </li>

              <!-- DETAILS -->
            <li class="treeview">
              <a href="#" class="noblockui">
                <i class="fa fa-info-circle"></i> <span>{{ __("authenticated.Details") }}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                    <a href="javascript:void(0)" class="noblockui">
                        <span class="width-100">{{ __("authenticated.Username") }}:</span>
                        <span class="width-150">{{ Session::get('auth.username')}}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="noblockui">
                        <span class="width-100">{{ __("authenticated.Actual Balance") }}:</span>
                        <span class="width-150"><span id="balance"></span> {{ Session::get('auth.currency') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="noblockui">
                        <span class="width-100">{{ __("authenticated.Session Start") }}:</span>
                        <span class="width-150">{{ Session::get('auth.session_start') }}</span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0)" class="noblockui">
                        <span class="width-100">{{ __("authenticated.Duration") }}: </span>
                        <span class="width-150">{{ Session::get('auth.duration_interval') }}</span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0)" class="noblockui">
                        <span class="width-100">{{ __("authenticated.Last Login") }}: </span>
                        <span class="width-150">{{ Session::get('auth.last_login_date_time') }}</span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0)" class="noblockui">
                        <span class="width-100"></span>
                        <span class="width-150">{{ Session::get('auth.last_login_ip_address_country') }}</span>
                    </a>
                </li>

                  <li>
                      <a href="javascript:void(0)" class="noblockui">
                          <span class="width-150">{{ __("authenticated.Selected Period") }}</span>
                      </a>
                  </li>

                <li>
                    <a href="javascript:void(0)" class="noblockui">
                         <span class="width-100">
                             {{ __("authenticated.Start Date") }}:
                         </span>
                        <span class="width-150">
                            {{ Session::get('auth.report_start_date') }}
                        </span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0)" class="noblockui">
                        <span class="width-100">
                             {{ __("authenticated.End Date") }}:
                         </span>
                        <span class="width-150">
                             {{ Session::get('auth.report_end_date') }}
                        </span>
                    </a>
                </li>

              </ul>
            </li>
              <li>
                  <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "home_page")}}">
                      <i class="fa fa-home"></i>
                      <span> {{ __("authenticated.Home") }}</span>
                  </a>
              </li>

            <li class="header">{{ __("authenticated.MAIN NAVIGATION") }}</li>

            @if(!env('HIDE_FOR_PRODUCTION'))
            <li>
                <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/index")}}">
                    <i class="fa fa-bars"></i>
                    <span> {{ __("authenticated.Main Menu") }}</span>
                </a>
            </li>
            @endif

              <!-- MY ACCOUNT -->
            <li class="treeview <?php if(isset($controller) && $controller == 'MyAccountController'): ?>active <?php endif; ?>">
              <a href="#" class="noblockui">
                <i class="fa fa-user"></i> <span>{{ __("authenticated.My Account") }}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li @if (isset($controller) && ($controller == 'MyAccountController' && $action == 'myPersonalData'))class='active' @endif>
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/my-account/my-personal-data")}}">
                        <i class="fa fa-user"></i>
                        <span>{{ __("authenticated.My Personal Data") }}</span>
                    </a>
                </li>
                <li @if (isset($controller) && ($controller == 'MyAccountController' && $action == 'changePassword'))class='active' @endif>
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/my-account/change-password")}}">
                        <i class="fa fa-key"></i>
                        <span>{{ __("authenticated.Change Password") }}</span>
                    </a>
                </li>
              </ul>
            </li>

              @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID"))))
                  <!-- ADMINISTRATION -->
                  <li class="treeview @if ((isset($controller) && in_array($controller, ['JackPotController','AdministrationController', 'UserCurrencySetupController', 'VersionSetupController', 'ParameterSetupController', 'UserParameterSetupController', 'EntityParameterSetupController', 'LanguageFileSetupController', 'DrawModelSetupController'])) || (isset($controller) && $controller == 'ReportController' && $action == 'returnMachineKeysAndCodesReport'))active @endif">
                      <a href="#" class="noblockui">
                          <i class="fa fa-wrench"></i>
                          <span>{{ __("authenticated.Administration") }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                      </a>
                      <ul class="treeview-menu">
                          <li @if (isset($controller) && ($controller == 'AdministrationController' && $action=='searchUsers'))class='active' @endif>
                              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/search-users")}}">
                                  <i class="fa fa-search"></i>
                                  <span>{{ __("authenticated.Search All Entities & Users") }}</span>
                              </a>
                          </li>
                          @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))))

                              @if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))))
                                  <li class="treeview @if (isset($controller) && in_array($controller, ['LanguageFileSetupController']))active @endif">
                                      <a href="#" class="noblockui">
                                          <i class="fa fa-cog"></i>
                                          <span>{{ __("authenticated.Translation") }}</span>
                                          <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                          </span>
                                      </a>
                                      <ul class="treeview-menu">
                                          <li class="@if (isset($controller) && $controller == 'LanguageFileSetupController' && $action == "listLanguageFileForLogin")active @endif">
                                              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/language-setup/list-language-file-for-login")}}">
                                                  <i class="fa fa-cog"></i>
                                                  <span>{{ __("authenticated.Login Form") }}</span>
                                              </a>
                                          </li>
                                          <li class="@if (isset($controller) && $controller == 'LanguageFileSetupController' && $action == "listLanguageFileForAuthenticated")active @endif">
                                              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/language-setup/list-language-file-for-authenticated")}}">
                                                  <i class="fa fa-cog"></i>
                                                  <span>{{ __("authenticated.Other") }}</span>
                                              </a>
                                          </li>
                                      </ul>
                                  </li>
                              @endif

                              @if(in_array(session("auth.subject_type_id"), array(config("constants.MASTER_TYPE_ID"))))
                                  <li @if (isset($controller) && ($controller == 'VersionSetupController'))class='active' @endif>
                                      <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/version-setup/version-setup")}}">
                                          <i class="fa fa-cog"></i>
                                          <span>{{ __("authenticated.Version Setup") }}</span>
                                      </a>
                                  </li>
                              @endif

                              @if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID"))))
                                  <li class="treeview @if (isset($controller) && in_array($controller,
                                  [ 'ParameterSetupController', 'EntityParameterSetupController']))active @endif">
                                      <a href="#" class="noblockui">
                                          <i class="fa fa-cog"></i>
                                          <span>{{ __("authenticated.Parameter Setup") }}</span>
                                          <span class="pull-right-container">
                                                <i class="fa fa-angle-left pull-right"></i>
                                          </span>
                                      </a>
                                      <ul class="treeview-menu">
                                          @if(in_array(session("auth.subject_type_id"),
                                            array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"))))
                                          <li class="@if (isset($controller) && $controller == 'ParameterSetupController')active @endif">
                                              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/parameter-setup/add-new-parameter")}}">
                                                  <i class="fa fa-plus"></i>
                                                  <span>{{ __("authenticated.Add New Parameter") }}</span>
                                              </a>
                                          </li>
                                          @endif

                                          <li class="@if (isset($controller) && $controller == 'EntityParameterSetupController')active @endif">
                                              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/list-entities")}}">
                                                  <i class="fa fa-cog"></i>
                                                  <span>{{ __("authenticated.Entity List - Parameter Setup") }}</span>
                                              </a>
                                          </li>
                                      </ul>
                                  </li>
                              @endif
                          @endif

                          @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))))
                              <li @if (isset($controller) && ($controller == 'DrawModelSetupController'))class='active' @endif>
                                  <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models")}}">
                                      <i class="fa fa-money"></i>
                                      <span>{{ __("authenticated.Draw Model Setup") }}</span>
                                  </a>
                              </li>
                          @endif

                          <li @if (isset($controller) && ($controller == 'JackPotController' && $action=='returnJackPotSetupView'))class='active' @endif>
                              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "jackPotSetup")}}">
                                  <i class="fa fa-money"></i>
                                  <span>{{ __("authenticated.JackPot Setup") }}</span>
                              </a>
                          </li>
                          @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"))))
                              <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnMachineKeysAndCodesReport'))class='active' @endif>
                                  <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "machineKeysAndCodes")}}">
                                      <i class="fa fa-bar-chart"></i>
                                      <span> {{ __("authenticated.All Cashier Terminal Codes") }}</span>
                                  </a>
                              </li>
                          @endif

                      </ul>
                  </li>
              @endif

                <!-- STRUCTURE ENTITY -->
              @if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID"))))
              <li class="treeview @if (isset($controller) && in_array($controller, array('StructureEntityController')) || (in_array($controller, array("TerminalController")) && $action == "details"))active @endif">
                  <a href="#" class="noblockui">
                      <i class="fa fa-users"></i> <span>{{ __("authenticated.Structure Entity") }}</span>
                      <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                  </a>
                  <ul class="treeview-menu">

                      @if(session("auth.subject_type_id") != config("constants.COLLECTOR_LOCATION_TYPE_ID"))
                          <li @if (isset($controller) && ($controller == 'StructureEntityController' && $action=='returnNewStructureEntityView'))class='active' @endif>
                              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "newStructureEntity2")}}">
                                  <i class="fa fa-user-plus"></i>
                                  <span>{{ __("authenticated.New Entity") }}</span>
                              </a>
                          </li>
                      @endif
                      <li @if (isset($controller) && ($controller == 'StructureEntityController' && $action=='searchEntity'))class='active' @endif>
                          <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/search-entity")}}">
                              <i class="fa fa-search"></i>
                              <span>{{ __("authenticated.Search Entity") }}</span>
                          </a>
                      </li>

                      @if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_LOCATION_ID"))))
                          <li @if (isset($controller) && ($controller == 'StructureEntityController' && $action=='listUsersTree'))class='active' @endif>
                              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/list-users-tree")}}">
                                  <i class="fa fa-tree"></i>
                                  <span>{{ __("authenticated.Structure View") }}</span>
                              </a>
                          </li>
                      @endif
                  </ul>
              </li>
              @endif

              <!-- USERS -->
              @if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID"))))
            <li class="treeview @if (isset($controller) && in_array($controller, array('UserController', 'UserReportController', 'AdministratorController', 'AdministratorReportController', 'CashierController', 'CashierReportController', 'PlayerController', 'PlayerReportController', 'TerminalReportController')) || (in_array($controller, array("TerminalController")) && $action != "details"))active @endif">
              <a href="#" class="noblockui">
                <i class="fa fa-users"></i> <span>{{ __("authenticated.Users") }}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                  @if(session("auth.subject_type_id") != config("constants.COLLECTOR_LOCATION_TYPE_ID"))
                      <li @if (isset($controller) && ($controller == 'UserController' && $action=='returnNewUserView'))class='active' @endif>
                          <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/newUser2")}}">
                              <i class="fa fa-user-plus"></i>
                              <span>{{ __("authenticated.New User") }}</span>
                          </a>
                      </li>
                  @endif
                <li @if (isset($controller) && ($controller == 'UserController' && $action=='searchUsers'))class='active' @endif>
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/search-users")}}">
                        <i class="fa fa-search"></i>
                        <span>{{ __("authenticated.Search Users") }}</span>
                    </a>
                </li>
                  <li @if (isset($controller) && ($controller == 'UserController' && $action=='returnUsersStructureView'))class='active' @endif>
                      <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listUsersTree")}}">
                          <i class="fa fa-tree"></i>
                          <span>{{ __("authenticated.Structure View") }}</span>
                      </a>
                  </li>
                  <li @if (isset($controller) && ($controller == 'AdministratorController' && in_array($action, array('listAdministrators', 'changePassword', 'updateAdministrator'))))class='active' @endif>
                      <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/list-administrators")}}">
                          <i class="fa fa-list"></i>
                          <span>{{ __("authenticated.List Administrators") }}</span>
                      </a>
                  </li>
                  <li @if (isset($controller) && ($controller == 'TerminalController' && $action=='listTerminals'))class='active' @endif>
                      <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/list-terminals")}}">
                          <i class="fa fa-list"></i>
                          <span>{{ __("authenticated.List Terminals") }}</span>
                      </a>
                  </li>
                      <li @if (isset($controller) && ($controller == 'TerminalController' && $action=='returnDeactivatedTerminals'))class='active' @endif>
                          <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "deactivatedTerminals")}}">
                              <i class="fa fa-list"></i>
                              <span>{{ __("authenticated.List Deactivated Terminals") }}</span>
                          </a>
                      </li>
                  <li @if (isset($controller) && ($controller == 'PlayerController' && $action=='listPlayers'))class='active' @endif>
                      <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/list-players")}}">
                          <i class="fa fa-list"></i>
                          <span>{{ __("authenticated.List Players") }}</span>
                      </a>
                  </li>
              </ul>
            </li>
              @endif

              <!-- CREDIT TRANSFERS -->
            <li class="treeview @if (isset($controller) && in_array($controller, array('TransferCreditController')))active @endif">
                <a href="#" class="noblockui">
                    <i class="fa fa-money"></i> <span>{{ __("authenticated.Credit Transfers") }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li @if (isset($controller) && ($controller == 'TransferCreditController' && $action=='depositList'))class='active' @endif>
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/deposit-list")}}">
                            <i class="fa fa-plus"></i>
                            <span>{{ __("authenticated.Deposit") }}</span>
                        </a>
                    </li>
                    <li @if (isset($controller) && ($controller == 'TransferCreditController' && $action=='withdrawList'))class='active' @endif>
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/withdraw-list")}}">
                            <i class="fa fa-minus"></i>
                            <span>{{ __("authenticated.Withdraw") }}</span>
                        </a>
                    </li>

                    <li @if (isset($controller) && ($controller == 'TransferCreditController' && $action=='depositUserStructureView'))class='active' @endif>
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/deposit-user-structure-view")}}">
                            <i class="fa fa-plus"></i>
                            <i class="fa fa-tree"></i>
                            <span>{{ __("authenticated.Deposit - Structure View") }}</span>
                        </a>
                    </li>

                    <li @if (isset($controller) && ($controller == 'TransferCreditController' && $action=='withdrawUserStructureView'))class='active' @endif>
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/withdraw-user-structure-view")}}">
                            <i class="fa fa-minus"></i>
                            <i class="fa fa-tree"></i>
                            <span>{{ __("authenticated.Withdraw - Structure View") }}</span>
                        </a>
                    </li>
                </ul>
            </li>

              <!--<li>
                  <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/index")}}">
                      <i class="fa fa-bars"></i>
                      <span> {{ __("authenticated.Tickets") }}</span>
                  </a>
              </li>-->

              <!-- TICKETS -->
              @if(!in_array(session("auth.subject_type_id"), array(config("constants.COLLECTOR_TYPE_ID"), config("constants.COLLECTOR_OPERATER_TYPE_ID"), config("constants.COLLECTOR_LOCATION_TYPE_ID"))))
            <li class=" @if (isset($controller) && ($controller == 'TicketController' && $action=='searchTickets'))active @endif">
              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets")}}">
                <i class="fa fa-ticket"></i> <span>{{ __("authenticated.Tickets") }}</span>
              </a>

              <!--<ul class="treeview-menu">

                <li @if (isset($controller) && ($controller == 'TicketController' && $action=='searchTickets'))class='active' @endif>
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets")}}">
                        <i class="fa fa-search"></i>
                        <span>{{ __("authenticated.Search Tickets") }}</span>
                    </a>
                </li>

                <li style="display: none;" @if (isset($controller) && ($controller == 'TicketController' && $action=='listTemporaryTickets'))class='active' @endif>
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/list-temporary-tickets")}}">
                        <i class="fa fa-search"></i>
                        <span>{{ __("authenticated.Search Temporary Tickets") }}</span>
                    </a>
                </li>
              </ul>-->
            </li>
              @endif

              <!-- REPORTS -->
			<li class="treeview @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController') && ($action != 'returnMachineKeysAndCodesReport'))active @endif">
              <a href="#" class="noblockui">
                <i class="fa fa-bar-chart"></i> <span>{{ __("authenticated.Reports") }}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <!--<li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='dailyReport'))class='active' @endif>
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/daily-report")}}">
                        <i class="fa fa-bar-chart"></i>
                        <span>{{ __("authenticated.Daily Report") }}</span>
                    </a>
                </li>-->
                <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnTicketList'))class='active' @endif>
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket-list")}}">
                        <i class="fa fa-bar-chart"></i>
                        <span>{{ __("authenticated.Ticket List") }}</span>
                    </a>
                </li>
                <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnDrawList'))class='active' @endif>
                   <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "draw-list")}}">
                       <i class="fa fa-bar-chart"></i>
                       <span>{{ __("authenticated.Draw List") }}</span>
                   </a>
                </li>
                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnAllTransactionsReport'))class='active' @endif>
                        <a id="allTransactionsReportLink" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "allTransactionsReport")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span>{{ __("authenticated.All Transactions") }}</span>
                        </a>
                    </li>
                <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnFinancialReport'))class='active' @endif>
                   <a id="profitReportLink" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/financial-report")}}">
                       <i class="fa fa-bar-chart"></i>
                       <span>{{ __("authenticated.Profit Transactions") }}</span>
                   </a>
                </li>
                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnCollectorTransactionReport'))class='active' @endif>
                        <a id="collectorTransactionsReportLink" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/collector-transaction-report")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span>{{ __("authenticated.Collector Transactions") }}</span>
                        </a>
                    </li>
                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnTransactionReport'))class='active' @endif>
                        <a id="profitAndCollectedReportLink" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/transaction-report")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span>{{ __("authenticated.Profit & Collected") }}</span>
                        </a>
                    </li>
                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnPlayerLiabilityReport'))class='active' @endif>
                        <a id="playerLiabilityReportLink" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/player-liability-report")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span>{{ __("authenticated.Player Liability") }}</span>
                        </a>
                    </li>
                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnCashierDailyReport'))class='active' @endif>
                        <a id="dailyCashierReport" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "dailyCashierReport")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span> {{ __("authenticated.Daily Report Cashier View") }}</span>
                        </a>
                    </li>
                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='listLoginHistory'))class='active' @endif>
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/list-login-history")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span> {{ __("authenticated.List Login History") }}</span>
                        </a>
                    </li>

                    @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"))))
                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnListAffiliateMonthlySummaryReport'))class='active' @endif>
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/affiliate-monthly-summary-report")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span> {{ __("authenticated.List Affiliate Monthly Summary Report") }}</span>
                        </a>
                    </li>
                    @endif

                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnCashierShiftReport'))class='active' @endif>
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier-shift-report")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span> {{ __("authenticated.Cashier Shift Report") }}</span>
                        </a>
                    </li>

                    <li @if (isset($controller_full_path) && ($controller_full_path == 'App\Http\Controllers\Authenticated\ReportController' && $action=='returnHistoryOfPreferredTicketsReport'))class='active' @endif>
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/history-of-preferred-tickets")}}">
                            <i class="fa fa-bar-chart"></i>
                            <span> {{ __("authenticated.History Of Preferred Tickets") }}</span>
                        </a>
                    </li>
              </ul>
            </li>



              <!-- LANGUAGES -->
            <li class="treeview @if (isset($controller) && ($controller == 'LanguagesController')) active @endif">
              <a href="#" class="noblockui">
                <i class="fa ion-earth"></i> <span>{{ __("authenticated.Languages") }}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL("en") }}">
                        <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "en")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="{{ __("authenticated.English") }}" src="{{ asset('images/languages/uk.png') }}">
                        <span>{{ __("authenticated.English") }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL("de") }}">
                        <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "de")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="{{ __("authenticated.German") }}" src="{{ asset('images/languages/germany.png') }}">
                        <span>{{ __("authenticated.German") }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL("rs") }}">
                        <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "rs")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="{{ __("authenticated.Serbian") }}" src="{{ asset('images/languages/serbia.png') }}">
                        <span>{{ __("authenticated.Serbian") }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL("sq") }}">
                        <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "sq")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="{{ __("authenticated.Albanian") }}" src="{{ asset('images/languages/albania.png') }}">
                        <span>{{ __("authenticated.Albanian") }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL("cs") }}">
                        <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "cs")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="{{ __("authenticated.Czeck") }}" src="{{ asset('images/languages/czech.png') }}">
                        <span>{{ __("authenticated.Czeck") }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL("sv") }}">
                        <img height="18" width="18" class="<?php if(LaravelLocalization::getCurrentLocale() == "sv")echo 'langswitch-active-language'; else echo 'langswitch-inactive-language'; ?>" alt="{{ __("authenticated.Swedish") }}" src="{{ asset('images/languages/sweden.png') }}">
                        <span>{{ __("authenticated.Swedish") }}</span>
                    </a>
                </li>
              </ul>
            </li>
          </ul>
        </section>
    <!-- /.sidebar -->
  </aside>
<div class="control-sidebar-bg"></div>
<script>
    $(document).ready(function(){
        //console.log("{{session("auth.subject_type_id")}}, {{config("constants.MASTER_TYPE_ID")}}");

        $("#profitAndCollectedReportLink,#profitReportLink,#collectorTransactionsReportLink,#playerLiabilityReportLink,#allTransactionsReportLink,#dailyCashierReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "no");
        });

        //Updates time on home page. Can be used for all other time updates if needed.
        var intervalCountdown = setInterval(
            function() {
                var date = new Date();

                var weekday = new Array(7);
                weekday[0] = "Sunday";
                weekday[1] = "Monday";
                weekday[2] = "Tuesday";
                weekday[3] = "Wednesday";
                weekday[4] = "Thursday";
                weekday[5] = "Friday";
                weekday[6] = "Saturday";
                var monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

                var dayName = weekday[date.getDay()];
                var monthDay = date.getDate();
                var year = date.getFullYear();
                var monthName = monthNames[date.getMonth()];

                var endDate = monthDay + " " + monthName + " " + year;
                var startDate = new Date();
                var dateString = dayName + ", " + monthDay + ". " + monthName + " " + year;

                $("#dateTimeHomePage").val(monthDay + " " + monthName + " " + year + "     " + date.toLocaleTimeString());
                //$("#currentServerDate").text(dateString);
            }, 1000
        );

        $("#toggleSideBar").on("click", function(){
            if($('body').hasClass("sidebar-collapse")){
                localStorage.expandedMenu = 1;
                localStorage.ignore = true;
            }else{
                localStorage.expandedMenu = -1;
                localStorage.ignore = true;
            }
        });
        function getPersonalData(){
            $.ajax({
                method: "GET",
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getPersonalInfoAjax") }}",
                dataType: "json",
                //data: "result",
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "OK"){
                        var credits = data.result[0].credits_formatted;

                        $("#balance").text(credits);
                    }else if(data.status == -1){

                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        }

        //getPersonalData();
    });
</script>
