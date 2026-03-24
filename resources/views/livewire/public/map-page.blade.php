<div>
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 font-heading tracking-tight sm:text-5xl">Peta Jaringan Pos Bank Sampah</h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                Temukan pos pengumpulan terdekat dari lokasi Anda di Desa Sidomukti. Setorkan sampah dengan mudah dan mulai kumpulkan poin.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar List -->
        <div class="w-full lg:w-1/3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-[600px]">
            <div class="p-6 bg-brand text-white border-b border-brand-dark">
                <h2 class="text-xl font-bold font-heading">Daftar Pos Aktif</h2>
                <p class="text-brand-light text-sm mt-1">Pilih pos untuk melihat lokasinya di peta.</p>
            </div>
            
            <div class="flex-1 overflow-y-auto p-0" id="post-list-container">
                <ul class="divide-y divide-gray-100">
                    <template x-data x-for="post in {{ $postsJson }}" :key="post.id">
                        <li class="p-4 hover:bg-gray-50 cursor-pointer transition-colors" @click="$dispatch('focus-post', { id: post.id })">
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
                <div x-data x-show="JSON.parse('{{ $postsJson }}').length === 0" class="p-8 text-center text-gray-500">
                    Belum ada pos bank sampah yang terdaftar.
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="w-full lg:w-2/3 bg-white p-2 rounded-2xl shadow-sm border border-gray-100 h-[600px] z-0">
            <div id="leafletMap" class="w-full h-full rounded-xl z-0" wire:ignore></div>
        </div>

    </div>

    <!-- Alpine Leaflet logic -->
    @script
    <script>
        Alpine.data('mapController', () => ({
            map: null,
            markers: {},
            posts: [],
            
            init() {
                this.posts = @json(json_decode($postsJson, true));
                
                // Initialize map if L is loaded
                if (typeof L !== 'undefined') {
                    this.initMap();
                } else {
                    console.error('Leaflet is not loaded');
                }

                // Listen for custom event from sidebar clicks
                window.addEventListener('focus-post', (e) => {
                    const postId = e.detail.id;
                    if (this.markers[postId]) {
                        this.map.setView(this.markers[postId].getLatLng(), 16);
                        this.markers[postId].openPopup();
                    }
                });
            },
            
            initMap() {
                // Default center to Sidomukti (approximation)
                let centerLat = -6.839;
                let centerLng = 111.777;
                
                if (this.posts.length > 0) {
                    centerLat = this.posts[0].latitude;
                    centerLng = this.posts[0].longitude;
                }

                this.map = L.map('leafletMap').setView([centerLat, centerLng], 13);

                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(this.map);

                // Add markers
                const bounds = [];
                
                this.posts.forEach(post => {
                    if (post.latitude && post.longitude) {
                        const marker = L.marker([post.latitude, post.longitude]).addTo(this.map);
                        
                        const popupContent = `
                            <div class="px-2 py-1">
                                <h3 class="font-bold text-gray-900 border-b pb-1 mb-1 font-heading">${post.name}</h3>
                                <p class="text-sm text-gray-600 mb-2">${post.address}</p>
                                <p class="text-xs text-brand font-semibold">PIC: ${post.pic_name}</p>
                            </div>
                        `;
                        
                        marker.bindPopup(popupContent);
                        this.markers[post.id] = marker;
                        bounds.push([post.latitude, post.longitude]);
                    }
                });

                // Fit map to markers
                if (bounds.length > 0) {
                    this.map.fitBounds(bounds, { padding: [50, 50] });
                }
            }
        }));
    </script>
    @endscript

    <div x-data="mapController"></div>
</div>
