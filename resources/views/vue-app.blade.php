<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable=0">
        <meta name="robots" content="noindex">

        <title>blaise</title>

        <link rel="icon" href="{{ asset('b.svg') }}" type="image/svg+xml">

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
            rel="stylesheet"
        />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite('resources/blaise-vue-app/app.js')
        @endif
    </head>
    <body data-csrf="{{ csrf_token() }}" data-user="{{ auth()->id() }}">
        <div id="app"></div>
    </body>
</html>
