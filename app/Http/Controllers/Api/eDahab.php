<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

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
        $edahabNumber = $request->input('edahabNumber');
        $amount = $request->input('amount');
        $currency = $request->input('currency', 'SLSH'); // Default to 'USD' if not provided
        // $returnUrl = $request->input('returnUrl'); // Use 'returnUrl' as it is in the example

        $client = new Client(['base_uri' => self::BASE_URL]);

        $requestPayload = [
            'apiKey' => self::API_KEY,
            'edahabNumber' => $edahabNumber,
            'amount' => $amount,
            'currency' => $currency,
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

            return json_encode($result ?: new DahabResponse(['StatusCode' => 6]));
        } catch (\Exception $e) {
            Log::error($e);
            return json_encode(new DahabResponse(['StatusCode' => 6]));
        }
    }
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
