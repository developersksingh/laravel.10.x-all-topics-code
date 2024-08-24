<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;


class ApiController extends Controller
{

    //Register API (POST,FormData)
    public function register(Request $request)
    {

        // Data Validations
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        //Create a user
        user::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        return response()->json([
            "status" => true,
            "message" =>  "User Registered Successfuly"
        ]);
    }

    // Login API (POST, FormData)
    public function login(Request $request)
    {
        // Data Validations
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        //Email Check : In Databse
        $userInfo  = User::where(["email" => $request->email])->first();

        // If user Exist than concept of password validation
        if (!empty($userInfo)) {
            if (Hash::check($request->password, $userInfo->password)) {
                // User Exists
                $accessToken  =  $userInfo->createToken("loginToken")->plainTextToken;
                return response()->json([[
                    "status" => true,
                    "message" => "Login Successfull",
                    "accessToken" => $accessToken
                ]]);
            } else {
                return response()->json([[
                    "status" => false,
                    "message" => "password didn't match"
                ]]);
            }

            // Sanctum Token Value
        } else {
            return response()->json([[
                "status" => false,
                "message" => "Invalid login credentials"
            ]]);
        }
    }

    // Profile API (GET)
    public function profile()
    {
        $userInfo  =  auth()->user();
        return response()->json([[
            "status" => true,
            "message" => "Profile Information",
            "userDetails" => $userInfo
        ]]);
    }

    // Logout API (GET)

    public function logout()
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Delete all of the user's tokens
            auth()->user()->tokens()->delete();

            return response()->json([
                "status" => true,
                "message" => "User Logged Out Successfully",
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "No authenticated user found",
            ], 401);
        }
    }
}
