<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wallets;
use Illuminate\Support\Facades\Auth;

class WalletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
         // Retrieve all wallets
         $wallets = wallets::all();

         return response()->json(['status' => 'success', 'data' => $wallets]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $userId = auth()->user()->id;
    
            // Validate the request
            $request->validate([
                'name' => 'required|string',
            ]);
    
            // Create a new wallet for the user
            $userWallet = wallets::create([
                'user_id' => $userId,
                'name' => $request->input('name'),
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'Wallet created successfully', 'data' => $userWallet]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve wallets for a specific user
        $wallets = wallets::where('user_id', $userId)->get();

        return response()->json(['status' => 'success', 'data' => $wallets]);
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
         // Validate the request
         $request->validate([
            'name' => 'required|string',
        ]);

        // Update the wallet
        $wallet = wallets::findOrFail($walletId);
        $wallet->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Wallet updated successfully', 'data' => $wallet]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // Delete the wallet
         $wallet = wallets::findOrFail($walletId);
         $wallet->delete();
 
         return response()->json(['status' => 'success', 'message' => 'Wallet deleted successfully']);
    }
}
