<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'name',
        'description',
        'event_date',
        'location',
        'capacity',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    /**
     * Get the user who created the event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the users participating in the event.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_participations', 'event_id', 'user_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}