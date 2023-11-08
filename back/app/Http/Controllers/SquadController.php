<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Squad;

class SquadController extends Controller
{
    public function index()
    {
        $squad = Squad::with(['player'])->get();
        return response()->json($squad);
    }

    public function store(Request $request)
    {
        $squad = new Squad([
            'player_id' => $request->input('player_id'),
            'team_name' => $request->input('team_name'),
        ]);

        $squad->save();

        return response()->json('squad created!');
    }

    public function show($id)
    {
        $squad = Squad::find($id);
        return response()->json($squad);
    }

    public function update($id, Request $request)
    {
        $squad = Squad::find($id);
        $squad->update($request->all());

        return response()->json('squad updated!');
    }

    public function destroy($id)
    {
        $squad = Squad::find($id);
        $squad->delete();

        return response()->json('squad deleted!');
    }
}
