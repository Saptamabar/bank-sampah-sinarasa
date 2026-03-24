<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Nasabah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Greeting & Main Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Greeting Card -->
                <div class="md:col-span-2 bg-gradient-to-r from-brand to-brand-dark rounded-2xl shadow-lg relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                    <div class="p-8 relative z-10 text-white flex flex-col justify-center h-full">
                        <h3 class="text-2xl font-bold mb-2">Halo, {{ $user->name }}! 👋</h3>
                        <p class="text-brand-light mb-6">Selamat datang di panel nasabah Bank Sampah SINARASA. Mari bersama-sama menjaga kebersihan lingkungan dengan mendaur ulang sampah.</p>
                        
                        <div class="flex flex-wrap gap-4">
                            <!-- Let's assume there are routes set, we'll placeholder them or use "#" until created -->
                            <a href="{{ route('setoran.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-brand font-semibold rounded-lg shadow-sm hover:bg-gray-50 transition-colors" wire:navigate>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Setor Sampah
                            </a>
                            <a href="{{ route('hadiah.index') }}" class="inline-flex items-center px-4 py-2 bg-brand-light/20 text-white font-semibold rounded-lg hover:bg-brand-light/30 transition-colors border border-brand-light/30" wire:navigate>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                Tukar Poin
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Points Card -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Total Poin Anda</h4>
                    <div class="text-4xl font-bold font-heading text-gray-900">{{ number_format($user->points_total, 0, ',', '.') }}</div>
                    <a href="{{ route('poin.index') }}" class="mt-4 text-sm font-medium text-brand hover:underline" wire:navigate>Lihat Histori Poin &rarr;</a>
                </div>
            </div>

            <!-- Recent Activity Grids -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Submissions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-heading font-medium text-lg text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Setoran Terbaru
                        </h3>
                        <a href="{{ route('setoran.index') }}" class="text-sm font-medium text-brand hover:text-brand-dark" wire:navigate>Semua Setoran</a>
                    </div>
                    <div class="p-0">
                        <ul class="divide-y divide-gray-100">
                            @forelse($recentSubmissions as $sub)
                                <li class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($sub->submission_date)->translatedFormat('d M Y') }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">Pos: {{ $sub->collectionPost->name ?? 'Dihapus' }}</p>
                                        </div>
                                        <div class="text-right">
                                            @if($sub->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu</span>
                                            @elseif($sub->status === 'validated')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">+{{ $sub->total_points_earned }} Poin</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-8 text-center text-gray-500 text-sm">Belum ada riwayat setoran sampah.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Recent Redemptions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-heading font-medium text-lg text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                            Penukaran Poin
                        </h3>
                        <a href="{{ route('penukaran.index') }}" class="text-sm font-medium text-brand hover:text-brand-dark" wire:navigate>Riwayat Tukar</a>
                    </div>
                    <div class="p-0">
                        <ul class="divide-y divide-gray-100">
                            @forelse($recentRedemptions as $red)
                                <li class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            @if($red->reward && $red->reward->photo)
                                                <img src="{{ Storage::url($red->reward->photo) }}" class="w-10 h-10 rounded-lg object-cover mr-3 border border-gray-100">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $red->reward->name ?? 'Hadiah Dihapus' }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($red->created_at)->translatedFormat('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-gray-900 mb-1">-{{ number_format($red->points_used, 0, ',', '.') }}</p>
                                            @if($red->status === 'pending')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800">Proses</span>
                                            @elseif($red->status === 'approved')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800">Disetujui</span>
                                            @elseif($red->status === 'delivered')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-800">Diberikan</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800">Ditolak</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-8 text-center text-gray-500 text-sm">Belum ada riwayat penukaran hadiah.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Need Help / Map CTA -->
            <div class="mt-8 bg-brand-light/10 border border-brand-light/30 rounded-xl p-6 flex flex-col sm:flex-row items-center justify-between">
                <div class="flex items-center mb-4 sm:mb-0">
                    <div class="p-3 bg-white rounded-full text-brand shadow-sm mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-gray-900 font-bold mb-1">Cari Pos Setoran Terdekat</h4>
                        <p class="text-sm text-gray-600">Lihat peta interaktif untuk menemukan pos bank sampah di sekitar Desa Sidomukti.</p>
                    </div>
                </div>
                <a href="/peta" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition-colors whitespace-nowrap" wire:navigate>
                    Lihat Peta Pos &rarr;
                </a>
            </div>

        </div>
    </div>
</div>
