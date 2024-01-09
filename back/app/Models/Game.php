<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date_game',
        'id_team_a',
        'id_team_b',
        'goals_team_a',
        'goals_team_b',
        'status'
    ];

    public static function getPlayersSelected(int $gameId): array
    {
        return DB::select(
            <<<SQL
                select
                    p.id,
                    p.name,
                    pg.id as id_players_game
                from players p 
                left join players_games pg on (p.id = pg.player_id)
                where pg.game_id = :gameid or pg.game_id is null order by 1
            SQL,
            ['gameid' => $gameId]
        );
    }
}
