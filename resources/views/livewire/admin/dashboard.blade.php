<div>
    <x-slot name="header">
        Dashboard Admin
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card title="Total Nasabah Aktif" value="{{ number_format($activeUsersCount, 0, ',', '.') }}" icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>' />
        <x-stat-card title="Setoran Hari Ini" value="{{ number_format($todaySubmissionsCount, 0, ',', '.') }}" icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>' />
        <x-stat-card title="Poin Beredar" value="{{ number_format($circulatingPoints, 0, ',', '.') }}" icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' />
        <x-stat-card title="Setoran Pending" value="{{ number_format($pendingSubmissionsCount, 0, ',', '.') }}" icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' description="Ada {{ $pendingRedemptionsCount }} penukaran hadiah pending" />
    </div>

    <!-- Latest Pending Submissions -->
    <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-xl relative">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900 font-heading">Setoran Membutuhkan Validasi</h3>
            <a href="{{ route('admin.setoran.index') }}" class="text-sm font-medium text-brand hover:text-brand-dark" wire:navigate>
                Lihat Semua &rarr;
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nasabah</th>
                        <th scope="col" class="px-6 py-3">Pos Bank Sampah</th>
                        <th scope="col" class="px-6 py-3">Tanggal Setor</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestPendingSubmissions as $submission)
                        <tr class="bg-white border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $submission->user->name ?? 'User Dihapus' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $submission->collectionPost->name ?? 'Pos Dihapus' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($submission->submission_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.setoran.detail', $submission->id) }}" class="inline-flex items-center px-3 py-1.5 bg-brand text-white text-xs font-medium rounded-lg hover:bg-brand-dark transition-colors" wire:navigate>
                                    Validasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-sm">Tidak ada setoran tertunda yang perlu divalidasi hari ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
