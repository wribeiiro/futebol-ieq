<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function list()
    {
        $player = Player::all();

        return response()->json($player);
    }
}
