<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlayersGame extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'player_id'
    ];

    public static function teamsGame(int $gameId): array
    {
        return DB::select(
            <<<SQL
               select
                    p.id,
                    p.name,
                    pg.id as id_players_game
                from players p 
                left join players_games pg on (p.id = pg.player_id)
                where pg.game_id = :gameid order by 1;
            SQL,
            ['gameid' => $gameId]
        );
    }
}
