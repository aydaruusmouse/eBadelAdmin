<?php

namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use App\Models\Transaction;




/**
 *
 */
trait Waafi
{
/**
 * Undocumented function
 *
 * @param Enum $type [withdraw | topup]
 * @param String $number [+252.....]
 * @param Decimal $amount [0.00]
 * @param Number $clientId [who is the client making hte request]
 * @param String $invoiceId
 * @param String $description
 * @param String $referenceId
 * @return void
 */
    public function waafi($type, $number, $amount, $clientId, $invoiceId = '', $description = '',  $referenceId = '')
    {
        // dd($number, $amount);
        if (!is_numeric($number) && !is_numeric($amount) && !is_numeric($clientId)) {
            return (['error' => true, 'errorMsg' => 'Invalid company, number or amount']);
        }
        $transactions = Transactions::create([
            'client_id' => $clientId,
            'invoiceId' => $invoiceId,
            'type' => $type,
            'number' => $number,
            'amount' => $amount,
            'network' => 'evc'
        ]);
        $reqId = $transactions->id;
        $serviceName = $type == 'withdraw' ? 'API_PURCHASE' : 'API_CREDITACCOUNT';
        $client = new Client();
        $req = [
            'schemaVersion' => '1.0',
            'requestId' => $reqId,
            'timestamp' =>  time(),
            'channelName' => 'WEB',
            'serviceName' => $serviceName,
            'serviceParams' => [
                'merchantUid' => 'M0913203',
                'apiUserId' => 1006678,
                'apiKey' => 'API-1836453811AHX',
                'paymentMethod' => 'MWALLET_ACCOUNT',
                'payerInfo' => [
                    'accountNo' => $number,
                ],
                'transactionInfo' => [
                    'referenceId' => $referenceId,
                    'invoiceId' => $invoiceId,
                    'amount' => $amount,
                    'currency' => 'USD',
                    'description' => $description,
                ],
            ]
        ];

        $promise = $client->postAsync('https://api.waafi.com/asm', [
            RequestOptions::JSON =>
            $req
        ])->then(
            function ($response) {
                return $response->getBody();
            },
            function (GuzzleException $exception) {
                return $exception->getMessage();
            }
        );
        $resp = $promise->wait();
        $result = json_decode($resp);

        //check if successful
        // confirm and store transaction in db.
        //return success or failure.
        $request = Transaction::where('id', $reqId)->first();
        if (!empty($request)) {
            if ($result->responseCode == '2001') {
                $params = $result->params;
                $request->update([
                    'status' => 'approved',
                    'networkCharges' => $params->merchantCharges,
                    'transactionId' => $params->transactionId

                ]);
                return $request;
            } else {
                //something went wrong update db and return error
                $request->update([
                    'status' => 'failed',
                ]);

                if (preg_match("/: (.*)\)/", $result->responseMsg, $rMsg)) {
                    $responseMsg = $rMsg[1];
                } else {
                    $responseMsg = $result->responseMsg;
                }

                return (['error' => true, 'status' => 'failed', 'errorMsg' => $responseMsg, 'data' => $request]);
            }
        }
        return $resp;
    }

}