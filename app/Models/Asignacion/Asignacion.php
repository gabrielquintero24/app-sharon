<?php

namespace App\Models\Asignacion;

use App\Models\Corte\Corte;
use App\Models\Terceros\Modista;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asignacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asignacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'modista_id',
        'corte_id'
    ];

    /**
     * Get the modista that owns the Asignacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modista(): BelongsTo
    {
        return $this->belongsTo(Modista::class, 'modista_id');
    }

    /**
     * Get the corte that owns the Asignacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function corte(): BelongsTo
    {
        return $this->belongsTo(Corte::class, 'corte_id');
    }
}
