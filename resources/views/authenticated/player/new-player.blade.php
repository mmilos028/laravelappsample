
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.New Player") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user-plus"></i> {{ __("authenticated.Players") }}</li>
            <li class="active">
                {{ __("authenticated.New Player") }}
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-user-plus"></i>
                    <span>{{ __("authenticated.New Player") }}</span>
                </h4>
            </div>

            <div class="widget-content">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'player/new-player'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                @include('layouts.shared.form_messages')

                <div class="form-group required">
                {!! Form::label('username', trans('authenticated.Username') . ':', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-4">
                    {!!
                        Form::text('username', $user['username'],
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

                <div class="form-group required">
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

                <div class="form-group required">
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
                    <div class="col-md-2">
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
