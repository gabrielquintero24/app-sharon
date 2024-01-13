<?php

namespace App\Models\Especificacion;

use Illuminate\Database\Eloquent\Model;

class Especificacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'especificacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    const RELATION_SHIPS = [];
}
