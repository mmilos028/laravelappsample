
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        test page
        <a href="javascript:void(0)" class="btn btn-primary noblockui">
        Test dugme
        </a>
        <br />Username: {{ Session::get('auth')['username'] }}
        <br />BackOffice Session ID: {{Session::get('auth')['backoffice_session_id'] }}
        <br /> Locale:   {{ Session::get('locale') }}

    </section>
</div>
@endsection