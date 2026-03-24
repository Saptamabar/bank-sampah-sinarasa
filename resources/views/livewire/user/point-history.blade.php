<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buku Tabungan Poin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Summary Stats Card -->
            <div class="bg-gradient-to-br from-brand-dark to-brand text-white rounded-xl shadow-md p-6 mb-8 flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10">
                    <svg class="w-48 h-48 -mr-10 -mt-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                </div>
                
                <div class="relative z-10 text-center md:text-left mb-4 md:mb-0">
                    <h3 class="text-3xl font-bold font-heading mb-1">{{ number_format(auth()->user()->points_total, 0, ',', '.') }}</h3>
                    <p class="text-brand-light text-sm uppercase tracking-wider font-semibold">Total Saldo Poin Saat Ini</p>
                </div>
                
                <div class="relative z-10 flex gap-4">
                    <div class="bg-white/10 rounded-lg p-3 text-center min-w-[120px] backdrop-blur-sm border border-white/20">
                        <div class="text-green-300 font-bold mb-1">
                            <svg class="w-4 h-4 inline-block -mt-1 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                            Kredit
                        </div>
                        <div class="text-xs text-brand-light">Pemasukan Poin</div>
                    </div>
                    <div class="bg-white/10 rounded-lg p-3 text-center min-w-[120px] backdrop-blur-sm border border-white/20">
                        <div class="text-red-300 font-bold mb-1">
                            <svg class="w-4 h-4 inline-block -mt-1 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                            Debit
                        </div>
                        <div class="text-xs text-brand-light">Pengeluaran Poin</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 md:p-8">
                    
                    <!-- Filter -->
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 font-heading">Riwayat Transaksi</h3>
                        <div class="w-48">
                            <select wire:model.live="typeFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5 shadow-sm">
                                <option value="">Semua Transaksi</option>
                                <option value="credit">Kredit (Masuk)</option>
                                <option value="debit">Debit (Keluar)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ledger Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Tanggal & Waktu</th>
                                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3 text-right">Mutasi</th>
                                    <th scope="col" class="px-6 py-3 text-right whitespace-nowrap">Saldo Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                    <tr class="bg-white border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($trx->created_at)->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $trx->description }}</div>
                                            <!-- Transaction Type Badge -->
                                            <div class="mt-1">
                                                @if($trx->type === 'credit')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-800">Setoran Sampah</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800">Tukar Hadiah</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold whitespace-nowrap">
                                            @if($trx->type === 'credit')
                                                <span class="text-green-600">+{{ number_format($trx->amount, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-red-500">-{{ number_format($trx->amount, 0, ',', '.') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-gray-900 font-heading whitespace-nowrap">
                                            {{ number_format($trx->balance_after, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 border-b-0">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3 text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </div>
                                                <p class="text-sm font-medium text-gray-900">Belum ada catatan mutasi poin.</p>
                                                <p class="text-xs mt-1 max-w-sm mx-auto">Setorkan sampah ke pos untuk mendapatkan poin pertama Anda.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-4">
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
