<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiKey;

class AuthenticateApiKey
{
    public function handle($request, Closure $next)
    {
        $apiKeyModel = ApiKey::where('api_key', $apiKey)->first();
            if ($apiKeyModel) {
                Log::info('Client ID associé : ' . $apiKeyModel->client_id);
            } else {
                Log::info('Clé API non trouvée');
            }

     


        return $next($request);
    }
}
