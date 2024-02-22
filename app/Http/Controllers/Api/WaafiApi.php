<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB; 
use App\Models\Transaction;
use App\Models\User;
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
        // if (!Auth::check()) {
        //     return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        // }
       
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'phoneNumber' => 'required|string',
                'amount' => 'required|numeric|min:0',
                'selectedOption' => 'required|string',
                'currency' => 'required|string',
            ]);

//             $user = auth()->user()->User_Profile_Id; // Assuming user ID 12 exists

// if (!$user) {
//     return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
// }
            // User amount and phone number.
            $phoneNumber = $validatedData['phoneNumber'];
            $currency = $validatedData['currency'];
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
                        'accountNo' => $phoneNumber,
                    ],
                    'transactionInfo' => [
                        'referenceId' => $ref,
                        'invoiceId' => $invoiceId,
                        'amount' => $amount,
                        'currency' => $currency,
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
            // $paymentStatus = ($responseCode == 2001) ? 'success' : 'failed';
            // \Log::info('User ID passed to newPayment:', ['user_id' => $user->id]);
            // \Log::info('Phone number:', ['phoneNumber' => $phoneNumber]);
            // \Log::info('Amount:', ['amount' => $amount]);
            // \Log::info('Payment status:', ['paymentStatus' => $paymentStatus]);
            // \Log::info('API response message:', ['apiResponseMessage' => $apiResponseMessage]);
    
            // // Call the newPayment method to handle database insertion.
            // $response = $this->newPayment(1, $phoneNumber, $amount, $paymentStatus, $apiResponseMessage, $selectedOption);

            // return response()->json(['status' => $paymentStatus, 'message' => $apiResponseMessage]);
              return response()->json(['status'=> $apiResponseMessage]);
        } catch (\Exception $e) {
            // Log the full exception details
            \Log::error('Exception in payWithZaad: ' . $e->getMessage());
            \Log::error('Exception stack trace: ' . $e->getTraceAsString());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
  
    // DB insertion 

    // public function newPayment($userId, $phoneNumber, $amount, $paymentStatus, $apiResponseMessage, $selectedOption)
    // {
    //     try {
    //         // Start a database transaction
    //         DB::beginTransaction();
    
    //         // Get the user by ID
    //         $user = User::find($userId);
    
    //         if (!$user) {
    //             return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
    //         }
    
    //         // Create a new transaction record using the relationship
    //         $transaction = $user->transactions()->create([
    //             'senders_wallet_name' => $selectedOption,
    //             'receivers_wallet_name' => 'edahab',
    //             'senders_account_name' => 'aidarous mouse',
    //             'receivers_account_name' => $selectedOption,
    //             'senders_account_number' => $phoneNumber,
    //             'receivers_account_number' => $phoneNumber,
    //             'currencies' => 'SLSH',
    //             'swap_fee' => 0,
    //             'excuted_by' => 'Api',
    //             'wallet_type' => $selectedOption,
    //             'amount' => $amount,
    //             'status' => $paymentStatus,
    //             'debit_message' => $apiResponseMessage,
    //             'credit_response' => $apiResponseMessage,
    //             'transaction_id' => Str::uuid(),
    //         ]);
    
    //         // Commit the transaction if everything is successful
    //         DB::commit();
    
    //         return response()->json(['status' => 'success', 'message' => 'Payment recorded successfully', 'data' => $transaction]);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction in case of an exception
    //         DB::rollBack();
    
    //         // Log the exception details
    //         \Log::error('Exception in newPayment: ' . $e->getMessage());
    
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    //     }
    // }
    
    


    

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
