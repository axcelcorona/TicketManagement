<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    use SoftDeletes;
    //
    protected $table = 'tickets';
    protected $fillable = ['client_name',
                           'owner_name',
                           'client_email', 
                           'call_time',
                           'start_time',
                           'end_time',
                           'location',
                           'problem_description',
                           'solution_applied',
                           'observations', 
                           'status', 
                           'user_id', 
                           'equipment_id', 
                           'visit_type_id'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function visitType(): BelongsTo
    {
        return $this->belongsTo(VisitType::class, 'visit_type_id');
    }

    protected static function booted()
    {
        static::creating(function ($ticket) {
            $ticket->user_id = Auth::id();
        });
    }

    public function supportStaffs(): BelongsToMany
    {
        return $this->belongsToMany(SupportStaff::class, 
                                    'ticket_support_staff', 
                                    'ticket_id', 
                                    'support_staff_id')
                    ->withTimestamps();
    }
}
