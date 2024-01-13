<?php

namespace Database\Seeders\Especificacion;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Configuration\Enums;
use App\Models\Especificacion\Especificacion;

class EspecificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for ($i = 0; $i < 50; $i++) {
            Especificacion::create([
                'nombre' => $faker->name,
                'descripcion' => $faker->text(),
            ]);
        }
    }
}
