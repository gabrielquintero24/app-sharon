<?php

namespace App\Models\Terceros;

use Illuminate\Database\Eloquent\Model;

class Modista extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modista';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'celular'
    ];
}
