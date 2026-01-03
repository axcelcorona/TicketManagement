<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Axcel Coronado',
            'email' => 'axcelcorona01@gmail.com',
            'password' => bcrypt(env('ADMIN_PASSWORD')),
        ]);
    }
}
