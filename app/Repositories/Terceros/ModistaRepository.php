<?php

namespace App\Repositories\Terceros;

use App\Models\Terceros\Modista;

class ModistaRepository
{
    public function create(array $data): Modista
    {
        return Modista::create($data);
    }
}