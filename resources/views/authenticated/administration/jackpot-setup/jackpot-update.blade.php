
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
    </style>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-money">&nbsp;</i>
                {{ __("JackPot Update") }}
                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("Administration") }}</li>
                <li class="active">{{ __("JackPot Setup") }}</li>
                <li class="active">{{ __("JackPot Update") }}</li>
            </ol>
        </section>

        <section class="content">
            @include('layouts.shared.form_messages')
            <div class="box animate fadeOut" id="newJpModelBox">
                <div class="box-body">
                    <form id="newJackpotModelForm" class="form-horizontal">
                        <div id="alertFailCreateModel" class="alert alert-danger" style="display:none"></div>
                        <div id="alertSuccessCreateModel" class="alert alert-success" style="display:none"></div>

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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="form-group required">
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
                                                <div class="form-group required">
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
                                                <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.From Bet To JP POT")}}</label>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12" align="center">
                                                <label for="winPrice" class="control-label labelSmall">{{__ ("authenticated.JP Pot Start Value")}}</label>
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

                        <div class="form-actions">
                            <button class="btn btn-success" type="button" name="edit" id="editBtn"><i class="fa fa-edit">&nbsp;</i>{{__ ("authenticated.Edit")}}</button>
                            <button style="display: none;" class="btn btn-primary" type="button" name="save" id="saveBtn"><i class="fa fa-save">&nbsp;</i>{{__ ("authenticated.Save")}}</button>
                            <button style="display: none;" class="btn btn-default" type="button" name="cancel" id="cancelBtn"><i class="fa fa-times">&nbsp;</i>{{__ ("authenticated.Cancel")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function(){
            $("#minNoOfTickets").numeric();
            $("#fromHours").numeric();
            $("#toHours").numeric();

            $("#editBtn").on("click", function(){
                document.getElementById("editBtn").style.display = "none";
                document.getElementById("saveBtn").style.display = "inline";
                document.getElementById("cancelBtn").style.display = "inline";

                enableAllFormInputs();
            });

            $("#cancelBtn").on("click", function(){
                document.getElementById("editBtn").style.display = "inline";
                document.getElementById("saveBtn").style.display = "none";
                document.getElementById("cancelBtn").style.display = "none";

                disableAllFormInputs();
            });

            function disableAllFormInputs(){
                $("#newJackpotModelForm input").prop("disabled", true);
                $("#newJackpotModelForm select").prop("disabled", true);
            }
            function enableAllFormInputs(){
                $("#newJackpotModelForm input").prop("disabled", false);
                $("#newJackpotModelForm select").prop("disabled", false);
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
                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                element.value = value.currency;
                                element.textContent = value.currency;

                                currencyDropdown.appendChild(element);
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

                createNewJPModel(model_name, currency, minNoOfTickets, fromHours, toHours, winPriceLocal, winPriceGlobal, winProbabilityLocal, winProbabilityGlobal,
                    winBeforeLocal, winBeforeGlobal, minBetToWinLocal, minBetToWinGlobal, wholePot, fromBetToJPLocal, fromBetToJPGlobal, jpStartValueLocal, jpStartValueGlobal);
            });

            function createNewJPModel(model_name, currency, minNoTickets, fromHours, toHours, winPriceLocal, winPriceGlobal, winProbabilityLocal,
                                      winProbabilityGlobal, winBeforeLocal, winBeforeGlobal, minBetLocal, minBetGlobal, wholePot, fromBetToJpLocal, fromBetToJpGlobal,
                                      startValueLocal, startValueGlobal){
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
                        startValueGlobal: startValueGlobal
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

            disableAllFormInputs();
            listCurrencies();
        });
    </script>
@endsection
