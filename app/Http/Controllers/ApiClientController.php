<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;
use App\Models\Client;
use Illuminate\Support\Facades\Http;

class ApiClientController extends Controller
{
    public function checkBalance(Request $request)
    {
        // Get the API key from the request header or body
        $apiKey = $request->header('api_key') ?? $request->input('api_key');
        
        if (empty($apiKey)) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        // Validate the API key
        $clientApiKey = ApiKey::where('api_key', $apiKey)->first();
        if (!$clientApiKey) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        // Retrieve the client associated with the API key
        $client = Client::find($clientApiKey->client_id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        // Decrypt the client's password
        $decryptedPassword = $client->decryptPassword($client->nexah_password);

        // Make the request to Nexah to check balance
        $response = Http::post(env('NEXAH_API_URL_SMS_BALANCE'), [
            'user' => $client->email,
            'password' => $decryptedPassword,
        ]);

        $responseJson = $response->json();

        if (!isset($responseJson['responsecode']) || $responseJson['responsecode'] != 1) {
            return response()->json(['error' => 'Error retrieving balance'], 500);
        }

        // Return balance information as JSON
        return response()->json([
            'smsBalance' => $responseJson['credit'],
            'accountExpDate' => $responseJson['accountexpdate'],
            'balanceExpDate' => $responseJson['balanceexpdate']
        ]);
    }
}
