<?php

namespace App\Repositories\CorteEspecificacion;

use App\Models\Corte\CorteEspecificacion;

class CorteEspecificacionRepository
{
    public function create(array $data): CorteEspecificacion
    {
        return CorteEspecificacion::create($data);
    }

    public static function update(CorteEspecificacion $model, $data)
    {
        return $model->update($data);
    }

    public static function getAll()
    {
        return CorteEspecificacion::all();
    }

    public static function getByID($id)
    {
        return CorteEspecificacion::find($id);
    }
}
