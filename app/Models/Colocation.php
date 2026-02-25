<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Colocation extends Model
{
    protected $fillable = ['name', 'owner_id', 'status'];

    /**
     * Relationship with User (Owner)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relationship with Membership
     */
    public function membership(): HasMany
    {
        return $this->hasMany(Membership::class);
    }
}
