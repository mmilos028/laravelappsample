
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{ __("authenticated.Draw Model Setup") }}
                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
                <li class="active">{{ __("authenticated.Draw Model Setup") }}</li>
            </ol>
        </section>

        <section class="content">

            <div class="box table-responsive">
                <div class="box-body">
                    @include('layouts.shared.form_messages')
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <td colspan="3">
                                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/draw-model-setup'), 'method'=>'POST', 'class' => 'form-inline' ]) !!}
                                {!! Form::label('draw_model_name', trans('authenticated.Draw Model Name') . ':', array('class' => 'col-md-2 control-label')) !!}
                                {!!
                                    Form::text('draw_model_name', null,
                                        array(
                                              'class'=>'form-control col-md-5',
                                              'placeholder'=>trans('authenticated.Draw Model Name')
                                        )
                                    )
                                !!}
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
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        </thead>
                    </table>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <td colspan="8" class="align-right">
                                    {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/draw-model-setup'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                                    {!!
                                        Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                        array(
                                            'class'=>'btn btn-primary',
                                            'type'=>'submit',
                                            'name'=>'generate_report',
                                            'value'=>'generate_report'
                                            )
                                        )
                                    !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            <tr class="bg-blue-active">
                                <th width="100">{{ __("authenticated.Draw Model ID") }}</th>
                                <th>{{ __("authenticated.Draw Model Name") }}</th>
                                <th>{{ __("authenticated.Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($list_draw_models as $model)
                            <tr>
                                <td class="align-right">
                                    {{ $model->draw_model_id }}
                                </td>
                                <td>
                                    {{ $model->draw_model }}
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/update-draw-model/draw_model_id/{$model->draw_model_id}") }}" title="{{ __("authenticated.Update") }}">
                                        <i class="fa fa-pencil"></i>
                                        {{ __("authenticated.Update") }}
                                    </a>
                                    <a class="btn btn-danger" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/delete-draw-model/draw_model_id/{$model->draw_model_id}") }}" title="{{ __("authenticated.Delete") }}">
                                        <i class="fa fa-trash"></i>
                                        {{ __("authenticated.Delete") }}
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
