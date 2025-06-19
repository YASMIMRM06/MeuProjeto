<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'music_id',
        'rating',
        'comment',
    ];

    /**
     * Get the user who made the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the music that was rated.
     */
    public function music()
    {
        return $this->belongsTo(Music::class);
    }
}