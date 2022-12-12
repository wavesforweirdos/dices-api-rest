<?php

namespace App\Http\Controllers\API;

use App\Events\PlayerThrowsDices;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use App\Http\Resources\GameResource;
use Illuminate\Support\Facades\Auth;


class GameController extends Controller
{
    public function throw($id)
    {
        $user_auth_id = Auth::id();
        $user = User::find($id);
        if (!$user) {
            return response([
                'message' => 'Unregistred User',
                'status' => 404,
            ]);
        } elseif ($user_auth_id == $id || $user->hasRole('Admin')) {
            $dice1 = rand(1, 6);
            $dice2 = rand(1, 6);

            $event = event(new PlayerThrowsDices($id, $dice1, $dice2));

            $game = Game::create([
                $event
            ]);

            return response([
                'game' => new GameResource($game),
                'message' => 'Well played!',
                'status' => 200,
            ]);
        } else {
            return response([
                'message' => 'Sorry, you are not authorized to perform this action.',
                'status' => 403,
            ]);
        }
    }

    public function showAllGamesFromUser($id)
    {
        $user_auth_id = Auth::id();;
        $user = User::find($id);
        $games = $user->games;

        if (!$user) {
            return response([
                'message' => 'Unregistred User',
                'status' => 404,
            ]);
        } elseif ($user_auth_id == $id || $user->hasRole('Admin')) {
            $games = Game::all();
            if (!$games) {
                return response([
                    'message' => 'This user ' . $user->name . 'has not played yet.',
                    'status' => 200,
                ]);
            } else {
                return response([
                    'games' => $games,
                    'message' => 'Retrieved Successfully',
                    'status' => 200,
                ]);
            }
        } else {
            return response([
                'message' => 'Sorry, you are not authorized to perform this action.',
                'status' => 403,
            ]);
        }
    }

    public function showOneGame(Game $game)
    {
        $user_auth_id = Auth::id();
        $user = $game->player;
        $user_id = $user->id;

        if (!$user) {
            return response([
                'message' => 'Unregistred User',
                'status' => 404,
            ]);
        } elseif ($user_auth_id == $user_id || $user->hasRole('Admin')) {
            return response([
                'game' => new GameResource($game),
                'message' => 'This user ' . $user->name . 'just played.',
                'status' => 200,
            ]);
        } else {
            return response([
                'message' => 'Sorry, you are not authorized to perform this action.',
                'status' => 403,
            ]);
        }
    }

    public function destroyThrowsFromUser($id)
    {
        // A specific game cannot be deleted. 
        // Only a user's total execution log can be deleted.
        $user_auth_id = Auth::id();
        $user = User::find($id);

        if (!$user) {
            return response([
                'message' => 'Unregistred User',
                'status' => 404,
            ]);
        } elseif ($user_auth_id == $id || $user->hasRole('Admin')) {
            $user = User::find($id);
            $allGamesFromUser = $user->games();
            $allGamesFromUser->delete();

            return response([
                'game' => 0,
                'message' => 'Deleted All Data From User' . $user->name,
                'status' => 200,
            ]);
        } else {
            return response([
                'message' => 'Sorry, you are not authorized to perform this action.',
                'status' => 403,
            ]);
        }
    }
}
