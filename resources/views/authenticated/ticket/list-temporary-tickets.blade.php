
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
$(document).ready(function() {	
   
    $("#generate_report").attr("disabled", "disabled").addClass('disabled'); //set button disabled as default

    var table = $('#list-temporary-tickets').DataTable(
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

    $('#list-temporary-tickets tfoot th').each( function (index, value) {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
    } );

    $('#list-temporary-tickets tfoot tr').appendTo('#list-temporary-tickets thead');

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

    document.getElementById('list-temporary-tickets_wrapper').removeChild(
        document.getElementById('list-temporary-tickets_wrapper').childNodes[0]
    );

});
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-search"></i>
            {{ __("authenticated.Search Temporary Tickets") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-search"></i> {{ __("authenticated.Ticket") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/list-temporary-tickets") }}" title="{{ __('authenticated.List Temporary Tickets') }}">
                    {{ __("authenticated.Search Temporary Tickets") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'ticket/list-temporary-tickets'), 'method'=>'POST', 'class' => 'form-inline row-border' ]) !!}
            <div class="box-body table-responsive">
				
                <table id="list-temporary-tickets" style="width: 1400px;" class="table table-bordered table-hover table-striped pull-left">
                    <thead>
						<tr>
							<td class="align-right" colspan="8">
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
                        <tr class="bg-blue-active">
                            <th width="150">{{ __("authenticated.Temp Ticket ID") }}</th>
                            <th width="150">{{ __("authenticated.Temp Order Number") }}</th>
                            <th width="150">{{ __("authenticated.Creation Time") }}</th>
                            <th width="150">{{ __("authenticated.Expiration Time") }}</th>
                            <th width="150">{{ __("authenticated.Total Bet") }}</th>
                            <th width="150">{{ __("authenticated.Temp Serial Number") }}</th>
                            <th width="150">{{ __("authenticated.Is Valid") }}</th>
							<th width="350">{{ __("authenticated.Actions") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_tickets as $ticket)
                        <tr>
                            <td class="align-right">
                                {{ $ticket->temp_ticket_id }}
                            </td>
                            <td class="align-right">
                                {{ $ticket->temp_order_number }}
                            </td>

                            <td class="align-left">
                                {{ DateTimeHelper::returnDateTimeFormatted($ticket->creation_time) }}
                            </td>
                            <td class="align-right">
                                {{ DateTimeHelper::returnDateTimeFormatted($ticket->expiration_time) }}
                            </td>

                            <td class="align-right">
                                {{ $ticket->total_bet }}
                            </td>
                            <td class="align-right">
                                {{ $ticket->temp_serial_number }}
                            </td>
							<td class="align-right">
                                {{ $ticket->is_valid }}
                            </td>
                            <td class="align-left">
                                <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/temporary-to-real/ticket_id/{$ticket->temp_ticket_id}") }}" title="{{ __("authenticated.Temporary To Real") }}">
                                    <i class="fa fa-ticket-alt"></i>
                                    {{ __("authenticated.Temporary To Real") }}
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
