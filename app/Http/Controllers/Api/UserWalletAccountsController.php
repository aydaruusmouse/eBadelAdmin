<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserWalletAccount;
use App\Models\WalletProfile;
use Illuminate\Support\Facades\Auth; 
use App\Models\Order;
use Illuminate\Support\Facades\Log;
class UserWalletAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authenticatedUserProfileId = auth()->user()->User_Profile_Id;
        $walletProfiles = UserWalletAccount::where('User_Profile_Id', $authenticatedUserProfileId)->get();
        return response()->json($walletProfiles);
    }
    
    public function Userwallets()
    {
        $authenticatedUserProfileId = auth()->user()->User_Profile_Id;
        $walletProfiles = UserWalletAccount::where('User_Profile_Id', $authenticatedUserProfileId)
            ->where('Status', 'active') // Add this line to filter by active status
            ->get();

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
        'Account_Number' => 'required',
        'Account_Name' => 'required',
        'Wallet_Id'=> 'required',
        // 'Status'=> 'required',
    ]);

    if (!Auth::check()) {
        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    \Log::info('Authenticated User ID:', ['user_id' => $user->User_Profile_Id]);
    \Log::info('Authenticated User ID:', ['user_id' => $user]); // Remove ->id from $user

    $walletId = $request->input('Wallet_Id');
    $walletStatus = $request->input('Status');
    // $walletId=1;

    $data = [
        'Account_Number' => $request->Account_Number,
        'Account_Name' => $request->Account_Name,
        'User_Profile_Id' => $user->User_Profile_Id, // Set User_Profile_Id to the authenticated user's ID
        'Wallet_Id' => $walletId,
        'Status' => $walletStatus,
    ];

    $walletAccount = UserWalletAccount::create($data);

    return response()->json($walletAccount, 201);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $walletAccount = UserWalletAcccount::findOrFail($id);
        return response()->json($walletAccount);
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
            'Account_Number' => 'required',
            'Account_Name' => 'required',

        ]);

        $walletAccount = UserWalletAccount::findOrFail($id);
        $walletAccount->update($request->all());

        return response()->json($walletAccount, 200);
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
