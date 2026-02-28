<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable =[
        'category_name',
        'amount',
        'payer_id',
        'to_user_id',
        'title',
        'colocation_id',
        'date',
        'is_settlement',
    ];


    public function payer(){
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function toUser(){
        return $this->belongsTo(User::class, 'to_user_id');
    }


    public function colocation(){
        return $this->belongsTo(Colocation::class, 'colocation_id');
    }

}
