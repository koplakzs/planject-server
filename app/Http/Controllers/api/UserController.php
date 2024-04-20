<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $credential = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);


        if (Auth::attempt($credential)) {
            $user = User::where("email", $credential['email'])->firstOrFail();
            $token = $user->createToken($credential['email'])->plainTextToken;
            return response()->json([
                "status" => "success",
                "statusCode" => 200,
                "data" => [
                    "token" => $token,
                    "userId" => $user->uuid,
                    "username" => $user->username,
                    "role" => $user->role
                ]
            ], 200);
        }


        return response()->json([
            "status" => "failed",
            "statusCode" => 400,
        ], 400);
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            "username" => "required",
            "email" => "required|email",
            "role" => "required",
            "password" => "required",
        ]);
        $validate['password'] = bcrypt($validate['password']);
        User::create($validate);

        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "message" => "Success Created Account"
        ], 200);
    }

    public function redirect()
    {
        return response()->json([
            "message" => "unautho"
        ]);
    }
}
