<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EPOS') }}</title>

        <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        @if (setting('payment:card:service', 'stripe') == 'stripe')
            <script type="text/javascript" src="https://js.stripe.com/v3"></script>
        @endif

        <script>
            window.epos = {!! json_encode([
                'csrfToken' => csrf_token(),
                'app' => config('vue'),
                'settings' => setting()
            ]) !!};
        </script>
    </head>

    <body>
        <div id="app" v-cloak>
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

            <router-view></router-view>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
