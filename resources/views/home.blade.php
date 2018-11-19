
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-home"></i>
                {{ __("authenticated.Home") }}
                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-mail-forward"></i> {{ __("authenticated.Login") }}</li>
                <li class="active">{{ __("authenticated.Home") }}</li>
            </ol>
        </section>

        <section class="content">

            <div class="widget box col-md-4">
                <div class="widget-header" style="display: none;">
                    <h4>
                        <i class="fa fa-user"></i>
                        <span>{{ __("authenticated.Home") }}</span>
                    </h4>
                </div>
                <div class="widget-content">
                    <!--{!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'my-account/my-personal-data'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}-->

                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <img src="{{asset('images/lucky6_logo.png')}}" class="img-rounded" alt="Lucky Six Logo" width="304" height="236">
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <hr>

                        <form id="homePageForm" class="form-horizontal row-border">
                            @include('layouts.shared.form_messages')
                            <div class="form-group">
                                <label for="username" class="col-md-3 control-label">{{__('authenticated.Username')}}:</label>
                                <div class="col-md-4">
                                    <input readonly="readonly" class="form-control" placeholder="{{__('authenticated.Username')}}" name="username" type="text" id="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dateTimeHomePage" class="col-md-3 control-label">{{__('authenticated.Datum & Time')}}:</label>
                                <div class="col-md-4">
                                    <input readonly="readonly" class="form-control" placeholder="{{__('authenticated.Datum & Time')}}" name="dateTimeHomePage" type="text" id="dateTimeHomePage">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="actualLocation" class="col-md-3 control-label">{{__('authenticated.Actual Location')}}:</label>
                                <div class="col-md-4">
                                    <input readonly="readonly" class="form-control" placeholder="{{__('authenticated.Actual Location')}}" name="actualLocation" type="text" id="actualLocation">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastLogin" class="col-md-3 control-label">{{__('authenticated.Last Login')}}:</label>
                                <div class="col-md-4">
                                    <input readonly="readonly" class="form-control" placeholder="{{__('authenticated.Last Login')}}" name="lastLogin" type="text" id="lastLogin">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastLocation" class="col-md-3 control-label">{{__('authenticated.Last Location')}}:</label>
                                <div class="col-md-4">
                                    <input readonly="readonly" class="form-control" placeholder="{{__('authenticated.Last Location')}}" name="lastLogin" type="text" id="lastLocation">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastLocation" class="col-md-3 control-label">{{__('authenticated.Selected Period')}}:</label>
                            </div>
                            <div class="form-group">
                                <label for="sessionStartDate" class="col-md-3 control-label">{{__('authenticated.Start Date')}}:</label>
                                <div class="col-md-4">
                                    <input disabled id="sessionStartDate" class="form-control" data-provide="datepicker">
                                </div>
                                <button class="btn btn-success" type="button" id="editSessionStartDate"><i class="fa fa-edit">&nbsp;</i>{{__('authenticated.Edit')}}</button>
                                <button style="display: none;" class="btn btn-primary" type="button" id="saveSessionStartDate"><i class="fa fa-save">&nbsp;</i>{{__('authenticated.Save')}}</button>
                                <button style="display: none;" class="btn btn-danger" type="button" id="cancelSessionStartDate"><i class="fa fa-close">&nbsp;</i>{{__('authenticated.Cancel')}}</button>
                            </div>
                            <div class="form-group">
                                <label for="sessionEndDate" class="col-md-3 control-label">{{__('authenticated.End Date')}}:</label>
                                <div class="col-md-4">
                                    <input disabled id="sessionEndDate" class="form-control" data-provide="datepicker">
                                </div>
                                <button class="btn btn-success" type="button" id="editSessionEndDate"><i class="fa fa-edit">&nbsp;</i>{{__('authenticated.Edit')}}</button>
                                <button style="display: none;" class="btn btn-primary" type="button" id="saveSessionEndDate"><i class="fa fa-save">&nbsp;</i>{{__('authenticated.Save')}}</button>
                                <button style="display: none;" class="btn btn-danger" type="button" id="cancelSessionEndDate"><i class="fa fa-close">&nbsp;</i>{{__('authenticated.Cancel')}}</button>
                            </div>
                            <div class="form-group">
                                <label for="language" class="col-md-3 control-label">{{__('authenticated.Language')}}:</label>
                                <div class="col-md-4">
                                    <select disabled class="form-control"  name="language" id="language">

                                    </select>
                                </div>
                                <button class="btn btn-success" type="button" id="editLanguage"><i class="fa fa-edit">&nbsp;</i>{{__('authenticated.Edit')}}</button>
                                <button style="display: none;" class="btn btn-primary" type="button" id="saveLanguage"><i class="fa fa-save">&nbsp;</i>{{__('authenticated.Save')}}</button>
                                <button style="display: none;" class="btn btn-danger" type="button" id="cancelLanguage"><i class="fa fa-close">&nbsp;</i>{{__('authenticated.Cancel')}}</button>
                            </div>
                        </form>
                </div>
            </div>

        </section>
    </div>
    <script>
        $(document).ready(function(){
            var username;
            var actual_location;
            var last_login;
            var last_location;
            var language;
            var ignoreCall = false;

            var startDateFromSession = "{{session('auth.report_start_date')}}";
            var endDateFromSession = "{{session('auth.report_end_date')}}";

            $('#sessionStartDate').datepicker({
                format: 'dd-M-yyyy',
                //format: 'dd/mm/yyyy',
                autoclose: true,
                todayBtn: "linked"
                //startDate: '-3d'
            });

            $('#sessionEndDate').datepicker({
                format: 'dd-M-yyyy',
                //format: 'dd/mm/yyyy',
                autoclose: true,
                todayBtn: "linked"
                //startDate: '-3d'
            });

            var intervalCountdown = setInterval(
                function() {
                    var date = new Date();

                    var weekday = new Array(7);
                    weekday[0] = "{{trans('authenticated.Sunday')}}";
                    weekday[1] = "{{trans('authenticated.Monday')}}";
                    weekday[2] = "{{trans('authenticated.Tuesday')}}";
                    weekday[3] = "{{trans('authenticated.Wednesday')}}";
                    weekday[4] = "{{trans('authenticated.Thursday')}}";
                    weekday[5] = "{{trans('authenticated.Friday')}}";
                    weekday[6] = "{{trans('authenticated.Saturday')}}";
                    var monthNames = ["{{trans('authenticated.Jan')}}", "{{trans('authenticated.Feb')}}", "{{trans('authenticated.Mar')}}",
                        "{{trans('authenticated.Apr')}}", "{{trans('authenticated.May')}}", "{{trans('authenticated.Jun')}}", "{{trans('authenticated.Jul')}}",
                        "{{trans('authenticated.Aug')}}", "{{trans('authenticated.Sep')}}", "{{trans('authenticated.Oct')}}", "{{trans('authenticated.Nov')}}",
                        "{{trans('authenticated.Dec')}}"
                    ];

                    var dayName = weekday[date.getDay()];
                    var monthDay = date.getDate();
                    var year = date.getFullYear();
                    var monthName = monthNames[date.getMonth()];

                    var endDate = monthDay + " " + monthName + " " + year;
                    var startDate = new Date();
                    var dateString = dayName + ", " + monthDay + ". " + monthName + " " + year;

                    $("#dateTimeHomePage").val(monthDay + "-" + monthName + "-" + year + "     " + date.toLocaleTimeString());
                    //$("#currentServerDate").text(dateString);
                }, 1000
            );

            $("#editSessionStartDate").on("click", function(){
                document.getElementById("sessionStartDate").disabled = false;
                document.getElementById("editSessionStartDate").style.display = "none";
                document.getElementById("cancelSessionStartDate").style.display = "inline";

                generateNotification('{{trans("authenticated.This sets default start date value on report filters for this login session.")}}' + "<br>", '<br><strong>{{trans("authenticated.Exceptions")}}:</strong><br>{{trans("authenticated.Tickets/Search Tickets")}}<br>{{trans("authenticated.Reports/Ticket List")}}<br>{{trans("authenticated.Reports/Draw List")}}');

            });
            $("#cancelSessionStartDate").on("click", function(){
                document.getElementById("sessionStartDate").disabled = true;
                document.getElementById("editSessionStartDate").style.display = "inline";
                document.getElementById("cancelSessionStartDate").style.display = "none";
                document.getElementById("saveSessionStartDate").style.display = "none";

                document.getElementById("sessionStartDate").value = startDateFromSession;
            });
            $("#sessionStartDate").on("change", function(){
                document.getElementById("saveSessionStartDate").style.display = "inline";
            });
            $("#saveSessionStartDate").on("click", function(){
                var start_date = document.getElementById("sessionStartDate").value;
                setSessionStartDate(start_date);
            });

            $("#editSessionEndDate").on("click", function(){
                document.getElementById("sessionEndDate").disabled = false;
                document.getElementById("editSessionEndDate").style.display = "none";
                document.getElementById("cancelSessionEndDate").style.display = "inline";

                generateNotification('{{trans("authenticated.This sets default end date value on report filters for this login session.")}}','');
            });
            $("#cancelSessionEndDate").on("click", function(){
                document.getElementById("sessionEndDate").disabled = true;
                document.getElementById("editSessionEndDate").style.display = "inline";
                document.getElementById("saveSessionEndDate").style.display = "none";
                document.getElementById("cancelSessionEndDate").style.display = "none";

                document.getElementById("sessionEndDate").value = endDateFromSession;
            });
            $("#sessionEndDate").on("change", function(){
                document.getElementById("saveSessionEndDate").style.display = "inline";
            });
            $("#saveSessionEndDate").on("click", function(){
                var end_date = document.getElementById("sessionEndDate").value;
                setSessionEndDate(end_date);
            });

            $("#editLanguage").on("click", function(){
                document.getElementById("language").disabled = false;
                document.getElementById("editLanguage").style.display = "none";
                document.getElementById("cancelLanguage").style.display = "inline";

                generateNotification('{{trans("authenticated.This sets application language for this login session.")}}','');
            });
            $("#cancelLanguage").on("click", function(){
                document.getElementById("language").disabled = true;
                document.getElementById("editLanguage").style.display = "inline";
                document.getElementById("cancelLanguage").style.display = "none";
                document.getElementById("saveLanguage").style.display = "none";

                document.getElementById("language").value = language;
            });
            $("#language").on("change", function(){
                document.getElementById("saveLanguage").style.display = "inline";
            });
            $("#saveLanguage").on("click", function(){
                var language = document.getElementById("language").value;
                setLanguage(language);
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
                            username = data.result[0].username;
                            actual_location = data.result[0].current_session_ip + "     /     " + data.result[0].current_session_city;
                            last_login = data.result[0].last_login_date_formatted;
                            last_location = data.result[0].last_login_ip + "     /     " + data.result[0].last_login_city;
                            language =  data.result[0].language;

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){
                        document.getElementById("username").value = username;
                        document.getElementById("actualLocation").value = actual_location;
                        document.getElementById("lastLogin").value = last_login;
                        document.getElementById("lastLocation").value = last_location;
                        document.getElementById("sessionStartDate").value = startDateFromSession;
                        document.getElementById("sessionEndDate").value = endDateFromSession;
                        getLanguages();
                    },
                    error: function(data){

                    }
                });
            }
            function getLanguages(){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getLanguagesAjax") }}",
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        var languageDropdown = document.getElementById("language");
                        if(data.status == "OK"){
                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');
                                element.value = index;
                                element.textContent = value;
                                languageDropdown.appendChild(element);
                            });
                        }else if(data.status == "NOK"){

                        }
                    },
                    complete: function(data){
                        document.getElementById("language").value = language;
                    },
                    error: function(data){

                    }
                });
            }
            function setSessionStartDate(start_date){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "setSessionStartDateAjax") }}",
                    dataType: "json",
                    data: {
                        start_date: start_date
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        location.reload();
                    },
                    error: function(data){
                        location.reload();
                    }
                });
            }
            function setSessionEndDate(end_date){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "setSessionEndDateAjax") }}",
                    dataType: "json",
                    data: {
                        end_date: end_date
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        location.reload();
                    },
                    error: function(data){
                        location.reload();
                    }
                });
            }

            function setLanguage(language){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "setLanguageAjax") }}",
                    dataType: "json",
                    data: {
                        language: language,
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            window.location.replace(data.url);
                        }else{
                            location.reload();
                        }
                    },
                    error: function(data){
                        if(data.status == "OK"){
                            window.location.replace(data.url);
                        }else{
                            location.reload();
                        }
                    }
                });
            }

            getPersonalData();
        });
    </script>
@endsection
