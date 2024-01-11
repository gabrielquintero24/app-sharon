<?php

namespace Database\Seeders\Configuration;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoModistaEnumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'parent_id' => 1,
                'name' => 'Tipo Modista',
                'code' => 'tipo_modista',
                'description' => "",
                'is_father' => true,
                'status' => true,
                'childrens' => [
                    [
                        'name' => 'Tipo 1',
                        'code' => 'tipo_1',
                        'orden' => 0,
                    ],
                    [
                        'name' => 'Tipo 2',
                        'code' => 'tipo_2',
                        'orden' => 1,
                    ],
                    [
                        'name' => 'Tipo 3',
                        'code' => 'tipo_3',
                        'orden' => 2,
                    ],
                ],
            ],
        ];

        foreach ($items as $key => $item) {
            $temp_children = null;
            if (isset($item['childrens'])) {
                $temp_children = $item['childrens'];
                unset($item['childrens']);
            }

            # Creamos el padre y vinculamos los hijos
            $father_id = DB::table('enums')->insertGetId($item);

            if (!empty($temp_children)) {
                foreach ($temp_children as $child) {
                    DB::table('enums')->insert([
                        'parent_id' => $father_id,
                        'name' => $child['name'],
                        'code' => $child['code'],
                        'valor1' => $child['valor1'] ?? null,
                        'valor2' => $child['valor2'] ?? null,
                        'orden' => $child['orden'] ?? null,
                        'status' => true
                    ]);
                }
            }
        }
    }
}
