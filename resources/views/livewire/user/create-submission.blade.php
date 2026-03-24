<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pengajuan Setoran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <form wire:submit="store">
                <!-- Informational Alert -->
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Petunjuk Setoran</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Isi rincian estimasi sampah yang akan Anda setorkan. <b>Total poin yang tertera di form ini adalah estimasi awal.</b> Admin di Pos Bank Sampah akan melakukan penimbangan ulang dan memvalidasi poin yang Anda dapatkan saat Anda menyerahkan sampah secara fisik.</p>
                        </div>
                    </div>
                </div>

                <!-- Main Form Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 mb-6">
                    <div class="p-6 md:p-8">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 border-b border-gray-100 pb-4 mb-6 font-heading">Informasi Pos & Waktu Penyerahan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pos Bank Sampah -->
                            <div>
                                <x-input-label for="collection_post_id" value="Pos Bank Sampah Tujuan" />
                                <select wire:model="collection_post_id" id="collection_post_id" class="mt-1 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5 shadow-sm">
                                    <option value="" disabled selected>-- Pilih Pos --</option>
                                    @foreach($posts as $post)
                                        <option value="{{ $post->id }}">{{ $post->name }} ({{ $post->pic_name }})</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('collection_post_id')" class="mt-1" />
                            </div>

                            <!-- Tanggal Setor -->
                            <div>
                                <x-input-label for="submission_date" value="Tanggal Penyerahan Fisik" />
                                <x-text-input wire:model="submission_date" id="submission_date" type="date" class="mt-1 block w-full shadow-sm" required />
                                <x-input-error :messages="$errors->get('submission_date')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Catatan Opsional -->
                        <div class="mt-6">
                            <x-input-label for="notes" value="Catatan Tambahan (Opsional)" />
                            <textarea wire:model="notes" id="notes" rows="2" class="mt-1 block w-full border-gray-300 focus:border-brand focus:ring-brand rounded-md shadow-sm text-sm" placeholder="Contoh: Saya akan mengantar sekitar jam 3 sore."></textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Garbage Items Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 mb-8 relative">
                    <div class="p-6 md:p-8">
                        <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 font-heading">Rincian Jenis Sampah</h3>
                        </div>

                        <!-- Error Message for the whole array -->
                        @if($errors->has('items'))
                            <div class="mb-4 mt-1 text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-100">{{ $errors->first('items') }}</div>
                        @endif

                        <div class="space-y-4">
                            @foreach($items as $index => $item)
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-gray-50 border border-gray-100 p-4 rounded-lg relative transition-all duration-300">
                                    
                                    <!-- Remove Button (Top Right on Mobile, Inline on Desktop) -->
                                    @if(count($items) > 1)
                                        <button type="button" wire:click="removeItem({{ $index }})" class="absolute top-4 right-4 md:static md:col-span-1 flex items-center justify-center p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent md:-mb-1">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @else
                                        <!-- Empty space to align columns if only 1 row -->
                                        <div class="hidden md:block md:col-span-1"></div>
                                    @endif

                                    <!-- Category Select -->
                                    <div class="md:col-span-5 w-full pr-8 md:pr-0">
                                        <x-input-label value="Pilih Kategori Sampah" class="text-xs text-gray-500 uppercase tracking-wider mb-1" />
                                        <select wire:model.live="items.{{ $index }}.category_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5 shadow-sm">
                                            <option value="">-- Pilih --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }} ({{ number_format($cat->points_per_unit, 0, ',', '.') }} Poin/{{ $cat->unit }})</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('items.'.$index.'.category_id')" class="mt-1" />
                                    </div>

                                    <!-- Quantity Input -->
                                    <div class="md:col-span-3">
                                        <x-input-label value="Estimasi Jumlah/Berat" class="text-xs text-gray-500 uppercase tracking-wider mb-1" />
                                        <div class="relative">
                                            <input wire:model.live.debounce.500ms="items.{{ $index }}.quantity" type="number" step="0.1" min="0" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5 pr-12 shadow-sm">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">
                                                    @php
                                                        $catId = $item['category_id'] ?? null;
                                                        $selectedCat = $catId ? $categories->firstWhere('id', $catId) : null;
                                                        $unit = $selectedCat ? $selectedCat->unit : 'kg';
                                                    @endphp
                                                    {{ $unit }}
                                                </span>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('items.'.$index.'.quantity')" class="mt-1" />
                                    </div>

                                    <!-- Read-only Subtotal -->
                                    <div class="md:col-span-3">
                                        <x-input-label value="Subtotal Poin" class="text-xs text-brand uppercase tracking-wider mb-1" />
                                        <div class="bg-white border border-brand/20 text-brand-dark font-bold text-sm rounded-lg block w-full p-2.5 shadow-sm focus:outline-none flex items-center justify-between">
                                            <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="truncate">{{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <!-- Add Item Action Button -->
                        <div class="mt-4 flex justify-center md:justify-start">
                            <button type="button" wire:click="addItem" class="inline-flex items-center px-4 py-2 border border-dashed border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:text-brand hover:border-brand hover:bg-brand-light/5 transition-all">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Tambah Jenis Sampah Lain
                            </button>
                        </div>
                    </div>
                    
                    <!-- Form Aggregration / Footer Area -->
                    <div class="bg-gray-50 p-6 md:p-8 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6 relative">
                        <!-- Connecting Line Decoration -->
                        <div class="absolute -top-3 left-1/2 md:left-24 transform -translate-x-1/2 md:-translate-x-0 w-6 h-6 bg-white border border-gray-100 rounded-full flex items-center justify-center rotate-45">
                            <div class="w-2 h-2 bg-brand rounded-full"></div>
                        </div>

                        <div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Total Estimasi Pendapatan</h4>
                            <div class="flex items-center text-3xl font-bold font-heading text-brand">
                                <svg class="w-8 h-8 mr-2 opacity-50 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span wire:loading.class="animate-pulse">{{ number_format($estimated_points, 0, ',', '.') }} Poin</span>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-auto">
                            <button type="submit" wire:loading.attr="disabled" wire:target="store" class="w-full md:w-auto inline-flex justify-center items-center px-8 py-3 bg-brand border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-brand-dark focus:bg-brand-dark active:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                <span wire:loading.remove wire:target="store">Kirim Pengajuan</span>
                                <span wire:loading wire:target="store" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
