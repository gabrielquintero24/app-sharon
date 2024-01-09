<?php

namespace App\Repositories\Cortes;

use App\Models\Corte\Corte;

class CorteRepository
{
    public function create(array $data): Corte
    {
        return Corte::create($data);
    }

    public static function update(Corte $model, $data)
    {
        return $model->update($data);
    }

    public static function getAll()
    {
        return Corte::all();
    }

    public static function getByID($id)
    {
        return Corte::find($id);
    }
}
