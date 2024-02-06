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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <x-app-navigation />

            <!-- Page Heading -->
            @if (isset($heading))
                <x-app-header :heading="$heading" />
            @endif

            <!-- Page Content -->
            <main>
                <div class="container">
                    <div class="py-6">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
        @livewireScripts
    </body>
</html>
