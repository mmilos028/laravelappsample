
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
            <i class="fa fa-search"></i>
            {{ __("authenticated.Check Service Code") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-search"></i> {{ __("authenticated.Terminals") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/check-service-code") }}" title="{{ __('authenticated.Check Service Code') }}">
                    {{ __("authenticated.Check Service Code") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-search"></i>
                    <span>{{ __("authenticated.Check Service Code") }}</span>
                </h4>
            </div>

            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "terminal/check-service-code"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                    @include('layouts.shared.form_messages')

                    <div class="form-group required">
                        {!! Form::label('service_code', trans('authenticated.Service Code') . ':', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!!
                            Form::text('service_code', $service_code,
                                array(
										'autofocus',
										'class'=>'form-control',
										'placeholder'=>trans('authenticated.Service Code')
                                )
                            )
                        !!}
                        </div>
                    </div>
                    @if ($errors->has('service_code'))
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong>{{ $errors->first('service_code') }}</strong>
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group required">
                        {!! Form::label('maschine_key', trans('authenticated.Maschine Key') . ':', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!!
                            Form::text('maschine_key', $maschine_key,
                                array(
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Maschine Key')
                                )
                            )
                        !!}
                        </div>
                    </div>
                    @if ($errors->has('maschine_key'))
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong>{{ $errors->first('maschine_key') }}</strong>
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="form-actions">

                        {!!
                            Form::button('<i class="fa fa-search"></i> ' . trans('authenticated.Check'),
                            array(
                                'class'=>'btn btn-primary',
                                'type'=>'submit',
                                'name'=>'check',
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
