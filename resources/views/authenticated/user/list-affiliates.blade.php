
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#list-affiliates').DataTable(
            {
                responsive: true,
                paging: false,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: false,
                autoWidth: true,
                colReorder: true,
                stateSave: '{{ Config::get('constants.TABLE_STATE_SAVE') }}',
                stateDuration: '{{ Config::get('constants.TABLE_STATE_DURATION') }}'
            }
        );

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        $('#list-affiliates tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#list-affiliates tfoot tr').appendTo('#list-affiliates thead');

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

        document.getElementById('list-affiliates_wrapper').removeChild(
            document.getElementById('list-affiliates_wrapper').childNodes[0]
        );

    } );
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.List Affiliates") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> {{ __("authenticated.Users") }}</li>
            <li class="active">{{ __("authenticated.List Affiliates") }}</li>
        </ol>
    </section>

    <section class="content">

        <div class="box table-responsive">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'user/list-affiliates'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
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
                <table id="list-affiliates" class="table table-bordered table-hover table-striped">
                    <thead>
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
                        @foreach ($list_affiliates as $user)
                        <tr>
                            <td>
                                {{ isset($user->username) ? $user->username : '' }}
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
                                <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/update-user/user_id/{$user->subject_id}") }}" title="{{ __("authenticated.Update") }}">
                                    <i class="fa fa-pencil"></i>
                                    {{ __("authenticated.Update") }}
                                </a>
                                &nbsp;
                                <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/change-password/user_id/{$user->subject_id}") }}" title="{{ __("authenticated.Change Password") }}">
                                    <i class="fa fa-key"></i>
                                    {{ __("authenticated.Change Password") }}
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
