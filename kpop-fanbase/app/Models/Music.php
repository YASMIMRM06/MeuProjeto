<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $table = 'music'; // Explicitly define table name if it's not plural of model name

    protected $fillable = [
        'group_id',
        'title',
        'duration',
        'youtube_link',
        'release_date',
        'average_rating',
    ];

    protected $casts = [
        'release_date' => 'date',
        'duration' => 'datetime', // Cast to datetime to handle time format easily
        'average_rating' => 'float',
    ];

    /**
     * Get the group that owns the music.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the ratings for the music.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Update the average rating for the music.
     * This method could be called after a new rating is added or updated.
     */
    public function updateAverageRating()
    {
        $this->average_rating = $this->ratings()->avg('rating') ?? 0;
        $this->save();
    }
}