<div>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.setoran.index') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-gray-700 shadow-sm border border-gray-100" wire:navigate title="Kembali">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="font-heading font-semibold text-xl text-gray-800 leading-tight">Detail Setoran #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</h2>
                <div class="text-sm font-normal text-gray-500 mt-1">{{ $submission->submission_date->translatedFormat('l, d F Y') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Items and Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="border-b border-gray-100 bg-gray-50 p-6 flex justify-between items-center">
                    <h3 class="font-heading font-medium text-lg text-gray-900">Rincian Sampah disetor</h3>
                    <x-badge-status :status="$submission->status" />
                </div>
                
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-white border-b border-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama/Kategori Barang</th>
                                    <th scope="col" class="px-6 py-3 text-right">Poin per Satuan</th>
                                    <th scope="col" class="px-6 py-3 text-center">Estimasi Pengguna</th>
                                    <th scope="col" class="px-6 py-3 text-center">Berat / Qty Aktual</th>
                                    <th scope="col" class="px-6 py-3 text-right">Subtotal Poin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($submission->items as $item)
                                    <tr class="bg-white hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $item->category->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->category->description }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            {{ number_format($item->points_per_unit, 0, ',', '.') }} / {{ $item->category->unit }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-gray-400">
                                            {{ floatval($item->quantity) }} {{ $item->category->unit }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($submission->status === 'pending')
                                                <div class="flex items-center justify-center gap-2">
                                                    <input wire:model.live="quantities.{{ $item->id }}" type="number" step="0.01" min="0" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand p-2 text-center">
                                                    <span class="text-xs text-gray-500 w-8">{{ $item->category->unit }}</span>
                                                </div>
                                            @else
                                                <span class="font-medium text-gray-900">{{ floatval($item->quantity) }} {{ $item->category->unit }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @php
                                                $qty = $quantities[$item->id] ?? 0;
                                                $subtotal = is_numeric($qty) ? (float)$qty * $item->points_per_unit : 0;
                                            @endphp
                                            <div class="font-semibold text-brand-dark">{{ number_format($subtotal, 0, ',', '.') }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada item sampah.</td>
                                    </tr>
                                @endforelse
                                
                                <tr class="bg-gray-50 border-t-2 border-gray-200">
                                    <td colspan="4" class="px-6 py-4 text-right font-medium text-gray-900">Total Poin Diperoleh:</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="text-lg font-bold text-brand-dark">
                                            {{ number_format($submission->status === 'pending' ? $projectedTotal : $submission->total_points_earned, 0, ',', '.') }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Notes & Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <x-input-label for="adminNotes" value="Catatan Validasi Admin (Opsional / Wajib jika Ditolak)" />
                    @if($submission->status === 'pending')
                        <textarea wire:model="adminNotes" id="adminNotes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-brand focus:ring-brand rounded-md shadow-sm" placeholder="Tambahkan catatan jika ada perbedaan berat atau alasan penolakan..."></textarea>
                    @else
                        <div class="mt-2 p-3 bg-gray-50 rounded border border-gray-100 text-sm text-gray-700">
                            {!! nl2br(e($submission->admin_notes)) ?: '<i>Tidak ada catatan.</i>' !!}
                        </div>
                    @endif

                    @if($submission->status === 'pending')
                        <div class="mt-6 flex flex-col-reverse sm:flex-row gap-3 justify-end items-center border-t border-gray-100 pt-6">
                            <button wire:click="rejectSubmission" wire:confirm="Apakah Anda yakin ingin menolak setoran ini? Pastikan Anda telah mengisi catatan admin." type="button" class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-red-200 bg-white px-5 py-2.5 text-sm font-medium text-red-600 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                Tolak Setoran
                            </button>
                            <button wire:click="validateSubmission" wire:confirm="Data sudah benar? Poin akan langsung ditambahkan ke saldo nasabah." type="button" class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-transparent bg-brand px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Validasi & Berikan Poin
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Info Panel -->
        <div class="space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100 font-heading font-medium text-gray-900">
                    Informasi Penyetor
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-brand-light/30 flex items-center justify-center text-brand-dark font-bold text-xl">
                            {{ substr($submission->user->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <div class="font-medium text-gray-900">{{ $submission->user->name }}</div>
                            <div class="text-sm text-brand font-medium">Nasabah</div>
                        </div>
                    </div>
                    
                    <dl class="space-y-3 text-sm">
                        <div class="grid grid-cols-3 gap-1">
                            <dt class="text-gray-500 font-medium">NIK</dt>
                            <dd class="text-gray-900 col-span-2">{{ $submission->user->nik }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-1">
                            <dt class="text-gray-500 font-medium">Telepon</dt>
                            <dd class="text-gray-900 col-span-2">{{ $submission->user->phone }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-1">
                            <dt class="text-gray-500 font-medium">Alamat</dt>
                            <dd class="text-gray-900 col-span-2">{{ $submission->user->address }}, RT {{ $submission->user->rt }}/RW {{ $submission->user->rw }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-1 pt-3 border-t border-gray-50">
                            <dt class="text-gray-500 font-medium">Saldo Poin</dt>
                            <dd class="text-brand-dark font-bold col-span-2 text-lg">{{ number_format($submission->user->points_total, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-gray-50 overflow-hidden sm:rounded-lg border border-gray-200">
                <div class="p-5">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3 uppercase tracking-wider">Detail Pos Bank Sampah</h4>
                    
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-gray-400 mt-0.5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <div class="font-medium text-gray-900">{{ $submission->collectionPost->name }}</div>
                            <div class="text-sm text-gray-500 mt-1">{{ $submission->collectionPost->address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($submission->notes))
            <div class="bg-yellow-50 overflow-hidden sm:rounded-lg border border-yellow-100">
                <div class="p-5">
                    <h4 class="text-sm font-semibold text-yellow-800 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Catatan Pengguna
                    </h4>
                    <p class="text-sm text-yellow-700 italic">"{{ $submission->notes }}"</p>
                </div>
            </div>
            @endif

            @if($submission->status !== 'pending' && $submission->validator)
                <div class="text-xs text-center text-gray-400 pt-4">
                    Setoran {{ $submission->status === 'validated' ? 'divalidasi' : 'ditolak' }} oleh {{ $submission->validator->name }} pada {{ $submission->validated_at->translatedFormat('d M Y, H:i') }}
                </div>
            @endif
        </div>
    </div>
</div>
