<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Resources\GameResource;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $game = Game::all();
        return response([
            'game' => $game,
            'message' => 'Retrieved Succesfully',
            'status' => 200,
        ]);
    }

 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'dice1' => 'required|integer|min:1|max:6',
            'dice2' => 'required|integer|min:1|max:6',
            'result' => 'required|boolean',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'message' => 'Validation Fail',
                'status' => 400,
            ]);
        }

        $game = Game::create($data);

        return response([
            'game' => new GameResource($game),
            'message' => 'Created Succesfully',
            'status' => 200,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return response([
            'game' => new GameResource($game),
            'message' => 'Retrieved Succesfully',
            'status' => 200
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $game->update($request->all());

        return response([
            'game' => new GameResource($game),
            'message' => 'Retrieved Succesfully',
            'status' => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */

    public function destroy(User $user)
    {
        // A specific game cannot be deleted. 
        // Only a user's total execution log can be deleted.
        $allGamesFromUser = $user->games();
        $allGamesFromUser->delete();

        return response([
            'game' => new GameResource($allGamesFromUser),
            'message' => 'Deleted',
            'status' => 200,
        ]);
    }
}
