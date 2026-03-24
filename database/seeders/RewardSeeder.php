<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rewards = [
            ['name' => 'Sabun Cuci (500gr)', 'points_required' => 1500, 'stock' => 50],
            ['name' => 'Minyak Goreng (1L)', 'points_required' => 5000, 'stock' => 20],
            ['name' => 'Beras (2kg)', 'points_required' => 8000, 'stock' => 10],
            ['name' => 'Pulsa Rp 10.000', 'points_required' => 10000, 'stock' => 100],
        ];

        foreach ($rewards as $reward) {
            \App\Models\Reward::firstOrCreate(
                ['name' => $reward['name']],
                $reward
            );
        }
    }
}
