
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.Account Details") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> {{ __("authenticated.Players") }}</li>
            <li>
            <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/player/list-players') }}" title="{{ __('authenticated.List Players') }}">
                {{ __("authenticated.List Players") }}
            </a>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/do-player-details-update/user_id/{$user['user_id']}") }}" title="{{ __('authenticated.Account Details') }}">
                    {{ __("authenticated.Account Details") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

      <div class="tabbable tabbable-custom">
        <ul class="nav nav-tabs">
        <li <?php if($active_tab == 1)echo 'class="active"'; ?>>
          <a href="#tab_1_1" class="noblockui" data-toggle="tab">{{ __('authenticated.Account Details') }}</a>
        </li>
        <li <?php if($active_tab == 2)echo 'class="active"'; ?>>
          <a href="#tab_1_2" class="noblockui" data-toggle="tab">{{ __('authenticated.Update Player') }}</a>
        </li>


        <div class="tab-content">
          <div class="tab-pane <?php if($active_tab == 1)echo 'active'; ?>" id="tab_1_1">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-5">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-user"></i> {{ __('authenticated.Account Details') }}</h4>
                      <span class="pull-right">
                        <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/change-password/user_id/{$user['user_id']}") }}">
                          <button class="btn btn-sm btn-info">
                            <i class="fa fa-key"></i>
                            {{ __("authenticated.Change Password") }}
                          </button>
                        </a>
                      </span>
                    </div>
                    <div class="widget-content">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated.Username') }}</span>
                            </td>
                            <td>
                              <span class="bold-text red-caption-text"> {{ $user['username'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.First Name') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['first_name'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.Last Name') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['last_name'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.Country') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['country_name'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.City') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['city'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.Post Code') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['post_code'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.Address') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['address'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.Mobile Phone') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['mobile_phone'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>{{ __('authenticated.Email') }}</td>
                            <td style="padding:3px 0 0 5px;">
                              <span> {{ $user['email'] }}</span>
                              <a href="mailto:{{ $user['email'] }}" class="btn btn-sm btn-success noblockui">
                                <i class="fa fa-envelope"></i>
                                {{ __('authenticated.Email') }}
                              </a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-wrench"></i> {{ __('authenticated.Details') }}</h4>
                    </div>
                    <div class="widget-content">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.Language') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['language'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated.Account Active') }}</span>
                            </td>
                            <td>
                              @if ($user['active'] == 1)
                                  <span class="label label-success">{{ __("authenticated.Active") }}</span>
                              @else
                                  <span class="label label-danger">{{ __("authenticated.Inactive") }}</span>
                              @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="tab-pane <?php if($active_tab == 2)echo 'active'; ?>" id="tab_1_2">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="widget box col-md-4" style="margin-top:20px;">
                  <div class="widget-header">
                      <h4>
                          <i class="fa fa-user"></i>
                          <span>{{ __("authenticated.Update Player") }}</span>
                      </h4>
                  </div>
                  <div class="widget-content">
                  {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "player/do-player-details-update/user_id/{$user['user_id']}" ), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

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
                          {!! Form::label('mobile_phone', trans('authenticated.Mobile Phone') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('mobile_phone', $user['mobile_phone'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Mobile Phone')
                                  )
                              )
                          !!}
                          </div>
                      </div>
                      @if ($errors->has('mobile_phone'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('mobile_phone') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group required">
                          {!! Form::label('email', trans('authenticated.Email') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('email', $user['email'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Email')
                                  )
                              )
                          !!}
                          </div>
                      </div>
                      @if ($errors->has('email'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group required">
                          {!! Form::label('first_name', trans('authenticated.First Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('first_name', $user['first_name'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.First Name')
                                  )
                              )
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

                      <div class="form-group required">
                          {!! Form::label('last_name', trans('authenticated.Last Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('last_name', $user['last_name'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Last Name')
                                  )
                              )
                          !!}
                          </div>
                      </div>
                      @if ($errors->has('last_name'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('last_name') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group">
                          {!! Form::label('address', trans('authenticated.Address') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('address', $user['address'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Address')
                                  )
                              )
                          !!}
                          </div>
                      </div>
                      @if ($errors->has('address'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('address') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group">
                          {!! Form::label('post_code', trans('authenticated.Post Code') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('post_code', $user['post_code'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Post Code')
                                  )
                              )
                          !!}
                          </div>
                      </div>
                      @if ($errors->has('post_code'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('post_code') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group">
                          {!! Form::label('city', trans('authenticated.City') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('city', $user['city'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.City')
                                  )
                              )
                          !!}
                          </div>
                      </div>
                      @if ($errors->has('city'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('city') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group required">
                          {!! Form::label('country', trans('authenticated.Country') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::select('country', $list_countries, $user['country_code'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Country')
                                  )
                              )
                          !!}
                          </div>
                      </div>
                      @if ($errors->has('country'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('country') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group required">
                          {!! Form::label('language', trans('authenticated.Language') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!! Form::select('language', $languages, $user['language'], ['class' => 'form-control']) !!}
                          </div>
                      </div>
                      @if ($errors->has('language'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('language') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group required">
                          {!! Form::label('account_active', trans('authenticated.Account Active') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!! Form::select('account_active', $account_active_options, $user['active'], ['class' => 'form-control']) !!}
                          </div>
                      </div>
                      @if ($errors->has('account_active'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('account_active') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-group required">
                          {!! Form::label('currency', trans('authenticated.List Currency') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-2">
                          {!!
                                Form::text('currency', $user['currency'],
                                    array(
                                          'readonly',
                                          'class'=>'form-control',
                                          'placeholder'=>trans('authenticated.Currency')
                                    )
                                )
                            !!}
                          </div>
                      </div>
                      @if ($errors->has('currency'))
                      <div class="row">
                          <div class="col-sm-6">
                              <span class="help-block alert alert-danger alert-dismissible fade in">
                                  <strong>{{ $errors->first('currency') }}</strong>
                              </span>
                          </div>
                      </div>
                      @endif

                      <div class="form-actions">
                          {!! Form::hidden('user_id', $user['user_id']) !!}

                          {!!
                              Form::submit( trans('authenticated.Save'),
                                  array(
                                      'name'=>'save',
                                      'class'=>'btn btn-primary'
                                  )
                              )
                          !!}
                          {!!
                              Form::submit(trans('authenticated.Cancel'),
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
        </div>
      </div>
    <div>

  </div>





    </section>
</div>
@endsection
