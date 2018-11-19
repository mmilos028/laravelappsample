
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<script type="text/javascript">
    function calculateWidths(){
        var tableWidth = [];
        $("#list-terminals > thead > tr.bg-blue-active > th").each(function(index, value) {
            tableWidth.push(value.width);
        });

        $("#list-terminals > tbody > tr").each(function(index, value){
            $(this).find("td").each(function(index2, value2) {
                $(this).attr("width", tableWidth[index2]);
            });
        });
    }
    $(document).ready(function() {
        var table = $('#list-terminals').DataTable({
            initComplete: function (settings, json) {
                $("#list-terminals_length").addClass("pull-right");
                $("#list-terminals_filter").addClass("pull-left");
            },
            scrollX: true,
            scrollY: "60vh",
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
        });

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        document.getElementById('list-terminals_wrapper').removeChild(
            document.getElementById('list-terminals_wrapper').childNodes[0]
        );

        $(window).load(function(){
            calculateWidths();
        });

        $(window).resize(function(){
            calculateWidths();
        });

    } );
</script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-list"></i>
            {{ __("authenticated.List Terminals") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> {{ __("authenticated.Users") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/list-terminals") }}" title="{{ __('authenticated.List Terminals') }}">
                    {{ __("authenticated.List Terminals") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-right">
                        {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'terminal/list-terminals'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                            {!!
                                Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                array(
                                    'class'=>'btn btn-primary pull-left',
                                    'type'=>'submit',
                                    'name'=>'generate_report'
                                    )
                                )
                            !!}
                        {!! Form::close() !!}
                        </td>
                        <td class="pull-right">
                            @if(!env('HIDE_EXPORT_TO_EXCEL'))
                            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'terminal/list-terminals-excel'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                                <button type="submit" class="btn btn-primary" name="export_to_excel" title="{{ __("authenticated.Export To Excel") }}" value="export_to_excel">
                                    <i class="fa fa-file-excel-o"></i>
                                    {{ __("authenticated.Export To Excel") }}
                                </button>
                            {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="">
                    <table style="width: 100%;" id="list-terminals" class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                            <tr class="bg-blue-active">
                                <th width="100">{{ __("authenticated.Username") }}</th>
                                <th width="100">{{ __("authenticated.User Type") }}</th>
                                <th width="100">{{ __("authenticated.Location") }}</th>
                                <th width="100">{{ __("authenticated.City") }}</th>
                                <th width="100">{{ __("authenticated.Credits") }}</th>
                                <th width="100">{{ __("authenticated.Currency") }}</th>
                                <th width="100">{{ __("authenticated.Status") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_terminals as $player)
                                @php
                                //dd($player)
                                @endphp
                            <tr>
                                <td width="100">
                                  <a class="underline-text bold-text" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/details/user_id/{$player->subject_id}/{$player->subject_dtype}") }}" title="{{ __("authenticated.Update") }}">
                                      {{ $player->username }}
                                  </a>
                                </td>
                                <td width="100">
                                    {{ $player->subject_dtype_bo_name }}
                                </td>
                                <td width="100">
                                    {{ $player->parent_name }}
                                </td>
                                <td width="100">
                                    {{ $player->city }}
                                </td>

                                <td width="100" class="align-right">
                                    {{ NumberHelper::format_double($player->credits) }}
                                </td>
                                <td width="100">
                                    {{ $player->currency }}
                                </td>
                                <td width="100" class="align-center" title="{{ __("authenticated.Account Status") }}">
                                  <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/change-user-account-status/user_id/{$player->subject_id}") }}" title="{{ __("authenticated.Change Account Status") }}">
                                  @include('layouts.shared.account_status',
                                    ["account_status" => $player->subject_state]
                                  )
                                  </a>
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
