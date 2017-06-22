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
                'settings' => setting(),
                'user_id' => auth()->guest() ? null : auth()->user()->id
            ]) !!};
        </script>
    </head>

    <body>
        @yield('content')
    </body>
</html>
