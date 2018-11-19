
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-cog"></i>
            {{ __("authenticated.Version Setup") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/version-setup/version-setup") }}">
                    {{ __("authenticated.Version Setup") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span>{{ __("authenticated.Add Application / Version") }}</span>
                </h4>
            </div>

            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),
                "administration/version-setup/version-setup"),
                'method'=>'POST', 'class' => 'form-horizontal' ]) !!}

                    @include('layouts.shared.form_messages')

                    <div class="form-group required">
                        {!! Form::label('application_name', trans('authenticated.Application Name') . ':', array('class' => 'control-label col-md-2')) !!}
                        {!!
                            Form::text('application_name', null,
                                array(
                                      'class'=>'form-control col-md-6',
                                      'placeholder'=>trans('authenticated.Application Name')
                                )
                            )
                        !!}
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
                        {!! Form::label('application_version', trans('authenticated.Application Version') . ':', array('class' => 'control-label col-md-2')) !!}
                        {!!
                            Form::text('application_version', null,
                                array(
                                      'class'=>'form-control col-md-10',
                                      'placeholder'=>trans('authenticated.Application Version')
                                )
                            )
                        !!}
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
                                'name'=>'save_application_version',
                                'value'=>'save_application_version'
                                )
                            )
                        !!}

                    </div>

                {!! Form::close() !!}
            </div>
        </div>

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="ion ion-ios-list-outline"></i>
                    <span>
                    {{ __("authenticated.List Application / Version") }}
                    </span>
                </h4>
            </div>

            <div class="widget-content table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                       <tr class="bg-blue-active">
                            <th width="200">{{ __("authenticated.Application Name") }}</th>
                            <th width="200">{{ __("authenticated.Application Version") }}</th>
                            <th width="200">{{ __("authenticated.Action") }}</th>
                       </tr>
                    </thead>
                   <tbody>
                   @foreach ($list_application_version_set as $set)
                       @php
                       //dd($set)
                       @endphp
                        <tr>
                            <td>
                                {{ $set->application_name }}
                            </td>
                            <td>
                                {{ $set->version }}
                            </td>
                            <td>

                                <a class="btn btn-danger"
                                   href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),
                                   "/administration/version-setup/delete-application-version/application_name/{$set->application_name}") }}"
                                   title="{{ __("authenticated.Delete") }}">
                                    <i class="fa fa-trash"></i>
                                    {{ __("authenticated.Delete") }}
                                </a>
                                <span style="padding-right: 50px;"></span>
                                <a class="btn btn-primary"
                                   href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),
                                   "/administration/version-setup/update-application-version/application_name/{$set->application_name}/version/{$set->version}") }}"
                                   title="{{ __("authenticated.Update") }}">
                                    <i class="fa fa-edit"></i>
                                    {{ __("authenticated.Update") }}
                                </a>
                            </td>
                        </tr>
                   @endforeach
                   </tbody>
               </table>
            </div>

        </div>

    </section>
</div>
@endsection
