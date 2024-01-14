<?php

namespace App\Repositories\Asignacion;

use App\Models\Asignacion\Asignacion;

class AsignacionRepository
{
    public function create(array $data): Asignacion
    {
        return Asignacion::create($data);
    }

    public static function update(Asignacion $model, $data)
    {
        return $model->update($data);
    }

    public static function getAll()
    {
        return Asignacion::all();
    }

    public static function getByID($id)
    {
        return Asignacion::find($id);
    }
}
