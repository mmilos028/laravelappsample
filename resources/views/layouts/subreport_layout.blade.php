<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images/favicon.ico') }}"/>
        <script type="text/javascript">
            function pingValidSession(){
                $.ajax(
                    {
                        type: "POST",
                        data: "ping=1",
                        dataType: "json",
                        global: false,
                        url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/session-validation/ping-session') }}",
                        async: true,
                        success: function (data) {
                            if(!data.valid_session){
                               window.location = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/auth/logout') }}";
                            }else{

                            }

                        },
                        error: function (data) {
                            window.location = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/auth/logout') }}";
                        }
                    }
                );
            }
            setInterval("pingValidSession()", 60000);
        </script>
    </head>
    <body @if (Config::get('ENABLE_RIGHT_CLICK_ON_PAGE')) oncontextmenu="return false;" @endif>
        <div>
          <!-- =============================================== -->
                @yield('content')
          <!-- =============================================== -->
        </div>
    </body>
</html>
