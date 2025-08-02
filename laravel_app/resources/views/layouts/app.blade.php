<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="twitter:card" content="summary" />
        <meta property="og:url" content="https://map.sekibutsu.info/" />
        @stack('ogp')
        <link rel="apple-touch-icon" type="image/png" href="/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="/icon-192x192.png">

        <title>@yield('pretitle'){{ config('app.name', 'Laravel') }} @yield('subtitle')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- add CSS & JS -->
        <link rel="stylesheet" href="/tw-elements/index.min.css">
        @stack('css')
        <script type="text/javascript" src="/tw-elements/index.min.js"></script>
        @stack('scripts')

    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 dark:bg-gray-900">

            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
