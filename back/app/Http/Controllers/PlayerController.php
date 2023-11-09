<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    public function index()
    {
        $player = Player::all();
        return response()->json($player);
    }

    public function store(Request $request)
    {
        $player = new Player([
            'name' => $request->input('name'),
            'image' => $request->input('image'),
        ]);

        $player->save();

        return response()->json('player created!');
    }

    public function show($id)
    {
        $player = Player::find($id);
        return response()->json($player);
    }

    public function update($id, Request $request)
    {
        $player = Player::find($id);

        foreach ($request->all() as $key => $value) {
            $player->{$key} = $value;
        }

        $player->update();

        return response()->json('player updated!');
    }

    public function destroy($id)
    {
        $player = Player::find($id);
        $player->delete();

        return response()->json('player deleted!');
    }
}
