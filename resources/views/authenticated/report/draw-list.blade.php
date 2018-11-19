<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

    <style>
        #draw-list-report thead{
            width: 1490px;
            display: block;
            table-layout:fixed;
            padding-right: 40px;
        }
        #draw-list-report tbody{
            width: 1490px;
            display: block;
            padding-right: 25px;
            height: 65vh;
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
        $("#draw-list-report > thead > tr.bg-blue-active > th").each(function(index, value) {
            tableWidth.push(value.width);
        });

        $("#draw-list-report > tbody > tr").each(function(index, value){
            $(this).find("td").each(function(index2, value2) {
                $(this).attr("width", tableWidth[index2]);
            });
        });
    }
    $(document).ready(function() {
        var table = $('#draw-list-report').DataTable({
            "order": [],
            "ordering": false,
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
            "dom": '<"clear"><"top"l>rt<"bottom"ip><"clear">',
            stateSave: '{{ Session::get('auth.table_state_save') }}',
            stateDuration: '{{ Session::get('auth.table_state_duration') }}',
            language: {
                "lengthMenu": "Show _MENU_ entries"
            }
        });

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        $('#draw-list-report tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#draw-list-report tfoot tr').appendTo('#draw-list-report thead');

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

        document.getElementById('draw-list-report_wrapper').removeChild(
            document.getElementById('draw-list-report_wrapper').childNodes[0]
        );

        //top scrollbar
        var topScrollbar = document.getElementById('topScrollbar');
        var topScrollbar_div = document.getElementById('topScrollbar-div');
        var tableResponsive = document.getElementsByClassName('table-responsive');
        tableResponsive = tableResponsive[0];

        topScrollbar.style = "width: 320px; border: none; overflow-x: scroll; overflow-y:hidden;height: 20px;";
        topScrollbar_div.style = "width:2200px; height: 20px;";

        topScrollbar.onscroll = function() {
          tableResponsive.scrollLeft = topScrollbar.scrollLeft;
        };
        tableResponsive.onscroll = function() {
          topScrollbar.scrollLeft = tableResponsive.scrollLeft;
        };

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
            <i class="fa fa-bar-chart"></i>
            {{ __("authenticated.Draw List") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-bar-chart"></i> {{ __("authenticated.Reports") }}</li>
			<li class="active">
				<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/draw-list") }}">
				{{ __("authenticated.Draw List") }}
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
                        {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'report/draw-list'), 'method'=>'POST', 'class' => 'form-inline row-border' ]) !!}
                            {!!
                                Form::select('affiliate_id', $list_filter_users,
                                    $affiliate_id,
                                    array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Select Affiliate')
                                    )
                                )
                            !!}

                            {!!
                                Form::select('number_of_results', $number_of_results_array,
                                    $default_limit_per_page,
                                    array(
                                        'class'=>'form-control',
                                        'placeholder'=>trans('authenticated.Limit')
                                    )
                                )
                            !!}

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
                <hr>
                <div class="table-responsive">
                    <table style="width: 1490px; font-size: 11px !important;" id="draw-list-report" class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                            <tr class="bg-blue-active">
                                <th width="100">{{ __("authenticated.Draw ID") }}</th>
                                <th width="100">{{ __("authenticated.Draw SN") }}</th>
                                <th width="100">{{ __("authenticated.Draw Model") }}</th>
                                <th width="100">{{ __("authenticated.Date & Time") }}</th>
                                <th width="150">{{ __("authenticated.Tickets for Draw") }}</th>
                                <th width="150">{{ __("authenticated.Total Bet for Draw") }}</th>
                                <th width="100">{{ __("authenticated.Win for Draw") }}</th>
                                <th width="100">{{ __("authenticated.Currency") }}</th>
                                <th width="100">{{ __("authenticated.Status") }}</th>
                                <th width="150">{{ __("authenticated.Local JP Amount") }}</th>
                                <th width="150">{{ __("authenticated.Global JP Amount") }}</th>
                                <th width="150">{{ __("authenticated.Star Double Up") }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="150"></th>
                                <th width="150"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="100"></th>
                                <th width="150"></th>
                                <th width="150"></th>
                                <th width="150"></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($list_report as $report)
                            <tr>
                                <td width="100" title="{{ __("authenticated.Draw ID") }}" class="align-right">
                                    <a class="noblockui bold-text underline" href="#" onClick="window.open('{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/draw-details/draw_id/{$report->draw_id}") }}', 'draw_details_window',
                                            'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=900,height=600,top=100,left=100,resizable=yes').focus()">
                                    {{ $report->draw_id }}
                                    </a>
                                </td>
                                <td width="100" title="{{ __("authenticated.Draw SN") }}" class="align-left">
                                  {{ $report->order_num }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Draw Model") }}" class="align-left">
                                  {{ $report->draw_model }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Date & Time") }}" class="align-left">
                                  {{ $report->draw_date_time_formated }}
                                </td>
                                <td width="150" title="{{ __("authenticated.Tickets for Draw") }}" class="align-right">
                                  {{ NumberHelper::format_integer($report->number_of_tickets_for_draw) }}
                                </td>
                                <td width="150" title="{{ __("authenticated.Total Bet for Draw") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->sum_bet_for_draw) }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Win for Draw") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->sum_win_for_draw) }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Currency") }}" class="align-center">
                                  {{ $report->currency }}
                                </td>
                                <td width="100" title="{{ __("authenticated.Status") }}" class="align-center">
                                    @include('layouts.shared.draw_status',
									    ["draw_status" => $report->draw_status]
								    )
                                </td>
                                <td width="150" title="{{ __("authenticated.Local JP Amount") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->local_jp_win_amount) }}
                                </td>
                                <td width="150" title="{{ __("authenticated.Global JP Amount") }}" class="align-right">
                                  {{ NumberHelper::format_double($report->global_jp_win_amount) }}
                                </td>
                                <td width="150" title="{{ __("authenticated.Star Double Up") }}" class="align-right">
                                    {{ $report->stars }}
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
