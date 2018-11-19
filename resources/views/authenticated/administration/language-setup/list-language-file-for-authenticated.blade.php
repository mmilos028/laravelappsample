
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.For Entire Application") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("authenticated.For Entire Application") }}</li>
            <li>{{ __("authenticated.Translation") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/language-setup/list-language-file-for-authenticated") }}" class="noblockui">
                    {{ __("authenticated.For Entire Application") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span>{{ __("authenticated.For Entire Application") }}</span>
                </h4>
            </div>
            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/language-setup/list-language-file-for-authenticated'), 'method'=>'POST' ]) !!}

                    @include('layouts.shared.form_messages')

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
