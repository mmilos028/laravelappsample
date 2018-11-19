
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("page_title.Account Details") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> {{ __("menu.Terminals") }}</li>
            <li>
            <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/terminal/list-terminals') }}" title="{{ __('menu.List Terminals') }}">
                {{ __("menu.List Terminals") }}
            </a>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/do-terminal-details-update/terminal_id/{$user['user_id']}") }}" title="{{ __('page_title.Account Details') }}">
                    {{ __("page_title.Account Details") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

      <div class="tabbable tabbable-custom">
        <ul class="nav nav-tabs">
        <li <?php if($active_tab == 1)echo 'class="active"'; ?>>
          <a href="#tab_1_1" class="noblockui" data-toggle="tab">{{ __('authenticated/terminal/translation.Account Details') }}</a>
        </li>
        <li <?php if($active_tab == 2)echo 'class="active"'; ?>>
          <a href="#tab_1_2" class="noblockui" data-toggle="tab">{{ __('authenticated/terminal/translation.Update Terminal') }}</a>
        </li>


        <div class="tab-content">
          <div class="tab-pane <?php if($active_tab == 1)echo 'active'; ?>" id="tab_1_1">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-5">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-user"></i> {{ __('authenticated/terminal/translation.Account Details') }}</h4>
                      <span class="pull-right">
                        <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/change-password/terminal_id/{$user['user_id']}") }}">
                          <button class="btn btn-sm btn-info">
                            <i class="fa fa-key"></i>
                            {{ __("authenticated/terminal/translation.Change Password") }}
                          </button>
                        </a>
                      </span>
                    </div>
                    <div class="widget-content">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td>
                              <span class="bold-text">{{ __('authenticated/terminal/translation.Username') }}</span>
                            </td>
                            <td>
                              <span class="bold-text red-caption-text"> {{ $user['username'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.First Name') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['first_name'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.Last Name') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['last_name'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.Country') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['country_name'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.City') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['city'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.Post Code') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['post_code'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.Address') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['address'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.Mobile Phone') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['mobile_phone'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>{{ __('authenticated/terminal/translation.Email') }}</td>
                            <td style="padding:3px 0 0 5px;">
                              <span> {{ $user['email'] }}</span>
                              <a href="mailto:{{ $user['email'] }}" class="btn btn-sm btn-success">
                                <i class="fa fa-envelope"></i>
                                {{ __('authenticated/terminal/translation.Email') }}
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
                      <h4><i class="fa fa-wrench"></i> {{ __('authenticated/terminal/translation.Details') }}</h4>
                    </div>
                    <div class="widget-content">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.Language') }}</span>
                            </td>
                            <td>
                              <span> {{ $user['language'] }}</span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>{{ __('authenticated/terminal/translation.Account Active') }}</span>
                            </td>
                            <td>
                              @if ($user['active'] == 1)
                                  <span class="label label-success">{{ __("authenticated/forms/translation.Active") }}</span>
                              @else
                                  <span class="label label-danger">{{ __("authenticated/forms/translation.Inactive") }}</span>
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
                          <span>{{ __("page_title.Update Terminal") }}</span>
                      </h4>
                  </div>
                  <div class="widget-content">
                  {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "terminal/do-terminal-details-update/terminal_id/{$user['user_id']}" ), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                      @include('layouts.shared.form_messages')

                      <div class="form-group required">

                      {!! Form::label('username', trans('authenticated/terminal/translation.Username') . ':', array('class' => 'col-md-3 control-label')) !!}
                      <div class="col-md-4">
                          {!!
                              Form::text('username', $user['username'],
                                  array(
                                        'readonly',
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/terminal/translation.Username')
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
                          {!! Form::label('mobile_phone', trans('authenticated/terminal/translation.Mobile Phone') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('mobile_phone', $user['mobile_phone'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/terminal/translation.Mobile Phone')
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
                          {!! Form::label('email', trans('authenticated/my_account/translation.Email') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('email', $user['email'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/my_account/translation.Email')
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
                          {!! Form::label('first_name', trans('authenticated/terminal/translation.First Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('first_name', $user['first_name'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/terminal/translation.First Name')
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
                          {!! Form::label('last_name', trans('authenticated/terminal/translation.Last Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('last_name', $user['last_name'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/terminal/translation.Last Name')
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
                          {!! Form::label('address', trans('authenticated/user/translation.Address') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('address', $user['address'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/user/translation.Address')
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
                          {!! Form::label('post_code', trans('authenticated/terminal/translation.Post Code') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('post_code', $user['post_code'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/terminal/translation.Post Code')
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
                          {!! Form::label('city', trans('authenticated/user/translation.City') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::text('city', $user['city'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/user/translation.City')
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
                          {!! Form::label('country', trans('authenticated/user/translation.Country') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-4">
                          {!!
                              Form::select('country', $list_countries, $user['country_code'],
                                  array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated/user/translation.Country')
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
                          {!! Form::label('language', trans('authenticated/terminal/translation.Language') . ':', array('class' => 'col-md-3 control-label')) !!}
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
                          {!! Form::label('account_active', trans('authenticated/terminal/translation.Account Active') . ':', array('class' => 'col-md-3 control-label')) !!}
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
                          {!! Form::label('currency', trans('authenticated/terminal/translation.List Currency') . ':', array('class' => 'col-md-3 control-label')) !!}
                          <div class="col-md-2">
                          {!! Form::select('currency', $list_currency, null, ['class' => 'form-control']) !!}
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
                          {!! Form::hidden('terminal_id', $user['user_id']) !!}

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
        </div>
      </div>
    <div>

  </div>





    </section>
</div>
@endsection
