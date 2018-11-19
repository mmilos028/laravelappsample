
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{--- __("authenticated.Server Time") ---}}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-money"></i> {{ __("authenticated.Server Time") }}</li>
            <li class="active">{{ __("authenticated.Server Time") }}</li>
        </ol>
    </section>

    <section class="content">

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

        <!-- Form::open(array('url' => '/test/do-add-user'))  -->
        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-user"></i>
                    <span>Add User</span>
                </h4>
            </div>
            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'test/add-user'), 'class' => 'form-horizontal row-border' ]) !!}
                       <div class="form-group">
                        {!! Form::label('username', 'Username', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!! Form::text('username', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Username'))
                        !!}
                        </div>
                    </div>
                    @if ($errors->has('username'))
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('password', 'Password', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!! Form::password('password',
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Password'))
                        !!}
                        </div>
                    </div>
                    @if ($errors->has('password'))
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('first_name', 'First Name', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!! Form::text('first_name', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'First Name'))
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
                        {!! Form::label('last_name', 'Last Name', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                        {!! Form::text('last_name', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Last Name'))
                        !!}
                      </div>
                    </div>
                    @if ($errors->has('last_name'))
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="form-actions push-md-3">
                        {!! Form::submit('Save',
                          array(
                            'name'=>'save',
                            'class'=>'btn btn-primary'
                        )) !!}
                        {!! Form::submit('Cancel',
                           array(
                            'name'=>'cancel',
                            'formnovalidate',
                            'class'=>'btn btn-default'
                           )) !!}
                    </div>

                {!! Form::close() !!}
            </div>
        </div>

    </section>
</div>
@endsection
