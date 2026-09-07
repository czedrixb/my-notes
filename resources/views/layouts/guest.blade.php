<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <wireui:scripts />
</head>

<body class="font-sans text-slate-900 antialiased">
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white overflow-hidden">
        <x-decorative-orbs />

        <div class="animate-fade-up">
            <a href="/" wire:navigate class="group flex items-center gap-2">
                <x-application-logo class="w-14 h-14" />
                <div class="font-bold text-2xl text-primary-600">Notes</div>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white rounded-3xl shadow-[0_8px_40px_rgba(109,40,217,0.08)] overflow-hidden animate-fade-up animate-delay-1">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
