<?php

namespace App\Models\Terceros;

use App\Models\Configuration\Enums;
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
        'celular',
        'tipo_modista_id'
    ];

    const RELATION_SHIPS = ['tipo_modista'];

    public function tipo_modista()
    {
        return $this->belongsTo(Enums::class);
    }
}
