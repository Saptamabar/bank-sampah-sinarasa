<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SINARASA') }} - Autentikasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-800 antialiased bg-slate-50 selection:bg-brand-light selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-fixed">
            <div class="mb-8 text-center mt-10 sm:mt-0">
                <a href="/" wire:navigate class="inline-flex items-center gap-3 transition-transform hover:scale-105 duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-brand to-brand-dark rounded-2xl flex items-center justify-center shadow-lg shadow-brand/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <span class="text-3xl font-heading font-bold text-brand-dark tracking-tight">SINARASA</span>
                </a>
                <p class="mt-2 text-sm text-gray-500 font-medium">Bank Sampah Desa Sidomukti</p>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 bg-white/95 backdrop-blur-sm shadow-xl shadow-slate-200/50 sm:rounded-3xl border border-slate-100">
                {{ $slot }}
            </div>
            
            <p class="mt-8 mb-6 sm:mb-0 text-xs text-gray-400 font-medium">
                &copy; {{ date('Y') }} SINARASA - Desa Sidomukti, Mayang.
            </p>
        </div>
    </body>
</html>
