<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller{

    //Register API (POST,FormData)
    public function register(Request $request){
        $request->validate([
          "name" => "required|max:100",
          "email" => "required|email|unique:users",
          "password" => "required|confirmed"
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
