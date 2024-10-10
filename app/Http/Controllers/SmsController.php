<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;
use App\Models\Client;
use App\Models\SmsLog; // Ajout de l'importation du modèle SmsLog
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Ajoutez ceci pour utiliser le logger

class SmsController extends Controller
{
    public function sendSms(Request $request)
{
    $request->validate([
        'api_key' => 'required',
        'senderid' => 'required|string',
        'sms' => 'required|string',
        'mobiles' => 'required|string',
    ]);

    // Vérifier la clé API
    $clientApiKey = ApiKey::where('api_key', $request->api_key)->first();
    if (!$clientApiKey) {
        return response()->json(['error' => 'Invalid API key'], 401);
    }

    // Récupérer les informations du client
    $client = $clientApiKey->client;

    // Déchiffrer le mot de passe du client
    $decryptedPassword = $client->decryptPassword($client->nexah_password);

    // Appel à l'API Nexah
    $response = Http::post(env('NEXAH_API_URL_SEND_SMS'), [
        'user' => $client->email,
        'password' => $decryptedPassword,
        'senderid' => $request->senderid,
        'sms' => $request->sms,
        'mobiles' => $request->mobiles,
    ]);

    $result = $response->json();

    // Gérer les différents cas d'erreur retournés par l'API Nexah
    if ($response->failed()) {
        return response()->json([
            'error' => 'Erreur lors de la connexion à Nexah',
            'details' => $response->body(),
        ], 500);
    }

    // Vérifiez si la clé 'errorcode' existe dans la réponse avant d'y accéder
    if (isset($result['responsecode']) && $result['responsecode'] != 1) {
        // Gérer les erreurs spécifiques à Nexah
        $errorMessage = 'Erreur inconnue'; // Message par défaut

        if (isset($result['errorcode'])) {
            switch ($result['errorcode']) {
                case '-10019':
                    $errorMessage = 'Utilisateur inactif';
                    break;
                case '-10003':
                    $errorMessage = 'Numéro de mobile invalide';
                    break;
                case '-10008':
                    $errorMessage = 'Solde insuffisant';
                    break;
            }
        }

        return response()->json([
            'error' => $errorMessage,
            'details' => $result,
        ], 400);
    }

    // Si tout est correct, sauvegarder les logs
    SmsLog::create([
        'messageid' => $result['sms'][0]['messageid'],
        'mobileno' => $result['sms'][0]['mobileno'],
        'sms_content' => $request->sms,
        'delivery_status' => 'pending', // Statut initial
    ]);


    // Log the successful API call in ApiLog
    ApiLog::create([
        'client_id' => $client->id,
        'request' => json_encode($request->all()),
        'response' => json_encode($result),
        'status' => 'success', // Log as success
        'request_type' => $request->method(), // Record the request type (GET, POST)
    ]);

    // Réponse formatée
    return response()->json([
        'message' => 'SMS envoyé avec succès',
        'smsDetails' => [
            'smsClientId' => $result['sms'][0]['smsclientid'] ?? null,
            'messageId' => $result['sms'][0]['messageid'],
            'mobileNo' => $result['sms'][0]['mobileno'],
            'totalSmsUnit' => $result['sms'][0]['total_sms_unit'],
            'balance' => $result['sms'][0]['balance'] ?? null,
        ],
        'apiResponse' => [
            'responseCode' => $result['responsecode'],
            'responseDescription' => $result['responsedescription'],
            'responseMessage' => $result['responsemessage'],
        ],
    ], 200);
}


    public function handleDlr(Request $request)
    {
        // Valider que la requête contient les informations nécessaires
        $request->validate([
            'messageid' => 'required|string',
            'mobileno' => 'required|string',
            'status' => 'required|string',
            'deliverytime' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Rechercher l'entrée de log SMS correspondante dans la base de données
        $smsLog = SmsLog::where('messageid', $request->messageid)->first();

        if ($smsLog) {
            // Mettre à jour le statut du SMS et l'heure de livraison
            $smsLog->delivery_status = $request->status;
            $smsLog->delivery_time = $request->deliverytime;
            $smsLog->save();

            // Récupérer le client qui a envoyé ce SMS
            $client = $smsLog->client; // Supposons que SmsLog a une relation avec Client

            // Vérifier si le client a configuré un webhook
            if ($client && $client->webhook) {
                // Envoyer la notification DLR au webhook du client
                $this->sendDlrToClient($client->webhook, $request->all());
            }

            return response()->json(['message' => 'DLR reçu et mis à jour avec succès'], 200);
        } else {
            Log::warning("Message ID non trouvé pour DLR : " . $request->messageid);
            return response()->json(['error' => 'Message ID non trouvé'], 404);
        }
    }

    // Fonction pour envoyer les DLR au webhook du client
    protected function sendDlrToClient($webhookUrl, $data)
    {
        try {
            $response = Http::post($webhookUrl, $data);

            // Vérifier si l'appel webhook a réussi
            if ($response->successful()) {
                Log::info("DLR envoyé avec succès au webhook du client : $webhookUrl");
            } else {
                Log::error("Échec de l'envoi du DLR au webhook du client : $webhookUrl");
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi du DLR au webhook du client : " . $e->getMessage());
        }
    }
}
