<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CollectionPost::firstOrCreate(
            ['name' => 'Pos Induk Sidomukti'],
            [
                'address' => 'Balai Desa Sidomukti, Kec. Mayang, Jember',
                'latitude' => -8.1023,
                'longitude' => 113.7489,
                'pic_name' => 'Kepala Desa / Pengurus BUMDes',
                'pic_phone' => '-',
                'operational_hours' => 'Senin - Jumat 08:00 - 15:00',
            ]
        );
    }
}
