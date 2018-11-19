
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.Change Password") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-key"></i> {{ __("authenticated.Structure Entity") }}</li>
            <li>
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/operater/list-operaters') }}" title="{{ __('authenticated.List Operaters') }}">
                    {{ __("authenticated.List Operaters") }}
                </a>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/operater/change-password/user_id/{$user['user_id']}") }}" title="{{ __('authenticated.Change Password') }}">
                    {{ __("authenticated.Change Password") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-key"></i>
                    <span>{{ __("authenticated.Change Password") }}</span>
                </h4>
            </div>

            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "operater/change-password/user_id/{$user['user_id']}"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

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
                        {!! Form::label('password', trans('authenticated.Password') . ':', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!!
                            Form::password('password',
                                array(
										'autofocus',
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

                    <div class="form-actions">
                      {!! Form::hidden('user_id', $user['user_id']) !!}

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
