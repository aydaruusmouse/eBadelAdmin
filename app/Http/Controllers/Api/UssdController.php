<?php

namespace App\Http\Controllers\Api;
use App\Models\USSDCodes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UssdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return USSDCodes::all();
    }
    public function processUSSDCodes(Request $request)
{
    // Retrieve data from the POST request
    $telesomCode = $request->input('telesom');
    $somtelCode = $request->input('somtel');

    // Store USSD codes in the database
    USSDCodes::create([
        'telesom_code' => $telesomCode,
        'somtel_code' => $somtelCode,
    ]);

    // Return a JSON response
    return response()->json(['message' => 'USSD codes stored successfully']);
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
