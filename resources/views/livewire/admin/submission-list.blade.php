<div>
    <x-slot name="header">
        Validasi Setoran Sampah
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
        <div class="p-6 text-gray-900">
            <!-- Filters -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end space-y-4 md:space-y-0 pb-4 border-b border-gray-100 mb-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 w-full md:w-auto">
                    <!-- Search -->
                    <div class="w-full">
                        <x-input-label for="search" value="Cari Nasabah / Pos" class="mb-1" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" id="search" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full pl-10 p-2.5" placeholder="Kata kunci...">
                        </div>
                    </div>
                    
                    <!-- Filter Status -->
                    <div class="w-full">
                        <x-input-label for="statusFilter" value="Status Validasi" class="mb-1" />
                        <select wire:model.live="statusFilter" id="statusFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu Validasi</option>
                            <option value="validated">Selesai / Tervalidasi</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <!-- Filter Date -->
                    <div class="w-full">
                        <x-input-label for="dateFilter" value="Tanggal Setor" class="mb-1" />
                        <input wire:model.live="dateFilter" id="dateFilter" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5">
                    </div>

                    <!-- Reset Filters Button -->
                    <div class="w-full flex items-end">
                        <button wire:click="resetFilters" type="button" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors focus:ring-4 focus:ring-gray-200">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto relative">
                <div wire:loading class="absolute inset-0 bg-white/50 z-10 flex items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-brand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-t-lg">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-tl-lg">ID Setoran</th>
                            <th scope="col" class="px-6 py-3">Nasabah</th>
                            <th scope="col" class="px-6 py-3">Pos Tujuan</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3 text-right rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($submissions as $submission)
                            <tr class="bg-white hover:bg-gray-50/50 transition-colors" wire:key="submission-{{ $submission->id }}">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $submission->user->name ?? 'User Dihapus' }}</div>
                                    <div class="text-xs text-gray-500">{{ $submission->user->phone ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $submission->collectionPost->name ?? 'Pos Dihapus' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900">{{ $submission->submission_date->translatedFormat('d F Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $submission->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4 text-center items-center">
                                    <x-badge-status :status="$submission->status" />
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.setoran.detail', $submission->id) }}" class="inline-flex items-center px-3 py-1.5 {{ $submission->status === 'pending' ? 'bg-brand text-white hover:bg-brand-dark' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} text-xs font-medium rounded-lg transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-brand" wire:navigate>
                                        {{ $submission->status === 'pending' ? 'Review & Validasi' : 'Lihat Detail' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                        </div>
                                        <p class="text-base font-medium text-gray-900 mb-1">Tidak ada setoran ditemukan.</p>
                                        <p class="text-sm">Silakan ubah filter pencarian atau belum ada setoran sama sekali.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $submissions->links() }}
            </div>
        </div>
    </div>
</div>
