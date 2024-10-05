<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $userData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $userData['password'] = Hash::make($userData['password']);
        $userData['email_verified_at'] = now();
        $user = User::create($userData);

        return response()->json([ 
            'user' => $user, 
            'token' => $user->createToken('passportToken')->accessToken,
            'message' => 'User has been registered successfully.',
        ], 200);
    }
    public function login(Request $request)
    {
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];
  
        if (Auth::attempt($credentials)) 
        {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('passportToken')->accessToken;
             
            return response()->json([
                'user' => Auth::user(), 
                'token' => $token
            ], 200);
        }
  
        return response()->json([
            'error' => 'Unauthorised'
        ], 401);
  
    }
}
