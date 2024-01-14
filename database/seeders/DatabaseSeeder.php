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
        $this->call(Corte\CorteSeeder::class);
        $this->call(Especificacion\EspecificacionSeeder::class);
        $this->call(Terceros\ModistaSeeder::class);
        $this->call(Corte\CorteEspecificacionSeeder::class);
        $this->call(Asignacion\AsignacionSeeder::class);
    }
}
