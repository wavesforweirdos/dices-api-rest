<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $validatedData['password'] = Hash::make($request->password);
        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;
        return response([
            'user' => $user,
            'access_token' => $accessToken,
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return response([
                'message' => 'Invalid Credentials',
                'status' => 401
            ]);
        };

        $user = $request->user();
        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user' => Auth::user(),
            'access_token' => $accessToken,
            'status' => 200
        ]);
    }
}
