<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 
use App\Models\Order;
use Illuminate\Support\Facades\Auth; 
use App\Models\UserProfile;
// use App\Models\UserProfile;
class eDahab extends Controller
{
    private const BASE_URL = 'https://edahab.net/api/api/';
    private const API_KEY = 'jzEkZpumNSOCcs3goRXSyN7Amy7X4tR7jfyKRKoDo';
    private const AGENT_CODE = '724428';
    private const SECRET_KEY = 'Ei2mHubN1LQxLeXfM6PqvQektB1VkeVXC1QeXa';
    private const url = "https://edahab.net/api/api/agentPayment/";
    public function toSha256($requestBodyString)
    {
        $crypto = hash('sha256', utf8_encode($requestBodyString));
        return $crypto;
    }

    public function createInvoiceAsync(HttpRequest $request)
    {
        \Log::info('the amount is :', ['request' => $request->input('amount')]);
        // Retrieve data from the request
        \Log::info('the currency is :', ['request' => $request->input('currency')]);
        \Log::info('the senderAccount is :', ['request' => $request->input('senderaccount')]);
        
        $amount = $request->input('amount');
        $currency = $request->input('currency'); 
        $originwallet= $request->input('originwallet');
        $destinationwallet= $request->input('destinationwallet');
        $senderAccount= $request->input('senderaccount');
        $recipientAccount= $request->input('recipientaccount');
        $originCurrency= $request->input('originCurrency');
        $destinationCurrency= $request->input('destinationCurrency');
        $bridgeFee= $request->input('bridgeFee');
        $selectedOption= $request->input('selectedOption');
        // $debitResponse= $request->input('debitResponse');
        // $creditResponse= $request->input('creditResponse');
        // $status= $request->input('status');

        // Default to 'USD' if not provided
        $returnUrl = $request->input('returnUrl'); // Use 'returnUrl' as it is in the example

        $client = new Client(['base_uri' => self::BASE_URL]);
        
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }


    
        $user = Auth::user();
        \Log::info('Authenticated User ID:', ['user_id' => $user->User_Profile_Id]);
// Remove ->id from $user
        $userId= $user->User_Profile_Id;
        \Log::info('the userId is :', ['user_id' => $userId]); // Remove ->id from $user
        $requestPayload = [
            'apiKey' => self::API_KEY,
            'Edahabnumber' => $senderAccount,
            'amount' => $amount,
            'origincurrency' => $originCurrency,
            'agentCode' => self::AGENT_CODE,
            // 'returnUrl' => $returnUrl,
        ];

        $requestAsString = json_encode($requestPayload);
        $hash = $this->toSha256($requestAsString . self::SECRET_KEY);

        $requestBody = [
            'json' => $requestPayload,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ];

        try {
            $response = $client->post("issueinvoice?hash={$hash}", $requestBody);
            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                return json_encode(new DahabResponse(['StatusCode' => 6]));
            }

            $content = $response->getBody()->getContents();
            $result = json_decode($content);

            // $this->checkInvoiceStatus(); // Call the method with $this->
            $paymentStatus = ($statusCode == 2001) ? 'success' : 'failed';
            \Log::info('User ID passed to newPayment:', ['user_id' => $user->User_Profile_Id]);
            \Log::info('Phone number:', ['senderAccount' => $senderAccount]);
            \Log::info('Amount:', ['amount' => $amount]);
          
            // Call the newPayment method to handle database insertion.
            $response = $this->newPayment($user->User_Profile_Id, $senderAccount, $amount, $paymentStatus, 'noo', $selectedOption, $originwallet, $destinationwallet, $senderAccount, $recipientAccount, $originCurrency, $destinationCurrency, $bridgeFee, 'success', 'pending', 'active');
            \Log::info('Amount:', ['respond' => $response]);
          
            // return response()->json(['status' => $paymentStatus, 'message' => $apiResponseMessage]);
            //   return response()->json(['status'=> $apiResponseMessage]);
            return json_encode($result ?: new DahabResponse(['StatusCode' => 6]));
        } catch (\Exception $e) {
            Log::error($e);
            return json_encode(new DahabResponse(['StatusCode' => 6]));
        }
    }
    public function newPayment($userId, $phoneNumber, $amount, $paymentStatus, $apiResponseMessage, $selectedOption, $originwallet, $destinationwallet, $senderAccount, $recipientAccount, $originCurrency, $destinationCurrency, $bridgeFee, $debitResponse, $creditResponse, $status)
    {
       
        try {
            // Start a database transaction
            DB::beginTransaction();
    
            // Get the user by ID
            $user = UserProfile::find($userId);
            // auth()->user()->User_Profile_Id
            \Log::info('User ID passed to newPayment is aidoo:', ['user_id' => $user]);
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }
    
            // Create a new transaction record using the relationship
            $transaction = $user->orders()->create([
                'User_Profile_Id' => $user, // Use $userId instead of $user
                'Origin_Wallet' => $originwallet,
                'Destination_Wallet' => $destinationwallet,
                'Sender_Account' => $senderAccount,
                'Recipient_Account' => $recipientAccount,
                'Origin_Currency' => $originCurrency,
                'Destination_Currency' => $destinationCurrency,
                'Amount' => $amount,
                'Bridge_Fee' => $bridgeFee,
                'Debit_Response' => 'success',
                'Credit_Response' => 'pending',
                'Status' => 'active',
            ]);
    
            // Commit the transaction if everything is successful
            DB::commit();
    
            return response()->json(['status' => 'success', 'message' => 'Payment recorded successfully', 'data' => $transaction]);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
    
            // Log the exception details
            \Log::error('Exception in newPayment: ' . $e->getMessage());
    
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    // credit money
    public function CreditMoney(HttpRequest $request)
{
    // Controller logic to handle credit operation

    // Retrieve data from the request
    $phoneNumber = $request->input('phoneNumber');
    $transactionAmount = $request->input('transactionAmount');
    $currency = $request->input('currency', 'SLSH'); // Default to 'USD' if not provided

    // ... (other initialization and configuration)
    $client = new Client(['base_uri' => self::BASE_URL]);

        $requestPayload = [
            'apiKey' => self::API_KEY,
            'phoneNumber' => $phoneNumber,
            'transactionAmount' => $transactionAmount,
            'currency' => $currency,
            // 'agentCode' => self::AGENT_CODE,
            // 'returnUrl' => $returnUrl,
        ];

    // Generate hash for the request payload
    $requestAsString = json_encode($requestPayload);
    $hash = $this->toSha256($requestAsString . self::SECRET_KEY);

    // Prepare the request body
    $requestBody = [
        'json' => $requestPayload,
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ];

    try {
        // Make a POST request to the specified endpoint
        $response = $client->post("agentPayment?hash={$hash}", $requestBody);
        $statusCode = $response->getStatusCode();

        // Handle the response
        if ($statusCode !== 200) {
            return json_encode(new DahabResponse(['StatusCode' => 6]));
        }

        $content = $response->getBody()->getContents();
        $result = json_decode($content);

        return json_encode($result ?: new DahabResponse(['StatusCode' => 6]));
    } catch (\Exception $e) {
        Log::error($e);
        return json_encode(new DahabResponse(['StatusCode' => 6]));
    }
}


    public function checkInvoiceStatus()
    {
        $invoiceId = 23; // Get this from your database or somewhere. :)

        // Assuming VerifyAsync is part of your controller
        $result = $this->VerifyAsync($invoiceId, request()->getRequestAborted());

        if ($result->StatusCode != 0) {
            echo 'laguma guuleysan hubinta';
            // Laguma guulaysan hubinta, maybe u sheeg macmiilka inuu mar kale isku dayo...
        }

        if ($result->InvoiceStatus == "Paid") {
            // Waa success, guul iyo gobanimo! 😍
            echo 'waa success, guul iyo gobanimo!';
        } else {
            echo 'macmiil lacag bixintada lama xaqiiijin';
            // Macmiilku lacag ma bixin, ku qanci inuu bixiyo lacagta! 😆
        }
    }

    public function VerifyAsync($invoiceId, $requestAborted)
    {
        // Your implementation here, possibly using async/await features in PHP.
        // Ensure that it returns an object with StatusCode and InvoiceStatus properties.

        // For example, you might fetch the invoice status from your database.
        $invoiceStatus = Invoice::find($invoiceId)->status;

        return (object)['StatusCode' => 0, 'InvoiceStatus' => $invoiceStatus];
    }
}

class DahabResponse
{
    public $StatusCode; // 0-6 where 0 is success.
    public $InvoiceId; // Available only if the above is success (0).
    public $InvoiceStatus; // "Pending" or "Paid".

    public function __construct($statusCode, $invoiceId = null, $invoiceStatus = null)
    {
        $this->StatusCode = $statusCode;
        $this->InvoiceId = $invoiceId;
        $this->InvoiceStatus = $invoiceStatus;
    }
}
