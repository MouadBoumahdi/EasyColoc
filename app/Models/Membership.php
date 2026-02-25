<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    protected $fillable = [
        'user_id', 
        'colocation_id', 
        'role', 
        'is_active', 
        'joined_at', 
        'left_at'
    ];

    /**
     * Relationship with User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Colocation
     */
    public function colocation(): BelongsTo
    {
        return $this->belongsTo(Colocation::class);
    }
}
