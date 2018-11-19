
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
$(document).ready(function() {

	//load currency select list with currencies from selected affiliate
	function loadAffiliatesCurrencyList(){
		$.ajax({
			url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/user-details") }}",
			async: true, dataType: "json", global: false,
			data: "user_id=" + $("#sub_subject").val(),
			done: function(data){
			    if(data.hasOwnProperty('user') && data.user != null){
              if(data.user.hasOwnProperty('language') && data.user.language != null){
                  $("#language").val(data.user.language);
              }
              if(data.user.hasOwnProperty('country_code') && data.user.country_code != null){
                  $("#country").val(data.user.country_code)
              }
          }
			},
			fail: function(xhr){
				console.error(xhr);
			}
		});
	}

	function loadAffiliatesFromSelectedRole(){
        var response = $.ajax({
            url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/get-affiliates-from-role") }}",
            async: true, dataType: "json", global: false,
            data: "subject_type_id=" + $("#subject_type").val()
        });
        response.done(function(data){
            if(data['status'] == 'OK'){
                if(data.hasOwnProperty('list_affiliates')) {
                    var listParentAffiliates = [];
                    for (var i = 0; i < data['list_affiliates'].length; i++) {
                        listParentAffiliates += "<option value='" + data['list_affiliates'][i].subject_id_to + "'>" + data['list_affiliates'][i].subject_name_to + "</option>";
                    }
                    $("#sub_subject").html(listParentAffiliates);
                }
            }
        });
        response.fail(
            function(xhr){
                console.error(xhr);
            }
        );
    }


	//if selected role is not empty selected affiliate is enabled and selected affiliate is not empty then currency is filled in with affiliate
	$("#sub_subject").change(function(){
        if($("#sub_subject option:selected").val() != ''){
                if($("#sub_subject option:selected").val() != ''){
                loadAffiliatesCurrencyList();
            }
            $("#parent_affiliate_username").val($("#sub_subject option:selected").text());
        }

		var role = $("#subject_type option:selected").text();

        if(role == "<?php echo Config::get('constants.ROLE_CLIENT'); ?>"){
            $(".enable-draw-model").show();
        }else{
            $(".enable-draw-model").hide();
        }

		if(role == "<?php echo Config::get('constants.ROLE_CASHIER'); ?>"){
			var response = $.ajax({
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/get-location-address-information") }}",
                method: "GET",
                data: {
                  location_id: $("#sub_subject option:selected").val()
                }
              });
              response.done(function(data) {
                    if(data.status == "OK"){
                    $("#address").val(data.address);
                        $("#commercial_address").val(data.commercial_address);
                        $("#city").val(data.city);
                    }
              });
              response.fail(function(xhr) {
                console.error(xhr);
              });
        }else{
            //console.log(role);
        }
	    $("#sub_subject").focus();
	});

    $("#subject_type").change(function(){
        var role = $("#subject_type option:selected").text();

        if(role == "<?php echo Config::get('constants.ROLE_CLIENT'); ?>"){
            $(".enable-draw-model").show();
        }else{
            $(".enable-draw-model").hide();
        }

        if(role == "<?php echo Config::get('constants.ROLE_CASHIER'); ?>"){
            var response = $.ajax({
                url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/get-location-address-information") }}",
                method: "GET",
                data: {
                    location_id: $("#sub_subject option:selected").val()
                }
            });
            response.done(function(data) {
                if(data.status == "OK"){
                    $("#address").val(data.address);
                    $("#commercial_address").val(data.commercial_address);
                    $("#city").val(data.city);
                }
            });
            response.fail(function(xhr) {
                console.error(xhr);
            });
        }else{
            //console.log(role);
        }

        loadAffiliatesFromSelectedRole();
    });

	$("#parent_affiliate_username").val($("#sub_subject option:selected").text());
    $(".enable-draw-model").hide();
});
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.New User") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user-plus"></i> {{ __("authenticated.Administration") }}</li>
            <li class="active">{{ __("authenticated.New User") }}</li>
        </ol>
    </section>

    <section class="content">

        <!-- Form::open(array('url' => '/test/do-add-user'))  -->
        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-user-plus"></i>
                    <span>{{ __("authenticated.New User") }}</span>
                </h4>
            </div>

            <div class="widget-content">

            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/new-user'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                @include('layouts.shared.form_messages')

                <div class="form-group required">

                    {!! Form::label('subject_type', trans('authenticated.Role') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!! Form::select('subject_type', $list_subject_types, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                @if ($errors->has('subject_type'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('subject_type') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">

                    {!! Form::label('sub_subject', trans('authenticated.Parent Affiliate') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    <select name="sub_subject" id="sub_subject" class="form-control col-md-10">
                          @foreach($list_sub_subjects as $item)
                            <option value="{{ $item->subject_id }}">{{ $item->username }}</option>
                          @endforeach
                    </select>
                    </div>
                </div>
                @if ($errors->has('sub_subject'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('sub_subject') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                {!! Form::label('username', trans('authenticated.Username') . ':', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-4">
                    {!!
                        Form::text('username', $user['username'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Username')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('username'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                    {!! Form::label('password', trans('authenticated.Password') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::password('password',
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Password')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('password'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                    {!! Form::label('confirm_password', trans('authenticated.Confirm Password') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::password('confirm_password',
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Confirm Password')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('confirm_password'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('confirm_password') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                    {!! Form::label('mobile_phone', trans('authenticated.Mobile Phone') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('mobile_phone', $user['mobile_phone'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Mobile Phone')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('mobile_phone'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('mobile_phone') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                    {!! Form::label('email', trans('authenticated.Email') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('email', $user['email'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Email')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('email'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    {!! Form::label('first_name', trans('authenticated.First Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('first_name', $user['first_name'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.First Name')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('first_name'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    {!! Form::label('last_name', trans('authenticated.Last Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('last_name', $user['last_name'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Last Name')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('last_name'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    {!! Form::label('address', trans('authenticated.Address') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('address', $user['address'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Address')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('address'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    {!! Form::label('commercial_address', trans('authenticated.Commercial Address') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('commercial_address', $user['commercial_address'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Commercial Address')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('commercial_address'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('commercial_address') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    {!! Form::label('post_code', trans('authenticated.Post Code') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('post_code', $user['post_code'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Post Code')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('post_code'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('post_code') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    {!! Form::label('city', trans('authenticated.City') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('city', $user['city'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.City')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('city'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                    {!! Form::label('country', trans('authenticated.Country') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::select('country', $list_countries, $logged_in_user['country_code'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated.Country')
                            )
                        )
                    !!}
                    </div>
                </div>
                @if ($errors->has('country'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                    {!! Form::label('language', trans('authenticated.Language') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!! Form::select('language', $languages, $logged_in_user['language'], ['class' => 'form-control']) !!}
                    </div>
                </div>
                @if ($errors->has('language'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('language') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                    {!! Form::label('currency', trans('authenticated.List Currency') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!! Form::select('currency', $list_currency, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                @if ($errors->has('currency'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('currency') }}</strong>
                        </span>
                    </div>
                </div>
                @endif


                <div class="form-group required enable-draw-model">
                    {!! Form::label('draw_model_id', trans('authenticated.Draw Model') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                        <select name="draw_model_id" id="draw_model_id" class="form-control col-md-10">
                            @foreach($list_draw_models as $item)
                                <option value="{{ $item->draw_model_id }}">{{ $item->draw_model }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="invincible">
                    {!! Form::hidden('parent_affiliate_username', null, array('id' => 'parent_affiliate_username')) !!}
                </div>

                <div class="form-actions">

                    {!!
                          Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save'),
                          array(
                              'class'=>'btn btn-primary',
                              'type'=>'submit',
                              'name'=>'save',
                              'value'=>'save'
                              )
                          )
                      !!}
                    {!!
                        Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Cancel'),
                            array(
                                'formnovalidate',
                                'type' => 'submit',
                                'name'=>'cancel',
                                'value'=>'cancel',
                                'class'=>'btn btn-default'
                            )
                        )
                    !!}

                </div>

            {!! Form::close() !!}
        </div>
    </div>

    </section>
</div>
@endsection
