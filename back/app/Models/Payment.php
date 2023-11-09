<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'status',
        'amount',
        'player_id',
        'pay_date'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }
}
