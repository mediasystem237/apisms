<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;
use App\Models\Client;
use App\Models\SmsLog; // Ajout de l'importation du modèle SmsLog
use Illuminate\Support\Facades\Http; // Importation de la classe Http
use Illuminate\Support\Facades\Log; // Ajoutez ceci pour utiliser le logger
use App\Models\ApiLog;



class DashboardController extends Controller
{
    public function index()
    {
        // Logique pour la vue principale du dashboard
        $user = auth()->user();
        $apiRequestsCount = ApiLog::where('user_id', $user->id)->count();
        $successfulRequests = ApiLog::where('user_id', $user->id)->where('status', 'success')->count();
        $failedRequests = $apiRequestsCount - $successfulRequests;

        return view('dashboard.index', compact('apiRequestsCount', 'successfulRequests', 'failedRequests'));
    }

    public function developer()
{
    // Récupérer l'utilisateur connecté
    $user = auth()->user();

    // Rechercher le client avec l'utilisateur connecté
    $client = Client::where('user_id', $user->id)->first();

    // Initialiser les variables à passer à la vue
    $apiKey = null;
    $apiLogs = collect();

    // Si le client existe, récupérer la clé API et les logs associés
    if ($client) {
        $apiKey = ApiKey::where('client_id', $client->id)->latest()->first();
        $apiLogs = ApiLog::where('client_id', $client->id)->latest()->paginate(20);
    }

    // Passer les données à la vue
    return view('dashboard.developer', compact('apiKey', 'apiLogs'));
}



    public function settings()
    {
        // Logique pour la vue des paramètres
        $user = auth()->user();
        return view('dashboard.settings', compact('user'));
    }

    public function balance()
    {
        // Logique pour la vue du solde
        $user = auth()->user();
        $balance = $user->balance;
        $recentTransactions = Transaction::where('user_id', $user->id)->latest()->take(5)->get();

        return view('dashboard.balance', compact('balance', 'recentTransactions'));
    }

    public function history(Request $request)
{
    $user = auth()->user(); // Récupérer l'utilisateur connecté
    $client = Client::where('user_id', $user->id)->first(); // Récupérer le client associé

    if ($client) {
        // Récupérer les logs d'API associés au client
        $apiLogs = ApiLog::where('client_id', $client->id)->paginate(10);
    } else {
        $apiLogs = collect(); // Si le client n'existe pas, retourner une collection vide
    }

    return view('dashboard.history', compact('apiLogs'));
}


    public function documentation()
    {
        // Logique pour la vue de la documentation
        // Ici, vous pourriez avoir une logique pour charger différentes sections de la documentation
        return view('dashboard.documentation');
    }
    public function solde()
    {
        // Charger la vue sans données initiales
        return view('dashboard.solde', ['solde' => null]);
    }

    public function checkBalance(Request $request)
    {
        $user = auth()->user();
        $client = Client::where('user_id', $user->id)->first();

        if (!$client) {
            return redirect()->route('dashboard.solde')->withErrors(['error' => 'No client associated with your account.']);
        }

        // Récupérer l'API Key du client
        $apiKey = ApiKey::where('client_id', $client->id)->first();
        
        // Si la clé API n'est pas trouvée
        if (!$apiKey) {
            return redirect()->route('dashboard.solde')->withErrors(['error' => 'API Key not found.']);
        }

        // Faire la requête pour vérifier le solde
        $response = Http::withHeaders([
            'api_key' => $apiKey->api_key,
        ])->post(env('NEXAH_API_URL'), [
            'user' => $client->email,
            'password' => $client->nexah_password,
        ]);

        // Vérifier si la requête est réussie
        if ($response->failed()) {
            return redirect()->route('dashboard.solde')->withErrors(['error' => 'Failed to check balance.']);
        }

        // Obtenez le solde à partir de la réponse
        $solde = $response->json()['balance'] ?? 'Unavailable';

        // Retournez à la vue avec le solde
        return view('dashboard.solde', compact('solde'));
    }


    public function revokeApiKey($id)
    {
        // Logique pour révoquer une clé API
        $apiKey = ApiKey::findOrFail($id);
        $this->authorize('delete', $apiKey);
        $apiKey->delete();

        return redirect()->route('dashboard.developer')->with('success', 'Clé API révoquée avec succès.');
    }

    public function getStats()
{
    $user = auth()->user();
    $client = Client::where('user_id', $user->id)->first();

    $remainingCredit = 0; // Valeur par défaut
    $totalSentSMS = 0; // Valeur par défaut
    $failedSMS = 0; // Valeur par défaut

    if ($client) {
        // Déchiffrer le mot de passe du client
        $decryptedPassword = $client->decryptPassword($client->nexah_password);

        // Faire la requête à l'API Nexah pour vérifier le solde
        $response = Http::post(env('NEXAH_API_URL_SMS_BALANCE'), [
            'user' => $client->email,
            'password' => $decryptedPassword,
        ]);

        $data = $response->json();

        if (isset($data['responsecode']) && $data['responsecode'] == 1) {
            $remainingCredit = $data['credit'];
        }

        // Compter les SMS envoyés et échoués
        $totalSentSMS = ApiLog::where('client_id', $client->id)->where('status', 'success')->count();
        $failedSMS = ApiLog::where('client_id', $client->id)->where('status', 'failed')->count();
    }

    return response()->json([
        'remainingCredit' => $remainingCredit,
        'totalSentSMS' => $totalSentSMS,
        'failedSMS' => $failedSMS,
    ]);
}


}