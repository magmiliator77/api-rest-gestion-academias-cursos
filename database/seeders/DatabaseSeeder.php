<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Se ejecuta con: ./vendor/bin/sail artisan migrate --seed
    public function run(): void
    {
        $this->call(AcademySeeder::class);
    }
}
