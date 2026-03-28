<div>
    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-30" style="background-image: linear-gradient(#cbd5e1 1px, transparent 1px), linear-gradient(to right, #cbd5e1 1px, transparent 1px); background-size: 40px 40px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16 lg:pt-10 lg:pb-24 relative z-10">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">

                <div class="sm:text-center lg:text-left mb-12 lg:mb-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-brand/10 text-brand mb-4">
                        <span class="flex-shrink-0 w-2 h-2 rounded-full bg-brand mr-2 animate-pulse"></span>
                        Platform Digital Bank Sampah
                    </span>
                    <h1 class="text-4xl tracking-tight font-black text-gray-900 sm:text-5xl md:text-6xl font-heading leading-tight">
                        <span class="block xl:inline">Ubah Sampah Jadi</span>
                        <span class="block text-brand xl:inline">Berkah & Rupiah</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto lg:mx-0 md:mt-5 md:text-xl">
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

                <div class="relative w-full flex gap-4 justify-center items-center">
                    <div class="w-1/2 flex flex-col gap-4 mt-12">
                        <img class="h-64 w-full object-cover rounded-2xl shadow-xl hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1604187351574-c75ca79f5807?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Recycling process">
                        <img class="h-48 w-full object-cover rounded-2xl shadow-xl hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Community sorting">
                    </div>
                    <div class="w-1/2 flex flex-col gap-4">
                        <img class="h-48 w-full object-cover rounded-2xl shadow-xl hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Nature leaf">
                        <img class="h-64 w-full object-cover rounded-2xl shadow-xl hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1503596476-1c12a8ba09a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Groceries Reward">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-brand-dark py-12 lg:py-16 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <dl class="rounded-2xl bg-white shadow-xl sm:grid sm:grid-cols-3 divide-y-2 sm:divide-y-0 sm:divide-x-2 divide-gray-100 overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex flex-col p-6 text-center">
                        <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Nasabah Aktif</dt>
                        <dd class="order-1 text-4xl sm:text-5xl font-extrabold text-brand font-heading tracking-tight">{{ number_format($totalUsers ?? 0, 0, ',', '.') }}<span class="text-2xl">+</span></dd>
                    </div>
                    <div class="flex flex-col p-6 text-center">
                        <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Poin Dibagikan</dt>
                        <dd class="order-1 text-4xl sm:text-5xl font-extrabold text-brand font-heading tracking-tight">{{ number_format($totalPointsDistributed ?? 0, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex flex-col p-6 text-center">
                        <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Hadiah Ditukar</dt>
                        <dd class="order-1 text-4xl sm:text-5xl font-extrabold text-brand font-heading tracking-tight">{{ number_format($totalRedemptions ?? 0, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <div id="cara-kerja" class="py-16 bg-gray-50 overflow-hidden lg:py-24">
        <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
            <div class="relative text-center mb-16">
                <h2 class="text-3xl font-heading font-black tracking-tight text-gray-900 sm:text-4xl">Cara Kerja Bank Sampah SINARASA</h2>
                <p class="mt-4 max-w-3xl mx-auto text-xl text-gray-500">
                    Proses mudah dan transparan. Dari rumah Anda menuju lingkungan yang lebih bersih dan hadiah yang bermanfaat.
                </p>
            </div>

            <div class="relative lg:grid lg:grid-cols-3 lg:gap-8">
                <div class="relative group mt-10 lg:mt-0">
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

    <div class="bg-white py-16 lg:py-24 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-heading font-black tracking-tight text-gray-900 sm:text-4xl">Katalog Hadiah Menarik</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Tukarkan poin yang Anda kumpulkan dengan berbagai kebutuhan sehari-hari. Makin rajin menabung sampah, makin banyak untungnya!
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Beras Premium" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-1 font-heading">Beras Premium 5kg</h3>
                        <p class="text-brand font-extrabold text-xl mb-4">50.000 <span class="text-sm font-medium text-gray-500">Poin</span></p>
                        <button class="w-full py-2.5 px-4 bg-brand/10 text-brand font-bold rounded-xl hover:bg-brand hover:text-white transition-colors">Lihat Detail</button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1628187847527-1db2529ab8ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Minyak Goreng" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-1 font-heading">Minyak Goreng 2L</h3>
                        <p class="text-brand font-extrabold text-xl mb-4">35.000 <span class="text-sm font-medium text-gray-500">Poin</span></p>
                        <button class="w-full py-2.5 px-4 bg-brand/10 text-brand font-bold rounded-xl hover:bg-brand hover:text-white transition-colors">Lihat Detail</button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1620714223084-8fcacc6dfd8d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Token Listrik" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-1 font-heading">Token Listrik 20k</h3>
                        <p class="text-brand font-extrabold text-xl mb-4">22.000 <span class="text-sm font-medium text-gray-500">Poin</span></p>
                        <button class="w-full py-2.5 px-4 bg-brand/10 text-brand font-bold rounded-xl hover:bg-brand hover:text-white transition-colors">Lihat Detail</button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1580519542036-ed47f3e42214?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Saldo E-Wallet" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-1 font-heading">Saldo E-Wallet 50k</h3>
                        <p class="text-brand font-extrabold text-xl mb-4">55.000 <span class="text-sm font-medium text-gray-500">Poin</span></p>
                        <button class="w-full py-2.5 px-4 bg-brand/10 text-brand font-bold rounded-xl hover:bg-brand hover:text-white transition-colors">Lihat Detail</button>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="#" class="inline-flex items-center font-bold text-brand hover:text-brand-dark transition-colors text-lg" wire:navigate>
                    Lihat Semua Katalog Hadiah &rarr;
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white pb-16 lg:pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-brand rounded-3xl shadow-xl overflow-hidden lg:grid lg:grid-cols-2 lg:gap-0 flex flex-col">
                <div class="pt-10 pb-12 px-6 sm:pt-16 sm:px-16 lg:py-16 xl:py-20 xl:px-20 text-center lg:text-left flex-1 flex flex-col justify-center">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl font-heading mb-4">
                        <span class="block">Punya sampah menumpuk?</span>
                        <span class="block text-brand-light mt-1">Cari pos terdekat sekarang.</span>
                    </h2>
                    <p class="mt-4 text-lg leading-6 text-brand-light/90 mb-8 max-w-sm mx-auto lg:mx-0">
                        Kami memiliki jaringan pos pengumpulan yang tersebar di wilayah Desa Sidomukti, Jember. Lihat peta interaktif kami untuk menemukan pos terdekat dari rumah Anda.
                    </p>
                    <div>
                        <a href="{{ route('map') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-brand bg-white hover:bg-gray-50 hover:scale-105 transition-all shadow-sm" wire:navigate>
                            Buka Peta Ukuran Penuh &rarr;
                        </a>
                    </div>
                </div>

                <div class="relative w-full h-80 lg:h-full bg-gray-200">
                    <iframe
                        src="https://maps.google.com/maps?q=Balai+Desa+Sidomukti,+Jember,+Jawa+Timur&t=&z=16&ie=UTF8&iwloc=&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="absolute inset-0 w-full h-full">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8 border-t border-gray-100">
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center">
                <h2 class="text-3xl tracking-tight font-black text-gray-900 sm:text-4xl font-heading">Berita & Edukasi Terbaru</h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Pusat informasi pengelolaan sampah dan kegiatan Bank Sampah SINARASA.
                </p>
            </div>

            <div class="mt-12 max-w-lg mx-auto grid gap-8 lg:grid-cols-3 lg:max-w-none">
                @forelse($latestNews ?? [] as $article)
                    <div class="flex flex-col rounded-2xl shadow-lg border border-gray-100 overflow-hidden bg-white hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                        <div class="flex-shrink-0 relative h-48 bg-gray-200">
                            @if($article->thumbnail)
                                <img class="h-full w-full object-cover" src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
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
                                <a href="{{ route('news.show', $article->slug) }}" class="block mt-2 group" wire:navigate>
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
                    <div class="lg:col-span-3 text-center py-12 text-gray-500 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        Belum ada berita yang dipublikasikan saat ini.
                    </div>
                @endforelse
            </div>

            @if(count($latestNews ?? []) > 0)
                <div class="mt-10 text-center">
                    <a href="{{ route('news.index') }}" class="inline-flex items-center font-bold text-brand hover:text-brand-dark transition-colors" wire:navigate>
                        Lihat Semua Berita &rarr;
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
