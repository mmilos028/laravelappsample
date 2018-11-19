
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
$(document).ready(function() {
    $.fn.select2.defaults.set("theme", "bootstrap");

    $('#country').select2();
});
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user"></i>
            {{ __("authenticated.My Personal Data") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> {{ __("authenticated.My Account") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/my-account/my-personal-data") }}" class="noblockui">
                    {{ __("authenticated.My Personal Data") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-user"></i>
                    <span>{{ __("authenticated.My Personal Data") }}</span>
                </h4>
            </div>
            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'my-account/my-personal-data'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                    @include('layouts.shared.form_messages')

                    <div class="form-group required">
                        {!! Form::label('username', trans('authenticated.Username') . ':', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!!
                            Form::text('username', $user['username'],
                                array(
                                      'readonly',
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
                        {!! Form::label('mobile_phone', trans('authenticated.Mobile Phone') . ':', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!!
                            Form::text('mobile_phone', $user['mobile_phone'],
                                array(
                                    'autofocus',
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
                        <div class="col-sm-12">
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
                        {!! Form::label('commercial_address', trans('authenticated.Address 2') . ':', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                            {!!
                                Form::text('commercial_address', $user['commercial_address'],
                                    array(
                                          'class'=>'form-control',
                                          'placeholder'=>trans('authenticated.Address 2')
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
                            Form::select('country', $list_countries, $user['country_code'],
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
                            {!! Form::select('language', $languages, $user['language'], ['class' => 'form-control']) !!}
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

                        <div class="form-group">
                            {!! Form::label('registration_date', trans('authenticated.Registration Date') . ':', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-2">
                            {!!
                                Form::text('registration_date', DateTimeHelper::returnDateFormatted($user['registration_date']),
                                    array(
                                          'readonly',
                                          'class'=>'form-control',
                                          'placeholder'=>trans('authenticated.Registration Date')
                                    )
                                )
                            !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('currency', trans('authenticated.Currency') . ':', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-2">
                            {!!
                                Form::text('currency', $user['currency'],
                                    array(
                                          'readonly',
                                          'class'=>'form-control',
                                          'placeholder'=>trans('authenticated.Currency')
                                    )
                                )
                            !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('credits', trans('authenticated.Account Balance') . ':', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-2">
                            {!!
                                Form::text('credits', $user['credits_formatted'],
                                    array(
                                          'readonly',
                                          'class'=>'form-control align-right',
                                          'placeholder'=>trans('authenticated.Account Balance')
                                    )
                                )
                            !!}
                            </div>
                        </div>

                        <div class="form-actions">
                          {!! Form::hidden('user_id', $user['user_id']) !!}
                          {!! Form::hidden('subject_type', $user['subject_type']) !!}

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
