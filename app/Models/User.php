<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_global_admin',
        'is_banned',
        'reputation_score',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_global_admin' => 'boolean',
            'is_banned' => 'boolean',
            'reputation_score' => 'integer'
        ];
    }



    /**
     * Relationship with Membership
     */
    public function membership()
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Check if user is in an active colocation
     */
    public function hasActiveColocation()
    {
        return $this->membership()->where('is_active', true)->exists();
    }

    /**
     * Get the active membership of the user
     */
    public function activeMembership()
    {
        return $this->membership()->where('is_active', true)->first();
    }

    /**
     * Check if user is the owner of their active colocation
     */
    public function isColocationOwner()
    {
        $active = $this->activeMembership();
        return $active && $active->role === 'owner';
    }
}
