
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        @include('layouts.desktop_layout.header_navigation_second')
        <h1>
            <i class="fa fa-key"></i>
            {{ __("authenticated.Change Pin Code") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-key"></i> {{ __("authenticated.Users") }}</li>
            <li>
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/cashier/list-cashiers') }}" title="{{ __('authenticated.List Cashiers') }}">
                    {{ __("authenticated.List Cashiers") }}
                </a>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/change-pin-code/user_id/{$user['user_id']}") }}" title="{{ __('authenticated.Change Pin Code') }}">
                    {{ __("authenticated.Change Pin Code") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-key"></i>
                    <span>{{ __("authenticated.Change Pin Code") }}</span>
                </h4>
            </div>

            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "cashier/change-pin-code/user_id/{$user['user_id']}"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

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

                    <div class="form-group required">
                        {!! Form::label('pin_code', trans('authenticated.Pin Code') . ':', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!!
                            Form::text('pin_code', $cashier_pin_code,
                                array(
                                      'readonly',
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Pin Code')
                                )
                            )
                        !!}
                        </div>
                    </div>

                    <div class="form-actions">
                      {!! Form::hidden('user_id', $user['user_id']) !!}

                        {!!
                               Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Reset'),
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
