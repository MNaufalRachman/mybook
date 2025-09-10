<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(90deg, #f0f4ff 0%, #f9fafb 100%);
            font-family: 'Inter', 'Figtree', sans-serif;
        }

        header.bg-white.shadow {
            background: linear-gradient(90deg, #f8fafc 60%, #e0e7ff 100%);
            box-shadow: 0 2px 8px 0 #e0e7ff33;
        }

        main {
            min-height: 70vh;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        @if (session('error'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        x-transition
        class="fixed top-6 right-6 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg"
        role="alert"
    >
        <strong class="font-bold">🚫 Akses Ditolak!</strong>
        <span class="block sm:inline ml-2">{{ session('error') }}</span>
    </div>
@endif

       <!-- Page Heading -->
@isset($header)
<header>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <!-- Kiri: Judul Halaman -->
            <div>
                {{ $header }}
            </div>

            <!-- Kanan: Badge Role -->
            <div>
                <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                    👤 Role: <strong>{{ Auth::user()->role }}</strong>
                </span>
            </div>
        </div>
    </div>
</header>
@endisset


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>