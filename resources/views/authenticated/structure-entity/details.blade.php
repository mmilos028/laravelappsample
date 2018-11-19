
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
      @include('layouts.desktop_layout.header_navigation_second')
        <h1>
            <i class="fa fa-user"></i>
            {{ __("authenticated.Account Details") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> {{ __("authenticated.Structure Entity") }}</li>
            <li>
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/structure-entity/search-entity') }}" title="{{ __('authenticated.Search Entity') }}">
                    {{ __("authenticated.Search Entity") }}
                </a>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/details/user_id/{$user['user_id']}") }}" title="{{ __('authenticated.Account Details') }}">
                    {{ __("authenticated.Account Details") }}
                </a>
            </li>
        </ol>
    </section>

  @php
  //dd($user)
  @endphp

    <section class="content">

      <div class="col-md-12">
        <div class="row">
          <div class="col-md-5">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-user"></i> {{ __('authenticated.Account Details') }}</h4>
                <span class="pull-right">
                  <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/change-password/user_id/{$user['user_id']}") }}">
                    <button class="btn btn-sm btn-primary">
                      <i class="fa fa-key"></i>
                      {{ __("authenticated.Change Password") }}
                    </button>
                  </a>
                </span>
              </div>
              <div class="widget-content">
                @php
                  //dd($user);
                @endphp
                <table class="table table-striped table-bordered table-highlight-head">
                  <tbody>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Username') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['username'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Role') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['subject_dtype_bo_name'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Parent') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['parent_username'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Mobile Phone') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['mobile_phone'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">
                          {{ __('authenticated.Email') }}
                        </span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['email'] }}</span>
                        @if(strlen($user['email']) != 0)
                        <span class="pull-right">
                          <a href="mailto:{{ $user['email'] }}" class="btn btn-sm btn-primary noblockui">
                            <i class="fa fa-envelope"></i>
                            {{ __('authenticated.Email') }}
                          </a>
                        </span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.First Name') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['first_name'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Last Name') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['last_name'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Address') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['address'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Address 2') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['commercial_address'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Post Code') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['post_code'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.City') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['city'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Country') }}</span>
                      </td>
                      <td>
                        <span class="bold-text"> {{ $user['country_name'] }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Language') }}</span>
                      </td>
                      <td>
                        <span class="bold-text">
                           @include('layouts.shared.language',
                            ["language" => $user['language']]
                            )
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Account Active') }}</span>
                      </td>
                      <td>
                          @if ($user['active'] == 1)
                              <span class="label label-success">{{ __("authenticated.Active") }}</span>
                          @else
                              <span class="label label-danger">{{ __("authenticated.Inactive") }}</span>
                          @endif
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Currency') }}</span>
                      </td>
                      <td>
                          <span class="bold-text">
                            {{ $user['currency'] }}
                          </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Account Balance') }}</span>
                      </td>
                      <td>
                        <span class="width-120 text-left bold-text">
                          {{ NumberHelper::format_double($user['credits']) }}
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Account Created') }}</span>
                      </td>
                      <td>
                        <span class="bold-text">
                          {{ $user['registration_date'] }}
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Account Created By') }}</span>
                      </td>
                      <td>
                        <span class="bold-text">
                          {{ $user['created_by'] }}
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">{{ __('authenticated.Last Activity') }}</span>
                      </td>
                      <td>
                        <span class="bold-text">
                          {{ $user['last_activity'] }}
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
</div>
@endsection
