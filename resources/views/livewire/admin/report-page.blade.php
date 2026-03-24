<div>
    <x-slot name="header">
        Laporan & Ekspor Data
    </x-slot>

    <div class="grid grid-cols-1 gap-6 mb-6">
        <!-- Filter Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6">
                <h3 class="font-heading font-medium text-lg text-gray-900 mb-4 border-b pb-2">Filter Rentang Waktu</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <div>
                        <x-input-label for="startDate" value="Tanggal Awal" />
                        <x-text-input wire:model.live="startDate" id="startDate" type="date" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="endDate" value="Tanggal Akhir" />
                        <x-text-input wire:model.live="endDate" id="endDate" type="date" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <div class="h-10 flex items-center text-sm text-gray-500">
                            Data ditarik mulai <span class="font-bold text-gray-900 mx-1">{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}</span> s/d <span class="font-bold text-gray-900 ml-1">{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</span>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Submissions Stat -->
        <div class="bg-white rounded-lg border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Setoran Sampah</dt>
                        <dd>
                            <div class="text-xl font-bold text-gray-900" wire:loading.class="animate-pulse text-gray-300">
                                {{ number_format($stats['total_submissions']) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Points Issued Stat -->
        <div class="bg-white rounded-lg border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Poin Didistribusikan</dt>
                        <dd>
                            <div class="text-xl font-bold text-gray-900" wire:loading.class="animate-pulse text-gray-300">
                                {{ number_format($stats['total_points_issued'], 0, ',', '.') }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Redemptions Stat -->
        <div class="bg-white rounded-lg border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Penukaran Hadiah</dt>
                        <dd>
                            <div class="text-xl font-bold text-gray-900" wire:loading.class="animate-pulse text-gray-300">
                                {{ number_format($stats['total_redemptions']) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Points Redeemed Stat -->
        <div class="bg-white rounded-lg border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Poin Ditukarkan</dt>
                        <dd>
                            <div class="text-xl font-bold text-gray-900" wire:loading.class="animate-pulse text-gray-300">
                                -{{ number_format($stats['total_points_redeemed'], 0, ',', '.') }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Actions -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
        <div class="border-b border-gray-100 bg-gray-50 p-6">
            <h3 class="font-heading font-medium text-lg text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Ekspor Laporan (CSV)
            </h3>
            <p class="text-sm text-gray-500 mt-1">Unduh data dalam format CSV untuk diolah lebih lanjut menggunakan Microsoft Excel atau Google Sheets. Data ditarik sesuai dengan rentang waktu yang dipilih di atas (kecuali Data Nasabah).</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Export Submissions -->
                <div class="border border-gray-200 rounded-lg p-5 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Laporan Setoran Sampah</h4>
                        <p class="text-sm text-gray-500 mb-4">Berisi detail seluruh transaksi setoran sampah dalam rentang waktu yang dipilih, termasuk status validasi dan jumlah poin.</p>
                    </div>
                    <button wire:click="exportSubmissions" class="w-full inline-flex justify-center items-center px-4 py-2 border border-blue-200 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-colors">
                        Unduh Laporan CSV
                    </button>
                </div>

                <!-- Export Redemptions -->
                <div class="border border-gray-200 rounded-lg p-5 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Laporan Penukaran Hadiah</h4>
                        <p class="text-sm text-gray-500 mb-4">Berisi detail seluruh transaksi penukaran poin dalam rentang waktu yang dipilih, termasuk nama hadiah dan status.</p>
                    </div>
                    <button wire:click="exportRedemptions" class="w-full inline-flex justify-center items-center px-4 py-2 border border-purple-200 bg-purple-50 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-100 transition-colors">
                        Unduh Laporan CSV
                    </button>
                </div>

                <!-- Export Users -->
                <div class="border border-gray-200 rounded-lg p-5 flex flex-col justify-between hover:shadow-md transition-shadow bg-gray-50/50">
                    <div>
                        <div class="w-10 h-10 rounded-full bg-brand-light/30 text-brand-dark flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Data Nasabah</h4>
                        <p class="text-sm text-gray-500 mb-4">Ekspor seluruh data nasabah terdaftar saat ini (<b>{{ $total_users }}</b> data), termasuk saldo poin terakhir mereka. <br><span class="text-xs italic">*Tidak terpengaruh filter tanggal</span></p>
                    </div>
                    <button wire:click="exportUsers" class="w-full inline-flex justify-center items-center px-4 py-2 border border-brand/20 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-dark transition-colors shadow-sm">
                        Unduh Semua Data (.csv)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
