<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50 h-screen overflow-hidden relative flex items-center justify-center py-4 selection:bg-primary-500 selection:text-white">
        <!-- Modern Background abstract glows -->
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-primary-100/40 rounded-full blur-3xl -translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-primary-200/20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>
        
        <div class="w-full max-w-[440px] px-6 relative z-10">
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100/80 shadow-[0_8px_40px_-12px_rgba(0,0,0,0.08)] relative overflow-hidden">
                <!-- Subtle Top Accent Bar -->
                <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-primary-600 to-primary-700"></div>
                
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
