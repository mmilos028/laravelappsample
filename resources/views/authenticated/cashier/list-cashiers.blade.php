
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

    <style>
        #list-cashiers thead{
            width: 1050px;
            display: block;
            table-layout:fixed;
            padding-right: 40px;
        }
        #list-cashiers tbody{
            width: 1050px;
            display: block;
            padding-right: 25px;
            height: 50vh;
            overflow-y: scroll;
            overflow-x: hidden;
            -ms-overflow-y: scroll;
            -ms-overflow-x: hidden;
        }

        table.dataTable thead th {
            padding: 8px 10px;
        }
    </style>

<script type="text/javascript">
    function calculateWidths(){
        var tableWidth = [];
        $("#list-cashiers > thead > tr.bg-blue-active > th").each(function(index, value) {
            tableWidth.push(value.width);
        });

        $("#list-cashiers > tbody > tr").each(function(index, value){
            $(this).find("td").each(function(index2, value2) {
                $(this).attr("width", tableWidth[index2]);
            });
        });
    }
    $(document).ready(function() {
        var table = $('#list-cashiers').DataTable(
            {
                initComplete: function (settings, json) {
                    $("#list-cashiers_length").addClass("pull-right");
                    $("#list-cashiers_filter").addClass("pull-left");
                },
                "order": [],
                "ordering": true,
                "searching": true,
                "deferRender": true,
                "processing": true,
                responsive: false,
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
                language: {
                    "lengthMenu": "Show _MENU_ entries"
                }
            }
        );

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

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
            <i class="fa fa-list"></i>
            {{ __("authenticated.List Cashiers") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> {{ __("authenticated.Users") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/cashier/list-cashiers') }}" title="{{ __('authenticated.List Cashiers') }}">
                    {{ __("authenticated.List Cashiers") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'cashier/list-cashiers'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-right">
                            {!!
                                Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                array(
                                    'class'=>'btn btn-primary',
                                    'type'=>'submit',
                                    'name'=>'generate_report'
                                    )
                                )
                            !!}
                        </td>
                    </tr>
                </table>
                <div class="table-responsive">
                    <table style="width: 100%;" id="list-cashiers" class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                            <tr class="bg-blue-active">
                                <th width="200">{{ __("authenticated.Username") }}</th>
                                <th width="150">{{ __("authenticated.First Name") }}</th>
                                <th width="150">{{ __("authenticated.Last Name") }}</th>
                                <th width="150">{{ __("authenticated.Credits") }}</th>
                                <th width="100">{{ __("authenticated.Currency") }}</th>
                                <th width="200">{{ __("authenticated.Email") }}</th>
                                <th width="100">{{ __("authenticated.Account Active") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_cashiers as $user)
                                @php
                                //dd($user)
                                @endphp
                            <tr>
                                <td width="200">
                                    <a class="underline-text bold-text" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/details/user_id/{$user->subject_id}/{$user->subject_dtype}") }}" title="{{ __("authenticated.Account Details") }}">
                                      {{ isset($user->username) ? $user->username : '' }}
                                    </a>
                                </td>
                                <td width="150">
                                    {{ $user->first_name }}
                                </td>
                                <td width="150">
                                    {{ $user->last_name }}
                                </td>
                                <td width="150" class="align-right">
                                    {{ NumberHelper::format_double($user->credits) }}
                                </td>
                                <td width="100">
                                    {{ $user->currency }}
                                </td>
                                <td width="200">
                                    {{ $user->email }}
                                </td>
                                <td width="100" class="align-center">
                                  <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/change-user-account-status/user_id/{$user->subject_id}") }}" title="{{ __("authenticated.Change Account Status") }}">
                                  @include('layouts.shared.account_status',
                                    ["account_status" => $user->subject_state]
                                  )
                                  </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </section>
</div>
@endsection
