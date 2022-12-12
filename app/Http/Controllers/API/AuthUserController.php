<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
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
        //return la información del usuario y el token generado
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
            //las credenciales son incorrectas o no existen
            return response([
                'message' => 'Invalid Credentials',
                'status' => 401
            ]);
        } else {
            //generamos el token de acceso
            $user = $request->user();
            $accessToken = $user->createToken('authToken')->accessToken;

            //devolvemos la información del usuario, el token de acceso y success status
            return response([
                'user' => Auth::user(),
                'access_token' => $accessToken,
                'status' => 200
            ]);
        };
    }

    public function logout(Request $request)
    {

        $request->user()->token()->revoke();
        return response([
            'user' => Auth::user(),
            'message' => 'Succesfully Logged',
            'status' => 200
        ]);
    }

    public function assignPlayerRole(User $user)
    {
        $user->assignRole('Player');
    }

    public function assignAdminRole(User $user)
    {
        $user->assignRole('Admin');
    }

    public function edit($id)
    {
    }
}
