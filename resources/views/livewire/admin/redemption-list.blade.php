<div>
    <x-slot name="header">
        Manajemen Penukaran Hadiah
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
        <div class="p-6 text-gray-900">
            <!-- Filters -->
            <div class="flex flex-col sm:flex-row justify-between items-end space-y-4 sm:space-y-0 sm:space-x-4 pb-4 border-b border-gray-100 mb-4">
                <div class="w-full sm:w-1/3">
                    <x-input-label for="search" value="Cari Nasabah / Hadiah" class="mb-1" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" id="search" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full pl-10 p-2.5" placeholder="Kata kunci...">
                    </div>
                </div>
                
                <div class="w-full sm:w-1/4">
                    <x-input-label for="statusFilter" value="Status" class="mb-1" />
                    <select wire:model.live="statusFilter" id="statusFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu Persetujuan</option>
                        <option value="approved">Diproses (Siap Ambil)</option>
                        <option value="delivered">Selesai (Sudah Diberikan)</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-t-lg">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nasabah</th>
                            <th scope="col" class="px-6 py-3">Hadiah Ditukar</th>
                            <th scope="col" class="px-6 py-3 text-center">Poin Digunakan</th>
                            <th scope="col" class="px-6 py-3 text-center">Tanggal Transaksi</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($redemptions as $redemption)
                            <tr class="bg-white hover:bg-gray-50 transition-colors" wire:key="redemption-{{ $redemption->id }}">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $redemption->user->name ?? 'User Dihapus' }}</div>
                                    <div class="text-xs text-brand font-medium">{{ $redemption->user->phone ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($redemption->reward && $redemption->reward->photo)
                                            <img src="{{ Storage::url($redemption->reward->photo) }}" class="h-8 w-8 rounded object-cover border mr-3" alt="">
                                        @endif
                                        <div class="font-medium text-gray-700">{{ $redemption->reward->name ?? 'Hadiah Dihapus' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-red-600">-{{ number_format($redemption->points_used, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-gray-900">{{ $redemption->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $redemption->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu'],
                                            'approved' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Siap Ambil'],
                                            'delivered' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Selesai'],
                                            'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Ditolak'],
                                        ];
                                        $conf = $statusConfig[$redemption->status];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $conf['bg'] }} {{ $conf['text'] }}">
                                        {{ $conf['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($redemption->status === 'pending')
                                        <div class="flex justify-end gap-2">
                                            <button wire:click="approve({{ $redemption->id }})" wire:confirm="Sertujui penukaran ini? Pastikan stok hadiah fisik tersedia." class="px-3 py-1 bg-brand text-white text-xs font-medium rounded hover:bg-brand-dark transition-colors">
                                                Setujui
                                            </button>
                                            <button wire:click="openRejectModal({{ $redemption->id }})" class="px-3 py-1 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-xs font-medium rounded transition-colors">
                                                Tolak
                                            </button>
                                        </div>
                                    @elseif($redemption->status === 'approved')
                                        <button wire:click="markDelivered({{ $redemption->id }})" wire:confirm="Tandai selesai? Artinya nasabah sudah menerima hadiah fisiknya." class="px-3 py-1.5 bg-brand text-white text-xs font-medium rounded-lg shadow-sm hover:bg-brand-dark transition-colors">
                                            Tandai Selesai
                                        </button>
                                    @elseif($redemption->status === 'rejected' && $redemption->admin_notes)
                                        <div class="text-xs text-gray-500 italic" title="{{ $redemption->admin_notes }}">
                                            Lihat Alasan
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                        <p class="text-base font-medium text-gray-900 mb-1">Tidak ada data penukaran.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $redemptions->links() }}
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    @if ($isRejectModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('isRejectModalOpen', false)" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form wire:submit.prevent="reject">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tolak Penukaran Hadiah</h3>
                                    <div class="mt-2 text-sm text-gray-500 mb-4 text-wrap whitespace-normal">
                                        Poin yang telah ditukar oleh nasabah akan dikembalikan secara otomatis. Silakan berikan alasan penolakan.
                                    </div>
                                    
                                    <div>
                                        <x-input-label for="rejectionNotes" value="Alasan Penolakan" />
                                        <textarea wire:model="rejectionNotes" id="rejectionNotes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm" placeholder="Contoh: Stok fisik habis" required></textarea>
                                        <x-input-error :messages="$errors->get('rejectionNotes')" class="mt-1 text-xs" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                            <button type="submit" wire:loading.attr="disabled" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Konfirmasi Tolak</button>
                            <button type="button" wire:click="$set('isRejectModalOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
