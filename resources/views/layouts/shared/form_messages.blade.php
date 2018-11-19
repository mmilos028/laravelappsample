

        @if (isset($error_message))
        <div class="alert alert-error">
            <strong>
              {{ __("authenticated.error") }}
            </strong>
            {{ $error_message }}
        </div>

        @elseif (Session::has('error_message'))
        <div class="alert alert-error">
            <strong>
              {{ __("authenticated.error") }}
            </strong>
            {{ Session::get('error_message') }}
            {{ Session::forget('error_message') }}
        </div>

        @elseif (isset($success_message))
        <div class="alert alert-success">
            <strong>
              {{ __("authenticated.success") }}
            </strong>
            {{ $success_message }}
        </div>

        @elseif (Session::has('success_message'))
        <div class="alert alert-success">
            <strong>
              {{ __("authenticated.success") }}
            </strong>
            {{ Session::get('success_message') }}
            {{ Session::forget('success_message') }}
        </div>

        @elseif (isset($information_message))
        <div class="alert alert-info">
            <strong>
              {{ __("authenticated.information") }}
            </strong>
            {{ $information_message }}
        </div>

        @elseif (Session::has('information_message'))
        <div class="alert alert-info">
            <strong>
              {{ __("authenticated.information") }}
            </strong>
            {{ Session::get('information_message') }}
            {{ Session::forget('information_message') }}
        </div>

        @elseif (isset($warning_message))
        <div class="alert alert-warning">
            <strong>
              {{ __("authenticated.warning") }}
            </strong>
            {{ $warning_message }}
        </div>

        @elseif (Session::has('warning_message'))
        <div class="alert alert-warning">
            <strong>
              {{ __("authenticated.warning") }}
            </strong>
            {{ Session::get('warning_message') }}
            {{ Session::forget('warning_message') }}
        </div>
        @endif
