
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#list-users-for-parameter-setup').DataTable(
            {
                responsive: false,
                paging: false,
                searching: true,
                ordering: true,
                info: false,
            }
        );

        $('#list-users-for-parameter-setup tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#list-users-for-parameter-setup tfoot tr').appendTo('#list-users-for-parameter-setup thead');

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

        document.getElementById('list-users-for-parameter-setup_wrapper').removeChild(
            document.getElementById('list-users-for-parameter-setup_wrapper').childNodes[0]
        );

    } );
</script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("User List - Parameter Setup") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
            <li>{{ __("authenticated.Parameter Setup") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/user-parameter-setup/list-users") }}">
                    {{ __("User List - Parameter Setup") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/user-parameter-setup/list-users'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-right">
                            <button class="btn btn-primary" name="generate_report">
                                <i class="fa fa-refresh"></i>
                                {{ __("authenticated.Generate Report") }}
                            </button>
                        </td>
                    </tr>
                </table>
                <div class="table-responsive">
                    <table id="list-users-for-parameter-setup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr class="bg-blue-active">
                                <th width="200">{{ __("authenticated.Username") }}</th>
                                <th width="100">{{ __("User Type") }}</th>
                                <th width="100">{{ __("Parent") }}</th>
                                <th width="100">{{ __("authenticated.Currency") }}</th>
                                <th width="100">{{ __("authenticated.Account Active") }}</th>
                                <th width="100">{{ __("authenticated.Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                        //dd($list_users)
                        @endphp
                            @foreach ($list_users as $user)
                            <tr>
                                <td title="{{ __("authenticated.Username") }}">
                                    {{ $user->username }}
                                </td>
                                <td title="{{ __("User Type") }}">
                                    {{ $user->subject_dtype_bo_name }}
                                </td>
                                <td title="{{ $user->subject_path }}">
                                    {{ $user->parent_username }}
                                </td>
                                <td title="{{ __("authenticated.Currency") }}">
                                    {{ $user->currency }}
                                </td>
                                <td title="{{ __("authenticated.Account Active") }}">
                                    @if ($user->subject_state == 1)
                                        <span class="label label-success">{{ __("authenticated.Active") }}</span>
                                    @else
                                        <span class="label label-danger">{{ __("authenticated.Inactive") }}</span>
                                    @endif
                                </td>
                                <td title="{{ __("authenticated.Actions") }}">
                                    <a class="btn btn-primary"
                                       href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/user-parameter-setup/parameter-setup/user_id/{$user->subject_id}") }}"
                                       title="{{ __("authenticated.Parameter Setup") }} - {{ $user->username }}">
                                        <i class="fa fa-wrench"></i>
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
            </div>
            {!! Form::close() !!}
        </div>

    </section>
</div>
@endsection
