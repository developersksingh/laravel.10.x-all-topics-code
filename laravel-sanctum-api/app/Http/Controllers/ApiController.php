<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiController extends Controller{

    //Register API (POST,FormData)
    public function register(Request $request){

        // Data Validations
        $request->validate([
          "name" => "required|string",
          "email" => "required|email|unique:users",
          "password" => "required|confirmed"
        ]);

        //Create a user
        user::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password)
        ]);
        return response()->json([
            "status" => true,
            "message" =>  "User Registered Successfuly"
        ]);
    }

    // Login API (POST, FormData)
    public function login(Request $request){

    }

    // Profile API (GET)
    public function profile(){

    }

    // Logout API (GET)
    public function logout(){

    }
}
