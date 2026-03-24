<div>
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-y-0 h-full w-full opacity-[0.03] z-0" style="background-image: url('https://www.transparenttextures.com/patterns/connected.png');"></div>
        
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-transparent sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-20 px-4 sm:px-6 lg:px-8">
                <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 lg:px-0 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-brand/10 text-brand mb-4">
                            <span class="flex-shrink-0 w-2 h-2 rounded-full bg-brand mr-2 animate-pulse"></span>
                            Platform Digital Bank Sampah
                        </span>
                        <h1 class="text-4xl tracking-tight font-black text-gray-900 sm:text-5xl md:text-6xl font-heading leading-tight">
                            <span class="block xl:inline">Ubah Sampah Jadi</span>
                            <span class="block text-brand xl:inline">Berkah & Rupiah</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Bergabunglah bersama Bank Sampah SINARASA Desa Sidomukti. Pisahkan sampah Anda, setorkan ke pos terdekat, dan kumpulkan poin untuk ditukar dengan berbagai kebutuhan sehari-hari!
                        </p>
                        <div class="mt-8 sm:flex sm:justify-center lg:justify-start gap-4">
                            <div class="rounded-md shadow">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-brand hover:bg-brand-dark transition-colors md:py-4 md:text-lg md:px-10" wire:navigate>
                                    Mulai Menabung
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-brand-light to-brand rounded-xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                                <a href="#cara-kerja" class="relative w-full flex items-center justify-center px-8 py-3 border border-gray-200 text-base font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors md:py-4 md:text-lg md:px-10">
                                    Pelajari Cara Kerjanya &darr;
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <!-- Hero Right Image Array -->
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 flex items-center justify-center p-8 hidden lg:flex">
            <div class="relative w-full h-full max-h-[600px] flex gap-4">
                <div class="w-1/2 flex flex-col gap-4 mt-12">
                    <img class="h-64 w-full object-cover rounded-2xl shadow-xl" src="https://images.unsplash.com/photo-1532996122724-e3c354a0b1bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Recycling">
                    <img class="h-48 w-full object-cover rounded-2xl shadow-xl" src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Community sorting">
                </div>
                <div class="w-1/2 flex flex-col gap-4">
                    <img class="h-48 w-full object-cover rounded-2xl shadow-xl" src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Nature leaf">
                    <img class="h-64 w-full object-cover rounded-2xl shadow-xl" src="https://images.unsplash.com/photo-1503596476-1c12a8ba09a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Groceries Reward">
                </div>
            </div>
        </div>
    </div>

    <!-- Impact Stats Layer -->
    <div class="bg-brand-dark pb-12 sm:pb-16 mt-0 lg:-mt-10 relative z-20">
        <div class="relative">
            <div class="absolute inset-0 h-1/2 bg-white lg:hidden"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto mt-4 sm:mt-0">
                    <dl class="rounded-2xl bg-white shadow-xl sm:grid sm:grid-cols-3 divide-y-2 sm:divide-y-0 sm:divide-x-2 divide-gray-100 overflow-hidden">
                        <div class="flex flex-col border-b border-gray-100 p-6 text-center sm:border-0 sm:border-r">
                            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Nasabah Aktif</dt>
                            <dd class="order-1 text-4xl sm:text-5xl font-extrabold text-brand font-heading tracking-tight">{{ number_format($totalUsers, 0, ',', '.') }}<span class="text-2xl">+</span></dd>
                        </div>
                        <div class="flex flex-col border-t border-b border-gray-100 p-6 text-center sm:border-0 sm:border-l sm:border-r">
                            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Poin Dibagikan</dt>
                            <dd class="order-1 text-4xl sm:text-5xl font-extrabold text-brand font-heading tracking-tight">{{ number_format($totalPointsDistributed, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex flex-col border-t border-gray-100 p-6 text-center sm:border-0 sm:border-l">
                            <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Hadiah Ditukar</dt>
                            <dd class="order-1 text-4xl sm:text-5xl font-extrabold text-brand font-heading tracking-tight">{{ number_format($totalRedemptions, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- How it Works / Steps Section -->
    <div id="cara-kerja" class="py-16 bg-gray-50 overflow-hidden lg:py-24">
        <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
            <div class="relative text-center mb-16">
                <h2 class="text-3xl font-heading font-black tracking-tight text-gray-900 sm:text-4xl">Cara Kerja Bank Sampah SINARASA</h2>
                <p class="mt-4 max-w-3xl mx-auto text-xl text-gray-500">
                    Proses mudah dan transparan. Dari rumah Anda menuju lingkungan yang lebih bersih dan hadiah yang bermanfaat.
                </p>
            </div>

            <div class="relative lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Step 1 -->
                <div class="relative group">
                    <div class="absolute inset-0 h-full w-full bg-white rounded-2xl shadow-sm border border-gray-100 transform transition-transform group-hover:-translate-y-2 group-hover:shadow-lg duration-300"></div>
                    <div class="relative px-6 py-10 flex flex-col items-center">
                        <div class="h-20 w-20 bg-brand/10 text-brand rounded-full flex items-center justify-center mb-6">
                            <span class="text-3xl font-black font-heading">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-heading">Pisahkan & Ajukan</h3>
                        <p class="text-gray-500 text-center text-sm leading-relaxed">
                            Pisahkan sampah anorganik di rumah. Buat form pengajuan di dashboard untuk memberikan estimasi jenis dan berat sampah, serta pilih pos terdekat.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative group mt-10 lg:mt-0">
                    <div class="absolute inset-0 h-full w-full bg-white rounded-2xl shadow-sm border border-gray-100 transform transition-transform group-hover:-translate-y-2 group-hover:shadow-lg duration-300"></div>
                    <div class="relative px-6 py-10 flex flex-col items-center">
                        <div class="h-20 w-20 bg-brand text-white rounded-full flex items-center justify-center mb-6 shadow-md">
                            <span class="text-3xl font-black font-heading">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-heading">Setor & Validasi</h3>
                        <p class="text-gray-500 text-center text-sm leading-relaxed">
                            Bawa sampah fisik ke Pos Bank Sampah pada tanggal yang disepakati. Petugas akan menimbang ulang dan memvalidasi setoran poin Anda langsung ke sistem.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative group mt-10 lg:mt-0">
                    <div class="absolute inset-0 h-full w-full bg-white rounded-2xl shadow-sm border border-gray-100 transform transition-transform group-hover:-translate-y-2 group-hover:shadow-lg duration-300"></div>
                    <div class="relative px-6 py-10 flex flex-col items-center">
                        <div class="h-20 w-20 bg-green-500/10 text-green-600 rounded-full flex items-center justify-center mb-6">
                            <span class="text-3xl font-black font-heading">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 font-heading">Tukar Poin Hadiah</h3>
                        <p class="text-gray-500 text-center text-sm leading-relaxed">
                            Poin yang terkumpul dapat Anda pantau via tabungan digital. Tukarkan poin tersebut dengan sembako, voucher, atau hadiah lain di Katalog Hadiah!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map CTA Preview -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8">
            <div class="bg-brand rounded-3xl shadow-xl overflow-hidden lg:grid lg:grid-cols-2 lg:gap-4 flex flex-col items-center">
                <div class="pt-10 pb-12 px-6 sm:pt-16 sm:px-16 lg:py-16 lg:pr-0 xl:py-20 xl:px-20 text-center lg:text-left flex-1">
                    <div class="lg:self-center">
                        <h2 class="text-3xl font-extrabold text-white sm:text-4xl font-heading mb-4">
                            <span class="block">Punya sampah menumpuk?</span>
                            <span class="block text-brand-light">Cari pos terdekat sekarang.</span>
                        </h2>
                        <p class="mt-4 text-lg leading-6 text-brand-light/90 mb-8 max-w-xs mx-auto lg:mx-0">
                            Kami memiliki jaringan pos pengumpulan yang tersebar di wilayah Desa Sidomukti. Lihat peta interaktif kami.
                        </p>
                        <a href="{{ route('map') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-brand bg-white hover:bg-gray-50 transition-colors shadow-sm" wire:navigate>
                            Buka Peta Interaktif &rarr;
                        </a>
                    </div>
                </div>
                <div class="relative w-full h-64 sm:h-80 lg:h-full bg-brand-dark overflow-hidden flex items-center justify-center">
                    <!-- Placeholder graphic for Map -->
                    <div class="absolute inset-0 opacity-20 bg-[url('https://unpkg.com/leaflet@1.9.4/images/marker-icon.png')] bg-repeat"></div>
                    <svg class="w-32 h-32 text-white/50 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest News -->
    <div class="bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8 border-t border-gray-100">
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center">
                <h2 class="text-3xl tracking-tight font-black text-gray-900 sm:text-4xl font-heading">Berita & Edukasi Terbaru</h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Pusat informasi pengelolaan sampah dan kegiatan Bank Sampah SINARASA.
                </p>
            </div>
            
            <div class="mt-12 max-w-lg mx-auto grid gap-8 lg:grid-cols-3 lg:max-w-none">
                @forelse($latestNews as $article)
                    <div class="flex flex-col rounded-2xl shadow-lg border border-gray-100 overflow-hidden bg-white hover:shadow-xl transition-shadow">
                        <div class="flex-shrink-0 relative h-48 bg-gray-200">
                            @if($article->cover_image)
                                <img class="h-full w-full object-cover" src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-brand/90 text-white backdrop-blur-sm shadow-sm">
                                    Berita
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <a href="{{ route('news.show', $article->slug) }}" class="block mt-2" wire:navigate>
                                    <p class="text-xl font-bold font-heading text-gray-900 group-hover:text-brand transition-colors line-clamp-2">
                                        {{ $article->title }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                        {{ strip_tags($article->content) }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="sr-only">{{ $article->author->name ?? 'Admin' }}</span>
                                    <div class="h-10 w-10 rounded-full bg-brand-light/20 flex items-center justify-center text-brand font-bold border border-brand/20">
                                        {{ substr($article->author->name ?? 'A', 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-gray-900">
                                        {{ $article->author->name ?? 'Admin' }}
                                    </p>
                                    <div class="flex space-x-1 text-gray-500">
                                        <time datetime="{{ $article->published_at }}">{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="lg:col-span-3 text-center py-12 text-gray-500">
                        Belum ada berita yang dipublikasikan.
                    </div>
                @endforelse
            </div>
            
            @if(count($latestNews) > 0)
                <div class="mt-10 text-center">
                    <a href="{{ route('news.index') }}" class="inline-flex items-center font-bold text-brand hover:text-brand-dark transition-colors" wire:navigate>
                        Lihat Semua Berita &rarr;
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
