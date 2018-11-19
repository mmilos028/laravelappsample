
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("page_title.Update Location") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> {{ __("menu.Users") }}</li>
            <li>
            <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/user/list-locations') }}" title="{{ __('menu.List Locations') }}">
                {{ __("menu.List Locations") }}
            </a>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/update-location/user_id/{$user['user_id']}") }}" title="{{ __('page_title.Update Location') }}">
                    {{ __("page_title.Update Location") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <!-- Form::open(array('url' => '/test/do-add-user'))  -->
        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-user"></i>
                    <span>{{ __("page_title.Update Location") }}</span>
                </h4>
            </div>

            <div class="widget-content">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "user/update-location/user_id/{$user['user_id']}" ), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                @include('layouts.shared.form_messages')

                <div class="form-group required">

                {!! Form::label('username', trans('authenticated/user/translation.Username') . ':', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-4">
                    {!!
                        Form::text('username', $user['username'],
                            array(
                                  'readonly',
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.Username')
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
                    {!! Form::label('mobile_phone', trans('authenticated/user/translation.Mobile Phone') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('mobile_phone', null,
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.Mobile Phone')
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
                    {!! Form::label('email', trans('authenticated/user/translation.Email') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('email', $user['email'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.Email')
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
                    {!! Form::label('first_name', trans('authenticated/user/translation.First Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('first_name', $user['first_name'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.First Name')
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
                    {!! Form::label('last_name', trans('authenticated/user/translation.Last Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('last_name', $user['last_name'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.Last Name')
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
                    {!! Form::label('address', trans('authenticated/user/translation.Address') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('address', $user['address'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.Address')
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
                    {!! Form::label('post_code', trans('authenticated/user/translation.Post Code') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('post_code', null,
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.Post Code')
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
                    {!! Form::label('city', trans('authenticated/user/translation.City') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::text('city', $user['city'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.City')
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
                    {!! Form::label('country', trans('authenticated/user/translation.Country') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!!
                        Form::select('country', $list_countries, $user['country_code'],
                            array(
                                  'class'=>'form-control',
                                  'placeholder'=>trans('authenticated/user/translation.Country')
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
                    {!! Form::label('language', trans('authenticated/user/translation.Language') . ':', array('class' => 'col-md-3 control-label')) !!}
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

                <div class="form-group required">
                    {!! Form::label('account_active', trans('authenticated/user/translation.Account Active') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                    {!! Form::select('account_active', $account_active_options, $user['active'], ['class' => 'form-control']) !!}
                    </div>
                </div>
                @if ($errors->has('account_active'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('account_active') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group required">
                    {!! Form::label('currency', trans('authenticated/user/translation.List Currency') . ':', array('class' => 'col-md-3 control-label')) !!}
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

                <div class="form-actions">
                    {!! Form::hidden('user_id', $user['user_id']) !!}

                    {!!
                        Form::submit( trans('authenticated/forms/translation.Save'),
                            array(
                                'name'=>'save',
                                'class'=>'btn btn-primary'
                            )
                        )
                    !!}
                    {!!
                        Form::submit(trans('authenticated/forms/translation.Cancel'),
                            array(
                                'formnovalidate',
                                'name'=>'cancel',
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
