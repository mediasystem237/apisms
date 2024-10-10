<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Ajoutez ceci pour utiliser le logger

class ClientController extends Controller
{
    public function generateApiKey(Request $request)
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Validation des informations
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Vérifier les credentials avec l'API Nexah
    $response = Http::post(env('NEXAH_API_URL_SMS_BALANCE'), [
        'user' => $request->email,
        'password' => $request->password,
    ]);

    if ($response->json()['responsecode'] !== 1) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    // Chiffrer le mot de passe avant de créer le client
    $encryptedPassword = Client::encryptPassword($request->password);

    // Créer ou récupérer l'enregistrement Client sans user_id
    $client = Client::firstOrCreate(
        ['email' => $request->email],
        ['nexah_password' => $encryptedPassword]
    );

    // Vérifier si l'API Key existe déjà
    if (ApiKey::where('client_id', $client->id)->exists()) {
        return response()->json(['error' => 'API Key already exists for this client.'], 400);
    }

    // Create your structured API key
    $customCode = "Ms"; // Set your custom code here
    $msDate = date('Ymd'); // Format date as YYYYMMDD
    $uniqueIdentifier = Str::random(32); // Generate a random unique identifier

    // Construct the API key in the format "MS_YYYYMMDDUniqueIdentifier"
    $apiKey = "{$customCode}_{$msDate}{$uniqueIdentifier}";

    ApiKey::create([
        'client_id' => $client->id,
        'api_key' => $apiKey,
    ]);

    // Associer l'ID de l'utilisateur connecté après la création
    $client->user_id = $user->id;
    $client->save();

    return response()->json(['api_key' => $apiKey], 201);
}

    // Méthode pour vérifier le solde via Nexah
    public function solde()
    {
        return view('dashboard.solde', ['solde' => null]);
    }

    public function checkBalance(Request $request)
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Trouver les informations du client associé à l'utilisateur
    $client = Client::where('user_id', $user->id)->first();
    if (!$client) {
        return view('dashboard.solde')->withErrors(['error' => 'Client non trouvé']);
    }

    // Déchiffrer le mot de passe
    $decryptedPassword = $client->decryptPassword($client->nexah_password);

    // Faire la requête à l'API Nexah pour vérifier le solde
    $response = Http::post(env('NEXAH_API_URL_SMS_BALANCE'), [
        'user' => $client->email,
        'password' => $decryptedPassword,
    ]);

    $responseJson = $response->json();
    Log::info('Réponse de l\'API Nexah:', $responseJson);

    if (!isset($responseJson['responsecode']) || $responseJson['responsecode'] != 1) {
        return view('dashboard.solde')->withErrors(['error' => 'Erreur lors de la récupération du solde']);
    }

    // Retourner les données de solde à la vue
    return view('dashboard.solde', [
        'smsBalance' => $responseJson['credit'],
        'accountExpDate' => $responseJson['accountexpdate'],
        'balanceExpDate' => $responseJson['balanceexpdate']
    ]);
}

private function formatBalanceResponse(array $data): array
{
    $balanceDetails = array_map(function ($balance) {
        return [
            'country_code' => $balance['country_code'],
            'country_name' => $balance['country_name'],
            'credit' => $balance['credit'],
            'credit_rate' => $balance['credit_rate'] ?? null,
            'expire_date' => $balance['expire_date'] ?: null,
        ];
    }, $data['balance'] ?? []);  // Vérifiez si 'balance' existe avant de l'utiliser

    return [
        'total_credit' => $data['credit'] ?? 0,
        'account_exp_date' => $data['accountexpdate'] ?? null,
        'balance_exp_date' => $data['balanceexpdate'] ?? null,
        'balance_details' => $balanceDetails,
    ];
}

    public function saveWebhook(Request $request)
    {
        $request->validate([
            'webhook' => 'required|url',
        ]);

        // Récupérer le client connecté
        $client = Auth::user();

        // Enregistrer l'URL webhook
        $client->webhook = $request->webhook;
        $client->save();

        return redirect()->back()->with('success', 'Webhook configuré avec succès.');
    }


    public function revokeApiKey(Request $request)
    {
        // Logique pour révoquer la clé API ici
        // Exemple :
        $apiKey = $request->input('apiKey');
    
        $clientApiKey = ApiKey::where('api_key', $apiKey)->first();
        if (!$clientApiKey) {
            return response()->json(['error' => 'API Key not found'], 404);
        }
    
        // Suppression de la clé API
        $clientApiKey->delete();
    
        return response()->json(['message' => 'API Key revoked successfully'], 200);
    }
    

public function generateNewApiKey(Request $request)
{
    // Revoke the current API key first (you can also validate if the API key is valid)
    $request->validate([
        'client_id' => 'required|exists:clients,id', // Ensure client_id is valid
    ]);

    // Find the client
    $client = Client::find($request->client_id);

    // Revoke the existing API key, if any
    $existingApiKey = ApiKey::where('client_id', $client->id)->first();
    if ($existingApiKey) {
        $existingApiKey->delete();
    }

    // Create a new API key (reusing the earlier example)
    $customCode = "Ms";
    $msDate = date('Ymd');
    $uniqueIdentifier = Str::random(32);

    $newApiKey = "{$customCode}_{$msDate}{$uniqueIdentifier}";

    ApiKey::create([
        'client_id' => $client->id,
        'api_key' => $newApiKey,
    ]);

    return response()->json(['api_key' => $newApiKey], 201);
}

}
