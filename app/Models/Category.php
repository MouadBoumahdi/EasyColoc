<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = ['colocation_id','name'];


    public function colocation(): BelongsTo
    {
        return $this->belongsTo(Colocation::class, 'colocation_id');
    }


    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
