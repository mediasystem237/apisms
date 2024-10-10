<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    protected $routeMiddleware = [
        // Autres middlewares...
        'auth.api_key' => \App\Http\Middleware\AuthenticateApiKey::class,
    ];
    
}
