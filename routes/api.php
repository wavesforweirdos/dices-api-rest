<?php

use App\Http\Controllers\API\AuthUserController;
use App\Http\Controllers\API\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/players', [AuthUserController::class, 'register'])->name('register'); //create player
Route::post('/login', [AuthUserController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', [AuthUserController::class, 'logout'])->name('logout');
    Route::put('/players/{id}', [AuthUserController::class, 'edit'])->name('editName'); //edit name's player 

    Route::post('/players/{id}/games/', [GameController::class, 'throw'])->name('throw'); //a player throw dices
    Route::delete('/players/{id}/games', [GameController::class, 'destroyThrowsFromUser'])->name('deleteThrows'); //delete all player's throws
    Route::get('/players/{id}/games', [GameController::class, 'showAllGamesFromUser'])->name('throws'); //throws of onePlayer

    Route::get('/players', [GameController::class, 'fullSuccessRateRecord'])->name('admin.fullSuccessRateRecord'); //allPlayers & their %victories
    Route::get('/players/ranking', [GameController::class, 'ranking'])->name('ranking'); //%victories of allGame sortBy Asc
    Route::get('/players/ranking/loser', [GameController::class, 'loser'])->name('loser'); //loser player
    Route::get('/players/ranking/winner', [GameController::class, 'winner'])->name('winner'); //winner player
    Route::get('/players/successRate', [GameController::class, 'successRate'])->name('admin.successRate'); //success rate
});
