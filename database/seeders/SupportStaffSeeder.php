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
        collect([
            [
                'name' => 'Brina Gonzales',
                'phone' => '13213321',
                'email' => 'brina.gonzales@example.com',
            ],
            [
                'name' => 'Axcel Coronado',
                'phone' => '63221196',
                'email' => 'axcel.coronado@example.com',
            ],
            [
                'name' => 'Edwin Coronado',
                'phone' => '64500333',
                'email' => 'edwin.coronado@example.com',
            ],
        ])->each(function (array $staff): void {
            SupportStaff::query()->updateOrCreate(
                ['email' => $staff['email']],
                $staff
            );
        });
    }
}
