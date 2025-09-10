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
        <style>
            body {
                background: linear-gradient(270deg, #f0f4ff 0%, #f9fafb 100%);
                font-family: 'Inter', 'Figtree', sans-serif;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-2">
                <a href="/">
                    <x-application-logo class="w-20 h-20 text-blue-600 drop-shadow-lg" />
                </a>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/90 shadow-2xl border border-blue-100 overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
