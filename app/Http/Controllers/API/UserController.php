<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAllGamesFromUser($id)
    {
        $user_auth_id = Auth::id();
        $user_auth = User::findOrFail($user_auth_id);
        $user = User::findOrFail($id);

        if (!$user) {
            return response([
                'message' => 'Unregistred User',
                'status' => 404,
            ]);
        } elseif ($user_auth_id == $id || $user_auth->hasRole('Admin')) {
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
                'status' => 401,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, $id)
    {
        $user_auth_id = Auth::id();
        $user_auth = User::findOrFail($user_auth_id);
        $user = User::findOrFail($id);

        if (!$user) {
            return response([
                'message' => 'Unregistred User',
                'status' => 404,
            ]);
        } elseif ($user_auth_id == $id || $user_auth->hasRole('Admin')) {

            $request->validate([
                'name' => 'required|min:4|max:25|unique:users',
            ]);

            $user->update($request->all());
            return response([
                'user' => $user,
                'message' => 'Successfully User Updated',
                'status' => 200,
            ]);
        } else {
            return response([
                'message' => 'Sorry, you are not authorized to perform this action.',
                'status' => 401,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyThrowsFromUser($id)
    {
        // A specific game cannot be deleted. 
        // Only a user's total execution log can be deleted.
        $user_auth_id = Auth::id();
        $user_auth = User::findOrFail($user_auth_id);
        $user = User::findOrFail($id);

        if (!$user) {
            return response([
                'message' => 'Unregistred User',
                'status' => 404,
            ]);
        } elseif ($user_auth_id == $id || $user_auth->hasRole('Admin')) {
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
                'status' => 401,
            ]);
        }
    }
}
