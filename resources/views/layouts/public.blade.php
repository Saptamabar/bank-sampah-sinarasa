<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SINARASA Dashboard') }} - Desa Sidomukti</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700|poppins:400,500,600,700,800,900" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Optional: Leaflet CSS for public map if needed -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    @livewireStyles
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">
    
    <!-- Public Navbar -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 px-4 sm:px-6 lg:px-8 py-3 w-full shadow-sm transition-all duration-300" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group" wire:navigate>
                <div class="w-10 h-10 bg-brand rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md group-hover:bg-brand-dark transition-colors">
                    S
                </div>
                <div>
                    <span class="font-heading font-black text-xl tracking-tight text-gray-900 block leading-none">SINARASA</span>
                    <span class="text-[10px] text-gray-500 font-semibold tracking-widest uppercase block leading-tight">Desa Sidomukti</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-brand' : 'text-gray-600 hover:text-brand' }} transition-colors" wire:navigate>Beranda</a>
                <a href="{{ route('news.index') }}" class="text-sm font-semibold {{ request()->routeIs('news.*') ? 'text-brand' : 'text-gray-600 hover:text-brand' }} transition-colors" wire:navigate>Berita</a>
                <a href="{{ route('map') }}" class="text-sm font-semibold {{ request()->routeIs('map') ? 'text-brand' : 'text-gray-600 hover:text-brand' }} transition-colors" wire:navigate>Peta Pos</a>
                
                <div class="h-6 w-px bg-gray-200"></div>

                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-bold rounded-full hover:bg-brand-dark transition-all transform hover:scale-105 shadow-md shadow-brand/20" wire:navigate>
                        Dasbor Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-brand transition-colors" wire:navigate>Masuk</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-bold rounded-full hover:bg-brand-dark transition-all transform hover:scale-105 shadow-md shadow-brand/20" wire:navigate>
                        Daftar Nasabah
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-brand focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden absolute top-full left-0 w-full bg-white border-b border-gray-100 shadow-xl py-4 px-4 flex flex-col space-y-4 font-medium" style="display: none;">
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-brand/10 text-brand' : 'text-gray-700 hover:bg-gray-50' }}" wire:navigate>Beranda</a>
            <a href="{{ route('news.index') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('news.*') ? 'bg-brand/10 text-brand' : 'text-gray-700 hover:bg-gray-50' }}" wire:navigate>Berita</a>
            <a href="{{ route('map') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('map') ? 'bg-brand/10 text-brand' : 'text-gray-700 hover:bg-gray-50' }}" wire:navigate>Peta Pos</a>
            <div class="h-px bg-gray-100 my-2"></div>
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="px-4 py-2 rounded-lg bg-brand text-white text-center shadow-md shadow-brand/20" wire:navigate>Masuk ke Dasbor</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 text-center" wire:navigate>Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-brand text-white text-center shadow-md shadow-brand/20" wire:navigate>Daftar Jadi Nasabah</a>
            @endauth
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Public Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center font-bold text-lg shadow-md">
                            S
                        </div>
                        <span class="font-heading font-black text-xl tracking-tight leading-none">SINARASA</span>
                    </div>
                    <p class="text-sm text-gray-400 mb-6 max-w-sm leading-relaxed">
                        Sistem Informasi Bank Sampah Desa Sidomukti. Bersama wujudkan lingkungan bersih, sehat, dan ekonomi sirkular yang bermanfaat bagi seluruh warga.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-white transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-brand transition-colors" wire:navigate>Beranda</a></li>
                        <li><a href="{{ route('map') }}" class="hover:text-brand transition-colors" wire:navigate>Peta Pos Bank Sampah</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-brand transition-colors" wire:navigate>Berita & Edukasi</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-brand transition-colors" wire:navigate>Daftar Nasabah</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">Kontak Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-gray-500 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Kantor Desa Sidomukti, Kec. Kenduruan, Kab. Tuban, Jawa Timur</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-gray-500 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <a href="mailto:banksampah@sidomukti.desa.id" class="hover:text-brand transition-colors">info@sinarasa.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} Bank Sampah SINARASA Sidomukti. Hak cipta dilindungi.
                </p>
                <div class="flex gap-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</body>
</html>
