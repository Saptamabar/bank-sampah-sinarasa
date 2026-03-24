<div>
    <x-slot name="header">
        Edukasi & Berita
    </x-slot>

    <!-- Include Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
        <div class="p-6 text-gray-900">
            <!-- Header Actions -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0 pb-4 border-b border-gray-100 mb-4">
                <div class="w-full md:w-1/3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full pl-10 p-2.5" placeholder="Cari judul artikel/berita...">
                    </div>
                </div>
                
                <!-- Add Button -->
                <div>
                    <button wire:click="create" type="button" class="inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-dark transition-colors focus:ring-4 focus:ring-brand/30">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tulis Artikel
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-t-lg">
                        <tr>
                            <th scope="col" class="px-6 py-3">Artikel</th>
                            <th scope="col" class="px-6 py-3">Kategori</th>
                            <th scope="col" class="px-6 py-3">Penulis</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($newsItems as $news)
                            <tr class="bg-white hover:bg-gray-50 transition-colors" wire:key="news-{{ $news->id }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($news->thumbnail)
                                            <img src="{{ Storage::url($news->thumbnail) }}" class="h-12 w-16 rounded object-cover border mr-4" alt="">
                                        @else
                                            <div class="h-12 w-16 flex-shrink-0 rounded bg-brand-light/20 flex items-center justify-center text-brand font-bold border border-brand-light mr-4">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900 truncate max-w-xs" title="{{ $news->title }}">{{ $news->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $news->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $news->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 text-sm">{{ $news->author->name ?? 'Admin' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($news->is_published)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Dipublikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2" x-data="{ openDeleteModal: false }">
                                        <!-- Toggle Status Button -->
                                        <button wire:click="togglePublish({{ $news->id }})" wire:loading.attr="disabled"
                                            class="inline-flex items-center p-1.5 rounded-lg border {{ $news->is_published ? 'border-yellow-200 text-yellow-600 hover:bg-yellow-50' : 'border-green-200 text-green-600 hover:bg-green-50' }}"
                                            title="{{ $news->is_published ? 'Simpan ke Draft' : 'Publikasikan' }}">
                                            @if($news->is_published)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            @endif
                                        </button>

                                        <!-- Edit Button -->
                                        <button wire:click="edit({{ $news->id }})" class="inline-flex items-center p-1.5 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <button @click="openDeleteModal = true" class="inline-flex items-center p-1.5 rounded-lg border border-gray-200 text-gray-500 hover:text-red-600 hover:bg-red-50 hover:border-red-200" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div x-show="openDeleteModal" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                <div x-show="openDeleteModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openDeleteModal = false" aria-hidden="true"></div>
                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                <div x-show="openDeleteModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                            </div>
                                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Hapus Artikel</h3>
                                                                <div class="mt-2 text-wrap whitespace-normal">
                                                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus artikel <b>{{ $news->title }}</b>? Data yang dihapus tidak dapat dikembalikan.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <button @click="openDeleteModal = false; $wire.delete({{ $news->id }})" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Hapus</button>
                                                        <button @click="openDeleteModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                        <p class="text-base font-medium text-gray-900 mb-1">Belum ada artikel publikasi.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $newsItems->links() }}
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if ($isModalOpen)
        <!-- Alpine is used to bridge Quill JS and Livewire -->
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
            x-data="{
                initQuill() {
                    let quill = new Quill('#editor-container', {
                        theme: 'snow',
                        placeholder: 'Tulis isi artikel di sini...',
                        modules: {
                            toolbar: [
                                [{ 'header': [2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{'list': 'ordered'}, {'list': 'bullet'}],
                                ['link', 'clean']
                            ]
                        }
                    });
                    
                    // Set initial value from Livewire
                    quill.root.innerHTML = @this.get('content');
                    
                    // On every change, sync back to Livewire
                    quill.on('text-change', function() {
                        @this.set('content', quill.root.innerHTML);
                    });
                }
            }"
            x-init="setTimeout(() => initQuill(), 100)"
        >
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('isModalOpen', false)" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-4xl w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6 font-heading border-b pb-2" id="modal-title">{{ $newsId ? 'Edit' : 'Tulis' }} Artikel</h3>
                            
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-2">
                                        <x-input-label for="title" value="Judul Artikel" />
                                        <x-text-input wire:model="title" id="title" type="text" class="mt-1 block w-full text-lg" required placeholder="Contoh: Manfaat Memilah Sampah Plastik" />
                                        <x-input-error :messages="$errors->get('title')" class="mt-1 text-xs" />
                                    </div>
                                    <div>
                                        <x-input-label for="category" value="Kategori" />
                                        <select wire:model="category" id="category" class="mt-1 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full p-2.5">
                                            <option value="Edukasi">Edukasi</option>
                                            <option value="Berita">Berita</option>
                                            <option value="Pengumuman">Pengumuman</option>
                                            <option value="Promo">Promo</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('category')" class="mt-1 text-xs" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="thumbnail" value="Thumbnail / Foto Artikel" />
                                        <input wire:model="thumbnail" id="thumbnail" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-light file:text-brand-dark hover:file:bg-brand-light/80" accept="image/*" />
                                        <div wire:loading wire:target="thumbnail" class="text-sm text-brand mt-1">Mengunggah...</div>
                                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-1 text-xs" />
                                        
                                        @if ($thumbnail)
                                            <div class="mt-2 text-sm text-green-600">Foto baru siap diunggah.</div>
                                        @elseif ($existingThumbnail)
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($existingThumbnail) }}" class="h-24 w-auto rounded object-cover shadow border border-gray-100">
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center pt-6">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" wire:model="is_published" value="1" class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand"></div>
                                            <span class="ml-3 text-sm font-medium text-gray-900">Publikasikan Langsung</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Rich Text Editor -->
                                <div class="mt-4 border-t border-gray-100 pt-4">
                                    <x-input-label value="Isi Artikel (Gunakan Toolbar untuk Formating)" />
                                    <div wire:ignore class="mt-1">
                                        <!-- Keep container isolated from livewire updates to prevent quill getting wiped out -->
                                        <div id="editor-container" class="h-64 bg-white rounded-b-lg"></div>
                                    </div>
                                    <x-input-error :messages="$errors->get('content')" class="mt-1 text-xs" />
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                            <button type="submit" wire:loading.attr="disabled" wire:target="save, thumbnail" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand text-base font-medium text-white hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand sm:ml-3 sm:w-auto sm:text-sm">Simpan Artikel</button>
                            <button type="button" wire:click="$set('isModalOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
