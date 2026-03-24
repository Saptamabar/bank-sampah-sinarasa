<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SINARASA') }} - Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 z-40 bg-gray-900/80 lg:hidden" 
             @click="sidebarOpen = false" 
             aria-hidden="true" style="display: none;"></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-brand-dark text-white flex flex-col transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0"
               :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
            
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-center border-b border-brand/30 px-4">
                <a href="{{ route('admin.dashboard') }}" class="font-heading font-bold text-xl tracking-wider text-white flex items-center gap-2" wire:navigate>
                    <svg class="w-8 h-8 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    SINARASA
                </a>
            </div>

            <!-- Sidebar Links -->
            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        // Will add remaining routes here as we build them, placeholder for now
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs($item['route']) ? 'bg-brand text-white' : 'text-gray-300 hover:bg-brand/50 hover:text-white' }}"
                       wire:navigate>
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Sidebar Footer (Profile/Logout) -->
            <div class="p-4 border-t border-brand/30">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full bg-brand-light flex items-center justify-center text-brand-dark font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs font-medium text-gray-300 group-hover:text-gray-200">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Topbar (Mobile Hamburger & Desktop User Menu) -->
            <header class="bg-white shadow-sm border-b border-gray-100 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10">
                
                <!-- Mobile menu button -->
                <button type="button" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Page Heading (Desktop) -->
                <h1 class="font-heading font-semibold text-xl text-gray-800 hidden lg:block">
                    {{ $header ?? '' }}
                </h1>

                <!-- Topbar Actions -->
                <div class="flex items-center gap-4 ml-auto lg:ml-0">
                    <!-- User Dropdown Menu -> We can reuse Breeze's dropdown here or a simpler one -->
                    <livewire:layout.navigation />
                </div>
            </header>

            <!-- Main Scrollable Content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none bg-gray-50">
                <div class="py-6">
                    <!-- Page Heading (Mobile only) -->
                    @if (isset($header))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:hidden mb-4">
                            <h1 class="font-heading font-semibold text-2xl text-gray-900">{{ $header }}</h1>
                        </div>
                    @endif
                    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>

        <x-flash-message /> <!-- Toast notification component -->

        @livewireScripts
    </body>
</html>
