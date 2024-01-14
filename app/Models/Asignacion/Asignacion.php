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

    const RELATION_SHIPS = ['modista', 'corte'];    

    public function modista(): BelongsTo
    {
        return $this->belongsTo(Modista::class, 'modista_id');
    }

    public function corte(): BelongsTo
    {
        return $this->belongsTo(Corte::class, 'corte_id');
    }
}
