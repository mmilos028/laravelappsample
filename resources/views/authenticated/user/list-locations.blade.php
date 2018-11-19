
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#list-locations').DataTable(
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

        $('#list-locations tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#list-locations tfoot tr').appendTo('#list-locations thead');

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

        document.getElementById('list-locations_wrapper').removeChild(
            document.getElementById('list-locations_wrapper').childNodes[0]
        );

    } );
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("page_title.List Locations") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> {{ __("menu.Users") }}</li>
            <li class="active">{{ __("page_title.List Locations") }}</li>
        </ol>
    </section>

    <section class="content">

        <div class="box table-responsive">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'user/list-locations'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-right">
                        {!!
                            Form::submit( trans('authenticated/forms/translation.Generate Report'),
                                array(
                                    'name'=>'generate_report',
                                    'class'=>'btn btn-primary'
                                )
                            )
                        !!}
                        </td>
                    </tr>
                </table>
                <table id="list-locations" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="bg-blue-active">
                            <th>{{ __("authenticated/user/translation.Username") }}</th>
                            <th>{{ __("authenticated/user/translation.First Name") }}</th>
                            <th>{{ __("authenticated/user/translation.Last Name") }}</th>
                            <th>{{ __("authenticated/user/translation.Credits") }}</th>
                            <th>{{ __("authenticated/user/translation.Currency") }}</th>
                            <th>{{ __("authenticated/user/translation.Email") }}</th>
                            <th>{{ __("authenticated/user/translation.Account Active") }}</th>
                            <th>{{ __("authenticated/forms/translation.Actions") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_locations as $user)
                        <tr>
                            <td>
                                {{ $user->username }}
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
                                    <span class="label label-success">{{ __("authenticated/forms/translation.Active") }}</span>
                                @else
                                    <span class="label label-danger">{{ __("authenticated/forms/translation.Inactive") }}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/update-user/user_id/{$user->subject_id}") }}" title="{{ __("authenticated/user/translation.Update") }}">
                                    <i class="fa fa-pencil"></i>
                                    {{ __("authenticated/forms/translation.Update") }}
                                </a>
                                &nbsp;
                                <a class="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/change-password/user_id/{$user->subject_id}") }}" title="{{ __("authenticated/user/translation.Change Password") }}">
                                    <i class="fa fa-key"></i>
                                    {{ __("authenticated/user/translation.Change Password") }}
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
