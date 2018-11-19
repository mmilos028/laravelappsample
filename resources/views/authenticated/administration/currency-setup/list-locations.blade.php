
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.List Locations") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
            <li>{{ __("authenticated.Currency Setup") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/currency-setup/list-locations") }}" class="noblockui">
                    {{ __("authenticated.List Locations") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box table-responsive">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/currency-setup/list-locations'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
            <div class="box-body">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <td colspan="8" class="align-right">
                            {!!
                                Form::submit( trans('authenticated.Generate Report'),
                                    array(
                                        'name'=>'generate_report',
                                        'class'=>'btn btn-primary'
                                    )
                                )
                            !!}
                            </td>
                        </tr>
                        <tr class="bg-blue-active">
                            <th>{{ __("authenticated.Username") }}</th>
                            <th>{{ __("authenticated.First Name") }}</th>
                            <th>{{ __("authenticated.Last Name") }}</th>
                            <th>{{ __("authenticated.Credits") }}</th>
                            <th>{{ __("authenticated.Currency") }}</th>
                            <th>{{ __("authenticated.Email") }}</th>
                            <th>{{ __("authenticated.Account Active") }}</th>
                            <th>{{ __("authenticated.Actions") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_locations as $user)
                        <tr>
                            <td>
                                {{ $user->username }}
                            </td>
                            <td>
                                {{ $user->first_name }}
                            </td>
                            <td>
                                {{ $user->last_name }}
                            </td>
                            <td class="align-right">
                                {{ NumberHelper::format_double($user->credits) }}
                            </td>
                            <td>
                                {{ $user->currency }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                @if ($user->subject_state == 1)
                                    <span class="label label-success">{{ __("authenticated.Active") }}</span>
                                @else
                                    <span class="label label-danger">{{ __("authenticated.Inactive") }}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/currency-setup/add-currency-to-location/user_id/{$user->subject_id}") }}" title="{{ __("authenticated.Add Currency To Location") }}">
                                    <i class="fa fa-plus"></i>
                                    {{ __("authenticated.Add Currency To Location") }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            {!! Form::close() !!}
        </div>

    </section>
</div>
@endsection
