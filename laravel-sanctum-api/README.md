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

