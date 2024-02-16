<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletProfile;
class WalletsProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $walletProfiles = WalletProfile::all();
        return response()->json($walletProfiles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Wallet_Name' => 'required',
            'Wallet_Provider' => 'required',
            'Wallet_Type' => 'required',
            'Merchant_Number' => 'required',
            'Status' => 'required',
        ]);

        $walletProfile = WalletProfile::create($request->all());

        return response()->json($walletProfile, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $walletProfile = WalletProfile::findOrFail($id);
        return response()->json($walletProfile);
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
        $request->validate([
            'Wallet_Name' => 'required',
            'Wallet_Provider' => 'required',
            'Wallet_Type' => 'required',
            'Merchant_Number' => 'required',
            'Status' => 'required',
            
        ]);

        $walletProfile = WalletProfile::findOrFail($id);
        $walletProfile->update($request->all());

        return response()->json($walletProfile, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $walletProfile = WalletProfile::findOrFail($id);
        $walletProfile->delete();

        return response()->json(null, 204);
    }
}
