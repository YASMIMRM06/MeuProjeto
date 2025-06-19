<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtendedProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'social_networks',
    ];

    /**
     * Get the user that owns the extended profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}