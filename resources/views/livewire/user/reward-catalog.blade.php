<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Penukaran Hadiah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- User Balance Banner -->
            <div class="bg-gradient-to-r from-brand to-brand-light rounded-xl shadow-sm mb-8 overflow-hidden relative">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/clean-textile.png')] opacity-10"></div>
                <div class="p-6 md:p-8 relative z-10 flex flex-col md:flex-row justify-between items-center text-white">
                    <div class="mb-4 md:mb-0 text-center md:text-left">
                        <h3 class="text-xl font-bold mb-1">Saldo Poin Kamu:</h3>
                        <p class="text-brand-light/20 text-sm">Poin ini bisa ditukarkan dengan berbagai hadiah menarik di bawah.</p>
                    </div>
                    <div class="text-4xl md:text-5xl font-black font-heading tracking-tight flex items-center bg-white/20 px-6 py-3 rounded-xl border border-white/30 backdrop-blur-sm">
                        <svg class="w-8 h-8 md:w-10 md:h-10 mr-3 text-yellow-300 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ number_format(auth()->user()->points_total, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="w-full md:w-1/2 relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="bg-white border text-base border-gray-300 text-gray-900 rounded-xl focus:ring-brand focus:border-brand block w-full pl-10 p-3 shadow-sm hover:border-brand/50 transition-colors" placeholder="Cari sembako, voucher, dll...">
                </div>
                
                <a href="{{ route('penukaran.index') }}" class="w-full md:w-auto text-sm font-medium text-brand hover:text-brand-dark hover:underline flex items-center justify-center bg-white md:bg-transparent px-4 py-3 md:p-0 rounded-xl border border-gray-200 md:border-transparent transition-colors" wire:navigate>
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Cek Riwayat Penukaran Hadiah
                </a>
            </div>

            <!-- Rewards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($rewards as $reward)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group {{ auth()->user()->points_total < $reward->points_required ? 'opacity-80' : '' }}">
                        <!-- Image Area -->
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            @if($reward->photo)
                                <img src="{{ Storage::url($reward->photo) }}" alt="{{ $reward->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-700 shadow-sm">
                                Sisa Stok: {{ $reward->stock }}
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 leading-tight">{{ $reward->name }}</h3>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-2 min-h-[40px]">{{ $reward->description ?? 'Tidak ada deskripsi rinci.' }}</p>
                            
                            <div class="mt-auto">
                                <div class="flex items-center text-brand font-bold text-lg mb-3">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ number_format($reward->points_required, 0, ',', '.') }} Poin
                                </div>
                                
                                @if(auth()->user()->points_total >= $reward->points_required)
                                    <button wire:click="confirmRedeem({{ $reward->id }})" class="w-full py-2.5 bg-brand hover:bg-brand-dark text-white font-medium rounded-xl transition-colors shadow-sm focus:ring-4 focus:ring-brand/30">
                                        Tukar Sekarang
                                    </button>
                                @else
                                    <button disabled title="Poin belum mencukupi" class="w-full py-2.5 bg-gray-100 text-gray-400 font-medium rounded-xl cursor-not-allowed border border-gray-200">
                                        Poin Kurang
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Katalog Hadiah Kosong</h3>
                        <p class="text-gray-500 text-sm">Belum ada pilihan hadiah yang tersedia saat ini, atau coba ubah kata kunci pencarian.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Confirmation Modal Component included via Alpine or internal Livewire logic -->
    @if($isConfirmModalOpen)
        @php 
            $selectedReward = \App\Models\Reward::find($selectedRewardId);
            $userPoints = auth()->user()->points_total;
        @endphp
        
        @if($selectedReward)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="$set('isConfirmModalOpen', false)" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
                    <div class="px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-brand/10 sm:mx-0 sm:h-12 sm:w-12 border border-brand/20">
                                <svg class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <div class="mt-4 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-xl leading-6 font-bold text-gray-900 mb-2" id="modal-title">Konfirmasi Penukaran</h3>
                                
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-4 mt-4">
                                    <p class="text-sm text-gray-600 mb-1">Anda akan menukarkan poin untuk:</p>
                                    <p class="font-bold text-gray-900 text-base mb-3">{{ $selectedReward->name }}</p>
                                    
                                    <div class="flex justify-between items-center text-sm mb-1 pb-2 border-b border-gray-200">
                                        <span class="text-gray-500">Saldo Poin:</span>
                                        <span class="font-medium text-gray-900">{{ number_format($userPoints, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm pt-2 mb-1 pb-2 border-b border-gray-200">
                                        <span class="text-gray-500">Poin Dibutuhkan:</span>
                                        <span class="font-bold text-red-500">-{{ number_format($selectedReward->points_required, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm pt-2 pb-1">
                                        <span class="text-gray-700 font-medium tracking-wide text-xs">SISA POIN NANTI:</span>
                                        <span class="font-bold text-brand text-lg">{{ number_format($userPoints - $selectedReward->points_required, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <x-input-label for="notes" value="Pesan untuk Admin / Alamat Pengiriman (Opsional)" class="text-xs" />
                                    <textarea wire:model="notes" id="notes" rows="2" class="mt-1 block w-full border-gray-300 focus:border-brand focus:ring-brand rounded-lg shadow-sm text-sm" placeholder="Contoh: Tolong dikirim ke rumah hari Minggu..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/80 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 gap-3">
                        <button type="button" wire:click="processRedemption" wire:loading.attr="disabled" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-brand text-base font-bold text-white hover:bg-brand-dark focus:outline-none focus:ring-4 focus:ring-brand/30 sm:w-auto sm:text-sm transition-colors">
                            <span wire:loading.remove wire:target="processRedemption">Ya, Tukarkan Poin</span>
                            <span wire:loading wire:target="processRedemption">Memproses...</span>
                        </button>
                        <button type="button" wire:click="$set('isConfirmModalOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
