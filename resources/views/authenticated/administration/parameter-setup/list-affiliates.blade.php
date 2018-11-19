
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#list-affiliates-for-parameter-setup').DataTable(
            {
                responsive: true,
                paging: false,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: false,
                autoWidth: true,
                colReorder: true,
                scrollY: '70vh',
                /*stateSave: '{{ Session::get('auth.table_state_save') }}',
                stateDuration: '{{ Session::get('auth.table_state_duration') }}'*/
            }
        );

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        $('#list-affiliates-for-parameter-setup tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#list-affiliates-for-parameter-setup tfoot tr').appendTo('#list-affiliates-for-parameter-setup thead');

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

        document.getElementById('list-affiliates-for-parameter-setup_wrapper').removeChild(
            document.getElementById('list-affiliates-for-parameter-setup_wrapper').childNodes[0]
        );

    } );
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("Affiliates - Parameter Setup") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
            <li>{{ __("authenticated.Parameter Setup") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/affiliate-parameter-setup/list-affiliates") }}">
                    {{ __("Entity List") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box table-responsive">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/affiliate-parameter-setup/list-affiliates'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-right">
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
                </table>
                <table id="list-affiliates-for-parameter-setup" class="table table-bordered table-hover table-striped" style="width: 700px !important;">
                    <thead>
                        <tr class="bg-blue-active">
                            <th>{{ __("authenticated.Username") }}</th>
                            <th>{{ __("Entity Type") }}</th>
                            <th>{{ __("Subject Path") }}</th>
                            <!--<th>{{ __("authenticated.Credits") }}</th>-->
                            <th>{{ __("authenticated.Currency") }}</th>
                            <!--<th>{{ __("authenticated.Email") }}</th>-->
                            <th>{{ __("authenticated.Account Active") }}</th>
                            <th>{{ __("authenticated.Actions") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_affiliates as $user)
                        <tr>
                            <td>
                                {{ $user->username }}
                            </td>
                            <td>
                                {{ $user->subject_dtype_bo_name }}
                            </td>
                            <td>
                                {{ $user->subject_path }}
                            </td>
                            <!--<td class="align-right">
                                {{ NumberHelper::format_double($user->credits) }}
                            </td>-->
                            <td>
                                {{ $user->currency }}
                            </td>
                            <!--<td>
                                {{ $user->email }}
                            </td>-->
                            <td>
                                @if ($user->subject_state == 1)
                                    <span class="label label-success">{{ __("authenticated.Active") }}</span>
                                @else
                                    <span class="label label-danger">{{ __("authenticated.Inactive") }}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/affiliate-parameter-setup/parameter-setup/user_id/{$user->subject_id}") }}" title="{{ __("authenticated.Parameter Setup") }}">
                                    <i class="fa fa-wrench"></i>
                                    {{ __("authenticated.Parameter Setup") }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>

    </section>
</div>
@endsection
