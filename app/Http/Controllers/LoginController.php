<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    protected $maxAttempts = 5; // Default is 5
    protected $decayMinutes = 5; // Default is 1
    /**
     * API Login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()],422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response()->json(['access_token' => $token],201);
            } else {
                return response()->json(['message' => 'Invalid credentials'],401);
            }
        } else {
            return response()->json(['message' => 'User does not exist'],401);
        }
    }
}
