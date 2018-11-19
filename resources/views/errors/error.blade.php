<?php
    //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">

    @if(App::environment('local') || config('app.APP_ENV') == 'local')
        @if(isset($message_trace))

            <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        &nbsp;
                    </div>
                    <div class="col-xs-8">
                        <br /> <br />
                        <h1>{{ __("authenticated.BackOffice has generated an error") }}</h1>
                        {!! nl2br($message_trace) !!}
                        <a href="javascript:history.back()">{{ __("authenticated.Go to previous page") }}</a>
                    </div>
                    <div class="col-xs-1">
                        &nbsp;
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        @endif
    @endif

    @if(App::environment('production') || config('app.APP_ENV') == 'production')
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        &nbsp;
                    </div>
                    <div class="col-xs-8">
                        <br /> <br />
                        <h1>{{ __("authenticated.BackOffice has generated an error") }}</h1>
                        @if(isset($message))
                        <h3 style="color:black;"><?php echo $this->message ?></h3>
                        @endif
                        <a href="javascript:history.back()">{{ __("authenticated.Go to previous page") }}</a>
                    </div>
                    <div class="col-xs-1">
                        &nbsp;
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    @endif

    </section>
</div>
@endsection