
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("page_title.Menu") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("menu.Administration") }}</li>
            <li>{{ __("menu.Translation") }}</li>
            <li class="active">{{ __("page_title.Menu") }}</li>
        </ol>
    </section>

    <section class="content">

        <!-- Form::open(array('url' => '/test/do-add-user'))  -->
        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span>{{ __("page_title.Menu") }}</span>
                </h4>
            </div>
            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/language-setup/list-language-file-for-menu'), 'method'=>'POST' ]) !!}

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
