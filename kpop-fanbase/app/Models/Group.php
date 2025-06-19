<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'formation_date',
        'company',
        'description',
        'photo',
    ];

    protected $casts = [
        'formation_date' => 'date',
    ];

    /**
     * Get the music associated with the group.
     */
    public function music()
    {
        return $this->hasMany(Music::class);
    }
}