<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB; 
use App\Models\Transaction;


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
                $response = $this->newPayment($phoneNumber, $amount, $paymentStatus, $apiResponseMessage);
    
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
            $response = $this->newPayment($phoneNumber, $amount, $paymentStatus, $apiResponseMessage);

            return response()->json(['status' => $paymentStatus, 'message' => $apiResponseMessage]);
        } catch (\Exception $e) {
            // Log the full exception details
            \Log::error('Exception in payWithZaad: ' . $e->getMessage());
            \Log::error('Exception stack trace: ' . $e->getTraceAsString());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
  
    // DB insertion 

    public function newPayment($phoneNumber, $amount, $paymentStatus, $apiResponseMessage)
{
    try {
        // echo $phoneNumber;
        // echo $amount;
        // Start a database transaction
        DB::beginTransaction();
        // $validatedData['transaction_id'] = Str::uuid();
        // $validatedData['reference_id'] = Str::uuid();
        // Create a new transaction record
$transaction = Transaction::create([
    'sender' => 'aidarous mouse',
    'recipient' => 'aamin yousuf',
    'recipient_phone' => $phoneNumber,
    'amount' => $amount,
    'paymentStatus' => $paymentStatus,
    'apiResponseMessage' => $apiResponseMessage,
    'date' => now()->toDateString(),
    'time' => now()->toTimeString(),
    'reference_id' => Str::uuid(), // Use Str::uuid() to generate a UUID for 'transaction_id'
    'transaction_id' => Str::uuid(),
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
