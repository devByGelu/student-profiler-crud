<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'alpha', 'unique:App\Models\User,name'],
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'password' => ['required',
                'min:6',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
                'confirmed'],
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('tokenSecret')->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response($response, 201);
    }

    //
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ['message' => 'Logged out'];

    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $token = $user->createToken('tokenSecret')->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response($response, 201);
    }
}

