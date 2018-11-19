
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-cog"></i>
                {{ __("authenticated.Update Application / Version") }}                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
                <li> {{ __("authenticated.Version Setup") }}</li>
                <li class="active">{{ __("authenticated.Update Application / Version") }}</li>
            </ol>
        </section>

        <section class="content">

            <div class="box table-responsive">
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <td>

                                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),
                                "administration/version-setup/do-update-application-version"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                                    @include('layouts.shared.form_messages')

                                    <div class="form-group required">
                                    {!! Form::label('application_name', trans('authenticated.Application Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-4">
                                        {!!
                                            Form::text('application_name', $application_name,
                                                array(
                                                      'readonly',
                                                      'class'=>'form-control',
                                                      'placeholder'=>trans('authenticated.Application Name')
                                                )
                                            )
                                        !!}
                                        </div>
                                    </div>
                                    @if ($errors->has('application_name'))
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('application_name') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group required">
                                    {!! Form::label('application_version', trans('authenticated.Application Version') . ':', array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-4">
                                        {!!
                                            Form::text('application_version', $version,
                                                array(
                                                      'autofocus',
                                                      'class'=>'form-control',
                                                      'placeholder'=>trans('authenticated.Application Version')
                                                )
                                            )
                                        !!}
                                        </div>
                                    </div>
                                    @if ($errors->has('application_version'))
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('application_version') }}</strong>
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
                                                  'name'=>'save_update_application_version',
                                                  'value'=>'save_update_application_version'
                                                  )
                                              )
                                        !!}
                                        {!!
                                            Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Cancel'),
                                                array(
                                                    'formnovalidate',
                                                    'type' => 'submit',
                                                    'name'=>'cancel_update_application_version',
                                                    'value'=>'cancel_update_application_version',
                                                    'class'=>'btn btn-default'
                                                )
                                            )
                                        !!}

                                    </div>

                                {!! Form::close() !!}
                            </td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection
