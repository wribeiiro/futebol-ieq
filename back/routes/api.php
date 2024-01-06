<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayersGameController;
use App\Http\Controllers\SquadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    //players
    Route::get('/players', [PlayerController::class, 'list'])->name('players');

    //games
    Route::get('/game', [GameController::class, 'index'])->name('game');
    Route::post('/game', [GameController::class, 'store'])->name('store');
    Route::get('/game/pending', [GameController::class, 'getPendingGames'])->name('getPendingGames');
    Route::get('/game/players', [GameController::class, 'getPlayersSelected'])->name('getPlayersSelected');
    Route::post('/game/players/selector', [GameController::class, 'selector'])->name('selector');
    Route::post('/game/finish/selector', [GameController::class, 'finishSelector'])->name('finishSelector');
    
    //PlayersGame
    Route::post('/playersgame/selector', [PlayersGameController::class, 'selector'])->name('selector');
    Route::get('/playersgame/team', [PlayersGameController::class, 'teamsGame'])->name('team');

    Route::resource('payment', PaymentController::class);
    Route::resource('player', PlayerController::class);
    Route::resource('squad', SquadController::class);

    Route::get('/balance', [PaymentController::class, 'balance'])->name('balance');
});
