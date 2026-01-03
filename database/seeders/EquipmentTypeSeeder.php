<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        EquipmentType::Insert([
            ['name' => 'Laptop',
             'created_at' => now(),
             'updated_at' => now(), 
            ],
            ['name' => 'Desktop',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['name' => 'Printer',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['name' => 'Router',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['name' => 'Monitor',
             'created_at' => now(),
             'updated_at' => now(),
            ],
        ]);
    }
}
