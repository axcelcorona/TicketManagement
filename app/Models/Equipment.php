<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    //
    protected $table = 'equipments';
    protected $fillable = ['name', 'equipment_type_id', 'brand', 'model', 'serial', 'code'];

    public function equipment_type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
