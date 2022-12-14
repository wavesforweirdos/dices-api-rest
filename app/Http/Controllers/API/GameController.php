<?php

namespace App\Http\Controllers\API;

use App\Events\PlayerThrowsDices;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use App\Http\Resources\GameResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:Admin')->only('fullSuccessRateRecord', 'ranking', 'loser', 'winner', 'successRate');
    }

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
            $result = event(new PlayerThrowsDices($id, $dice1, $dice2));

            $game = Game::create([
                'dice1' => $dice1,
                'dice2' => $dice2,
                'result' => $result[0],
                'user_id' => $id,
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

        if (!$user) {
            return response([
                'message' => 'Unregistred User',
                'status' => 404,
            ]);
        } elseif ($user_auth_id == $id || $user->hasRole('Admin')) {
            $games = $user->games;
            $countGames = count($games);
            if (!$countGames) {
                return response([
                    'message' => 'The user ' . $user->name . ' has not played yet.',
                    'status' => 200,
                ]);
            } else {
                return response([
                    'games' => $games,
                    'message' => 'Retrieved Succesfully',
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
                'message' => 'All Data Deleted From The User ' . ucfirst($user->name),
                'status' => 200,
            ]);
        } else {
            return response([
                'message' => 'Sorry, you are not authorized to perform this action.',
                'status' => 403,
            ]);
        }
    }

    public function fullSuccessRateRecord()
    {
        $fullSuccessRateRecord = DB::table('games')
            ->select(
                'users.id as ID Player',
                'users.name as Player',
                DB::raw('count(games.result) as Games'),
                DB::raw('sum(games.result = 1) as Victories'),
                DB::raw('concat(round(sum(games.result = 1)*100/count(games.result)),"%") as Success')
            )
            ->join('users', 'games.user_id', '=', 'users.id')
            ->groupBy('ID Player', 'Player')
            ->orderBy('users.id')
            ->get();
        return  $fullSuccessRateRecord;
    }

    public function ranking()
    {
        $ranking = DB::table('games')
            ->select(
                'users.id as ID Player',
                'users.name as Player',
                DB::raw('count(games.result) as Games'),
                DB::raw('sum(games.result = 1) as Victories'),
                DB::raw('round(sum(games.result = 1)*100/count(games.result)) as Success')
            )
            ->join('users', 'games.user_id', '=', 'users.id')
            ->groupBy('ID Player', 'Player')
            ->orderByDesc('Success')
            ->orderBy('users.id')
            ->get();

        return  $ranking;
    }

    public function loser()
    {
        $loser = DB::table('games')
            ->select(
                'users.id as ID Player',
                'users.name as Player',
                DB::raw('count(games.result) as Games'),
                DB::raw('sum(games.result = 1) as Victories'),
                DB::raw('round(sum(games.result = 1)*100/count(games.result)) as Success')
            )
            ->join('users', 'games.user_id', '=', 'users.id')
            ->groupBy('ID Player', 'Player')
            ->orderBy('Success')
            ->orderByDesc('Games')
            ->first();
        return  $loser;
    }

    public function winner()
    {
        $winner = DB::table('games')
            ->select(
                'users.id as ID Player',
                'users.name as Player',
                DB::raw('count(games.result) as Games'),
                DB::raw('sum(games.result = 1) as Victories'),
                DB::raw('round(sum(games.result = 1)*100/count(games.result)) as Success')
            )
            ->join('users', 'games.user_id', '=', 'users.id')
            ->groupBy('ID Player', 'Player')
            ->orderByDesc('Success')
            ->orderByDesc('Games')
            ->first();
        return  $winner;
    }

    public function successRate()
    {
        $successRate = DB::table('games')
            ->select(
                DB::raw('count(games.result) as Games'),
                DB::raw('sum(games.result = 1) as Victories'),
                DB::raw('concat(round(sum(games.result = 1)*100/count(games.result)),"%") as Success')
            )
            ->join('users', 'games.user_id', '=', 'users.id')
            ->get();
        return  $successRate;
    }
}
