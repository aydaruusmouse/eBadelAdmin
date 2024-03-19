<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB; 
use App\Models\Order;
// use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use App\Models\UserProfile;
class WaafiApi extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo 'reached this function';
    }
    public function creditMoney(Request $request){
        \Log::info('Database connection status: ' . (DB::connection()->getPdo() ? 'Connected' : 'Not connected'));

        // if (!Auth::check()) {
        //     return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        // }
            //  echo 'creditmoney';
      
             try {
                // Validate the request data
                $validatedData = $request->validate([
                    'phoneNumber' => 'required|string',
                    'amount' => 'required|numeric|min:0',
                ]);
    
                // User amount and phone number.
                $phoneNumber = $validatedData['phoneNumber'];
                $amount = $validatedData['amount'];
                $desc = 'lacag bixin tijaabo ah';
                $requestId = rand(100000, 999999);
                $ref = rand(100000, 999999);
                $invoiceId = rand(100000, 999999);
                $timestamp = now();
    
                $data = [
                    'schemaVersion' => '1.1',
                    'requestId' => $requestId,
                    'timestamp' => $timestamp,
                    'channelName' => 'WEB',
                    'serviceName' => 'API_CREDITACCOUNT',
                    'serviceParams' => [
                        'merchantUid' => 'M0913203',
                        'apiUserId' => 1006678,
                        'apiKey' => 'API-1836453811AHX',
                        'paymentMethod' => 'MWALLET_ACCOUNT',
                        'payerInfo' => [
                            'accountNo' => $phoneNumber,
                            
                        ],
                        'transactionInfo' => [
                            'referenceId' => $ref,
                            'invoiceId' => $invoiceId,
                            'amount' => $amount,
                            'currency' => 'SLSH',
                            'description' => $desc,
                        ]
                    ]
                ];
    
                // Send the request using Laravel's HTTP client.
                $response = Http::post('https://api.waafipay.net/asm', $data);
                $returnData = $response->json();
                $responseCode = $returnData['responseCode'];
                $apiResponseMessage = $returnData['responseMsg'];
    
                // Check the response code and set payment status
                $paymentStatus = ($responseCode == 2001) ? 'success' : 'failed';
    
                // Call the newPayment method to handle database insertion.
                $response = $this->newPayment(1,$phoneNumber, $amount, $paymentStatus, $apiResponseMessage, $selectedOption);
    
                return response()->json(['status' => $paymentStatus, 'message' => $apiResponseMessage]);
            } catch (\Exception $e) {
                // Log the full exception details
                \Log::error('Exception in payWithZaad: ' . $e->getMessage());
                \Log::error('Exception stack trace: ' . $e->getTraceAsString());
                  
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            

    }
    public function payWithZaad(Request $request)
    {
        
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'amount' => 'required|numeric|min:0',
                'selectedOption' => 'required|string',
                // 'currency' => 'required|string',
                'originwallet' => 'required|string',
                'destinationwallet' => 'required|string',
                'senderaccount' => 'required|string',
                'recipientaccount' => 'required|string',
                'originCurrency' => 'required|string',
                'destinationCurrency' => 'required|string',
                'bridgeFee' => 'required|numeric|min:0',

            ]);
           
            if (!Auth::check()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
            }
            $user = Auth::user();
            // if (Auth::check()) {
            //     $userId = Auth::user()->User_Profile_Id;
            //     //
            //     return response()->json(['status' => 'error', 'message' => 'Autharized'], 401);
            //     # code...
            // }
            \Log::info('Authenticated User ID:', ['user_id' => $user->User_Profile_Id]);
            // Remove ->id from $user
            $userId= $user->User_Profile_Id;
            \Log::info('Authenticated User ID:', ['user_id' => $userId]);
            \Log::info('Authenticated User ID:', ['user_id' => $user]); // Remove ->id from $user
            // User amount and phone number.
            // $phoneNumber = $validatedData['phoneNumber'];
            $originwallet = $validatedData['originwallet'];
            $destinationwallet = $validatedData['destinationwallet'];
            $senderaccount = $validatedData['senderaccount'];
            $recipientaccount = $validatedData['recipientaccount'];
            $originCurrency = $validatedData['originCurrency'];
            $destinationCurrency = $validatedData['destinationCurrency'];
            $bridgeFee = $validatedData['bridgeFee'];
            $amount = $validatedData['amount'];
            $selectedOption= $validatedData['selectedOption'];
            $desc = 'lacag bixin tijaabo ah';
            $requestId = rand(100000, 999999);
            $ref = rand(100000, 999999);
            $invoiceId = rand(100000, 999999);
            $timestamp = now();

            $data = [
                'schemaVersion' => '1.1',
                'requestId' => $requestId,
                'timestamp' => $timestamp,
                'channelName' => 'WEB',
                'serviceName' => 'API_PURCHASE',
                'serviceParams' => [
                    'merchantUid' => 'M0913203',
                    'apiUserId' => 1006678,
                    'apiKey' => 'API-1836453811AHX',
                    'paymentMethod' => 'MWALLET_ACCOUNT',
                    'payerInfo' => [
                        'accountNo' => $senderaccount,
                    ],
                    'transactionInfo' => [
                        'referenceId' => $ref,
                        'invoiceId' => $invoiceId,
                        'amount' => $amount,
                        'currency' => $originCurrency,
                        'description' => $desc,
                    ]
                ]
            ];

            // Send the request using Laravel's HTTP client.
            $response = Http::post('https://api.waafipay.net/asm', $data);
            $returnData = $response->json();
            $responseCode = $returnData['responseCode'];
            $apiResponseMessage = $returnData['responseMsg'];

            // Check the response code and set payment status
            $paymentStatus = ($responseCode == 2001) ? 'success' : 'failed';
            \Log::info('User ID passed to newPayment:', ['user_id' => $user->id]);
            \Log::info('Phone number:', ['phoneNumber' => $senderaccount]);
            \Log::info('Amount:', ['amount' => $amount]);
            \Log::info('Payment status:', ['paymentStatus' => $paymentStatus]);
            \Log::info('API response message:', ['apiResponseMessage' => $apiResponseMessage]);
    
            // Call the newPayment method to handle database insertion.
            $response = $this->newPayment($user->User_Profile_Id, $senderaccount, $amount, $paymentStatus, $apiResponseMessage, $selectedOption, $originwallet, $destinationwallet, $recipientaccount, $originCurrency, $destinationCurrency, $bridgeFee);

            return response()->json(['status' => $paymentStatus, 'message' => $apiResponseMessage]);
              return response()->json(['status'=> $apiResponseMessage]);
        } catch (\Exception $e) {
            // Log the full exception details
            \Log::error('Exception in payWithZaad: ' . $e->getMessage());
            \Log::error('Exception stack trace: ' . $e->getTraceAsString());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
  
    // DB insertion 

    
    public function newPayment($userId, $senderaccount, $amount, $paymentStatus, $apiResponseMessage, $selectedOption, $originwallet, $destinationwallet, $recipientaccount, $originCurrency, $destinationCurrency, $bridgeFee)
{
    try {
        // Start a database transaction
        DB::beginTransaction();

        // Get the user by ID
        $user = UserProfile::find($userId);
        // auth()->user()->User_Profile_Id
        // Check if the user exists
        // \Log::info('User ID passed to newPayment is a :', ['user_id' => $user]);
        \Log::info('User ID passed to newPayment is a of paramter is :', ['user_id' => $userId]);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        // Create a new transaction record using the relationship
        $transaction = $user->orders()->create([
            'User_Profile_Id' => $userId, // Use $userId instead of $user
            'Origin_Wallet' => $originwallet,
            'Destination_Wallet' => $destinationwallet,
            'Sender_Account' => $senderaccount,
            'Recipient_Account' => $recipientaccount,
            'Origin_Currency' => $originCurrency,
            'Destination_Currency' => $destinationCurrency,
            'Amount' => $amount,
            'Bridge_Fee' => $bridgeFee,
            'Debit_Response' => 'success',
            'Credit_Response' => 'pending',
            'Status' => 'Pending',
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
