<div>
    <!-- Article Header -->
    <div class="bg-white border-b border-gray-100 pb-10">
        <!-- Back Button -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <a href="{{ route('news.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-brand transition-colors" wire:navigate>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Berita
            </a>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 font-heading tracking-tight sm:text-4xl md:text-5xl lg:leading-tight mb-6">
                {{ $news->title }}
            </h1>
            
            <div class="flex items-center justify-center mt-6">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 rounded-full bg-brand-light/20 flex items-center justify-center text-brand font-bold border border-brand/20 shadow-sm">
                        {{ substr($news->author->name ?? 'A', 0, 1) }}
                    </div>
                </div>
                <div class="ml-4 text-left">
                    <p class="text-base font-bold text-gray-900">
                        {{ $news->author->name ?? 'Admin' }}
                    </p>
                    <div class="flex space-x-2 text-sm text-gray-500 items-center">
                        <time datetime="{{ $news->published_at }}">{{ \Carbon\Carbon::parse($news->published_at)->translatedFormat('l, d F Y') }}</time>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ \Carbon\Carbon::parse($news->published_at)->format('H:i') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Body -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($news->cover_image)
            <figure class="mb-10 rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <img class="w-full h-auto object-cover max-h-[500px]" src="{{ Storage::url($news->cover_image) }}" alt="{{ $news->title }}">
            </figure>
        @endif

        <article class="prose prose-lg prose-brand max-w-none text-gray-800">
            {!! $news->content !!}
        </article>

        <!-- Share & Tags (Optional Placeholders) -->
        <div class="mt-16 pt-8 border-t border-gray-100 flex items-center justify-between">
            <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">Bagikan Artikel</span>
            <div class="flex gap-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}" target="_blank" class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                </a>
                <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M17.498 14.382c-.301-.15-1.767-.867-2.04-.966-.274-.101-.473-.15-.673.15-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.06-.297-.15-1.265-.462-2.406-1.485-.888-.795-1.484-1.77-1.66-2.07-.174-.3-.019-.465.13-.615.136-.135.301-.345.451-.523.146-.181.194-.301.297-.496.098-.205.044-.384-.033-.533-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.172-.015-.371-.015-.571-.015-.2 0-.523.074-.797.359-.273.285-1.045 1.02-1.045 2.475s1.07 2.865 1.219 3.075c.149.21 2.095 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c0-5.445 4.454-9.88 9.896-9.88 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.442 9.88-9.889 9.88m8.36-18.254C18.211 1.293 15.241 0 12.071 0 5.432 0 .041 5.39.041 12.03c0 2.124.553 4.195 1.604 6.014L0 24l6.113-1.603a12.016 12.016 0 005.955 1.57h.005c6.634 0 12.028-5.385 12.03-12.023A11.968 11.968 0 0020.437 3.531" clip-rule="evenodd"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Related Articles -->
    @if(count($relatedNews) > 0)
    <div class="bg-gray-50 py-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 font-heading mb-8">Berita Terkait Lainnya</h2>
            
            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2">
                @foreach($relatedNews as $related)
                    <div class="flex flex-col rounded-xl shadow-sm border border-gray-100 overflow-hidden bg-white hover:shadow-md transition-shadow group">
                        <div class="flex-shrink-0 relative h-48 bg-gray-200 overflow-hidden">
                            @if($related->cover_image)
                                <img class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ Storage::url($related->cover_image) }}" alt="{{ $related->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col justify-between flex-1">
                            <a href="{{ route('news.show', $related->slug) }}" class="block mt-2" wire:navigate>
                                <p class="text-lg font-bold font-heading text-gray-900 group-hover:text-brand line-clamp-2">
                                    {{ $related->title }}
                                </p>
                            </a>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xs text-brand font-medium">{{ \Carbon\Carbon::parse($related->published_at)->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
