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
        if ($request['name'] == null) {
            $validatedData = $request->validate([
                'name' => 'nullable',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            $validatedData['name'] = 'Anonymous';
        } else {
            $validatedData = $request->validate([
                'name' => 'required|max:25|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
        };

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

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response([
            'user' => Auth::user(),
            'message' => 'Successfully Logged',
            'status' => 200
        ]);
    }

  
}
