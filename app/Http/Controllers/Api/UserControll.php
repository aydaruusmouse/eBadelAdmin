<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
class UserControll extends Controller
{
    // add index and read the data 
  
   public function index()
   {
       $users = User::all();
       return response()->json(['status' => 'success', 'data' => $users]);
   }

   // Access a single user by its id
   public function show($id)
   {
       $user = User::find($id);
       if (!$user) {
           return response()->json(['status' => 'error', 'message' => 'User not found']);
       }

       return response()->json(['status' => 'success', 'data' => $user]);
   }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'telesom_number' => 'nullable|string', // adjust validation as needed
            'somtel_number' => 'nullable|string', 
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        // Hash the password
        $password = bcrypt($request->password);
        $request->merge(['password' => $password]);

        // Create the user account
        $created = User::create($request->all());

        // If user creation fails, return an error response
        if (!$created) {
            return response()->json(['success' => false, 'message' => 'User registration failed.'], 500);
        }

        // Login now (you may need to implement your login logic here)
        // For example, you can call the login method if it's defined in the same controller.

        return response()->json(['success' => true, 'message' => 'User registered successfully.'], 201);
    }

    
 // Log in a user
//  public function login(Request $request)
//  {
//      $validator = Validator::make($request->all(), [
//          'telesom_number' => 'required|string',
//      ]);

//      if ($validator->fails()) {
//          return response()->json(['status' => 'error', 'errors' => $validator->errors()], 400);
//      }

//      // Check if a user with the provided telesom_number exists
//      $user = User::where('telesom_number', $request->telesom_number)->first();

//      if ($user) {
//          // If the user exists, generate a token and return it
//          $token = $user->createToken('auth_token')->plainTextToken;
//          return response()->json(['status' => 'success', 'token' => $token]);
//      }

//      // If no user found with the provided telesom_number, return an error
//      return response()->json(['status' => 'error', 'message' => 'Invalid telesom number'], 401);
//  }

public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'telesom_number' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'errors' => $validator->errors()], 400);
    }

    // Check if a user with the provided telesom_number exists
    $user = User::where('telesom_number', $request->telesom_number)->first();

    if ($user) {
        // If the user exists, generate a token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Store the token in the personal_access_tokens table
        $tokenModel = new PersonalAccessToken();
        $tokenModel->forceFill([
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user),
            'name' => 'auth_token',
            'token' => $token,
            'abilities' => ['*'],
        ])->save();

        return response()->json(['status' => 'success', 'token' => $token]);
    }

    // If no user found with the provided telesom_number, return an error
    return response()->json(['status' => 'error', 'message' => 'Invalid telesom number'], 401);
}

 // Log out a user
 public function logout(Request $request)
 {
     Auth::logout();

     return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
 }

 // Get the current user
 public function getCurrentUser(Request $request)
 {
     if (!User::checkToken($request)) {
         return response()->json([
             'message' => 'Token is required'
         ], 422);
     }
     
     $user = JWTAuth::parseToken()->authenticate();

     // Add isProfileUpdated....
     $isProfileUpdated = false;
     if ($user->isPicUpdated == 1 && $user->isEmailUpdated) {
         $isProfileUpdated = true;
     }
     $user->isProfileUpdated = $isProfileUpdated;

     return $user;
 }



   
public function update(Request $request){
    $user=$this->getCurrentUser($request);
    if(!$user){
        return response()->json([
            'success' => false,
            'message' => 'User is not found'
        ]);
    }
   
    unset($data['token']);

    $updatedUser = User::where('id', $user->id)->update($data);
    $user =  User::find($user->id);

    return response()->json([
        'success' => true, 
        'message' => 'Information has been updated successfully!',
        'user' =>$user
    ]);
}

public function getCurrentUserWithTransactions(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        // Get the currently authenticated user
        $user = Auth::user();

        // Get all transactions associated with the user
        $userTransactions = $user->transactions;

        // You can now use $userTransactions as needed

        return response()->json(['status' => 'success', 'user' => $user, 'transactions' => $userTransactions]);
    }
}
