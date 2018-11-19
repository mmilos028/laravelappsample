
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("page_title.Manage Nonauthenticated Language File") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("menu.Administration") }}</li>
            <li>{{ __("menu.Translation") }}</li>
            <li class="active">{{ __("page_title.Manage Nonauthenticated Language File") }}</li>
        </ol>
    </section>

    <section class="content">

        <!-- Form::open(array('url' => '/test/do-add-user'))  -->
        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span>{{ __("page_title.Manage Nonauthenticated Language File") }}</span>
                </h4>
            </div>
            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/language-setup/manage-nonauthenticated-language-files'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                     <div class="row">
                        <div class="col-xs-12">
                            <h4>Change Language File</h4>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-xs-12">
                            {!! Form::label('select_language', trans('authenticated/forms/translation.Select Language') . ':',
                             array('class' => 'col-md-3 control-label', 'style'=>'width: 99%; padding-top: 5px;')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            {!!
                                Form::select('select_language', $list_languages, $language_file,
                                    [
                                        'class'=>'form-control col-md-9'
                                    ]
                                )
                            !!}
                            {!! csrf_field() !!}
                            {!!
                                Form::submit(trans('authenticated/forms/translation.Change'),
                                    array(
                                        'name'=>'change_language',
                                        'class'=>'btn btn-primary col-md-1'
                                    )
                                )
                            !!}
                        </div>
                    </div>
                {!! Form::close() !!}

                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/language-setup/manage-nonauthenticated-language-files'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Create New Language Entry</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            {!!
                                Form::text('new_translation_key', null,
                                    [
                                        'class'=>'form-control col-md-4',
                                        'placeholder' => 'Key'
                                    ]
                                )
                            !!}
                            {!!
                                Form::text('new_translation_value', null,
                                    array(
                                        'class'=>'form-control col-md-4',
                                        'placeholder' => 'Value'

                                    )
                                )
                            !!}
                            {!! Form::hidden('used_language', $language_file) !!}
                            {!! csrf_field() !!}
                            {!!
                                Form::submit(trans('authenticated/forms/translation.New'),
                                    array(
                                        'name'=>'add_new_language_key',
                                        'class'=>'btn btn-primary col-md-1'
                                    )
                                )
                            !!}
                        </div>
                    </div>
                {!! Form::close() !!}

                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/language-setup/manage-nonauthenticated-language-files'), 'method'=>'POST' ]) !!}

                    @include('layouts.shared.form_messages')

                    <div class="row">
                        <div class="col-xs-12">
                            <h4>List Language File Values</h4>
                        </div>
                    </div>

                    @foreach($translations as $key=>$value)
                    <div class="row">

                        <div class="col-xs-12">
                            {!! Form::label('translationkey[' . $key . ']', $key, array('class' => 'col-md-3 control-label', 'style'=>'width: 99%; padding-top: 5px;')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            {!!
                                Form::text('translationvalue[' . $key . ']', $value,
                                    array(
                                          'class'=>'form-control',
                                          'style'=>'max-width: 99% !important;'
                                    )
                                )
                            !!}
                        </div>
                    </div>
                    @endforeach

                    <div class="form-actions">
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

                      {!! csrf_field() !!}
                      {!! Form::hidden('used_language', $language_file) !!}

                    </div>

                {!! Form::close() !!}
            </div>
        </div>

    </section>
</div>
@endsection
