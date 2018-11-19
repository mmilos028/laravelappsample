
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.Update Player") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> {{ __("authenticated.Player/Pos") }}</li>
            <li>
            <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/player/list-players') }}" title="{{ __('authenticated.List Players') }}">
                {{ __("authenticated.List Players") }}
            </a>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/update-player/player_id/{$user['user_id']}") }}" title="{{ __('authenticated.Update Player') }}">
                    {{ __("authenticated.Update Player") }}
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
                    <span>{{ __("authenticated.Update Player") }}</span>
                </h4>
            </div>

            <div class="widget-content">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "player/update-player/player_id/{$user['user_id']}" ), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                @if (isset($error_message))
                <div class="alert alert-error">
                    <strong>
                      {{ __("authenticated.error") }}
                    </strong>
                    {{ $error_message }}
                </div>
                @endif

                @if (isset($success_message))
                <div class="alert alert-success">
                    <strong>
                      {{ __("authenticated.success") }}
                    </strong>
                    {{ $success_message }}
                </div>
                @endif

                @if (isset($information_message))
                <div class="alert alert-info">
                    <strong>
                      {{ __("authenticated.information") }}
                    </strong>
                    {{ $information_message }}
                </div>
                @endif

                @if (isset($warning_message))
                <div class="alert alert-warning">
                    <strong>
                      {{ __("authenticated.warning") }}
                    </strong>
                    {{ $warning_message }}
                </div>
                @endif

                <div class="form-group required">

                {!! Form::label('username', trans('authenticated.Username'), array('class' => 'col-md-3 control-label')) !!}
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
                    {!! Form::label('email', trans('authenticated.Email'), array('class' => 'col-md-3 control-label')) !!}
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
                    {!! Form::label('first_name', trans('authenticated.First Name'), array('class' => 'col-md-3 control-label')) !!}
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
                    {!! Form::label('last_name', trans('authenticated.Last Name'), array('class' => 'col-md-3 control-label')) !!}
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
                    {!! Form::label('language', trans('authenticated.Language'), array('class' => 'col-md-3 control-label')) !!}
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
                    {!! Form::label('account_active', trans('authenticated.Account Active'), array('class' => 'col-md-3 control-label')) !!}
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
                    {!! Form::label('currency', trans('authenticated.List Currency'), array('class' => 'col-md-3 control-label')) !!}
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
                @if ($errors->has('currency'))
                <div class="row">
                    <div class="col-sm-6">
                        <span class="help-block alert alert-danger alert-dismissible fade in">
                            <strong>{{ $errors->first('currency') }}</strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-actions push-md-3">
                    {!! Form::hidden('user_id', $user['user_id']) !!}

                    {!!
                        Form::submit( trans('authenticated.Save'),
                            array(
                                'name'=>'save',
                                'class'=>'btn btn-primary'
                            )
                        )
                    !!}
                    {!!
                        Form::submit(trans('authenticated.Cancel'),
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
