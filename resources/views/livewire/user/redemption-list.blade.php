<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Penukaran Hadiah') }}
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
                                <option value="pending">Sedang Diproses</option>
                                <option value="approved">Disetujui / Siap Diambil</option>
                                <option value="delivered">Sudah Diterima</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                        
                        <!-- Catalog Button -->
                        <div>
                            <a href="{{ route('hadiah.index') }}" class="inline-flex items-center px-4 py-2 bg-brand-light/10 text-brand-dark border border-brand/20 text-sm font-medium rounded-lg hover:bg-brand-light/20 transition-colors shadow-sm" wire:navigate>
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                Tukar Poin Lagi
                            </a>
                        </div>
                    </div>

                    <!-- List Area -->
                    <div class="space-y-6">
                        @forelse($redemptions as $red)
                            <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition-shadow bg-white flex flex-col md:flex-row shadow-sm">
                                
                                <!-- Reward Image Section -->
                                <div class="w-full md:w-48 h-48 md:h-auto bg-gray-100 flex-shrink-0 relative">
                                    @if($red->reward && $red->reward->photo)
                                        <img src="{{ Storage::url($red->reward->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Reward Details Section -->
                                <div class="p-5 md:p-6 flex-1 flex flex-col justify-between">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <p class="text-xs text-gray-400 font-medium mb-1">Dibuat pada {{ \Carbon\Carbon::parse($red->created_at)->translatedFormat('d M Y - H:i') }}</p>
                                            <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $red->reward->name ?? 'Hadiah Telah Dihapus' }}</h3>
                                        </div>
                                        <div>
                                            @if($red->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded bg-yellow-100 text-yellow-800 text-xs font-medium border border-yellow-200 whitespace-nowrap">
                                                    Dalam Proses
                                                </span>
                                            @elseif($red->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded bg-blue-100 text-blue-800 text-xs font-medium border border-blue-200 whitespace-nowrap">
                                                    Disetujui
                                                </span>
                                            @elseif($red->status === 'delivered')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded bg-green-100 text-green-800 text-xs font-medium border border-green-200 whitespace-nowrap">
                                                    Diterima
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded bg-red-100 text-red-800 text-xs font-medium border border-red-200 whitespace-nowrap">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-auto">
                                        <div>
                                            <h4 class="text-[10px] uppercase font-bold text-gray-500 tracking-wider mb-1">Catatan Anda</h4>
                                            <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded-lg border border-gray-100 min-h-[40px]">{{ $red->notes ?: '-' }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-[10px] uppercase font-bold text-gray-500 tracking-wider mb-1">Catatan Admin</h4>
                                            <p class="text-sm border border-gray-100 p-2 bg-gray-50 rounded-lg min-h-[40px] {{ $red->admin_notes ? 'text-gray-900 font-medium' : 'text-gray-400 italic' }}">{{ $red->admin_notes ?: 'Belum ada catatan dari admin' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Points Area -->
                                <div class="bg-gray-50 md:w-48 p-5 md:p-6 border-t md:border-t-0 md:border-l border-gray-100 flex flex-col items-center justify-center text-center">
                                    <span class="text-xs text-gray-500 uppercase font-bold tracking-widest mb-2">Poin Digunakan</span>
                                    <span class="text-3xl font-heading font-black {{ $red->status === 'rejected' ? 'text-gray-400 line-through' : 'text-red-500' }}">
                                        {{ number_format($red->points_used, 0, ',', '.') }}
                                    </span>
                                    @if($red->status === 'rejected')
                                        <span class="text-[10px] font-bold text-green-600 mt-2 bg-green-100 px-2 py-1 rounded border border-green-200 uppercase tracking-widest text-center">Poin Dikembalikan</span>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div class="text-center py-16 px-4 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                <p class="text-lg font-medium text-gray-900">Belum ada riwayat penukaran hadiah.</p>
                                <p class="text-sm text-gray-500 mt-2 mb-6 max-w-sm mx-auto">Kumpulkan terus poin dari menyetor sampah dan tukarkan dengan berbagai hadiah menarik di katalog!</p>
                                <a href="{{ route('hadiah.index') }}" class="inline-flex items-center px-5 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-dark transition-colors shadow-sm" wire:navigate>
                                    Lihat Katalog Hadiah
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $redemptions->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
