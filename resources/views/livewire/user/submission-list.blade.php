<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Setoran Sampah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 md:p-8">
                    
                    <!-- Header Actions -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0 pb-6 border-b border-gray-100 mb-6">
                        <div class="w-full md:w-1/3">
                            <x-input-label for="statusFilter" value="Filter Status" class="sr-only" />
                            <select wire:model.live="statusFilter" id="statusFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5 shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu Validasi</option>
                                <option value="validated">Berhasil (Divalidasi)</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                        
                        <!-- Add Button -->
                        <div>
                            <a href="{{ route('setoran.create') }}" class="inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-dark transition-colors focus:ring-4 focus:ring-brand/30 shadow-sm" wire:navigate>
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Setoran Baru
                            </a>
                        </div>
                    </div>

                    <!-- List Area -->
                    <div class="space-y-6">
                        @forelse($submissions as $sub)
                            <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition-shadow bg-white">
                                <!-- Card Header -->
                                <div class="bg-gray-50/80 px-4 py-3 border-b border-gray-100 flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-white border border-gray-200 p-1.5 rounded-lg text-gray-500 shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Tanggal Setor</p>
                                            <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($sub->submission_date)->translatedFormat('l, d F Y') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        @if($sub->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                <svg class="mr-1 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                                Menunggu Validasi
                                            </span>
                                        @elseif($sub->status === 'validated')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                <svg class="mr-1 h-3 w-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Berhasil Divalidasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                <svg class="mr-1 h-3 w-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-2">
                                        <div class="mb-4">
                                            <h4 class="text-xs uppercase tracking-wider text-gray-500 mb-1">Pos Tujuan</h4>
                                            <p class="text-sm font-medium text-gray-900 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $sub->collectionPost->name ?? 'Dihapus' }}
                                            </p>
                                        </div>

                                        <div>
                                            <h4 class="text-xs uppercase tracking-wider text-gray-500 mb-2">Rincian Sampah</h4>
                                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                                <ul class="divide-y divide-gray-200 text-sm">
                                                    @foreach($sub->items as $item)
                                                        <li class="py-2 flex justify-between items-center first:pt-0 last:pb-0">
                                                            <div class="flex items-center text-gray-700">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-brand mr-2"></span>
                                                                {{ $item->category->name ?? 'Kategori Dihapus' }} 
                                                                <span class="text-gray-400 mx-1">&bull;</span> 
                                                                <span class="font-medium">{{ $item->quantity + 0 }} {{ $item->category->unit ?? 'kg' }}</span>
                                                            </div>
                                                            <div class="text-gray-900 font-medium">
                                                                {{ number_format($item->subtotal_points, 0, ',', '.') }} Poin
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        @if($sub->notes)
                                            <div class="mt-4">
                                                <h4 class="text-xs uppercase tracking-wider text-gray-500 mb-1">Catatan Anda</h4>
                                                <p class="text-sm text-gray-600 bg-yellow-50 p-2 rounded border border-yellow-100">{{ $sub->notes }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="md:col-span-1 border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6 flex flex-col justify-center text-center">
                                        <span class="text-xs text-brand uppercase tracking-widest font-bold mb-1">Total Poin Diperoleh</span>
                                        <span class="text-4xl font-heading font-bold text-gray-900 mb-4 flex items-center justify-center">
                                            @if($sub->status === 'validated')
                                                <svg class="w-6 h-6 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                            {{ number_format($sub->total_points_earned, 0, ',', '.') }}
                                        </span>

                                        @if($sub->admin_notes && $sub->status !== 'pending')
                                            <div class="mt-auto">
                                                <h4 class="text-xs uppercase tracking-wider text-gray-500 mb-1">Pesan dari Admin</h4>
                                                <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded border border-gray-100 italic">"{{ $sub->admin_notes }}"</p>
                                            </div>
                                        @endif
                                        
                                        @if($sub->status === 'pending')
                                            <div class="mt-4 text-xs text-gray-400">
                                                <p>Admin belum memvalidasi timbangan sampah Anda.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 px-4 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p class="text-base font-medium text-gray-900">Belum ada riwayat setoran</p>
                                <p class="text-sm text-gray-500 mt-1 mb-6">Mulai pisahkan sampahmu dan dapatkan poin sekarang!</p>
                                <a href="{{ route('setoran.create') }}" class="inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-dark transition-colors" wire:navigate>
                                    Setor Sampah Pertamamu
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $submissions->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
