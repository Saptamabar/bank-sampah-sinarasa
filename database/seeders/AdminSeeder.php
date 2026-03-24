<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@sinarasa.id'],
            [
                'name' => 'Admin SINARASA',
                'nik' => '1234567890123456',
                'password' => \Illuminate\Support\Facades\Hash::make('sinarasa2024'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
