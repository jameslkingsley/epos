<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EPOS') }}</title>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <script>
            window.epos = {!! json_encode([
                'csrfToken' => csrf_token(),
                'app' => config('app')
            ]) !!};
        </script>
    </head>

    <body>
        <div id="app">
            {{-- @if (auth()->guest())
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @else
                <a href="{{ route('logout') }}" @click.prevent="document.getElementById('logout-form').submit()">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endif --}}

            @yield('content')
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
