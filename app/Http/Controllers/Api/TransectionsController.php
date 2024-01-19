<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; 

class TransectionsController extends Controller
{
    public function index()
{
    
    \Log::info('User not authenticated');
    if (!Auth::check()) {
        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }
    \Log::info('User authenticated');

    try {
        \Log::info('Authenticated User:', ['user' => Auth::user()]);

        // Get the authenticated user
        $user = Auth::user();

        // Fetch only the transactions for the authenticated user
        $transactions = Transaction::where('recipient_phone', $user->telesom_number)
            ->with('user')
            ->get();
            \Log::info('User Transactions:', ['transactions' => Auth::user()->transactions]);

        return response()->json(['status' => 'success', 'data' => $transactions]);
    } catch (\Exception $e) {
        // Log the exception for debugging
        \Log::error($e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
    }
}

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'sender' => 'required|string',
                'recipient' => 'required|string',
                'recipient_phone' => 'required|string',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i:s', 
                //// Assuming 'time' is in the format HH:mm:ss
              
            ]);

            // Create a new transaction
            $validatedData['transaction_id'] = Str::uuid();
            $validatedData['reference_id'] = Str::uuid();
            $transaction = Transaction::create($validatedData);
         
            return response()->json(['status' => 'success', 'data' => $transaction]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            
            \Log::error('Error in TransectionsController@store: ' . $e->getMessage());
            
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }
}
