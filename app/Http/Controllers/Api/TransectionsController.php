<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransectionsController extends Controller
{
    public function index()
    {
        try {
            // Retrieve all transactions
            $transactions = Transaction::all();

            return response()->json(['status' => 'success', 'data' => $transactions]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }

    public function store(Request $request)
    {
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
