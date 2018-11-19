
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <br /> <br />
        <table class="table table-bordered table-hover dataTable">

        <tr>
            <th colspan="3">List users</th>
        </tr>
        <tr>
            <th>Username</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Phone</th>

        </tr>
        <!--
        customerid": 1
    +"firstname": "VKUUXF"
    +"lastname": "ITHOMQJNYX"
    +"address1": "4608499546 Dell Way"
    +"address2": null
    +"city": "QSDPAGD"
    +"state": "SD"
    +"zip": 24101
    +"country": "US"
    +"region": 1
    +"email": "ITHOMQJNYX@dell.com"
    +"phone": "4608499546"
    +"creditcardtype": 1
    +"creditcard": "1979279217775911"
    +"creditcardexpiration": "2012/03"
    +"username": "user1"
    +"password": "password"
    +"age": 55
    +"income": 100000
    +"gender": "M"
        -->


        @foreach ($result as $data)
        <tr>
            <td>
            {{ $data->username }}
            </td>
            <td>
            {{ $data->firstname }}
            </td>
            <td>
            {{ $data->lastname }}
            </td>
            <td>
              {{ $data->email }}
            </td>
            <td>
              {{ $data->phone }}
            </td>
        </tr>
        @endforeach
        </table>

    </section>
</div>
@endsection
