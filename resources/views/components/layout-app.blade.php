<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? config('app.name') . ' - ' . $title : config('app.name') }}</title>

        <link rel="shortcut icon" href="{{ Vite::asset('resources/images/hermes.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">

        @routes

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased max-[1279px]:pb-[62px] bg-gray-100 ">
        <div class="min-h-dvh">
            <!-- Page Content -->
            <main>
                <x-side-menu />
                <section class="xl:ml-64">
                    <!-- Page Heading -->
                    @if (isset($heading))
                        <x-app-header :heading="$heading" />
                    @endif
                    <div class="px-4 py-6 mx-auto max-w-screen-2xl xl:px-8">{{ $slot }}</div>
                </section>
            </main>
        </div>
        @if (session('alert'))
            <x-alert :type="session('alert')['type']">
                {!! session('alert')['message'] !!}
            </x-alert>
        @endif
        <x-side-menu-open-button />
        <x-side-menu-backdrop />
        @livewireScriptConfig
    </body>
</html>
