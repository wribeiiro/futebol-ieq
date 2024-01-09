<?php

namespace App\Http\Controllers;

use App\Models\PlayersGame;
use Illuminate\Http\Request;

class PlayersGameController extends Controller
{
    public function selector(Request $request)
    {
        if ($request->input('option') == 2) {
            PlayersGame::find($request->input('id_players_game'))->delete();
            return response()->json('game deleted!');
        }

        $game = new PlayersGame([
            'game_id' => $request->input('game_id'),
            'player_id' => $request->input('player_id'),
        ]);

        $game->save();

        return response()->json('game updated!');
    }

    public function teamsGame(Request $request)
    {
        $game = PlayersGame::teamsGame($request->input('id_game'));

        return response()->json($game);
    }
}
