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
                Profit Overview Comparison
                <br>
                {{$start_date}} - {{$end_date}}&nbsp;
            </h1>
        </section>
        <section class="content" style="overflow-y: scroll !important; height: 500px !important;">
            <div class="box">
                <div class="box-header">
                    <h3>With Profit Transactions Report <small>(comparing Difference with Netto)</small>
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                        <tr class="bg-blue-active">
                            <th width="100">{{ __("authenticated.Username") }}</th>
                            <th width="100">{{ __("authenticated.Difference") }}</th>
                            <th width="100">{{ __("authenticated.Netto") }}</th>
                            <th width="100">True Netto</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($profit_transactions as $row)
                            <tr>
                                <td width="100" class="align-left">
                                    {{$row["profit_overview"]->aff_name}}
                                </td>
                                <td width="100" class="align-left">
                                    {{$row["profit_overview"]->difference}}
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
        </section>
    </div>
@endsection

