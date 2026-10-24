<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\UserController;
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

Route::post('/players', [AuthController::class, 'register'])->name('register'); //create player
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('/players/{id}', [UserController::class, 'edit'])->name('editName'); //edit name's player 

    Route::post('/players/{id}/games/', [GameController::class, 'throw'])->name('throw'); //a player throw dices
    Route::delete('/players/{id}/games', [UserController::class, 'destroyThrowsFromUser'])->name('deleteThrows'); //delete all player's throws
    Route::get('/players/{id}/games', [UserController::class, 'showAllGamesFromUser'])->name('throws'); //throws of onePlayer

    Route::get('/players', [GameController::class, 'fullSuccessRateRecord'])->name('admin.fullSuccessRateRecord'); //allPlayers & their %victories
    Route::get('/players/ranking', [GameController::class, 'ranking'])->name('ranking'); //%victories of allGame sortBy Asc
    Route::get('/players/ranking/loser', [GameController::class, 'loser'])->name('loser'); //loser player
    Route::get('/players/ranking/winner', [GameController::class, 'winner'])->name('winner'); //winner player
    Route::get('/players/successRate', [GameController::class, 'successRate'])->name('admin.successRate'); //success rate
});
