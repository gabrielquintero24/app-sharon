<?php

namespace Database\Seeders\Terceros;

use App\Models\Configuration\Enums;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Terceros\Modista;

class ModistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $tipoModistaIds = Enums::whereRaw("parent_id = (SELECT id FROM enums WHERE code = 'tipo_modista')")
            ->pluck('id')
            ->toArray();

        for ($i = 0; $i < 50; $i++) {
            Modista::create([
                'nombre' => $faker->name,
                'direccion' => $faker->address,
                'celular' => $faker->randomNumber(9, true),
                'tipo_modista_id' => $faker->randomElement($tipoModistaIds)
            ]);
        }
    }
}
