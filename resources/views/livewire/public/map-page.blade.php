<div x-data="mapController" class="relative">
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 font-heading tracking-tight sm:text-5xl">Peta Jaringan Pos Bank Sampah</h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                Temukan pos pengumpulan terdekat dari lokasi Anda di Desa Sidomukti. Setorkan sampah dengan mudah dan mulai kumpulkan poin.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-8">

        <div class="w-full lg:w-1/3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-[600px]">
            <div class="p-6 bg-brand text-white border-b border-brand-dark">
                <h2 class="text-xl font-bold font-heading">Daftar Pos Aktif</h2>
                <p class="text-brand-light text-sm mt-1">Pilih pos untuk melihat lokasinya di peta.</p>
            </div>

            <div class="flex-1 overflow-y-auto p-0" id="post-list-container">
                <ul class="divide-y divide-gray-100">
                    <template x-for="post in posts" :key="post.id">
                        <li class="p-4 hover:bg-gray-50 cursor-pointer transition-colors"
                            @click="focusPost(post.latitude, post.longitude, post.name)"
                            :class="{'bg-brand/5 border-l-4 border-brand': activePostId === post.id}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div class="ml-3 xl:ml-4">
                                    <h3 class="text-md font-bold text-gray-900 font-heading" x-text="post.name"></h3>
                                    <p class="mt-1 text-sm text-gray-500 line-clamp-2" x-text="post.address"></p>
                                    <div class="mt-2 text-xs font-semibold text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        PIC: <span class="ml-1" x-text="post.pic_name"></span>
                                    </div>
                                    <div x-show="post.phone" class="mt-1 text-xs text-brand flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span x-text="post.phone"></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
                <div x-show="posts.length === 0" class="p-8 text-center text-gray-500">
                    Belum ada pos bank sampah yang terdaftar.
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/3 bg-white p-2 rounded-2xl shadow-sm border border-gray-100 h-[600px] relative">

            <div x-show="isLoading" class="absolute inset-0 z-10 flex items-center justify-center bg-gray-50 rounded-xl">
                <svg class="animate-spin h-10 w-10 text-brand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <iframe
                :src="mapUrl"
                @load="isLoading = false"
                class="w-full h-full rounded-xl z-0"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>

    @script
    <script>
        Alpine.data('mapController', () => ({
            posts: [],
            // URL Default: Mengarah ke Desa Sidomukti Jember
            mapUrl: 'https://maps.google.com/maps?q=Balai+Desa+Sidomukti,+Jember,+Jawa+Timur&t=&z=16&ie=UTF8&iwloc=&output=embed',
            isLoading: true,
            activePostId: null,

            init() {
                this.posts = @json(json_decode($postsJson, true));
            },

            focusPost(lat, lng, name) {
                // Jika tidak ada koordinat, gunakan nama tempat + nama desa
                if (!lat || !lng) {
                    const query = encodeURIComponent(`${name}, Desa Sidomukti, Jember`);
                    this.mapUrl = `https://maps.google.com/maps?q=${query}&t=&z=16&ie=UTF8&iwloc=&output=embed`;
                } else {
                    // Gunakan koordinat latitude & longitude yang ada di database
                    this.mapUrl = `https://maps.google.com/maps?q=${lat},${lng}&t=&z=17&ie=UTF8&iwloc=&output=embed`;
                }

                this.isLoading = true; // Tampilkan loading spinner

                // Cari id pos yang aktif untuk styling sidebar
                const post = this.posts.find(p => p.latitude == lat && p.longitude == lng);
                if(post) this.activePostId = post.id;
            }
        }));
    </script>
    @endscript
</div>
