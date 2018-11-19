
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

    /*.btn{
        height: 50px !important;
        white-space: normal !important;
        vertical-align: middle !important;
    }*/
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">

    </section>

    <section class="content">
            <div class="row" id="menuContainer">
                @if(session("auth.subject_type_id") != config("constants.COLLECTOR_LOCATION_TYPE_ID"))
                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "newStructureEntity2")}}">
                            {{ __("authenticated.New Entity") }}
                        </a>
                    </div>
                @endif
                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/search-entity")}}">
                            {{ __("authenticated.Search Entity") }}
                        </a>
                    </div>
                    @if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_LOCATION_ID"))))
                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-primary" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/list-users-tree")}}">
                            {{ __("authenticated.Structure View") }}
                        </a>
                    </div>
                    @endif
                    <div class="col-md-6 col-xs-6">
                        <a class="btn btn-block btn-danger" href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/index")}}">
                            {{ __("authenticated.Main Menu") }}
                        </a>
                    </div>
            </div>
    </section>
</div>
@endsection
