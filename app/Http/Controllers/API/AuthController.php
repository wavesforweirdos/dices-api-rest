<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $loginData = $request->all();
        if ($request['name'] == null) {
            $validator = Validator::make($loginData, [
                'name' => 'nullable',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            $validatedData = $request->validate([
                'name' => 'nullable',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            $validatedData['name'] = 'Anonymous';
        } else {
            $validator = Validator::make($loginData, [
                'name' => 'required|max:25|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
        };

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors(),
                'status' => 422
            ]);
        }

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
        $loginData = $request->all();
        $validator = Validator::make($loginData, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors(),
                'status' => 422
            ]);
        } else {
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
