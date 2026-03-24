<div>
    <!-- Header -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center pt-24">
            <span class="inline-flex flex-col items-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-brand/10 text-brand mb-4">
                    Pusat Informasi
                </span>
                <h1 class="text-4xl font-extrabold text-gray-900 font-heading tracking-tight sm:text-5xl">Berita & Edukasi Lingkungan</h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Dapatkan informasi terbaru seputar kegiatan Bank Sampah SINARASA Sidomukti dan tips gaya hidup ramah lingkungan.
                </p>
            </span>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Search Bar -->
        <div class="max-w-xl mx-auto mb-12 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input wire:model.live.debounce.500ms="search" type="text" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-brand focus:border-brand sm:text-sm shadow-sm transition-colors" placeholder="Cari judul atau isi berita...">
        </div>

        <!-- News Grid -->
        <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2">
            @forelse($news as $article)
                <div class="flex flex-col rounded-2xl shadow-sm border border-gray-100 overflow-hidden bg-white hover:shadow-lg transition-shadow group">
                    <div class="flex-shrink-0 relative h-56 bg-gray-200 overflow-hidden">
                        @if($article->cover_image)
                            <img class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <a href="{{ route('news.show', $article->slug) }}" class="block mt-2" wire:navigate>
                                <p class="text-xl font-bold font-heading text-gray-900 group-hover:text-brand transition-colors line-clamp-2">
                                    {{ $article->title }}
                                </p>
                                <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                    {{ strip_tags($article->content) }}
                                </p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="sr-only">{{ $article->author->name ?? 'Admin' }}</span>
                                    <div class="h-10 w-10 rounded-full bg-brand-light/20 flex items-center justify-center text-brand font-bold border border-brand/20">
                                        {{ substr($article->author->name ?? 'A', 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-3 text-sm">
                                    <p class="font-medium text-gray-900">
                                        {{ $article->author->name ?? 'Admin' }}
                                    </p>
                                    <div class="flex space-x-1 text-gray-500">
                                        <time datetime="{{ $article->published_at }}">{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') }}</time>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('news.show', $article->slug) }}" class="text-brand flex items-center hover:text-brand-dark transition-colors" wire:navigate>
                                <span class="sr-only">Baca selengkapnya</span>
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"></path></svg>
                    <p class="text-lg">Belum ada berita yang ditemukan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $news->links() }}
        </div>
    </div>
</div>
