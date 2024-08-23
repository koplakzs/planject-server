<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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

            // $cookieOption = [
            //     'expire' => 60 * 24,
            //     'secure' => true,
            //     'httpOnly' => true
            // ];

            // Cookie::queue(['userToken', $token, $cookieOption]);
            // Cookie::queue('userId', $token, $user->uuid);

            $setUserToken = cookie("userToken", $token, 60 * 24, "/", sameSite: "none");
            $setUserId = cookie("userId", $user->uuid, 60 * 24, "/", sameSite: "none");

            $response =  response()->json([
                "status" => "success",
                "statusCode" => 200,
                "data" => [
                    "token" => $token,
                    "userId" => $user->uuid,
                    "username" => $user->username,
                    "role" => $user->role
                ]
            ], 200);

            $response->withCookie($setUserToken);
            $response->withCookie($setUserId);

            return $response;
        }


        return response()->json([
            "status" => "failed",
            "statusCode" => 400,
        ], 400);
    }

    public function register(Request $request)
    {
        try {
            $validate = $request->validate([
                "username" => "required",
                "email" => "required|email",
                "role" => "required",
                "password" => "required",
            ]);

            $checkEmail = User::where("email", $validate['email'])->first();

            if ($checkEmail != null) {
                return response()->json([
                    "status" => "fail",
                    "statusCode" => 403,
                    "message" => "Email already exists"
                ], 403);
            }

            $validate['password'] = bcrypt($validate['password']);
            User::create($validate);

            return response()->json([
                "status" => "success",
                "statusCode" => 200,
                "message" => "Success Created Account"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "fail",
                "statusCode" => 500,
                "message" => "Failed Created Account"
            ], 500);
        }
    }

    public function redirect()
    {
        return response()->json([
            "message" => "unautho"
        ]);
    }
}
