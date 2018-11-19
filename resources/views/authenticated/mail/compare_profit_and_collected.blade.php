@extends('layouts/desktop_layout.mail_layout')

@section('content')
    <style>
        .content-wrapper{
            padding-top: 0px !important;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1 align="center">
                <i class="fa fa-calendar-check-o"></i>
                Profit And Collected Comparison
                <br>
                {{$start_date}} - {{$end_date}}&nbsp;
            </h1>
        </section>
        <section class="content" style="overflow-y: scroll !important; height: 500px !important;">
            <div class="box">
                <div class="box-header">
                    <h3>With Profit Transactions Report <small>(comparing Profit For Period with Netto)</small>
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                        <tr class="bg-blue-active">
                            <th width="100">{{ __("authenticated.Username") }}</th>
                            <th width="100">{{ __("authenticated.Profit For Period") }}</th>
                            <th width="100">{{ __("authenticated.Netto") }}</th>
                            <th width="100">True Netto</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($profit_transactions as $row)
                            <tr>
                                <td width="100" class="align-left">
                                    {{$row["profit_and_collected"]->child_name}}
                                </td>
                                <td width="100" class="align-left">
                                    {{$row["profit_and_collected"]->profit_for_period}}
                                </td>
                                <td width="100" class="align-left">
                                    {{$row["profit_transactions"]["netto"]}}
                                </td>
                                <td width="100" class="align-left">
                                    {{$row["profit_transactions"]["true_netto"]}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            <div class="box">
                <div class="box-header">
                    <h3>With Collector Transactions Report <small>(comparing Collected On Entity Level with Total Collected)</small></h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                        <tr class="bg-blue-active">
                            <th width="100">{{ __("authenticated.Username") }}</th>
                            <th width="100">{{ __("authenticated.Collected On Entity Level") }}</th>
                            <th width="100">{{ __("authenticated.Total Collected") }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($collector_transactions as $row)
                            <tr>
                                <td width="100" class="align-left">
                                    {{$row["profit_and_collected"]->child_name}}
                                </td>
                                <td width="100" class="align-left">
                                    {{$row["profit_and_collected"]->collected}}
                                </td>
                                <td width="100" class="align-left">
                                    {{$row["collector_transactions"]->total_collected}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3>With Cashier Shift Report <small>(comparing Actual Balance with End Balance)</small></h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped pull-left">
                                <thead>
                                <tr class="bg-blue-active">
                                    <th width="100">{{ __("authenticated.Username") }}</th>
                                    <th width="100">{{ __("authenticated.Actual Balance") }}</th>
                                    <th width="100">{{ __("authenticated.End Balance") }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cashier_shift_report["calculated"] as $row)
                                    <tr>
                                        <td width="100" class="align-left">
                                            {{$row["profit_and_collected"]->child_name}}
                                        </td>
                                        <td width="100" class="align-left">
                                            {{$row["profit_and_collected"]->actual_credits}}
                                        </td>
                                        <td width="100" class="align-left">
                                            {{$row["cashier_shift_report"]->end_balance}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3><small>Cashiers With Active Sessions (not taken into account)</small></h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-hover table-striped pull-left">
                                <thead>
                                <tr class="bg-blue-active">
                                    <th width="100">{{ __("authenticated.Username") }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cashier_shift_report["non_calculated"] as $row)
                                    <tr>
                                        <td width="100" class="align-left">
                                            {{$row["profit_and_collected"]->child_name}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

