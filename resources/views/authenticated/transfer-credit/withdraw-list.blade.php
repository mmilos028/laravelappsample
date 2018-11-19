<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <script type="text/javascript">
        function calculateWidths(){
            var tableWidth = [];
            $("#credit-transfers-withdraw-list > thead > tr.bg-blue-active > th").each(function(index, value) {
                tableWidth.push(value.width);
            });


            $("#credit-transfers-withdraw-list > tbody > tr").each(function(index, value){
                $(this).find("td").each(function(index2, value2) {
                    $(this).attr("width", tableWidth[index2]);
                });
            });
        }
        $(document).ready(function() {
            var table = $('#credit-transfers-withdraw-list').DataTable(
                {
                    initComplete: function (settings, json) {
                        $("#credit-transfers-withdraw-list_length").addClass("pull-right");
                        $("#credit-transfers-withdraw-list_filter").addClass("pull-left");
                    },
                    scrollX: true,
                    scrollY: "60vh",
                    "order": [],
                    "searching": true,
                    "deferRender": true,
                    "processing": true,
                    responsive: false,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    colReorder: true,
                    "paging": true,
                    pagingType: 'simple_numbers',
                    "iDisplayLength": 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
                    lengthChange: true,
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    "dom": '<"clear"><"top"fl>rt<"bottom"ip><"clear">',
                    stateSave: '{{ Session::get('auth.table_state_save') }}',
                    stateDuration: '{{ Session::get('auth.table_state_duration') }}',
                    columns: [
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        "lengthMenu": "Show _MENU_ entries"
                    }
                }
            );

            document.getElementById('credit-transfers-withdraw-list_wrapper').removeChild(
                document.getElementById('credit-transfers-withdraw-list_wrapper').childNodes[0]
            );

            $(window).load(function(){
                calculateWidths();
            });

            $(window).resize(function(){
                calculateWidths();
            });

        } );
    </script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-minus"></i>
                {{ __("authenticated.Withdraw") }}                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-minus"></i> {{ __("authenticated.Credit Transfers") }}</li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/withdraw-list") }}" title="{{ __('authenticated.Withdraw') }}">
                        {{ __("authenticated.Withdraw") }}
                    </a>
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="box">
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <td class="pull-left">
                            </td>
                            <td class="pull-right">
                                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'transfer-credit/withdraw-list'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                                {!!
                                    Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                    array(
                                        'class'=>'btn btn-primary',
                                        'type'=>'submit',
                                        'name'=>'generate_report'
                                        )
                                    )
                                !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </table>
                    <div class="">
                        <table style="width: 100%;" id="credit-transfers-withdraw-list" class="table table-bordered table-hover table-striped pull-left">
                            <thead>
                            <tr class="bg-blue-active">
                                <th width="100">{{ __("authenticated.Username") }}</th>
                                <th width="100">{{ __("authenticated.User Type") }}</th>
                                <th width="100">{{ __("authenticated.Parent Path") }}</th>
                                <th width="100">{{ __("authenticated.Credits") }}</th>
                                <th width="100">{{ __("authenticated.Currency") }}</th>
                                <th width="100">{{ __("authenticated.Status") }}</th>
                                <th width="100">{{ __("authenticated.Actions") }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list_users as $user)
                                @php
                                    $subject_type = $user->subject_dtype;
                                    $authSessionData = Session::get('auth');
                                    $logged_in_subject_dtype = $authSessionData['subject_dtype'];
                                @endphp
                                <tr>
                                    <td width="100" title="{{ __("authenticated.Username") }}">
                                        @if ($user->credits > 0)
                                            @if($subject_type == config('constants.COLLECTOR_TYPE_NAME'))
                                                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-orange btn-block">
                                                {{$user->username}}
                                                </a>
                                            @elseif($subject_type == config('constants.ROLE_ADMINISTRATOR'))
                                                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red btn-block">
                                                {{$user->username}}
                                                </a>
                                            @elseif($subject_type == config('constants.ADMINISTRATOR_SYSTEM'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red btn-block">
                                                    {{$user->username}}
                                                    </a>
                                                @endif
                                            @elseif($subject_type == config('constants.ADMINISTRATOR_CLIENT'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red btn-block">
                                                    {{$user->username}}
                                                    </a>
                                                @endif
                                            @elseif($subject_type == config('constants.ADMINISTRATOR_LOCATION'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red btn-block">
                                                    {{$user->username}}
                                                    </a>
                                                @endif
                                            @elseif($subject_type == config('constants.ADMINISTRATOR_OPERATER'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red btn-block">
                                                    {{$user->username}}
                                                    </a>
                                                @endif
                                            @elseif($subject_type == config('constants.ROLE_CASHIER') || $subject_type == config('constants.SHIFT_CASHIER'))
                                                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red btn-block">
                                                    {{$user->username}}
                                                </a>
                                            @elseif($subject_type == config('constants.ROLE_PLAYER'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))
                                                    {{$user->username}}
                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-pink btn-block">
                                                        {{$user->username}}
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            {{$user->username}}
                                        @endif
                                    </td>
                                    <td width="100" title="{{ __("authenticated.User Type") }}">
                                        <span>
                                        {{ $user->subject_dtype_bo_name }}
                                        </span>
                                    </td>
                                    <td width="100" title="{{ __("authenticated.Parent Path") }}">
                                        <span>
                                        {{ $user->subject_path }}
                                        </span>
                                    </td>
                                    <td width="100" title="{{ __("authenticated.Credits") }}" class="align-right">
                                        <span>
                                        {{ NumberHelper::format_double($user->credits) }}
                                        </span>
                                    </td>
                                    <td width="100" title="{{ __("authenticated.Currency") }}">
                                        <span>
                                        {{ $user->currency }}
                                        </span>
                                    </td>
                                    <td width="100" class="align-center" title="{{ __("authenticated.Status") }}">
                                        @include('layouts.shared.account_status',
                                          ["account_status" => $user->subject_state]
                                        )
                                    </td>
                                    <td width="100" title="{{ __("authenticated.Withdraw") }}">
                                        @if ($user->credits > 0)
                                            @if($subject_type == config('constants.COLLECTOR_TYPE_NAME'))
                                                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-orange">
                                                    {{ __("authenticated.Withdraw") }}
                                                </a>
                                            @elseif($subject_type == config('constants.ROLE_ADMINISTRATOR'))
                                                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red">
                                                    {{ __("authenticated.Withdraw") }}
                                                </a>
                                            @elseif($subject_type == config('constants.ADMINISTRATOR_SYSTEM'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red">
                                                        {{ __("authenticated.Withdraw") }}
                                                    </a>
                                                @endif
                                            @elseif($subject_type == config('constants.ADMINISTRATOR_CLIENT'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red">
                                                        {{ __("authenticated.Withdraw") }}
                                                    </a>
                                                @endif
                                            @elseif($subject_type == config('constants.ADMINISTRATOR_LOCATION'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red">
                                                        {{ __("authenticated.Withdraw") }}
                                                    </a>
                                                @endif
                                            @elseif($subject_type == config('constants.ADMINISTRATOR_OPERATER'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red">
                                                        {{ __("authenticated.Withdraw") }}
                                                    </a>
                                                @endif
                                            @elseif($subject_type == config('constants.ROLE_CASHIER') || $subject_type == config('constants.SHIFT_CASHIER'))
                                                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-red">
                                                    {{ __("authenticated.Withdraw") }}
                                                </a>
                                            @elseif($subject_type == config('constants.ROLE_PLAYER'))
                                                @if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME"))

                                                @else
                                                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}") }}" class="btn btn-pink">
                                                        {{ __("authenticated.Withdraw") }}
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
