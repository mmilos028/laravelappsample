
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
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">

    </section>

    <section class="content">

    <br /><br /><br />

        <div class="row">
            <div class="<?php echo $mobile_menu_button_css; ?>">
                <div class="info-box bg-navy">
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/new-player")}}">
                    <span class="info-box-icon bg-navy"><i class="fa fa-user-plus"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number super-large-text">{{ __("authenticated.New Player") }}</span>
                    </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $mobile_menu_button_css; ?>">
                <div class="info-box bg-navy">
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/list-players")}}">
                    <span class="info-box-icon bg-navy"><i class="fa fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number super-large-text">{{ __("authenticated.List Players") }}</span>
                    </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $mobile_menu_button_css; ?>">
                <div class="info-box bg-red">
                    <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/mobile-menu/index")}}">
                    <span class="info-box-icon bg-red"><i class="fa fa-bars"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number super-large-text">{{ __("authenticated.Main Menu") }}</span>
                    </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- BELLOW ARE SUBMENUES --->

    </section>
</div>
@endsection
