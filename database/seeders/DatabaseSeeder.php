<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Enums
        $this->call(Configuration\MasterEnumsSeeder::class);
        $this->call(Configuration\TipoModistaEnumSeeder::class);
    }
}
