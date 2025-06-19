<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // Added 'type' as per your migration
        'birth_date',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
    ];

    /**
     * Get the extended profile associated with the user.
     */
    public function extendedProfile()
    {
        return $this->hasOne(ExtendedProfile::class);
    }

    /**
     * Get the events created by the user.
     */
    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'creator_id');
    }

    /**
     * Get the events the user is participating in.
     */
    public function eventsParticipating()
    {
        return $this->belongsToMany(Event::class, 'event_participations', 'user_id', 'event_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Get the ratings given by the user.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the permissions associated with the user.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id')
                    ->withTimestamps();
    }

    /**
     * Check if the user has a specific permission.
     *
     * @param string $permissionSlug
     * @return bool
     */
    public function hasPermission(string $permissionSlug): bool
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }

    /**
     * Check if the user has a specific type.
     *
     * @param string $type
     * @return bool
     */
    public function isOfType(string $type): bool
    {
        return $this->type === $type;
    }
}