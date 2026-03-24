<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WasteCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Plastik Keras', 'unit' => 'kg', 'points_per_unit' => 500],
            ['name' => 'Plastik Lunak', 'unit' => 'kg', 'points_per_unit' => 300],
            ['name' => 'Kertas/Kardus', 'unit' => 'kg', 'points_per_unit' => 250],
            ['name' => 'Logam/Besi', 'unit' => 'kg', 'points_per_unit' => 700],
            ['name' => 'Aluminium', 'unit' => 'kg', 'points_per_unit' => 1000],
            ['name' => 'Kaca', 'unit' => 'kg', 'points_per_unit' => 200],
            ['name' => 'Sampah Organik', 'unit' => 'kg', 'points_per_unit' => 100],
        ];

        foreach ($categories as $category) {
            \App\Models\WasteCategory::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
