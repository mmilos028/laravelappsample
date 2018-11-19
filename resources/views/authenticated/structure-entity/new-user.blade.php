
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
$(document).ready(function() {

    function setDefaults(){
        loadAffiliatesFromSelectedRole();
        /*document.getElementById("currency").disabled = true;
        document.getElementById("currnecyHiddenContainer").style.display = "none";*/
    }

    setDefaults();

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
	$("#subject_type").change(function(){
        loadAffiliatesFromSelectedRole();

    if(role == "<?php echo Config::get('constants.ROLE_CASHIER'); ?>"){
            var response = $.ajax({
            url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/get-location-address-information") }}",
            method: "GET"
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

    //$(".enable-draw-model").hide();
});
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.New Structure Entity") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user-plus"></i> {{ __("authenticated.Structure Entity") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/newStructureEntity2") }}" title="{{ __('authenticated.New Entity') }}">
                    {{ __("authenticated.New Entity") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-user-plus"></i>
                    <span>{{ __("authenticated.New Structure Entity") }}</span>
                </h4>
            </div>

            <div class="widget-content">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'structure-entity/new-user'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                @include('layouts.shared.form_messages')

                <div class="form-group required">

                    {!! Form::label('subject_type', trans('authenticated.Role') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                        <select class="form-control" id="subject_type" name="subject_type">
                            @foreach($list_subject_types as $s_type)
                                <option value="{{$s_type["subject_type_id"]}}">{{$s_type["subject_type_bo_name"]}} </option>
                            @endforeach
                        </select>
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

                <div class="form-group required">
                {!! Form::label('username', trans('authenticated.Username') . ':', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-4">
                    {!!
                        Form::text('username', '',
                            array(
									'autofocus',
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

                <div class="form-group">
                    {!! Form::label('first_name', trans('authenticated.First Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('first_name', '',
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
                        Form::text('last_name', '',
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

                <div class="form-group required">
                    {!! Form::label('mobile_phone', trans('authenticated.Mobile Phone') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('mobile_phone', null,
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
                        Form::text('email', '',
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
                    {!! Form::label('address', trans('authenticated.Address') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('address', null,
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
                        Form::text('commercial_address', null,
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
                        Form::text('post_code', null,
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
                        Form::text('city', null,
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
                    {!! Form::select('country', $list_countries, $logged_in_user['country_code'], ['class' => 'form-control']) !!}
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
                    {!! Form::select('currency', $list_currency, '', ['class' => 'form-control']) !!}
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
