<?php

namespace App\Models\Corte;

use App\Models\Corte\Corte;
use Illuminate\Database\Eloquent\Model;
use App\Models\Especificacion\Especificacion;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorteEspecificacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'corte_especificacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad',
        'precio',
        'corte_id',
        'especificacion_id'
    ];

    /**
     * Get the corte that owns the CorteEspecificacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function corte(): BelongsTo
    {
        return $this->belongsTo(Corte::class, 'corte_id');
    }

    /**
     * Get the especificacion that owns the CorteEspecificacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function especificacion(): BelongsTo
    {
        return $this->belongsTo(Especificacion::class, 'especificacion_id');
    }

}
