<?php

namespace Database\Seeders\Configuration;

use Illuminate\Database\Seeder;
use App\Models\Configuration\Enums;

class MasterEnumsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enums::create(
            [
                'parent_id' => 1,
                'name' => 'master padre',
                'description' => 'Maestro de Maestros'
            ]
        );
    }
}
