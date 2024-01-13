<?php

namespace App\Repositories\Especificacion;
use App\Models\Especificacion\Especificacion;

class EspecificacionRepository
{
    public function create(array $data): Especificacion
    {
        return Especificacion::create($data);
    }

    public static function update(Especificacion $model, $data)
    {
        return $model->update($data);
    }

    public static function getAll()
    {
        return Especificacion::all();
    }

    public static function getByID($id)
    {
        return Especificacion::find($id);
    }
}
