<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'player_id',
        'team_name',
        'created_at'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }
}
