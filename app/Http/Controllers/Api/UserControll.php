<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserControll extends Controller
{
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
    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
        'telesom_number' => 'nullable|string', // adjust validation as needed
        'somtel_number' => 'nullable|string', // adjust validation as needed
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'errors' => $validator->errors()], 400);
    }

    $credentials = $request->only('email', 'password');

    // Add conditions for telesom_number and somtel_number if provided
    if ($request->has('telesom_number')) {
        $credentials['telesom_number'] = $request->telesom_number;
    }

    if ($request->has('somtel_number')) {
        $credentials['somtel_number'] = $request->somtel_number;
    }

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => 'success', 'token' => $token]);
    }

    return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
}
public function logout(Request $request)
{
    Auth::logout();

    return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
}

    public function getCurrentUser(Request $request){
       if(!User::checkToken($request)){
           return response()->json([
            'message' => 'Token is required'
           ],422);
       }
        
        $user = JWTAuth::parseToken()->authenticate();
       // add isProfileUpdated....
       $isProfileUpdated=false;
        if($user->isPicUpdated==1 && $user->isEmailUpdated){
            $isProfileUpdated=true;
            
        }
        $user->isProfileUpdated=$isProfileUpdated;

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
