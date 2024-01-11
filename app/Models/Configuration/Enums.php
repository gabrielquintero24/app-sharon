<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;

class Enums extends Model
{
    protected $table = 'enums';
    protected $primaryKey = 'id';

    protected $fillable = [
        'parent_id',
        'code',
        'name',
        'description',
        'valor1',
        'valor2',
        'is_father',
        'status',
        'orden'
    ];

    public function parent()
    {
        return $this->belongsTo(Enums::class, 'parent_id');
    }

    public static function getChildrens($names)
    {
        $names = explode(',', $names);

        $responses = Enums::whereIn('parent_id', function ($query) use ($names) {
            $query->select('id')
                ->from('enums')
                ->whereIn('code', $names);
        })
            ->where('status', true)
            ->orderBy('orden', 'asc')
            ->get()
            ->groupBy('parent_id');


        $comboResponses = [];
        foreach ($responses as $index => $value) {
            $parent = Enums::find($index)->code;
            $comboResponses[$parent] = $value->toArray();
        }

        return $comboResponses;
    }
}
