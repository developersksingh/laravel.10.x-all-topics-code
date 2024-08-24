# laravel.10.x-all-topics-code :  <u>Laravel Sanctum</u>
Laravel Sanctum provides a featherweight authentication system for SPAs (single page applications), mobile applications,
and simple, token based APIs. Sanctum allows each user of your application to generate multiple API tokens for their
account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform.

In the Topic we learn : 
1. Laravel installation : Done
2. Database Connectivity
3. API Controllers & MethodS Settings
4. About Sanctum Auth Package Setting
5. Setups API Routes
6. Register API
7 Login API
8. Profile API
9. Logout API

Here : 
 
#open Routes : 
  Register & Login

#Protected Routes : 
  Profile & Logout

Step 1: Laravel installation : Done
    composer create-project laravel/laravel:^10.0 laravel-sanctum-api

Step 2: 
    Database Connectivity : Done

step 3: 
    API Controllers & MethodS Settings  : Done
    A. php artisan make:controller ApiController


step 4: About Sanctum Auth Package Setting : Done   
    Laravel Sanctum offers this feature by storing user API tokens in a single database table and authenticating incoming HTTP requests via the Authorization header which should contain a valid API token.

    For this feature, Sanctum does not use tokens of any kind. Instead, Sanctum uses Laravel's built-in cookie based session authentication services. Typically, Sanctum utilizes Laravel's web authentication guard to accomplish this. This provides the benefits of CSRF protection, session authentication, as well as protects against leakage of the authentication credentials via XSS.

    Sanctum will only attempt to authenticate using cookies when the incoming request originates from your own SPA frontend. When Sanctum examines an incoming HTTP request, it will first check for an authentication cookie and, if none is present, Sanctum will then examine the Authorization header for a valid API token.

Note : By Default sanctum allready install in laravel 10, No need to install again :  (auth::sanctum)
Here Sanctum using this table for generate a TOKEN :  laravel-sanctum-api\database\migrations\2019_12_14_000001_create_personal_access_tokens_table.php

Inside :  laravel-sanctum-api\config\sanctum.php : Basic settings of sanctum , and configure it.

Step 5. 
    Setups API Routes : Done Than php artisan migrate
Register a new user API : http://localhost:8000/api/register  [postman body/row/ ] Type :  JSON

{
    "name": "Sanjay Singh",
    "email":"sanjaysingh@gmail.com",
    "password":123456,
    "password_confirmation" :123456
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

```
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
