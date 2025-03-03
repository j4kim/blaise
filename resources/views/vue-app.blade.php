<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable=0, viewport-fit=cover">
        <meta name="robots" content="noindex">

        <title>blaise</title>

        <meta name="description" content="Gestion de salon en plus simple">
        <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png')}}" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg')}}" />
        <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png')}}" />
        <meta name="apple-mobile-web-app-title" content="blaise" />
        <link rel="manifest" href="{{ asset('site.webmanifest')}}" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

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
    <body data-csrf="{{ csrf_token() }}" data-user="{{ auth()->id() }}" class="dark:bg-surface-900">
        <div id="app"></div>
    </body>
</html>
