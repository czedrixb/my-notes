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

<body class="font-sans antialiased">
    <div class="relative min-h-screen bg-white">
        <x-decorative-orbs />

        <livewire:layout.navigation />

        @isset($header)
            <header class="max-w-7xl mx-auto px-5 lg:px-8">
                {{ $header }}
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function showSuccessToast(message) {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: message,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    color: '#991b1b',
                    iconColor: '#ef4444',
                });
            }

            document.addEventListener('DOMContentLoaded', () => {
                @if (session('message'))
                    showSuccessToast(@js(session('message')));
                @endif
            });

            document.addEventListener('livewire:navigated', () => {
                Livewire.on('toast', ({ message }) => showSuccessToast(message));
            });
        </script>
    </div>
</body>

</html>
