<?php

namespace App\Http\Controllers\API;
use App\Models\CrossTransferModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class cros_transfer_requests extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           // You can implement functionality to fetch and display cross-transfer requests
           $crossTransfers = CrossTransferModel::all();
           return response()->json($crossTransfers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'sender_wallet_number' => 'required',
            'receiver_wallet_number' => 'required',
            'amount' => 'required',
        ]);
    
        // Set the initial status to 'initial'
        $validatedData['status'] = 'pending';
    
        // Create a new cross-transfer request
        $crossTransfer = CrossTransferModel::create($validatedData);
    
        // Return a JSON response
        return response()->json(['status' => 'success', 'data' => $crossTransfer]);
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
          // Validate the incoming request
          $request->validate([
            'status' => 'required|in:initial,pending,success,failed',
        ]);

        // Update the status of the cross-transfer request
        $crossTransfer = CrossTransferModel::findOrFail($id);
        $crossTransfer->update(['status' => $request->status]);

        // You may want to perform additional actions here based on the updated status

        return response()->json($crossTransfer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // Delete the specified cross-transfer request
         CrossTransferModel::findOrFail($id)->delete();

         // You may want to perform additional cleanup or logging here
 
         return response()->json(['message' => 'Cross-transfer request deleted successfully']);
     
    }
}
