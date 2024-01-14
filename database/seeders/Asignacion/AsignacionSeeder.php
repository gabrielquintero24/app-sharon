<?php

namespace Database\Seeders\Asignacion;

use App\Models\Corte\Corte;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Terceros\Modista;
use App\Models\Asignacion\Asignacion;


class AsignacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $corteIds = Corte::pluck('id')->toArray();
        $modistaIds = Modista::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            Asignacion::create([
                'corte_id' => $faker->randomElement($corteIds),
                'modista_id' => $faker->randomElement($modistaIds)
            ]);
        }
    }
}
