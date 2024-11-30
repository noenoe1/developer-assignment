<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    //
    public function login(LoginRequest $request) {
        $request->validated();

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => true,
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
       
    }

    public function register(RegisterRequest $request) {
        $existingUser = User::where('email', $request['email'])->first();

        if($existingUser) {
            return response()->json([
                'status' => false,
                'message' => 'Email already exists.'
            ]);
        }

        User::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Success'
        ]);
    }

}
