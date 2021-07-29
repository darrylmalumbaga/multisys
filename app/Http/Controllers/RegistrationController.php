<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Notifications\RegisteredUserNotification;
use Notification;
use App\User;

class RegistrationController extends Controller
{

    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rules = [
            'email'    => 'unique:users|required',
            'password' => 'required',
        ];

        $input     = $request->only('email','password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()],400);
        }

        $email    = $request->email;
        $password = $request->password;
        $user     = User::create(['email' => $email, 'password' => Hash::make($password)]);
        Notification::route('mail', 'dmzmsz@gmail.com')->notify(new RegisteredUserNotification($user));

        return response()->json(['success' => true, 'message' => 'User successfully registered'],201);
    }

}
