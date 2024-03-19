<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BridgeFee;

class BridgeFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
     
    public function readBrigdeFee(){
        $feePercentage = BridgeFee::where('Origin_Wallet', 'Zaad')
    ->where('Destination_Wallet', 'eBirr')
    ->where('Origin_Currency', 'USD')
    ->where('Destination_Currency', 'BIRR')
    ->pluck('Fee_Percentage')
    ->first();
    return response()->json($feePercentage);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            // Validate the request data
            $request->validate([
                'Origin_Wallet' => 'required|string',
                'Destination_Wallet' => 'required|string',
                'Origin_Currency' => 'required|string',
                'Destination_Currency' => 'required|string',
                'Fee_Percentage' => 'required|numeric',
            ]);
    
            // Create a new BridgeFee instance
            $bridgeFee = new BridgeFee();
            $bridgeFee->Origin_Wallet = $request->input('Origin_Wallet');
            $bridgeFee->Destination_Wallet = $request->input('Destination_Wallet');
            $bridgeFee->Origin_Currency = $request->input('Origin_Currency');
            $bridgeFee->Destination_Currency = $request->input('Destination_Currency');
            $bridgeFee->Fee_Percentage = $request->input('Fee_Percentage');
    
            // Save the BridgeFee instance
            $bridgeFee->save();
    
            // Return a success response
            return response()->json(['message' => 'Bridge fee saved successfully'], 201);
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
