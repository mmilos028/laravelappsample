
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        test page
        <a href="javascript:void(0)" class="btn btn-primary noblockui">
        Test dugme
        </a>
        <br />Username: {{ Auth::user()->username }}
        <br />Firstname: {{ Auth::user()->first_name }}
        <br />Lastname: {{ Auth::user()->last_name }}
        <br /> Locale:   {{ Session::get('locale') }}

        <br /> <br />
        <table class="table table-bordered table-hover dataTable">
        <tr>
            <th colspan="3">List users</th>
        </tr>
        <tr>
            <th>Username</th>
            <th>First name</th>
            <th>Last name</th>

        </tr>
        @foreach ($resultUsers as $data)
        <tr>
            <td>
            {{ $data->username }}
            </td>
            <td>
            {{ $data->first_name }}
            </td>
            <td>
            {{ $data->last_name }}
            </td>
        </tr>
        @endforeach
        </table>


        <br /> <br />
        <table class="table table-bordered table-hover dataTable">
        <tr>
            <th colspan="3">List admins</th>
        </tr>
        <tr>
            <th>Username</th>
            <th>First name</th>
            <th>Last name</th>

        </tr>
        @foreach ($resultAdmins as $data)
        <tr>
            <td>
            {{ $data->username }}
            </td>
            <td>
            {{ $data->first_name }}
            </td>
            <td>
            {{ $data->last_name }}
            </td>
        </tr>
        @endforeach
        </table>

    </section>
</div>
@endsection