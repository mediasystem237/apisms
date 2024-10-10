<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ApiKeyController extends Controller
{
    // Afficher la clé API
    public function index()
    {
        $client = Auth::user();
        $apiKey = ApiKey::where('client_id', $client->id)->first();

        return view('dashboard.api', compact('client', 'apiKey'));
    }

    // Générer ou régénérer la clé API
    public function generateApiKey()
    {
        $client = Auth::user();

        // Vérifier si le client a déjà une clé API
        $apiKey = ApiKey::where('client_id', $client->id)->first();

        if (!$apiKey) {
            // Si aucune clé n'existe, en générer une
            $apiKey = new ApiKey();
            $apiKey->client_id = $client->id;
        }

        // Générer une nouvelle clé API
        $apiKey->api_key = Str::random(32);
        $apiKey->save();

        return redirect()->route('dashboard.api')->with('success', 'Clé API générée avec succès.');
    }
}
