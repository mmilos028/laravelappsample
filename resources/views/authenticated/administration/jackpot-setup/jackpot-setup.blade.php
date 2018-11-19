
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <style>
        .labelSmall{
            font-size: 11px !important;
        }
        .box{
            padding-bottom: 0px;
        }
        .smallFont td{
            font-size: 11px;
        }
        .smallFont th{
            font-size: 9px;
        }
        .dataTables_scroll
        {
            overflow:auto;
            max-height: 500px;
        }

    </style>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-money">&nbsp;</i>
                {{ __("authenticated.JackPot Setup") }}
                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/jackPotSetup") }}" class="noblockui">
                        {{ __("authenticated.JackPot Setup") }}
                    </a>
                </li>
            </ol>
        </section>

        <section class="content">
            @include('layouts.shared.form_messages')

            @if(session("auth.subject_type_id") == config("constants.ADMINISTRATOR_SYSTEM_ID") || session("auth.subject_type_id") == config("constants.MASTER_TYPE_ID"))
            <div class="box">
                <div class="box-body">
                    <div class="col-md-2">
                        <button id="showNewJPModelForm" class="btn btn-primary"><span class="fa fa-plus">&nbsp;</span>{{__ ("authenticated.Add JackPot Specification")}}</button>

                    </div>
                </div>
            </div>
            @else
            <button style="display: none;" id="showNewJPModelForm" class="btn btn-primary"><span class="fa fa-plus">&nbsp;</span>{{__ ("authenticated.Add JackPot Specification")}}</button>
            @endif

            <div class="box animate fadeOut" id="newJpModelBox" style="display: none;">
                <div class="box-header">
                    <h3 class="box-title">{{__ ("authenticated.New JP Model")}}</h3>
                </div>
                <div class="box-body">
                    <form id="newJackpotModelForm" class="form-horizontal">
                        <div id="alertFailCreateModel" class="alert alert-danger" style="display:none"></div>
                        <div id="alertSuccessCreateModel" class="alert alert-success" style="display:none"></div>

                        @if($agent->isDesktop())
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group required">
                                        <label for="name" class="col-md-4 control-label">{{__ ("authenticated.Name")}}:</label>
                                        <div class="col-md-6">
                                            <input class="form-control" placeholder="{{__ ("authenticated.Name")}}" name="name" type="text" id="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="minNoOfTickets" class="col-md-6 control-label">{{__ ("authenticated.Min no. of tickets in draw to win")}}:</label>
                                        <div class="col-md-6">
                                            <input step="0.01" min="0" class="form-control" placeholder="{{__ ("authenticated.Min no. of tickets in draw to win")}}" name="minNoOfTickets" type="number" id="minNoOfTickets">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group required">
                                        <label for="currency" class="col-md-4 control-label">{{__ ("authenticated.Currency")}}:</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="currency" name="currency"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="fromHours" class="col-md-6 control-label">{{__ ("authenticated.JackPot possible to win (from hours)")}}:</label>
                                        <div class="col-md-6">
                                            <input min="0" class="form-control" placeholder="{{__ ("authenticated.JackPot possible to win (from hours)")}}" name="fromHours" type="number" id="fromHours">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group required">
                                        <label for="globalJPOnOff" class="col-md-2 control-label">{{__ ("authenticated.Global JP")}}:</label>
                                        <div class="col-md-3">
                                            <select class="form-control" id="globalJPOnOff">
                                                <option value="-1">{{trans("authenticated.Off")}}</option>
                                                <option value="1">{{trans("authenticated.On")}}</option>
                                            </select>
                                        </div>
                                        <label for="localJPOnOff" class="col-md-2 control-label">{{__ ("authenticated.Local JP")}}:</label>
                                        <div class="col-md-3">
                                            <select class="form-control" id="localJPOnOff">
                                                <option value="-1">{{trans("authenticated.Off")}}</option>
                                                <option value="1">{{trans("authenticated.On")}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="toHours" class="col-md-6 control-label">{{__ ("authenticated.JackPot possible to win (to hours)")}}:</label>
                                        <div class="col-md-6">
                                            <input min="0" class="form-control" placeholder="{{__ ("authenticated.JackPot possible to win (to hours)")}}" name="toHours" type="number" id="toHours">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">{{__ ("authenticated.Levels Win")}}</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="row" id="labelsRow">
                                                <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                    <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.Win Price")}}<strong style="color: red">*</strong></label>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12 required" align="center">
                                                    <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Win Probability")}}<strong style="color: red">*</strong></label>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                    <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Win Before")}}</label>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12 required" align="center">
                                                    <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Min Bet To Win JP")}}<strong style="color: red">*</strong></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="winPriceGlobal" class="col-md-4 control-label labelSmall">{{__ ("authenticated.Global")}}:</label>
                                                        <div class="col-md-8">
                                                            <input min="0" class="form-control" name="winPriceGlobal" type="number" id="winPriceGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="winProbabilityGlobal" class="col-md-1 control-label">1:</label>
                                                        <div class="col-md-8">
                                                            <input min="0" class="form-control" name="winProbabilityGlobal" type="number" id="winProbabilityGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input min="0" class="form-control" name="winBeforeGlobal" type="number" id="winBeforeGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="">
                                                            <input min="0" class="form-control" name="minBetToWinGlobal" type="number" id="minBetToWinGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="winPriceLocal" class="col-md-4 control-label labelSmall">{{__ ("authenticated.Local")}}:</label>
                                                        <div class="col-md-8">
                                                            <input min="0" class="form-control" name="winPriceLocal" type="number" id="winPriceLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="winProbabilityLocal" class="col-md-1 control-label">1:</label>
                                                        <div class="col-md-8">
                                                            <input min="0" class="form-control" name="winProbabilityLocal" type="number" id="winProbabilityLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input min="0" class="form-control" name="winBeforeLocal" type="number" id="winBeforeLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="">
                                                            <input min="0" class="form-control" name="minBetToWinLocal" type="number" id="minBetToWinLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <label for="winWholePot" class="control-label labelSmall">{{__ ("authenticated.Win Whole Pot")}}:</label>
                                                    <select class="form-control" id="winWholePot" name="winWholePot">
                                                        <option value="1">{{__ ("authenticated.Yes")}}</option>
                                                        <option value="-1">{{__ ("authenticated.No")}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <label for="winWholePot" class="control-label labelSmall">{{__ ("authenticated.JackPot Will trigger before this amount")}}</label>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <label for="winWholePot" class="control-label labelSmall">{{__ ("authenticated.Min Bet is total bet per ticket")}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">{{__ ("authenticated.Levels JP Pot")}}</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="row" id="labelsRow2">
                                                <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                    <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.From Bet To JP POT")}}<strong style="color: red">*</strong></label>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                    <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.JP Pot Start Value")}}<strong style="color: red">*</strong></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group required">
                                                        <div class="input-group">
                                                            <input min="0" class="form-control" name="fromBetToJPGlobal" type="number" id="fromBetToJPGlobal">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input min="0" class="form-control" name="jpStartValueGlobal" type="number" id="jpStartValueGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group required">
                                                        <div class="input-group">
                                                            <input min="0" class="form-control" name="fromBetToJPLocal" type="number" id="fromBetToJPLocal">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input min="0" class="form-control" name="jpStartValueLocal" type="number" id="jpStartValueLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($agent->isMobile())
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group required">
                                        <label for="name" class="col-md-4 control-label">{{__ ("authenticated.Name")}}:</label>
                                        <div class="col-md-6">
                                            <input class="form-control" placeholder="{{__ ("authenticated.Name")}}" name="name" type="text" id="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group required">
                                        <label for="currency" class="col-md-4 control-label">{{__ ("authenticated.Currency")}}:</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="currency" name="currency"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group required">
                                        <label for="globalJPOnOff" class="col-md-4 control-label">{{__ ("authenticated.Global JP")}}:</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="globalJPOnOff">
                                                <option value="-1">{{trans("authenticated.Off")}}</option>
                                                <option value="1">{{trans("authenticated.On")}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group required">
                                        <label for="localJPOnOff" class="col-md-4 control-label">{{__ ("authenticated.Local JP")}}:</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="localJPOnOff">
                                                <option value="-1">{{trans("authenticated.Off")}}</option>
                                                <option value="1">{{trans("authenticated.On")}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="minNoOfTickets" class="col-md-6 control-label">{{__ ("authenticated.Min no. of tickets in draw to win")}}:</label>
                                        <div class="col-md-6">
                                            <input step="0.01" min="0" class="form-control" placeholder="{{__ ("authenticated.Min no. of tickets in draw to win")}}" name="minNoOfTickets" type="number" id="minNoOfTickets">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="fromHours" class="col-md-6 control-label">{{__ ("authenticated.JackPot possible to win (from hours)")}}:</label>
                                        <div class="col-md-6">
                                            <input min="0" class="form-control" placeholder="{{__ ("authenticated.JackPot possible to win (from hours)")}}" name="fromHours" type="number" id="fromHours">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="toHours" class="col-md-6 control-label">{{__ ("authenticated.JackPot possible to win (to hours)")}}:</label>
                                        <div class="col-md-6">
                                            <input min="0" class="form-control" placeholder="{{__ ("authenticated.JackPot possible to win (to hours)")}}" name="toHours" type="number" id="toHours">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">{{__ ("authenticated.Levels Win")}}</h3>
                                        </div>
                                        <div class="box-body">
                                            <!--<div class="row" id="labelsRow">
                                                <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                    <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.Win Price")}}</label>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                    <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Win Probability")}}</label>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                    <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Win Before")}}</label>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                    <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Min Bet To Win JP")}}</label>
                                                </div>
                                            </div>-->
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="winPriceGlobal" class="col-md-4 control-label">{{__ ("authenticated.Global Win Price")}}:</label>
                                                        <div class="col-md-8">
                                                            <input min="0" class="form-control" name="winPriceGlobal" type="number" id="winPriceGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="winProbabilityGlobal" class="col-md-1 control-label">{{__ ("authenticated.Global Win Probability")}} 1:</label>
                                                        <div class="col-md-8">
                                                            <input min="0" class="form-control" name="winProbabilityGlobal" type="number" id="winProbabilityGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="winBeforeGlobal" class="col-md-1 control-label">{{__ ("authenticated.Global Win Before")}}</label>
                                                        <div class="col-md-12">
                                                            <input min="0" class="form-control" name="winBeforeGlobal" type="number" id="winBeforeGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="minBetToWinGlobal" class="col-md-1 control-label">{{__ ("authenticated.Global Min. Bet To Win JP")}}:</label>
                                                        <div class="">
                                                            <input min="0" class="form-control" name="minBetToWinGlobal" type="number" id="minBetToWinGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="winPriceLocal" class="col-md-4 control-label">{{__ ("authenticated.Local Win Price")}}:</label>
                                                        <div class="col-md-8">
                                                            <input min="0" class="form-control" name="winPriceLocal" type="number" id="winPriceLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="winProbabilityLocal" class="col-md-1 control-label">{{__ ("authenticated.Local Win Probability")}} 1:</label>
                                                        <div class="col-md-8">
                                                            <input min="0" class="form-control" name="winProbabilityLocal" type="number" id="winProbabilityLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="winBeforeLocal" class="col-md-1 control-label">{{__ ("authenticated.Local Win Before")}}</label>
                                                        <div class="col-md-12">
                                                            <input min="0" class="form-control" name="winBeforeLocal" type="number" id="winBeforeLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="minBetToWinLocal" class="col-md-1 control-label">{{__ ("authenticated.Local Min. Bet To Win JP")}}</label>
                                                        <div class="">
                                                            <input min="0" class="form-control" name="minBetToWinLocal" type="number" id="minBetToWinLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-xs-12 required">
                                                    <label for="winWholePot" class="control-label">{{__ ("authenticated.Win Whole Pot")}}:</label>
                                                    <select class="form-control" id="winWholePot" name="winWholePot">
                                                        <option value="1">{{__ ("authenticated.Yes")}}</option>
                                                        <option value="-1">{{__ ("authenticated.No")}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <br>
                                                    <label for="winWholePot" class="control-label labelSmall">*{{__ ("authenticated.JackPot will trigger before 'Win Before' amount.")}}</label>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <label for="winWholePot" class="control-label labelSmall">*{{__ ("authenticated.Min Bet is total bet per ticket.")}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">{{__ ("authenticated.Levels JP Pot")}}</h3>
                                        </div>
                                        <div class="box-body">
                                            <!--<div class="row" id="labelsRow2">
                                                <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                    <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.From Bet To JP POT")}}</label>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                    <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.JP Pot Start Value")}}</label>
                                                </div>
                                            </div>-->
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="fromBetToJPGlobal" class="control-label">{{__ ("authenticated.Global From Bet To JP POT")}}:</label>
                                                        <div class="input-group">
                                                            <input min="0" class="form-control" name="fromBetToJPGlobal" type="number" id="fromBetToJPGlobal">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="jpStartValueGlobal" class="control-label">{{__ ("authenticated.Global JP Pot Start Value")}}:</label>
                                                        <div class="col-md-12">
                                                            <input min="0" class="form-control" name="jpStartValueGlobal" type="number" id="jpStartValueGlobal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="fromBetToJPLocal" class="control-label">{{__ ("authenticated.Local From Bet To JP POT")}}:</label>
                                                        <div class="input-group">
                                                            <input min="0" class="form-control" name="fromBetToJPLocal" type="number" id="fromBetToJPLocal">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group required">
                                                        <label for="jpStartValueLocal" class="control-label">{{__ ("authenticated.Local JP Pot Start Value")}}:</label>
                                                        <div class="col-md-12">
                                                            <input min="0" class="form-control" name="jpStartValueLocal" type="number" id="jpStartValueLocal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-actions">
                            <button class="btn btn-primary" type="button" name="save" id="addNewJPBtn"><i class="fa fa-save">&nbsp;</i>{{__ ("authenticated.Add")}}</button>
                            <button class="btn btn-default" type="button" name="cancel" id="cancelNewJPBtn"><i class="fa fa-times">&nbsp;</i>{{__ ("authenticated.Cancel")}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{__ ("authenticated.JackPot Model List")}}</h3>
                </div>
                <div class="box-body">
                    <table id="modelList" class="table table-bordered dataTable pull-left" style="width: 100% !important;">
                        <thead>
                        <tr class="bg-blue-active">
                            <th>{{__ ("authenticated.Model Name")}}</th>
                            <th>{{__ ("authenticated.Currency")}}</th>
                            <th>Details L G</th>
                            <th style="text-align: left;">{{__ ("authenticated.Action")}}</th>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="box" id="selectedModelSubjectsListBox" style="display:none;">
                <div class="box-header">
                    <h3 class="box-title">{{__ ("List of Subjects for Selected JP Model")}}&nbsp;(<strong id="selectedModelName"></strong>)</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <h2 class="text-light-blue">Disabled</h2>
                            <table id="disabledSubjectsList" class="table table-bordered dataTable pull-left smallFont" style="width: 100%;">
                                <thead>
                                <tr class="bg-blue-active">
                                    <th>{{__ ("Name")}}</th>
                                    <th>{{__ ("Type")}}</th>
                                    <th>{{__ ("Path")}}</th>
                                </thead>
                            </table>
                        </div>
                        @if($agent->isDesktop())
                            <div class="col-md-1" align="center" style="padding-top: 150px;">
                                <button id="enableSubjectForModelBtn" class="btn btn-primary btn-block"><span class="fa fa-arrow-right"></span></button>
                                <button id="disableSubjectForModelBtn" class="btn btn-primary btn-block"><span class="fa fa-arrow-left"></span></button>
                            </div>
                        @elseif($agent->isMobile())
                            <hr>
                            <div class="col-md-1" align="center" style="">
                                <button id="enableSubjectForModelBtn" class="btn btn-primary btn-block"><span class="fa fa-arrow-down"></span></button>
                                <button id="disableSubjectForModelBtn" class="btn btn-primary btn-block"><span class="fa fa-arrow-up"></span></button>
                            </div>
                            <hr>
                        @endif
                        <div class="col-md-6">
                            <h2 class="text-light-blue">Enabled</h2>
                            <table id="enabledSubjectsList" class="table table-bordered dataTable smallFont pull-left" style="width: 100%;">
                                <thead>
                                <tr class="bg-blue-active">
                                    <th>{{__ ("Name")}}</th>
                                    <th>{{__ ("Type")}}</th>
                                    <th style="text-align: left;">{{__ ("Priority")}}</th>
                                    <th>{{__ ("Activity Type")}}</th>
                                    <th>{{__ ("Pot")}}</th>
                                    <th style="text-align: left;">{{__ ("Details")}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{__ ("Edit JP Model")}}</h4>
                </div>
                <div class="modal-body">
                    <div class="box animate fadeOut" id="newJpModelBox">
                        <div class="box-body">
                            <form id="editJackpotModelForm" class="form-horizontal">
                                <div id="alertFailEditModel" class="alert alert-danger" style="display:none"></div>
                                <div id="alertSuccessEditModel" class="alert alert-success" style="display:none"></div>
                                @if($agent->isDesktop())
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group required">
                                                <label for="nameEdit" class="col-md-4 control-label">{{__ ("authenticated.Name")}}:</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" placeholder="{{__ ("authenticated.Name")}}" name="nameEdit" type="text" id="nameEdit">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="minNoOfTicketsEdit" class="col-md-6 control-label">{{__ ("authenticated.Min no. of tickets in draw to win")}}:</label>
                                                <div class="col-md-6">
                                                    <input step="0.01" min="0" class="form-control" placeholder="{{__ ("authenticated.Min no. of tickets in draw to win")}}" name="minNoOfTicketsEdit" type="number" id="minNoOfTicketsEdit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group required">
                                                <label for="currencyEdit" class="col-md-4 control-label">{{__ ("authenticated.Currency")}}:</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" id="currencyEdit" name="currencyEdit"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="fromHoursEdit" class="col-md-6 control-label">{{__ ("authenticated.JackPot possible to win (from hours)")}}:</label>
                                                <div class="col-md-6">
                                                    <input min="0" class="form-control" placeholder="{{__ ("authenticated.JackPot possible to win (from hours)")}}" name="fromHoursEdit" type="number" id="fromHoursEdit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group required">
                                                <label for="globalJPOnOffEdit" class="col-md-2 control-label">{{__ ("authenticated.Global JP")}}:</label>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="globalJPOnOffEdit">
                                                        <option value="-1">{{trans("authenticated.Off")}}</option>
                                                        <option value="1">{{trans("authenticated.On")}}</option>
                                                    </select>
                                                </div>
                                                <label for="localJPOnOffEdit" class="col-md-2 control-label">{{__ ("authenticated.Local JP")}}:</label>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="localJPOnOffEdit">
                                                        <option value="-1">{{trans("authenticated.Off")}}</option>
                                                        <option value="1">{{trans("authenticated.On")}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="toHoursEdit" class="col-md-6 control-label">{{__ ("authenticated.JackPot possible to win (to hours)")}}:</label>
                                                <div class="col-md-6">
                                                    <input min="0" class="form-control" placeholder="{{__ ("authenticated.JackPot possible to win (to hours)")}}" name="toHoursEdit" type="number" id="toHoursEdit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="box box-primary">
                                                <div class="box-header">
                                                    <h3 class="box-title">{{__ ("authenticated.Levels Win")}}</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row" id="labelsRow">
                                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                            <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.Win Price")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                            <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Win Probability")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                            <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Win Before")}}</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                            <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Min Bet To Win JP")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <label for="winPriceGlobalEdit" class="col-md-4 control-label labelSmall">{{__ ("authenticated.Global")}}:</label>
                                                                <div class="col-md-8">
                                                                    <input min="0" class="form-control" name="winPriceGlobalEdit" type="number" id="winPriceGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <label for="winProbabilityGlobalEdit" class="col-md-1 control-label">1:</label>
                                                                <div class="col-md-8">
                                                                    <input min="0" class="form-control" name="winProbabilityGlobalEdit" type="number" id="winProbabilityGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input min="0" class="form-control" name="winBeforeGlobalEdit" type="number" id="winBeforeGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <div class="">
                                                                    <input min="0" class="form-control" name="minBetToWinGlobalEdit" type="number" id="minBetToWinGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <label for="winPriceLocalEdit" class="col-md-4 control-label labelSmall">{{__ ("authenticated.Local")}}:</label>
                                                                <div class="col-md-8">
                                                                    <input min="0" class="form-control" name="winPriceLocalEdit" type="number" id="winPriceLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <label for="winProbabilityLocalEdit" class="col-md-1 control-label">1:</label>
                                                                <div class="col-md-8">
                                                                    <input min="0" class="form-control" name="winProbabilityLocalEdit" type="number" id="winProbabilityLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input min="0" class="form-control" name="winBeforeLocalEdit" type="number" id="winBeforeLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <div class="">
                                                                    <input min="0" class="form-control" name="minBetToWinLocalEdit" type="number" id="minBetToWinLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <label for="winWholePotEdit" class="control-label labelSmall">{{__ ("authenticated.Win Whole Pot")}}:</label>
                                                            <select class="form-control" id="winWholePotEdit" name="winWholePotEdit">
                                                                <option value="1">{{__ ("authenticated.Yes")}}</option>
                                                                <option value="-1">{{__ ("authenticated.No")}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <label for="winWholePot" class="control-label labelSmall">{{__ ("authenticated.JackPot Will trigger before this amount")}}</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <label for="winWholePot" class="control-label labelSmall">{{__ ("authenticated.Min Bet is total bet per ticket")}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="box box-primary">
                                                <div class="box-header">
                                                    <h3 class="box-title">{{__ ("authenticated.Levels JP Pot")}}</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row" id="labelsRow2">
                                                        <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                            <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.From Bet To JP POT")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                            <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.JP Pot Start Value")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group required">
                                                                <div class="input-group">
                                                                    <input min="0" class="form-control" name="fromBetToJPGlobalEdit" type="number" id="fromBetToJPGlobalEdit">
                                                                    <span class="input-group-addon">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input min="0" class="form-control" name="jpStartValueGlobalEdit" type="number" id="jpStartValueGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group required">
                                                                <div class="input-group">
                                                                    <input min="0" class="form-control" name="fromBetToJPLocalEdit" type="number" id="fromBetToJPLocalEdit">
                                                                    <span class="input-group-addon">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input min="0" class="form-control" name="jpStartValueLocalEdit" type="number" id="jpStartValueLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($agent->isMobile())
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group required">
                                                <label for="nameEdit" class="col-md-4 control-label">{{__ ("authenticated.Name")}}:</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" placeholder="{{__ ("authenticated.Name")}}" name="nameEdit" type="text" id="nameEdit">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group required">
                                                <label for="currencyEdit" class="col-md-4 control-label">{{__ ("authenticated.Currency")}}:</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" id="currencyEdit" name="currencyEdit"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group required">
                                                <label for="globalJPOnOffEdit" class="col-md-4 control-label">{{__ ("authenticated.Global JP")}}:</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" id="globalJPOnOffEdit">
                                                        <option value="-1">{{trans("authenticated.Off")}}</option>
                                                        <option value="1">{{trans("authenticated.On")}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group required">
                                                <label for="localJPOnOffEdit" class="col-md-4 control-label">{{__ ("authenticated.Local JP")}}:</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" id="localJPOnOffEdit">
                                                        <option value="-1">{{trans("authenticated.Off")}}</option>
                                                        <option value="1">{{trans("authenticated.On")}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="minNoOfTicketsEdit" class="col-md-6 control-label">{{__ ("authenticated.Min no. of tickets in draw to win")}}:</label>
                                                <div class="col-md-6">
                                                    <input step="0.01" min="0" class="form-control" placeholder="{{__ ("authenticated.Min no. of tickets in draw to win")}}" name="minNoOfTicketsEdit" type="number" id="minNoOfTicketsEdit">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="fromHoursEdit" class="col-md-6 control-label">{{__ ("authenticated.JackPot possible to win (from hours)")}}:</label>
                                                <div class="col-md-6">
                                                    <input min="0" class="form-control" placeholder="{{__ ("authenticated.JackPot possible to win (from hours)")}}" name="fromHoursEdit" type="number" id="fromHoursEdit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="toHoursEdit" class="col-md-6 control-label">{{__ ("authenticated.JackPot possible to win (to hours)")}}:</label>
                                                <div class="col-md-6">
                                                    <input min="0" class="form-control" placeholder="{{__ ("authenticated.JackPot possible to win (to hours)")}}" name="toHoursEdit" type="number" id="toHoursEdit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="box box-primary">
                                                <div class="box-header">
                                                    <h3 class="box-title">{{__ ("authenticated.Levels Win")}}</h3>
                                                </div>
                                                <div class="box-body">
                                                    <!--<div class="row" id="labelsRow">
                                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                            <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.Win Price")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                            <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Win Probability")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                            <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Win Before")}}</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                                            <label for="winProbability" class="control-label labelSmall">{{__ ("authenticated.Min Bet To Win JP")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                    </div>-->
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="winPriceGlobalEdit" class="col-md-4 control-label">{{__ ("authenticated.Global Win Price")}}:</label>
                                                                <div class="col-md-8">
                                                                    <input min="0" class="form-control" name="winPriceGlobalEdit" type="number" id="winPriceGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="winProbabilityGlobalEdit" class="col-md-1 control-label">{{__ ("authenticated.Global Win Probability")}} 1:</label>
                                                                <div class="col-md-8">
                                                                    <input min="0" class="form-control" name="winProbabilityGlobalEdit" type="number" id="winProbabilityGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <label for="winBeforeGlobalEdit" class="col-md-1 control-label">{{__ ("authenticated.Global Win Before")}}:</label>
                                                                <div class="col-md-12">
                                                                    <input min="0" class="form-control" name="winBeforeGlobalEdit" type="number" id="winBeforeGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="minBetToWinGlobalEdit" class="col-md-1 control-label">{{__ ("authenticated.Global Min. Bet To Win JP")}}</label>
                                                                <div class="">
                                                                    <input min="0" class="form-control" name="minBetToWinGlobalEdit" type="number" id="minBetToWinGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="winPriceLocalEdit" class="col-md-4 control-label">{{__ ("authenticated.Local Win Price")}}:</label>
                                                                <div class="col-md-8">
                                                                    <input min="0" class="form-control" name="winPriceLocalEdit" type="number" id="winPriceLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="winProbabilityLocalEdit" class="col-md-1 control-label">{{__ ("authenticated.Local Win Probability")}} 1:</label>
                                                                <div class="col-md-8">
                                                                    <input min="0" class="form-control" name="winProbabilityLocalEdit" type="number" id="winProbabilityLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <label for="winBeforeLocalEdit" class="col-md-1 control-label">{{__ ("authenticated.Local Win Before")}}:</label>
                                                                <div class="col-md-12">
                                                                    <input min="0" class="form-control" name="winBeforeLocalEdit" type="number" id="winBeforeLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="minBetToWinLocalEdit" class="col-md-1 control-label">{{__ ("authenticated.Local Min. Bet To Win JP")}}:</label>
                                                                <div class="">
                                                                    <input min="0" class="form-control" name="minBetToWinLocalEdit" type="number" id="minBetToWinLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <label for="winWholePotEdit" class="control-label">{{__ ("authenticated.Win Whole Pot")}}:</label>
                                                            <select class="form-control" id="winWholePotEdit" name="winWholePotEdit">
                                                                <option value="1">{{__ ("authenticated.Yes")}}</option>
                                                                <option value="-1">{{__ ("authenticated.No")}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <br>
                                                            <label for="winWholePot" class="control-label labelSmall">*{{__ ("authenticated.JackPot will trigger before 'Win Before' amount.")}}</label>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <label for="winWholePot" class="control-label labelSmall">*{{__ ("authenticated.Min Bet is total bet per ticket.")}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="box box-primary">
                                                <div class="box-header">
                                                    <h3 class="box-title">{{__ ("authenticated.Levels JP Pot")}}</h3>
                                                </div>
                                                <div class="box-body">
                                                    <!--<div class="row" id="labelsRow2">
                                                        <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                            <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.From Bet To JP POT")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                            <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.JP Pot Start Value")}}<strong style="color: red">*</strong></label>
                                                        </div>
                                                    </div>-->
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group required">
                                                                <label for="fromBetToJPGlobalEdit" class="control-label labelSmall">{{__ ("authenticated.Global From Bet To JP POT")}}:</label>
                                                                <div class="input-group">
                                                                    <input min="0" class="form-control" name="fromBetToJPGlobalEdit" type="number" id="fromBetToJPGlobalEdit">
                                                                    <span class="input-group-addon">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="jpStartValueGlobalEdit" class="control-label labelSmall">{{__ ("authenticated.Global JP Pot Start Value")}}:</label>
                                                                <div class="col-md-12">
                                                                    <input min="0" class="form-control" name="jpStartValueGlobalEdit" type="number" id="jpStartValueGlobalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="fromBetToJPLocalEdit" class="control-label labelSmall">{{__ ("authenticated.Local From Bet To JP POT")}}:</label>
                                                                <div class="input-group">
                                                                    <input min="0" class="form-control" name="fromBetToJPLocalEdit" type="number" id="fromBetToJPLocalEdit">
                                                                    <span class="input-group-addon">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group required">
                                                                <label for="jpStartValueLocalEdit" class="control-label labelSmall">{{__ ("authenticated.Local JP Pot Start Value")}}:</label>
                                                                <div class="col-md-12">
                                                                    <input min="0" class="form-control" name="jpStartValueLocalEdit" type="number" id="jpStartValueLocalEdit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </form>
                            <div id="alertWarningEditModel" class="alert alert-warning" style="display:none;">
                                <span class="fa fa-warning">&nbsp;</span>
                                {{trans("authenticated.If you disable a specific jackpot for this model, all affiliates with this model WILL have this specific jackpot disabled.")}}
                                <br>
                                {{trans("authenticated.If you enable a specific jackpot for this model, all affiliates with this model WILL NOT have this specific jackpot enabled, it must be done manually.")}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="display: none;" id="cancelEditJPBtn" type="button" class="btn btn-default pull-right"><span class="fa fa-close">&nbsp;</span>Cancel</button>
                    <button style="display: none;" id="saveJPBtn" type="button" class="btn btn-primary pull-right"><span class="fa fa-save">&nbsp;</span>Save</button>
                    <button id="closeEditJPModalBtn" type="button" class="btn btn-default pull-right" data-dismiss = "modal"><span class="fa fa-sign-out">&nbsp;</span>Close</button>

                    @if(session("auth.subject_type_id") == config("constants.ADMINISTRATOR_SYSTEM_ID") || session("auth.subject_type_id") == config("constants.MASTER_TYPE_ID"))
                        <button id="editJPBtn" type="button" class="btn btn-success pull-right"><span class="fa fa-edit">&nbsp;</span>Edit</button>
                    @else
                        <button style="display: none;" id="editJPBtn" type="button" class="btn btn-success pull-right"><span class="fa fa-edit">&nbsp;</span>Edit</button>
                    @endif

                    @if(session("auth.subject_type_id") == config("constants.ADMINISTRATOR_SYSTEM_ID") || session("auth.subject_type_id") == config("constants.MASTER_TYPE_ID"))
                        <button id="deleteJPBtn" type="button" class="btn btn-danger pull-left" data-dismiss = "modal"><span class="fa fa-close">&nbsp;</span>Delete</button>
                    @else
                        <button style="display: none;" id="deleteJPBtn" type="button" class="btn btn-danger pull-left" data-dismiss = "modal"><span class="fa fa-close">&nbsp;</span>Delete</button>
                    @endif

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editJPLevelLocationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Entity JackPot Details</h4>
                </div>
                <div class="modal-body">
                    <div id="alertFailLocationEditJPModel" class="alert alert-danger" style="display:none"></div>
                    <div id="alertSuccessLocationEditJPModel" class="alert alert-success" style="display:none"></div>
                    <div id="alertInfoLocationEditJPModal" class="alert alert-warning" style="display: none;">
                        <span class="fa fa-warning">&nbsp;</span>{{trans("authenticated.This location has no affiliate to inherit global jack-pot from, therefore, global jack-pot can not be active.")}}
                    </div>
                    <form accept-charset="UTF-8" id="editJPLevelLocationModalForm" class="form-horizontal row-border">
                        <div class="form-group">
                            <label for="location_model_name_level" class="col-md-4 control-label">Jackpot Model:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Model" name="location_model_name_level" type="text" id="location_model_name_level">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location_entity_name_level" class="col-md-4 control-label">Entity Name:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Entity Name" name="location_entity_name_level" type="text" id="location_entity_name_level">
                            </div>
                        </div>
                        <div class="form-group" id="location_inherit_from_level_container">
                            <label for="location_inherit_from_level" class="col-md-4 control-label">Inherit From:</label>
                            <div class="col-md-6">
                                <select disabled name="location_inherit_from_level" id="location_inherit_from_level" class="form-control">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location_priority_level" class="col-md-4 control-label">Priority:</label>
                            <div class="col-md-6">
                                <select disabled name="location_priority_level" id="location_priority_level" class="form-control">
                                    <option value="{{config("constants.priority_100")}}">100%</option>
                                    <option value="{{config("constants.priority_50")}}">50%</option>
                                    <option value="{{config("constants.priority_0")}}">0%</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="location_global_level_container">
                            <label for="location_global_level" class="col-md-4 control-label">Global:</label>
                            <div class="col-md-6">
                                <select disabled name="location_global_level" id="location_global_level" class="form-control">
                                    <option value="1">On</option>
                                    <option value="-1">Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location_local_level" class="col-md-4 control-label">Local:</label>
                            <div class="col-md-6">
                                <select disabled name="location_local_level" id="location_local_level" class="form-control">
                                    <option value="1">On</option>
                                    <option value="-1">Off</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <h4>Actual Value for POT:</h4>
                        <br>
                        <div class="form-group">
                            <label for="location_actual_global_pot_value_level" class="col-md-4 control-label">Global:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Global" name="location_actual_global_pot_value_level" type="text" id="location_actual_global_pot_value_level">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location_actual_local_pot_value_level" class="col-md-4 control-label">Local:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Local" name="location_actual_local_pot_value_level" type="text" id="location_actual_local_pot_value_level">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location_currency_level" class="col-md-4 control-label">Currency:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Currency" name="location_currency_level" type="text" id="location_currency_level">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="jpDetailsCloseBtn" type="button" class="btn btn-default pull-right" data-dismiss="modal"><span class="fa fa-close">&nbsp;</span>Close</button>
                    <button id="jpDetailsEditBtn" type="button" class="btn btn-success pull-right"><span class="fa fa-edit">&nbsp;</span>Edit</button>
                    <button style="display: none;" id="jpDetailsCancelBtn" type="button" class="btn btn-danger pull-right"><span class="fa fa-close">&nbsp;</span>Cancel</button>
                    <button style="display: none;" id="jpDetailsSaveBtn" type="button" class="btn btn-primary pull-right"><span class="fa fa-check">&nbsp;</span>Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editJPLevelClientModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Entity JackPot Details</h4>
                </div>
                <div class="modal-body">
                    <div id="alertFailClientEditJPModel" class="alert alert-danger" style="display:none"></div>
                    <div id="alertSuccessClientEditJPModel" class="alert alert-success" style="display:none"></div>

                    <form accept-charset="UTF-8" id="editJPLevelClientModalForm" class="form-horizontal row-border">
                        <div class="form-group">
                            <label for="client_model_name_level" class="col-md-4 control-label">Jackpot Model:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Model" name="client_model_name_level" type="text" id="client_model_name_level">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_entity_name_level" class="col-md-4 control-label">Entity Name:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Entity Name" name="client_entity_name_level" type="text" id="client_entity_name_level">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_global_level" class="col-md-4 control-label">Global:</label>
                            <div class="col-md-6">
                                <select disabled name="client_global_level" id="client_global_level" class="form-control">
                                    <option value="1">On</option>
                                    <option value="-1">Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_actual_global_pot_value_level" class="col-md-4 control-label">Global POT:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Global" name="client_actual_global_pot_value_level" type="text" id="client_actual_global_pot_value_level">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_currency_level" class="col-md-4 control-label">Currency:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Currency" name="client_currency_level" type="text" id="client_currency_level">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="jpClientDetailsCloseBtn" type="button" class="btn btn-default pull-right" data-dismiss="modal"><span class="fa fa-close">&nbsp;</span>Close</button>
                    <button id="jpClientDetailsEditBtn" type="button" class="btn btn-success pull-right"><span class="fa fa-edit">&nbsp;</span>Edit</button>
                    <button style="display: none;" id="jpClientDetailsCancelBtn" type="button" class="btn btn-danger pull-right"><span class="fa fa-close">&nbsp;</span>Cancel</button>
                    <button style="display: none;" id="jpClientDetailsSaveBtn" type="button" class="btn btn-primary pull-right"><span class="fa fa-check">&nbsp;</span>Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete JackPot Model '<strong id="modelNameDelete"></strong>'.Are you sure ?</p>
                </div>
                <div class="modal-footer">
                    <button id="closeDeleteModalBtn" type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                    <button id="deleteModalBtn" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="infoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p id="infoModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Ok</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="removeSubjectFromJPModelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p id="removeSubjectModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                    <button id="disableSubjectFromJPModelBtn" type="button" class="btn btn-primary pull-right" data-dismiss="modal">Disable</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="addSubjectOtherThanLocationToJPModelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p id="addSubjectOtherThanLocationToJPModelModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                    <button id="addSubjectOtherThanLocationToJPModelModalBtn" type="button" class="btn btn-primary pull-right">Enable</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="addLocationToJPModelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <div id="alertFailLocationModal" class="alert alert-danger" style="display: none;"></div>
                    <div id="alertSuccessLocationModal" class="alert alert-success" style="display: none;"></div>
                    <div id="alertInfoLocationModal" class="alert alert-warning" style="display: none;">
                        <span class="fa fa-warning">&nbsp;</span>{{trans("authenticated.This location has no affiliate to inherit global jack-pot from, therefore, global jack-pot can not be active.")}}
                    </div>

                    <form accept-charset="UTF-8" id="addLocationToJPModelModalForm" class="form-horizontal row-border">
                        <div class="form-group">
                            <label for="location_model_name" class="col-md-4 control-label">Model:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Model" name="location_model_name" type="text" id="location_model_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location" class="col-md-4 control-label">Location:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="Location" name="location" type="text" id="location">
                            </div>
                        </div>
                        <div class="form-group" id="inheritFromSubjectsContainer">
                            <label for="inheritFromSubjects" class="col-md-4 control-label">Global Inherited From:</label>
                            <div class="col-md-6">
                                <select name="inheritFromSubjects" id="inheritFromSubjects" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="priority" class="col-md-4 control-label">Priority:</label>
                            <div class="col-md-6">
                                <select name="priority" id="priority" class="form-control">
                                    <option value="{{config("constants.priority_100")}}">100%</option>
                                    <option value="{{config("constants.priority_50")}}">50%</option>
                                    <option value="{{config("constants.priority_0")}}">0%</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="global" class="col-md-4 control-label">Global:</label>
                            <div class="col-md-6">
                                <select name="global" id="global" class="form-control">
                                    <option value="1">On</option>
                                    <option value="-1">Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="local" class="col-md-4 control-label">Local:</label>
                            <div class="col-md-6">
                                <select name="local" id="local" class="form-control">
                                    <option value="1">On</option>
                                    <option value="-1">Off</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><span class="fa fa-close">&nbsp;</span>Cancel</button>
                    <button id="addLocationToJPModelModalBtn" type="button" class="btn btn-primary pull-right"><span class="fa fa-check">&nbsp;</span>Enable</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <script>
        $(document).ready(function(){
            //INITIALIZATION -------------------------------------------------------------------------------------------

            var client_type_id = "{{config('constants.CLIENT_TYPE_ID')}}";
            var operator_type_id = "{{config('constants.OPERATER_TYPE_ID')}}";
            var location_type_id = "{{config('constants.LOCATION_TYPE_ID')}}";

            $("#minNoOfTickets").numeric();

            var selected_model_id;
            var selected_model_name;

            var tableDisabledSubjects;
            var selectedDisabledSubjectID;
            var selectedDisabledSubjectName;
            var selectedDisabledSubjectTypeID;
            var selectedDisabledSubjectTypeName;

            var tableEnabledSubjects;
            var selectedEnabledSubjectID;
            var selectedEnabledSubjectName;
            var selectedEnabledSubjectTypeID;
            var selectedEnabledSubjectTypeName;

            var jp_details_jp_model;
            var jp_details_jp_model_id;
            var jp_details_entity_name;
            var jp_details_priority;
            var jp_details_global_level_on_off;
            var jp_details_local_level_on_off;
            var jp_details_global_level_value;
            var jp_details_local_level_value;
            var jp_details_currency;
            var jp_details_inherit_from;

            var ignore = false;
            var dropDownSubjectsCounter;

            //wrap all datatables and don't use scrollx property
            //jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');

            $("#minNoOfTickets").numeric();
            $("#fromHours").numeric();
            $("#toHours").numeric();

            var table = $('#modelList').DataTable( {
                "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                initComplete: function (settings, json) {
                    $("#modelList_length").addClass("pull-right");
                    $("#modelList_filter").addClass("pull-left");
                },
                "order": [],
                //scrollY: 100,
                scrollX: true,
                select: true,
                colReorder: true,
                stateSave: false,
                "deferRender": true,
                "processing": true,
                "serverSide": false,
                ajax: {
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getJpModels") }}",
                    "dataSrc": "result"
                },
                "paging": true,
                pagingType: 'full_numbers',
                "iDisplayLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
                columns:[
                    {
                        data: "model_name",
                        width: 200,
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: "currency",
                        width: 200,
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: "details",
                        width: 200,
                        bSearchable: true,
                        sortable: true
                    },
                    {
                        data: function(row, type, val, meta){
                            var model_id = row.model_id;
                            var model_name = row.model_name;

                            return '<div class="btn-group" align = "center">' +
                                '<button type="button" class="btn btn-sm btn-success" onclick = "showEditForm(' + model_id + ',\'' + model_name + '\'' + ')"><span class="fa fa-edit"></span></button>' +
                                /*'<button type="button" class="btn btn-sm btn-danger" onclick = "showDeleteModal(' + model_id + ',\'' + model_name + '\'' + ')"><span class="glyphicon glyphicon-remove-sign"></span></button>' +*/
                                '</div>';
                        },
                        width: 200,
                        className: "text-center",
                        bSearchable: false,
                        sortable: false
                    }
                ],
                "language": {
                    "zeroRecords": "<?php echo __("No records available."); ?>",
                    "info": "<?php echo __("Showing _START_ to _END_ of _MAX_ entries."); ?>",
                    "lengthMenu": "<?php echo __("Showing _MENU_ entries"); ?>",
                    "search": "<?php echo __("Search"); ?>",
                    "infoEmpty": "<?php echo __("No records available."); ?>",
                    "infoFiltered": "<?php echo __("filtered from _MAX_ total records"); ?>",
                    "paginate": {
                        "first": "<?php echo __("First") ?>",
                        "last": "<?php echo __("Last") ?>",
                        "previous": "<?php echo __("Previous") ?>",
                        "next": "<?php echo __("Next") ?>"
                    }
                }
            } );

            //LISTENERS ------------------------------------------------------------------------------------------------

            $('#modelList').on( 'click', 'tbody tr', function () {
                document.getElementById("selectedModelSubjectsListBox").style.display = "inline";

                var row_data = table.row( this ).data();

                selectedDisabledSubjectID = null;
                selectedDisabledSubjectName = null;
                selectedDisabledSubjectTypeID = null;
                selectedDisabledSubjectTypeName = null;
                selectedEnabledSubjectID = null;
                selectedEnabledSubjectName = null;
                selectedEnabledSubjectTypeID = null;
                selectedEnabledSubjectTypeName = null;

                selected_model_id = row_data.model_id;
                selected_model_name = row_data.model_name;

                document.getElementById("selectedModelName").innerHTML = selected_model_name;

                generateSubjectTables(selected_model_id);

                if ( $(this).hasClass('selected') ) {
                    //$(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );

            $('#disabledSubjectsList').on( 'click', 'tbody tr', function () {
                var row_data = tableDisabledSubjects.row( this ).data();
                selectedDisabledSubjectID = row_data.subject_id_to;
                selectedDisabledSubjectName = row_data.subject_name_to;
                selectedDisabledSubjectTypeID = row_data.subject_type_id_to;
                selectedDisabledSubjectTypeName = row_data.subject_type_name_to;

                if ( $(this).hasClass('selected') ) {
                    //$(this).removeClass('selected');
                }
                else {
                    tableDisabledSubjects.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );
            $('#enabledSubjectsList').on( 'click', 'tbody tr', function () {
                var row_data = tableEnabledSubjects.row( this ).data();
                selectedEnabledSubjectID = row_data.subject_id_to;
                selectedEnabledSubjectName = row_data.subject_name_to;
                selectedEnabledSubjectTypeID = row_data.subject_type_id_to;
                selectedEnabledSubjectTypeName = row_data.subject_type_name_to;

                if ( $(this).hasClass('selected') ) {
                    //$(this).removeClass('selected');
                }
                else {
                    tableEnabledSubjects.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );

            $("#editJPBtn").on("click", function(){
                enableAllEditFormInputs();
                document.getElementById("editJPBtn").style.display = "none";
                document.getElementById("closeEditJPModalBtn").style.display = "none";
                document.getElementById("cancelEditJPBtn").style.display = "inline";
                document.getElementById("saveJPBtn").style.display = "inline";

                $("#alertSuccessEditModel").empty();
                $('#alertSuccessEditModel').hide();
                $("#alertFailEditModel").empty();
                $('#alertFailEditModel').hide();

                $("#alertWarningEditModel").show();
            });

            $("#cancelEditJPBtn").on("click", function(){
                disableAllEditFormInputs();
                document.getElementById("editJPBtn").style.display = "inline";
                document.getElementById("closeEditJPModalBtn").style.display = "inline";
                document.getElementById("cancelEditJPBtn").style.display = "none";
                document.getElementById("saveJPBtn").style.display = "none";

                $("#alertSuccessEditModel").empty();
                $('#alertSuccessEditModel').hide();
                $("#alertFailEditModel").empty();
                $('#alertFailEditModel').hide();

                $("#alertWarningEditModel").hide();

                document.getElementById("editJackpotModelForm").reset();

                getJpModelDetails(selected_model_id);
            });
            $("#enableSubjectForModelBtn").on("click", function(){
                if(selectedDisabledSubjectID){
                    if(selectedDisabledSubjectTypeID == location_type_id){

                        listInheritFromSubjects(selectedDisabledSubjectTypeID, selected_model_id);

                        document.getElementById("location_model_name").value = selected_model_name;
                        document.getElementById("location").value = selectedDisabledSubjectName;

                        $("#addLocationToJPModelModal").modal({
                            //backdrop:'static',
                            keyboard:false,
                            show:true
                        });
                    }else{
                        document.getElementById("addSubjectOtherThanLocationToJPModelModalMessage").innerHTML = "JP Model Name: " + selected_model_name + "<br>" + "Subject: " + selectedDisabledSubjectName + "<br>" +
                            "Subject Type: " + selectedDisabledSubjectTypeName + "<br><br>" + "Are you sure ?";

                        $("#addSubjectOtherThanLocationToJPModelModal").modal({
                            //backdrop:'static',
                            keyboard:false,
                            show:true
                        });
                    }

                }else{
                    document.getElementById("infoModalMessage").innerHTML = "No disabled subject is selected.";

                    $("#infoModal").modal({
                        //backdrop:'static',
                        keyboard:false,
                        show:true
                    });
                }
            });
            $("#addSubjectOtherThanLocationToJPModelModalBtn").unbind().on("click", function(){
                enableJpModelForSubject(selectedDisabledSubjectID, selected_model_id, selectedDisabledSubjectID, null, -1, 1, null, selectedDisabledSubjectTypeID);
            });
            $("#addLocationToJPModelModalBtn").unbind().on("click", function(){
                var inherit_from;
                var priority = document.getElementById("priority").value;
                var local = document.getElementById("local").value;
                var global = document.getElementById("global").value;

                if(global == 1){
                    inherit_from = document.getElementById("inheritFromSubjects").value;
                }else{
                    inherit_from = null;
                }

                enableJpModelForSubject(selectedDisabledSubjectID, selected_model_id, inherit_from, priority, local, global, null, selectedDisabledSubjectTypeID);
            });
            $("#disableSubjectForModelBtn").on("click", function(){
                if(selectedEnabledSubjectID){

                    document.getElementById("removeSubjectModalMessage").innerHTML = "JP Model Name: " + selected_model_name + "<br>" + "Subject: " + selectedEnabledSubjectName + "<br><br>" +
                        "Are you sure ?";

                    $("#removeSubjectFromJPModelModal").modal({
                        //backdrop:'static',
                        keyboard:false,
                        show:true
                    });

                    $("#disableSubjectFromJPModelBtn").unbind().on("click", function(){
                        disableJpModelForSubject(selectedEnabledSubjectID);
                    });

                }else{
                    document.getElementById("infoModalMessage").innerHTML = "No enabled subject is selected.";

                    $("#infoModal").modal({
                        //backdrop:'static',
                        keyboard:false,
                        show:true
                    });
                }
            });
            $('#editModal').on('hidden.bs.modal', function () {
                disableAllEditFormInputs();
                document.getElementById("editJackpotModelForm").reset();

                @if(session("auth.subject_type_id") == config("constants.ADMINISTRATOR_SYSTEM_ID") || session("auth.subject_type_id") == config("constants.MASTER_TYPE_ID"))
                document.getElementById("editJPBtn").style.display = "inline";
                @else
                document.getElementById("editJPBtn").style.display = "none";
                @endif

                document.getElementById("cancelEditJPBtn").style.display = "none";
                document.getElementById("saveJPBtn").style.display = "none";
                $("#closeEditJPModalBtn").show();

                $("#alertSuccessEditModel").empty();
                $('#alertSuccessEditModel').hide();
                $("#alertFailEditModel").empty();
                $('#alertFailEditModel').hide();
                $("#alertWarningEditModel").hide();
            });

            $('#addLocationToJPModelModal').on('hidden.bs.modal', function () {
                document.getElementById("addLocationToJPModelModalForm").reset();
                document.getElementById("alertFailLocationModal").style.display = "none";
                document.getElementById("alertSuccessLocationModal").style.display = "none";

                $("#inheritFromSubjectsContainer").show();
            });

            $("#showNewJPModelForm").on("click", function(){
                document.getElementById("newJpModelBox").style.display = "inline";
                document.getElementById("showNewJPModelForm").style.display = "none";
            });
            $("#cancelNewJPBtn").on("click", function(){
                $("#alertSuccessCreateModel").empty();
                $('#alertSuccessCreateModel').hide();
                $("#alertFailCreateModel").empty();
                $('#alertFailCreateModel').hide();

                document.getElementById("newJackpotModelForm").reset();

                document.getElementById("newJpModelBox").style.display = "none";
                document.getElementById("showNewJPModelForm").style.display = "inline";
            })

            $("#global").on("change", function(){
                var global = $(this).val();
                if(global == 1){
                    $("#inheritFromSubjectsContainer").show();
                }else{
                    $("#inheritFromSubjectsContainer").hide();
                }
            });

            //FUNCTIONS ------------------------------------------------------------------------------------------------

            function generateSubjectTables(model_id){
                if(tableDisabledSubjects){
                    tableDisabledSubjects.destroy();
                }
                if(tableEnabledSubjects){
                    tableEnabledSubjects.destroy();
                }
                tableDisabledSubjects = $('#disabledSubjectsList').DataTable( {
                    "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                    initComplete: function (settings, json) {
                        $("#disabledSubjectsList_length").addClass("pull-right");
                        $("#disabledSubjectsList_filter").addClass("pull-left");
                    },
                    "order": [],
                    //scrollY: '50vh',
                    scrollX: true,
                    numbers_length: 3,
                    select: true,
                    searching: true,
                    colReorder: true,
                    stateSave: false,
                    "deferRender": true,
                    "processing": true,
                    "serverSide": false,
                    ajax: {
                        method: "GET",
                        url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getDisabledSubjectsForJPModel") }}",
                        data:{
                            model_id: model_id
                        },
                        "dataSrc": "result"
                    },
                    "paging": true,
                    pagingType: 'full_numbers',
                    "iDisplayLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    columns:[
                        {
                            data: "subject_name_to",
                            width: 100,
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: "subject_type_name_to",
                            width: 100,
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: "subject_path",
                            width: 100,
                            bSearchable: true,
                            sortable: true
                        }
                    ],
                    "language": {
                        "zeroRecords": "<?php echo __("No records available."); ?>",
                        "info": "<?php echo __("Showing _START_ to _END_ of _MAX_ entries."); ?>",
                        "lengthMenu": "<?php echo __("Showing _MENU_ entries"); ?>",
                        "search": "<?php echo __("Search"); ?>",
                        "infoEmpty": "<?php echo __("No records available."); ?>",
                        "infoFiltered": "<?php echo __("filtered from _MAX_ total records"); ?>",
                        "paginate": {
                            "first": "<?php echo __("First") ?>",
                            "last": "<?php echo __("Last") ?>",
                            "previous": "<?php echo __("Previous") ?>",
                            "next": "<?php echo __("Next") ?>"
                        }
                    }
                } );

                tableEnabledSubjects = $('#enabledSubjectsList').DataTable( {
                    "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                    initComplete: function (settings, json) {
                        $("#enabledSubjectsList_length").addClass("pull-right");
                        $("#enabledSubjectsList_filter").addClass("pull-left");
                    },
                    "order": [],
                    "scrollX": true,
                    //scrollY: '50vh',
                    numbers_length: 3,
                    select: true,
                    colReorder: true,
                    stateSave: false,
                    "deferRender": true,
                    "processing": true,
                    "serverSide": false,
                    ajax: {
                        method: "GET",
                        url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getEnabledSubjectsForJPModel") }}",
                        data:{
                            model_id: model_id
                        },
                        "dataSrc": "result"
                    },
                    "paging": true,
                    pagingType: 'full_numbers',
                    "iDisplayLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    //"dom": '<"clear"><"top"l>rt<"bottom"ip><"clear">',
                    columns:[
                        {
                            data: "subject_name_to",
                            bSearchable: true,
                            sortable: true,
                            width: 50,
                        },
                        {
                            data: "subject_type_name_to",
                            bSearchable: true,
                            sortable: true,
                            width: 50,
                        },
                        {
                            data: "priority_text",
                            className: "text-left",
                            bSearchable: true,
                            sortable: true,
                            width: 50,
                        },
                        {
                            data: function(row, type, val, meta){
                                var local_level_text = row.local_level_on_off_text;
                                var global_level_text = row.global_level_on_off_text;

                                var text = global_level_text + " , " + local_level_text;

                                return '<label>' + text +  '</label>';
                            },
                            bSearchable: true,
                            sortable: true,
                            width: 100,
                        },
                        {
                            data: "pot",
                            className: "text-left",
                            bSearchable: true,
                            sortable: true,
                            width: 50,
                        },
                        {
                            data: function(row, type, val, meta){
                                var subject_id = row.subject_id_to;
                                var subject_type_id = row.subject_type_id_to;

                                if(subject_type_id == "{{config('constants.LOCATION_TYPE_ID')}}"){
                                    return '<button class="btn btn-primary" onclick="showJPLevelDetails(' + subject_id + ',' + subject_type_id + ')"><span class="fa fa-info-circle"></span></button>';
                                }else {
                                    return '<button class="btn btn-primary" onclick="showJPLevelDetailsClient(' + subject_id + ',' + subject_type_id + ')"><span class="fa fa-info-circle"></span></button>';
                                }


                            },
                            className: "text-center",
                            bSearchable: false,
                            sortable: false,
                            width: 50,
                        },
                    ],
                    "language": {
                        "zeroRecords": "<?php echo __("No records available."); ?>",
                        "info": "<?php echo __("Showing _START_ to _END_ of _MAX_ entries."); ?>",
                        "lengthMenu": "<?php echo __("Showing _MENU_ entries"); ?>",
                        "search": "<?php echo __("Search"); ?>",
                        "infoEmpty": "<?php echo __("No records available."); ?>",
                        "infoFiltered": "<?php echo __("filtered from _MAX_ total records"); ?>",
                        "paginate": {
                            "first": "<?php echo __("First") ?>",
                            "last": "<?php echo __("Last") ?>",
                            "previous": "<?php echo __("Previous") ?>",
                            "next": "<?php echo __("Next") ?>"
                        }
                    }
                } );
            }

            window.showJPLevelDetailsClient = function(subject_id, subject_type_id){
                getAffJPModelSettings(subject_id);

                $("#editJPLevelClientModal").modal({
                    //backdrop:'static',
                    keyboard:false,
                    show:true
                });

                $("#jpClientDetailsEditBtn").unbind().on("click", function(){
                    $(this).hide();
                    $("#jpClientDetailsCloseBtn").hide();
                    $("#jpClientDetailsSaveBtn").show();
                    $("#jpClientDetailsCancelBtn").show();

                    $( "#client_actual_global_pot_value_level" ).prop( "disabled", false );
                });
                $("#jpClientDetailsCancelBtn").unbind().on("click", function(){
                    $("#jpClientDetailsEditBtn").show();
                    $("#jpClientDetailsCloseBtn").show();
                    $("#jpClientDetailsSaveBtn").hide();
                    $("#jpClientDetailsCancelBtn").hide();

                    $("#editJPLevelClientModalForm input").prop("disabled", true);
                    $("#editJPLevelClientModalForm select").prop("disabled", true);

                    $("#editJPLevelClientModalForm")[0].reset();
                    getAffJPModelSettings(subject_id);
                });
                $('#editJPLevelClientModal').on('hidden.bs.modal', function () {
                    $("#editJPLevelClientModalForm input").prop("disabled", true);
                    $("#editJPLevelClientModalForm select").prop("disabled", true);

                    $("#jpClientDetailsEditBtn").show();
                    $("#jpClientDetailsCloseBtn").show();
                    $("#jpClientDetailsSaveBtn").hide();
                    $("#jpClientDetailsCancelBtn").hide();

                });

                $("#jpClientDetailsSaveBtn").unbind().on("click", function(){
                    var current_amount = $("#client_actual_global_pot_value_level").val();

                    saveJPModelDetailsClient(subject_id, jp_details_jp_model_id, jp_details_priority, jp_details_local_level_on_off,
                        jp_details_global_level_on_off, current_amount, subject_id);
                });
            };

            window.showJPLevelDetails = function(subject_id, subject_type_id){
                getAffJPModelSettings(subject_id);

                $("#editJPLevelLocationModal").modal({
                    //backdrop:'static',
                    keyboard:false,
                    show:true
                });

                $("#jpDetailsEditBtn").unbind().on("click", function(){
                    $(this).hide();
                    $("#jpDetailsCloseBtn").hide();
                    $("#jpDetailsSaveBtn").show();
                    $("#jpDetailsCancelBtn").show();

                    $( "#location_inherit_from_level" ).prop( "disabled", false );
                    $( "#location_priority_level" ).prop( "disabled", false );

                    if(dropDownSubjectsCounter == 0){
                        $( "#location_global_level" ).prop( "disabled", true );
                    }else{
                        $( "#location_global_level" ).prop( "disabled", false );
                    }
                    $( "#location_local_level" ).prop( "disabled", false );
                    $( "#location_actual_local_pot_value_level" ).prop( "disabled", false );
                });
                $("#jpDetailsCancelBtn").unbind().on("click", function(){
                    $("#jpDetailsEditBtn").show();
                    $("#jpDetailsCloseBtn").show();
                    $("#jpDetailsSaveBtn").hide();
                    $("#jpDetailsCancelBtn").hide();

                    $("#editJPLevelLocationModalForm input").prop("disabled", true);
                    $("#editJPLevelLocationModalForm select").prop("disabled", true);

                    $("#editJPLevelLocationModalForm")[0].reset();
                    getAffJPModelSettings(subject_id);
                });
                $('#editJPLevelLocationModal').on('hidden.bs.modal', function () {
                    $("#editJPLevelLocationModalForm input").prop("disabled", true);
                    $("#editJPLevelLocationModalForm select").prop("disabled", true);

                    $("#alertFailLocationEditJPModel").hide();
                    $("#alertSuccessLocationEditJPModel").hide();

                    $("#jpDetailsEditBtn").show();
                    $("#jpDetailsCloseBtn").show();
                    $("#jpDetailsSaveBtn").hide();
                    $("#jpDetailsCancelBtn").hide();

                });

                $("#jpDetailsSaveBtn").unbind().on("click", function(){
                    var inherit_from = $("#location_inherit_from_level").val();
                    var priority = $("#location_priority_level").val();
                    var global_on_off = $("#location_global_level").val();
                    var local_on_off = $("#location_local_level").val();
                    var current_amount = $("#location_actual_local_pot_value_level").val();

                    saveJPModelDetailsLocation(subject_id, jp_details_jp_model_id, priority, local_on_off,
                        global_on_off, current_amount, inherit_from);
                });

                $("#location_global_level").on("change", function(){
                    var global = $(this).val();
                    if(global == 1){
                        $("#location_inherit_from_level_container").show();
                    }else{
                        $("#location_inherit_from_level_container").hide();
                    }
                });
            };

            function getAffJPModelSettings(subject_id){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getAffJPModelSettings") }}",
                    dataType: "json",
                    data: {
                        subject_id: subject_id
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        jp_details_jp_model = data.result[0].jp_model;
                        jp_details_jp_model_id = data.result[0].jp_model_id;
                        jp_details_entity_name = data.result[0].entity_name;

                        jp_details_priority = data.result[0].priority;
                        jp_details_global_level_on_off = data.result[0].global_level_on_off;
                        jp_details_local_level_on_off = data.result[0].local_level_on_off;

                        jp_details_global_level_value = data.result[0].global_current_level;
                        jp_details_local_level_value = data.result[0].local_current_level;
                        jp_details_currency  = data.result[0].currency;

                        listInheritFromSubjects(subject_id, selected_model_id);

                        jp_details_inherit_from = data.result[0].global_jp_inherited_from_id;
                    },
                    complete: function(data){
                        $("#location_model_name_level").val(jp_details_jp_model);
                        $("#client_model_name_level").val(jp_details_jp_model);

                        $("#location_entity_name_level").val(jp_details_entity_name);
                        $("#client_entity_name_level").val(jp_details_entity_name);

                        $("#location_priority_level").val(jp_details_priority);
                        $("#location_global_level").val(jp_details_global_level_on_off);
                        $("#client_global_level").val(jp_details_global_level_on_off);

                        if(jp_details_global_level_on_off == 1){
                            $("#location_inherit_from_level_container").show();
                        }else{
                            $("#location_inherit_from_level_container").hide();
                        }

                        $("#location_local_level").val(jp_details_local_level_on_off);

                        $("#location_actual_global_pot_value_level").val(jp_details_global_level_value);
                        $("#client_actual_global_pot_value_level").val(jp_details_global_level_value);

                        $("#location_actual_local_pot_value_level").val(jp_details_local_level_value);
                        $("#location_currency_level").val(jp_details_currency);
                        $("#client_currency_level").val(jp_details_currency);

                        $("#location_inherit_from_level").val(jp_details_inherit_from);
                    },
                    error: function(data){

                    }
                });
            }

            window.showDeleteModal = function (model_id, model_name){
                document.getElementById("modelNameDelete").innerHTML = model_name;

                $("#deleteModal").modal({
                    //backdrop:'static',
                    keyboard:false,
                    show:true
                });
                $("#deleteModalBtn").unbind().on("click", function(){
                    deleteJPModel(model_id);
                });
            };

            window.showEditForm = function (model_id, model_name){
                getJpModelDetails(model_id);

                $("#editModal").modal({
                    //backdrop:'static',
                    keyboard:false,
                    show:true
                });

                $("#deleteJPBtn").unbind().on("click", function(){
                    showDeleteModal(model_id, model_name);
                });

                $("#saveJPBtn").unbind().on("click", function(){
                    var model_name = document.getElementById("nameEdit").value;
                    var currency = document.getElementById("currencyEdit").value;
                    var minNoOfTickets = document.getElementById("minNoOfTicketsEdit").value;
                    var fromHours = document.getElementById("fromHoursEdit").value;
                    var toHours = document.getElementById("toHoursEdit").value;

                    var winPriceGlobal = document.getElementById("winPriceGlobalEdit").value;
                    var winPriceLocal = document.getElementById("winPriceLocalEdit").value;
                    var winProbabilityGlobal = document.getElementById("winProbabilityGlobalEdit").value;
                    var winProbabilityLocal = document.getElementById("winProbabilityLocalEdit").value;
                    var winBeforeGlobal = document.getElementById("winBeforeGlobalEdit").value;
                    var winBeforeLocal = document.getElementById("winBeforeLocalEdit").value;
                    var minBetToWinGlobal = document.getElementById("minBetToWinGlobalEdit").value;
                    var minBetToWinLocal = document.getElementById("minBetToWinLocalEdit").value;
                    var wholePot = document.getElementById("winWholePotEdit").value;

                    var fromBetToJPGlobal = document.getElementById("fromBetToJPGlobalEdit").value;
                    var fromBetToJPLocal = document.getElementById("fromBetToJPLocalEdit").value;
                    var jpStartValueGlobal = document.getElementById("jpStartValueGlobalEdit").value;
                    var jpStartValueLocal = document.getElementById("jpStartValueLocalEdit").value;

                    var local_on_off = document.getElementById("localJPOnOffEdit").value;
                    var global_on_off = document.getElementById("globalJPOnOffEdit").value;

                    updateJPModel(model_id, model_name, currency, minNoOfTickets, fromHours, toHours, winPriceLocal, winPriceGlobal, winProbabilityLocal, winProbabilityGlobal,
                        winBeforeLocal, winBeforeGlobal, minBetToWinLocal, minBetToWinGlobal, wholePot, fromBetToJPLocal, fromBetToJPGlobal, jpStartValueLocal, jpStartValueGlobal, local_on_off, global_on_off);
                });
            };

            function deleteJPModel(model_id){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "deleteJPModel") }}",
                    dataType: "json",
                    data: {
                        model_id: model_id
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            table.ajax.reload();
                            $("#selectedModelSubjectsListBox").hide();
                        }else{
                            table.ajax.reload();
                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function listCurrencies(){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listCurrencies") }}",
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var currencyDropdown = document.getElementById("currency");
                            var currencyEditDropdown = document.getElementById("currencyEdit");
                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');
                                var element2 = document.createElement('option');

                                element.value = value.currency;
                                element.textContent = value.currency;
                                element2.value = value.currency;
                                element2.textContent = value.currency;

                                currencyDropdown.appendChild(element);
                                currencyEditDropdown.appendChild(element2);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function listInheritFromSubjects(subject_id, model_id){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listSubjectsForGlobalJP") }}",
                    dataType: "json",
                    data: {
                        subject_id: subject_id,
                        model_id: model_id
                    },
                    "dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var subjectDropdown = document.getElementById("inheritFromSubjects");
                            var subjectDropdown2 = document.getElementById("location_inherit_from_level");
                            $("#inheritFromSubjects").empty();
                            $("#location_inherit_from_level").empty();

                            dropDownSubjectsCounter = 0;

                            $.each(data.result, function(index, value){
                               var element = document.createElement('option');
                                var element2 = document.createElement('option');

                                element.value = value.subject_id;
                                element.textContent = value.username;
                                element2.value = value.subject_id;
                                element2.textContent = value.username;

                                subjectDropdown.appendChild(element);
                                subjectDropdown2.appendChild(element2);

                                dropDownSubjectsCounter++;
                            });

                            if(dropDownSubjectsCounter == 0){
                                $("#global").prop("disabled", true);
                                $("#inheritFromSubjectsContainer").hide();
                                $("#global").val(-1);

                                $("#location_global_level").prop("disabled", true);
                                $("#location_inherit_from_level_container").hide();
                                $("#location_global_level").val(-1);

                                $("#alertInfoLocationModal").show();
                                $("#alertInfoLocationEditJPModal").show();
                            }else{
                                $("#global").prop("disabled", false);
                                $("#inheritFromSubjectsContainer").show();

                                $("#location_global_level").prop("disabled", true);
                                $("#location_inherit_from_level_container").show();

                                $("#alertInfoLocationModal").hide();
                                $("#alertInfoLocationEditJPModal").hide();
                            }

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            $("#addNewJPBtn").on("click", function(){
                var model_name = document.getElementById("name").value;
                var currency = document.getElementById("currency").value;
                var minNoOfTickets = document.getElementById("minNoOfTickets").value;
                var fromHours = document.getElementById("fromHours").value;
                var toHours = document.getElementById("toHours").value;

                var winPriceGlobal = document.getElementById("winPriceGlobal").value;
                var winPriceLocal = document.getElementById("winPriceLocal").value;
                var winProbabilityGlobal = document.getElementById("winProbabilityGlobal").value;
                var winProbabilityLocal = document.getElementById("winProbabilityLocal").value;
                var winBeforeGlobal = document.getElementById("winBeforeGlobal").value;
                var winBeforeLocal = document.getElementById("winBeforeLocal").value;
                var minBetToWinGlobal = document.getElementById("minBetToWinGlobal").value;
                var minBetToWinLocal = document.getElementById("minBetToWinLocal").value;
                var wholePot = document.getElementById("winWholePot").value;
                var fromBetToJPGlobal = document.getElementById("fromBetToJPGlobal").value;
                var fromBetToJPLocal = document.getElementById("fromBetToJPLocal").value;
                var jpStartValueGlobal = document.getElementById("jpStartValueGlobal").value;
                var jpStartValueLocal = document.getElementById("jpStartValueLocal").value;
                var global_on_off = $("#globalJPOnOff").val();
                var local_on_off = $("#localJPOnOff").val();

                createNewJPModel(model_name, currency, minNoOfTickets, fromHours, toHours, winPriceLocal, winPriceGlobal, winProbabilityLocal, winProbabilityGlobal,
                winBeforeLocal, winBeforeGlobal, minBetToWinLocal, minBetToWinGlobal, wholePot, fromBetToJPLocal, fromBetToJPGlobal, jpStartValueLocal, jpStartValueGlobal, global_on_off, local_on_off);
            });

            function saveJPModelDetailsClient(subject_id, model_id, priority, local_level_on_off, global_level_on_off, current_amount, inherited_from){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "updateJPModelDetailsForAffiliate") }}",
                    dataType: "json",
                    data: {
                        subject_id: subject_id,
                        model_id: model_id,
                        priority: priority,
                        local_level_on_off: local_level_on_off,
                        global_level_on_off: global_level_on_off,
                        current_amount: current_amount,
                        inherited_from: inherited_from
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            $("#alertSuccessClientEditJPModel").empty();
                            $('#alertSuccessClientEditJPModel').show();
                            $("#alertFailClientEditJPModel").empty();
                            $('#alertFailClientEditJPModel').hide();

                            document.getElementById("jpClientDetailsEditBtn").style.display = "inline";
                            document.getElementById("jpClientDetailsCloseBtn").style.display = "inline";
                            document.getElementById("jpClientDetailsCancelBtn").style.display = "none";
                            document.getElementById("jpClientDetailsSaveBtn").style.display = "none";
                            $("#editJPLevelClientModalForm input").prop("disabled", true);
                            $("#editJPLevelClientModalForm select").prop("disabled", true);

                            jQuery('#alertSuccessClientEditJPModel').append('<p>'+data.message+'</p>');
                            $("html, body").animate({ scrollTop: 0 }, "fast");

                            getAffJPModelSettings(subject_id);
                        }else{
                            $("#alertSuccessClientEditJPModel").empty();
                            $('#alertSuccessClientEditJPModel').hide();
                            $("#alertFailClientEditJPModel").empty();
                            $('#alertFailClientEditJPModel').show();

                            document.getElementById("jpClientDetailsEditBtn").style.display = "inline";
                            document.getElementById("jpClientDetailsCloseBtn").style.display = "inline";
                            document.getElementById("jpClientDetailsCancelBtn").style.display = "none";
                            document.getElementById("jpClientDetailsSaveBtn").style.display = "none";
                            $("#editJPLevelClientModalForm input").prop("disabled", true);
                            $("#editJPLevelClientModalForm select").prop("disabled", true);

                            if(data.success){
                                jQuery('#alertFailClientEditJPModel').append('<p>'+data.message+'</p>');
                                $("html, body").animate({ scrollTop: 0 }, "fast");
                            }else{
                                jQuery.each(data.errors, function(key, value){
                                    jQuery('#alertFailClientEditJPModel').append('<p>'+value+'</p>');
                                    $("html, body").animate({ scrollTop: 0 }, "fast");
                                })
                            }
                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function saveJPModelDetailsLocation(subject_id, model_id, priority, local_level_on_off, global_level_on_off, current_amount, inherited_from){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "updateJPModelDetailsForAffiliate") }}",
                    dataType: "json",
                    data: {
                        subject_id: subject_id,
                        model_id: model_id,
                        priority: priority,
                        local_level_on_off: local_level_on_off,
                        global_level_on_off: global_level_on_off,
                        current_amount: current_amount,
                        inherited_from: inherited_from
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            $("#alertSuccessLocationEditJPModel").empty();
                            $('#alertSuccessLocationEditJPModel').show();
                            $("#alertFailLocationEditJPModel").empty();
                            $('#alertFailLocationEditJPModel').hide();

                            document.getElementById("jpDetailsEditBtn").style.display = "inline";
                            document.getElementById("jpDetailsCloseBtn").style.display = "inline";
                            document.getElementById("jpDetailsCancelBtn").style.display = "none";
                            document.getElementById("jpDetailsSaveBtn").style.display = "none";
                            $("#editJPLevelLocationModalForm input").prop("disabled", true);
                            $("#editJPLevelLocationModalForm select").prop("disabled", true);

                            jQuery('#alertSuccessLocationEditJPModel').append('<p>'+data.message+'</p>');
                            $("html, body").animate({ scrollTop: $("#alertSuccessLocationEditJPModel").offset().top }, "fast");

                            getAffJPModelSettings(subject_id);
                        }else{
                            $("#alertSuccessLocationEditJPModel").empty();
                            $('#alertSuccessLocationEditJPModel').hide();
                            $("#alertFailLocationEditJPModel").empty();
                            $('#alertFailLocationEditJPModel').show();

                            document.getElementById("jpDetailsEditBtn").style.display = "inline";
                            document.getElementById("jpDetailsCloseBtn").style.display = "inline";
                            document.getElementById("jpDetailsCancelBtn").style.display = "none";
                            document.getElementById("jpDetailsSaveBtn").style.display = "none";
                            $("#editJPLevelLocationModalForm input").prop("disabled", true);
                            $("#editJPLevelLocationModalForm select").prop("disabled", true);

                            getAffJPModelSettings(subject_id);

                            if(data.success){
                                jQuery('#alertFailLocationEditJPModel').append('<p>'+data.message+'</p>');
                                $("html, body").animate({ scrollTop: $("#alertFailLocationEditJPModel").offset().top }, "fast");
                            }else{
                                jQuery.each(data.errors, function(key, value){
                                    jQuery('#alertFailLocationEditJPModel').append('<p>'+value+'</p>');
                                    $("html, body").animate({ scrollTop: $("#alertFailLocationEditJPModel").offset().top }, "fast");
                                })
                            }
                        }
                    },
                    complete: function(data){
                        $("#enabledSubjectsList").DataTable().ajax.reload();
                    },
                    error: function(data){

                    }
                });
            }


            function updateJPModel(model_id, model_name, currency, minNoTickets, fromHours, toHours, winPriceLocal, winPriceGlobal, winProbabilityLocal,
                                      winProbabilityGlobal, winBeforeLocal, winBeforeGlobal, minBetLocal, minBetGlobal, wholePot, fromBetToJpLocal, fromBetToJpGlobal,
                                      startValueLocal, startValueGlobal, local_on_off, global_on_off){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "updateJPModel") }}",
                    dataType: "json",
                    data: {
                        model_id: model_id,
                        model_name: model_name,
                        currency: currency,
                        minNoTickets: minNoTickets,
                        fromHours: fromHours,
                        toHours: toHours,
                        winPriceLocal: winPriceLocal,
                        winPriceGlobal: winPriceGlobal,
                        winProbabilityLocal: winProbabilityLocal,
                        winProbabilityGlobal: winProbabilityGlobal,
                        winBeforeLocal: winBeforeLocal,
                        winBeforeGlobal: winBeforeGlobal,
                        minBetLocal: minBetLocal,
                        minBetGlobal: minBetGlobal,
                        wholePot: wholePot,
                        fromBetToJpLocal: fromBetToJpLocal,
                        fromBetToJpGlobal: fromBetToJpGlobal,
                        startValueLocal: startValueLocal,
                        startValueGlobal: startValueGlobal,
                        local_on_off: local_on_off,
                        global_on_off: global_on_off
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            $("#alertSuccessEditModel").empty();
                            $('#alertSuccessEditModel').show();
                            $("#alertFailEditModel").empty();
                            $('#alertFailEditModel').hide();
                            $('#alertWarningEditModel').hide();

                            document.getElementById("editJPBtn").style.display = "inline";
                            document.getElementById("closeEditJPModalBtn").style.display = "inline";
                            document.getElementById("cancelEditJPBtn").style.display = "none";
                            document.getElementById("saveJPBtn").style.display = "none";
                            disableAllEditFormInputs();

                            jQuery('#alertSuccessEditModel').append('<p>'+data.message+'</p>');
                            $("html, body").animate({ scrollTop: 0 }, "fast");

                            table.ajax.reload();
                        }else{
                            $("#alertSuccessEditModel").empty();
                            $('#alertSuccessEditModel').hide();
                            $("#alertFailEditModel").empty();
                            $('#alertFailEditModel').show();
                            $('#alertWarningEditModel').hide();

                            document.getElementById("editJPBtn").style.display = "inline";
                            document.getElementById("closeEditJPModalBtn").style.display = "inline";
                            document.getElementById("cancelEditJPBtn").style.display = "none";
                            document.getElementById("saveJPBtn").style.display = "none";
                            disableAllEditFormInputs();

                            table.ajax.reload();

                            if(data.success){
                                jQuery('#alertFailEditModel').append('<p>'+data.message+'</p>');
                                $("html, body").animate({ scrollTop: 0 }, "fast");
                            }else{
                                jQuery.each(data.errors, function(key, value){
                                    jQuery('#alertFailEditModel').append('<p>'+value+'</p>');
                                    $("html, body").animate({ scrollTop: 0 }, "fast");
                                })
                            }
                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function createNewJPModel(model_name, currency, minNoTickets, fromHours, toHours, winPriceLocal, winPriceGlobal, winProbabilityLocal,
            winProbabilityGlobal, winBeforeLocal, winBeforeGlobal, minBetLocal, minBetGlobal, wholePot, fromBetToJpLocal, fromBetToJpGlobal,
            startValueLocal, startValueGlobal, global_on_off, local_on_off){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "createNewJPModel") }}",
                    dataType: "json",
                    data: {
                        model_name: model_name,
                        currency: currency,
                        minNoTickets: minNoTickets,
                        fromHours: fromHours,
                        toHours: toHours,
                        winPriceLocal: winPriceLocal,
                        winPriceGlobal: winPriceGlobal,
                        winProbabilityLocal: winProbabilityLocal,
                        winProbabilityGlobal: winProbabilityGlobal,
                        winBeforeLocal: winBeforeLocal,
                        winBeforeGlobal: winBeforeGlobal,
                        minBetLocal: minBetLocal,
                        minBetGlobal: minBetGlobal,
                        wholePot: wholePot,
                        fromBetToJpLocal: fromBetToJpLocal,
                        fromBetToJpGlobal: fromBetToJpGlobal,
                        startValueLocal: startValueLocal,
                        startValueGlobal: startValueGlobal,
                        global_on_off: global_on_off,
                        local_on_off: local_on_off
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            $("#alertSuccessCreateModel").empty();
                            $('#alertSuccessCreateModel').show();
                            $("#alertFailCreateModel").empty();
                            $('#alertFailCreateModel').hide();

                            jQuery('#alertSuccessCreateModel').append('<p>'+data.message+'</p>');
                            $("html, body").animate({ scrollTop: 0 }, "fast");

                            table.ajax.reload();
                        }else{
                            $("#alertSuccessCreateModel").empty();
                            $('#alertSuccessCreateModel').hide();
                            $("#alertFailCreateModel").empty();
                            $('#alertFailCreateModel').show();

                            table.ajax.reload();

                            if(data.success){
                                jQuery('#alertFailCreateModel').append('<p>'+data.message+'</p>');
                                $("html, body").animate({ scrollTop: 0 }, "fast");
                            }else{
                                jQuery.each(data.errors, function(key, value){
                                    jQuery('#alertFailCreateModel').append('<p>'+value+'</p>');
                                    $("html, body").animate({ scrollTop: 0 }, "fast");
                                })
                            }
                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function getJpModelDetails(model_id){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getJPModelDetails") }}",
                    dataType: "json",
                    data: {
                        model_id: model_id
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            document.getElementById("nameEdit").value = data.result[0].model_name;
                            document.getElementById("currencyEdit").value = data.result[0].currency;
                            document.getElementById("minNoOfTicketsEdit").value = data.result[0].min_tickets_to_win;
                            document.getElementById("fromHoursEdit").value = data.result[0].time_active_from;
                            document.getElementById("toHoursEdit").value = data.result[0].time_active_to;
                            document.getElementById("winPriceGlobalEdit").value = data.result[0].global_win_price;
                            document.getElementById("winPriceLocalEdit").value = data.result[0].local_win_price;
                            document.getElementById("winProbabilityGlobalEdit").value = data.result[0].global_win_probability;
                            document.getElementById("winProbabilityLocalEdit").value = data.result[0].local_win_probability;
                            document.getElementById("winBeforeGlobalEdit").value = data.result[0].global_forced_win_before;
                            document.getElementById("winBeforeLocalEdit").value = data.result[0].local_forced_win_before;
                            document.getElementById("minBetToWinGlobalEdit").value = data.result[0].global_min_bet;
                            document.getElementById("minBetToWinLocalEdit").value = data.result[0].local_min_bet;
                            document.getElementById("winWholePotEdit").value = data.result[0].win_whole_pot;
                            document.getElementById("fromBetToJPGlobalEdit").value = data.result[0].global_level_percent_from_bet;
                            document.getElementById("fromBetToJPLocalEdit").value = data.result[0].local_level_percent_from_bet;
                            document.getElementById("jpStartValueGlobalEdit").value = data.result[0].global_pot_start_value;
                            document.getElementById("jpStartValueLocalEdit").value = data.result[0].local_pot_start_value;
                            document.getElementById("localJPOnOffEdit").value = data.result[0].local_level_type;
                            document.getElementById("globalJPOnOffEdit").value = data.result[0].global_level_type;
                        }else{

                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function disableAllEditFormInputs(){
                $("#editJackpotModelForm input").prop("disabled", true);
                $("#editJackpotModelForm select").prop("disabled", true);
            }
            function enableAllEditFormInputs(){
                $("#editJackpotModelForm input").prop("disabled", false);
                $("#editJackpotModelForm select").prop("disabled", false);
            }

            function disableJpModelForSubject(subject_id){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "deleteJpModelForSubject") }}",
                    dataType: "json",
                    data: {
                        subject_id: subject_id
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        selectedDisabledSubjectID = null;
                        selectedDisabledSubjectName = null;
                        selectedDisabledSubjectTypeID = null;
                        selectedDisabledSubjectTypeName = null;
                        selectedEnabledSubjectID = null;
                        selectedEnabledSubjectName = null;
                        selectedEnabledSubjectTypeID = null;
                        selectedEnabledSubjectTypeName = null;

                        if(data.status == "OK"){
                            tableEnabledSubjects.ajax.reload();
                            tableDisabledSubjects.ajax.reload();
                        }else{
                            tableEnabledSubjects.ajax.reload();
                            tableDisabledSubjects.ajax.reload();
                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function enableJpModelForSubject(subject_id, model_id, inherited_from, priority, local_level_on_off, global_level_on_off, payout_percent, subject_type_id){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "addJpModelForSubject") }}",
                    dataType: "json",
                    data: {
                        subject_id: subject_id,
                        model_id: model_id,
                        inherited_from: inherited_from,
                        priority: priority,
                        local_level_on_off: local_level_on_off,
                        global_level_on_off: global_level_on_off,
                        payout_percent: payout_percent,
                        subject_type_id: subject_type_id
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            selectedDisabledSubjectID = null;
                            selectedDisabledSubjectName = null;
                            selectedDisabledSubjectTypeID = null;
                            selectedDisabledSubjectTypeName = null;
                            selectedEnabledSubjectID = null;
                            selectedEnabledSubjectName = null;
                            selectedEnabledSubjectTypeID = null;
                            selectedEnabledSubjectTypeName = null;

                            $('#addSubjectOtherThanLocationToJPModelModal').modal('hide');
                            $('#addLocationToJPModelModal').modal('hide');
                            tableEnabledSubjects.ajax.reload();
                            tableDisabledSubjects.ajax.reload();
                        }else{
                            if(subject_type_id == location_type_id){
                                $("#alertSuccessLocationModal").empty();
                                $('#alertSuccessLocationModal').hide();
                                $("#alertFailLocationModal").empty();
                                $('#alertFailLocationModal').show();

                                if(data.success){
                                    jQuery('#alertFailLocationModal').append('<p>'+data.message+'</p>');
                                }else{
                                    jQuery.each(data.errors, function(key, value){
                                        jQuery('#alertFailLocationModal').append('<p>'+value+'</p>');
                                    })
                                }
                                /*tableEnabledSubjects.ajax.reload();
                                tableDisabledSubjects.ajax.reload();*/
                            }else{
                                $('#addSubjectOtherThanLocationToJPModelModal').modal('hide');
                                /*tableEnabledSubjects.ajax.reload();
                                tableDisabledSubjects.ajax.reload();*/
                            }
                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }



            disableAllEditFormInputs();
            listCurrencies();
        });
    </script>
@endsection
