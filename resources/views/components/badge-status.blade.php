@props(['status'])

@php
    $colors = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'validated' => 'bg-green-100 text-green-800',
        'approved' => 'bg-green-100 text-green-800',
        'delivered' => 'bg-blue-100 text-blue-800',
        'rejected' => 'bg-red-100 text-red-800',
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-gray-100 text-gray-800',
    ];

    $labels = [
        'pending' => 'Menunggu',
        'validated' => 'Tervalidasi',
        'approved' => 'Disetujui',
        'delivered' => 'Terkirim',
        'rejected' => 'Ditolak',
        'active' => 'Aktif',
        'inactive' => 'Nonaktif',
    ];

    $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800';
    $label = $labels[$status] ?? ucfirst($status);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $colorClass"]) }}>
    {{ $label }}
</span>
