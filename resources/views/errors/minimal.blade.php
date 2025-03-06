
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ Vite::asset('resources/images/favicon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-white">
    <div class="container">
        <div class="flex flex-col items-center justify-center min-h-screen gap-6 text-center">
            <a href="{{ route('login') }}" class="block w-24 mx-auto">
                <x-hermes-logo />
            </a>
            <p class="font-semibold text-7xl">@yield('code')</p>
            <p class="text-lg">@yield('message')</p>
            <x-button variant="primary" href="{{ route('login') }}" title="{{ __('Go Home') }}">{{ __('Go Home') }}</x-button>
        </div>
    </div>
</body>
</html>
