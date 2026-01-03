<?php

namespace Database\Seeders;

use App\Models\VisitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        VisitType::Insert([
            ['name' => 'Visita de Llamada' , 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Visita Programada' , 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Visita Especial'  , 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
