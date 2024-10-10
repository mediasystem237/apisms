<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ApiKey;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Récupérer l'utilisateur connecté
        $client = Client::where('user_id', $user->id)->first(); // Récupérer le client associé

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

        // Assurez-vous que le nom de la vue est correct
        return view('dashboard', compact('remainingCredit', 'totalSentSMS', 'failedSMS'));

    }
}
