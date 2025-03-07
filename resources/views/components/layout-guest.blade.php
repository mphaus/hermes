<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? config('app.name') . ' - ' . $title : config('app.name') }}</title>

        <link rel="shortcut icon" href="{{ Vite::asset('resources/images/favicon.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @if (request()->routeIs('login'))
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <script>
                function onSubmit(token) {
                    document.querySelector('[data-element="login-form"]').submit();
                }
            </script>
        @endif

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-center min-h-screen px-4 pt-6 bg-gray-100 sm:justify-center sm:pt-0">
            <div class="flex flex-col w-full gap-4 sm:max-w-md">
                <a href="/">
                    <x-hermes-logo class="w-32" title="{{ __('Hermes') }}" />
                </a>
                <div class="px-6 py-4 overflow-hidden bg-white shadow-md sm:rounded-lg">
                    {{ $slot }}
                </div>
                <a href="/" class="self-end" title="{{ __('MPH Australia') }}">
                    <x-mph-logo class="w-14" />
                </a>
            </div>
        </div>
        @livewireScriptConfig
    </body>
</html>
