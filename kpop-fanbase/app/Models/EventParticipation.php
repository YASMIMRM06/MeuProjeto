<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

// This model is for the pivot table if you need to add extra logic or attributes
// to the many-to-many relationship beyond what withPivot offers.
// If you just need the pivot status, you might not strictly need a dedicated model
// but it's good practice for more complex pivot tables.

class EventParticipation extends Pivot
{
    use HasFactory;

    protected $table = 'event_participations';

    protected $fillable = [
        'user_id',
        'event_id',
        'status',
    ];

    /**
     * Get the user associated with the participation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event associated with the participation.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}