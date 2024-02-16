<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use App\Models\User;
use App\Models\UserProfile;
use Laravel\Sanctum\PersonalAccessToken;
class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       $users = UserProfile::all();
       return response()->json(['status' => 'success', 'data' => $users]);
   }
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'Login_Phone' => 'required|string',
            'First_Name' => 'required|string',
            'Last_Name' => 'required|string',
            'Gender' => 'required|in:male,female',
            'Date_of_Birth' => 'required|date_format:Y-m-d',
            // 'Join_Date' => 'required|date',
        ]);
    
        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
    
        // Create the user account
        $created = UserProfile::create($request->all());
    
        // If user creation fails, return an error response
        if (!$created) {
            return response()->json(['success' => false, 'message' => 'User registration failed.'], 500);
        }
    
        return response()->json(['success' => true, 'message' => 'User registered successfully.'], 201);
    }

    // login

   // Log in a user

   public function login(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'Login_Phone' => 'required|string',
       ]);
   
       if ($validator->fails()) {
           return response()->json(['status' => 'error', 'errors' => $validator->errors()], 400);
       }
   
       // Check if a user with the provided Login_Phone exists
       $user = UserProfile::where('Login_Phone', $request->Login_Phone)->first();
   
       if ($user) {
           // If the user exists, generate a token
           $token = $user->createToken('auth_token')->plainTextToken;
   
           // Return the token
           return response()->json(['status' => 'success', 'token' => $token]);
       }
   
       // If no user found with the provided Login_Phone, return an error
       return response()->json(['status' => 'error', 'message' => 'Invalid Login_Phone'], 401);
   }
   
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
