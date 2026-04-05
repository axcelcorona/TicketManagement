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
        collect([
            'Visita de Llamada',
            'Visita Programada',
            'Visita Especial',
        ])->each(function (string $name): void {
            VisitType::query()->updateOrCreate(
                ['name' => $name],
                ['name' => $name]
            );
        });
    }
}
