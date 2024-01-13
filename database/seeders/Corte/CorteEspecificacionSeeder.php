<?php

namespace Database\Seeders\Corte;

use App\Models\Corte\Corte;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Corte\CorteEspecificacion;
use App\Models\Especificacion\Especificacion;

class CorteEspecificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $corteIds = Corte::pluck('id')->toArray();
        $especificacionIds = Especificacion::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            CorteEspecificacion::create([
                'cantidad' => $faker->numberBetween(10, 999),
                'precio' => $faker->numberBetween(10, 999),
                'corte_id' => $faker->randomElement($corteIds),
                'especificacion_id' => $faker->randomElement($especificacionIds)
            ]);
        }
    }
}
