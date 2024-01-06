<?php

namespace App\Http\Controllers;

use App\Http\Game\Enums\StatusGameEnum;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return response()->json($games);
    }

    public function store(Request $request)
    {
        $game = new Game([
            'date_game' => $request->input('date_game'),
            'id_team_a' => null,
            'id_team_b' => null,
            'goals_team_a' => null,
            'goals_team_b' => null,
            'status' => StatusGameEnum::SELECT_PLAYERS->getFlag(),
        ]);

        $game->save();

        return response()->json('game created!');
    }

    public function getPendingGames()
    {
        $games = Game::where('status', StatusGameEnum::SELECT_PLAYERS->getFlag())->get();
        return response()->json($games);
    }

    public function getPlayersSelected(Request $request)
    {
        $players = Game::getPlayersSelected($request->input('id_game'));
        return response()->json($players);
    }

    public function finishSelector(Request $request)
    {
        $game = Game::find($request->input('id_game'));
        $game->status = StatusGameEnum::SELECT_TEAMS->getFlag();
        $game->save();

        return response()->json('next step!');
    }
}
