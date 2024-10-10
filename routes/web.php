<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;


// Routes protégées par le middleware d'authentification
Route::middleware(['auth'])->group(function () {
    
    // Vue pour le dashboard principal
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route pour le tableau de bord développeur
    Route::get('/dashboard/developer', [DashboardController::class, 'developer'])->name('dashboard.developer');

    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');


    
    // Routes pour la gestion des clés API
    Route::get('/dashboard/api', [ApiKeyController::class, 'index'])->name('dashboard.api');
    Route::post('/generate-api-key', [ClientController::class, 'generateApiKey'])->name('client.generateApiKey');

    // Route pour configurer le webhook
    Route::post('/configurer-webhook', [ClientController::class, 'saveWebhook'])->name('configurer.webhook');
    Route::get('/dashboard/history', [DashboardController::class, 'history'])->name('dashboard.history');
    // web.php
    Route::get('/dashboard/solde', [ClientController::class, 'solde'])->name('dashboard.solde');
    Route::post('/dashboard/check-balance', [ClientController::class, 'checkBalance'])->name('check.balance');



    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les autres pages du tableau de bord
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::get('/dashboard/documentation', [DashboardController::class, 'documentation'])->name('dashboard.documentation');

    // Route pour révoquer une clé API
    Route::delete('/dashboard/api-keys/{id}', [DashboardController::class, 'revokeApiKey'])->name('dashboard.revokeApiKey');
});

// Inclure les routes d'authentification de Laravel Breeze
require __DIR__.'/auth.php';
