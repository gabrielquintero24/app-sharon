<?php

namespace App\Models\Corte;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'corte';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'codigo_referencia',
        'cantidad_salida',
        'cantidad_entrada',
        'fecha_creacion'
    ];

    const RELATION_SHIPS = [];

    // Mutadores
    public function setFechaCreacionAttribute($value)
    {
        $this->attributes['fecha_creacion'] = Carbon::parse($value)->format('Y-m-d');
    }
}
