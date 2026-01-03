<?php

namespace Database\Seeders;

use App\Models\SupportStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportStaffSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        SupportStaff::insert([
            [
                'name' => 'Brina Gonzales',
                'phone' => '13213321',
                'email' => 'brina.gonzales@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Axcel Coronado',
                'phone' => '63221196',
                'email' => 'axcel.coronado@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Edwin Coronado',
                'phone' => '64500333',
                'email' => 'edwin.coronado@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
