<?php

namespace Database\Seeders\Corte;

use App\Models\Corte\Corte;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class CorteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            Corte::create([
                'nombre' => $faker->word,
                'codigo_referencia' => $faker->unique()->bothify('CORTE###??'),
                'cantidad_salida' => $faker->numberBetween(10, 999),
                'cantidad_entrada' => $faker->numberBetween(10, 999),
                'fecha_creacion' => $faker->optional()->date
            ]);
        }
    }
}
