<?php

namespace App\Http\Controllers\Api;


use App\Traits\Waafi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
echo 'reached waafi controller';
class WaafiController extends Controller
{
    
    use Waafi;
   
    public function handleWaafiRequest(Request $request)
    {
        echo 'reached waafi controller';
        $type = $request->input('type');
        $number = $request->input('number');
        $amount = $request->input('amount');
        $clientId = $request->input('clientId');
        $invoiceId = $request->input('invoiceId', '');
        $description = $request->input('description', '');
        $referenceId = $request->input('referenceId', '');

        return $this->waafi($type, $number, $amount, $clientId, $invoiceId, $description, $referenceId);
    }
}
