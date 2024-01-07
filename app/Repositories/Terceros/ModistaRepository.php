<?php

namespace App\Repositories\Terceros;

use App\Models\Terceros\Modista;

class ModistaRepository
{
    public function create(array $data): Modista
    {
        return Modista::create($data);
    }

    public static function update(Modista $model, $data)
    {
        return $model->update($data);
    }

    public static function getAll()
    {
        return Modista::all();
    }

    public static function getByID($id)
    {
        return Modista::find($id);
    }
}
