<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitType extends Model
{
    //
    protected $table = 'visit_types';
    protected $fillable = ['name'];

    public function tickets() : HasMany
    {
        return $this->hasMany(Ticket::class, 'visit_type_id');
    }
}
