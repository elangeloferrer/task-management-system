<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Validators\RegisterUserValidator;
use App\Helpers\ApiResponse;

use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = RegisterUserValidator::validate($request);

        if ($validator->fails()) {
            return ApiResponse::validationErrors($validator->errors(), 422);
        }

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            Auth::login($user);

            return ApiResponse::success([
                'user' => new UserResource($user)
            ], 'Successfully registered!', 200);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return ApiResponse::error('Username or password is incorrect.', 401);
        }

        return ApiResponse::success([
            'user' => new UserResource(Auth::user())
        ], 'Successfully login!', 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out']);
    }
}
