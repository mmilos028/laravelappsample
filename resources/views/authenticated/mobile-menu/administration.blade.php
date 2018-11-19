
<?php
$mobile_menu_button_css = "col-xs-12";
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<style>
    .super-large-text{
        padding-top: 15px;
        font-size: 30px;
    }
    div.info-box a{
        color: white;
    }

    #menuContainer > div {
        margin-top: 10px !important;
    }

    .btn{
        height: 50px !important;
        white-space: normal !important;
        vertical-align: middle !important;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">

    </section>

    <section class="content">
		    <div class="row" id="menuContainer">
            @if(in_array(session("auth.subject_type_id"),
            array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID"))))
                <div class="col-md-6 col-xs-6">
                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/search-users")}}">
                    {{ __("authenticated.Search All Entities & Users") }}
                    </a>
                </div>
                @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))))
                    @if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))))
                        <div class="col-md-6 col-xs-6">
                            <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/language-setup/list-language-file-for-login")}}">
                                {{ __("authenticated.Translation") }} - {{ __("authenticated.Login Form") }}
                            </a>
                        </div>

                        <div class="col-md-6 col-xs-6">
                            <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/language-setup/list-language-file-for-authenticated")}}">
                                {{ __("authenticated.Translation") }} - {{ __("authenticated.Other") }}
                            </a>
                        </div>
                    @endif

                    @if(in_array(session("auth.subject_type_id"), array(config("constants.MASTER_TYPE_ID"))))
                            <div class="col-md-6 col-xs-6">
                                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/version-setup/version-setup")}}">
                                    {{ __("authenticated.Version Setup") }}
                                </a>
                            </div>
                    @endif

                    @if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID"))))
                        @if(in_array(session("auth.subject_type_id"), array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"))))
                                <div class="col-md-6 col-xs-6">
                                    <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/parameter-setup/add-new-parameter")}}">
                                        {{ __("authenticated.Parameter Setup") }} - {{ __("authenticated.New Parameter") }}
                                    </a>
                                </div>
                        @endif

                            <div class="col-md-6 col-xs-6">
                                <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/list-entities")}}">
                                    {{ __("authenticated.Parameter Setup") }} - {{ __("authenticated.Entity List") }}
                                </a>
                            </div>
                    @endif

                        <div class="col-md-6 col-xs-6">
                            <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models")}}">
                                {{ __("authenticated.Draw Model Setup") }}
                            </a>
                        </div>
                @endif
                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/jackPotSetup")}}">
                            {{ __("authenticated.JackPot Setup") }}
                        </a>
                    </div>

                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/machineKeysAndCodes")}}">
                            {{ __("authenticated.All Cashier Terminal Codes") }}
                        </a>
                    </div>

                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-danger" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/index")}}">
                            {{ __("authenticated.Main Menu") }}
                        </a>
                    </div>
                @endif
            </div>
    </section>
</div>
@endsection
