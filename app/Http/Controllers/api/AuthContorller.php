<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    /**
     * LOGIN
     */
    public function login(Request $request) {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check the valid email first
        $user = User::where('email', $fields['email'])->first();

        // Check the password
        if (!$user || !Hash::check($fields['password'], $user->password)) {

            return response([

                'message' => 'Invalid Email or Password'

            ], 401);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    /**
     * LOGOUT
     */
    public function logout() {

        auth()->user()->tokens()->delete();

        return [
            'message' => 'You Logged out Successfully'
        ];
    }

}