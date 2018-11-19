
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

<?php
    //dd(get_defined_vars());
?>


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">

        @include('layouts.shared.form_messages')

    </section>
</div>
@endsection