

<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#list-report').DataTable(
            {
                //responsive: true,
                paging: false,
                //lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                //autoWidth: true,
                colReorder: true,
                stateSave: '{{ Session::get('auth.table_state_save') }}',
                stateDuration: '{{ Session::get('auth.table_state_duration') }}'
            }
        );

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        $('#list-report tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#list-report tfoot tr').appendTo('#list-report thead');

        table.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        document.getElementById('list-report_wrapper').removeChild(
            document.getElementById('list-report_wrapper').childNodes[0]
        );

        var topScrollbar = document.getElementById('topScrollbar');
        var topScrollbar_div = document.getElementById('topScrollbar-div');
        var tableResponsive = document.getElementsByClassName('table-responsive');
        tableResponsive = tableResponsive[0];

        topScrollbar.style = "width: 320px; border: none; overflow-x: scroll; overflow-y:hidden;height: 20px;";
        topScrollbar_div.style = "width:1600px; height: 20px;";

        topScrollbar.onscroll = function() {
          tableResponsive.scrollLeft = topScrollbar.scrollLeft;
        };
        tableResponsive.onscroll = function() {
          topScrollbar.scrollLeft = tableResponsive.scrollLeft;
        };

    } );
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.Daily Report") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Reports") }}</li>
            <li class="active">{{ __("authenticated.Daily Report") }}</li>
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
                        {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'report/daily-report'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
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
                <div id="topScrollbar">
					<div id="topScrollbar-div">
					</div>
				</div>
                <div class="table-responsive">
                    <table style="width: 2200px;" id="list-report" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr class="bg-blue-active">
                                <th width="200">{{ __("authenticated.Start Credits") }}</th>
                                <th width="200">{{ __("authenticated.No of Deposits") }}</th>
                                <th width="200">{{ __("authenticated.No of Deactivated Tickets") }}</th>
                                <th width="200">{{ __("authenticated.No of Online Deposits") }}</th>
                                <th width="200">{{ __("authenticated.No of Cashier Deposits") }}</th>
                                <th width="200">{{ __("authenticated.Sum of Canceled Deposits") }}</th>
                                <th width="200">{{ __("authenticated.Sum of Deposits") }}</th>
                                <th width="200">{{ __("authenticated.Sum of Cashier Deposits") }}</th>
                                <th width="200">{{ __("authenticated.No of Payed Out Tickets") }}</th>
                                <th width="200">{{ __("authenticated.No of Not Payed Out Tickets") }}</th>
                                <th width="200">{{ __("authenticated.End Credits") }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($list_report as $report)
                            <tr>
                                <td title="{{ __("authenticated.Start Credits") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->start_credits) }}
                                </td>
                                <td title="{{ __("authenticated.No of Deposits") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->no_of_deposits) }}
                                </td>
                                <td title="{{ __("authenticated.No of Deactivated Tickets") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->no_of_deactivated_tickets) }}
                                </td>
                                <td title="{{ __("authenticated.No of Online Deposits") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->no_of_online_deposits) }}
                                </td>
                                <td title="{{ __("authenticated.No of Cashier Deposits") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->no_of_cashier_deposits) }}
                                </td>
                                <td title="{{ __("authenticated.Sum of Canceled Deposits") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->sum_of_canceled_deposits) }}
                                </td>
                                <td title="{{ __("authenticated.Sum of Deposits") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->sum_deposits) }}
                                </td>
                                <td title="{{ __("authenticated.Sum of Cashier Deposits") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->sum_cashier_deposits) }}
                                </td>
                                <td title="{{ __("authenticated.No of Payed Out Tickets") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->no_of_payed_out_tickets) }}
                                </td>
                                <td title="{{ __("authenticated.No of Not Payed Out Tickets") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->no_of_not_payed_out_tickets) }}
                                </td>
                                <td title="{{ __("authenticated.End Credits") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->end_credits) }}
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
