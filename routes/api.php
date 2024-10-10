<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ApiClientController;
use App\Http\Controllers\SmsController;

// Route to generate an API key via the ClientController
Route::post('/generate-api-key', [ClientController::class, 'generateApiKey']);

// In api.php
Route::post('/revoke-api-key', [ClientController::class, 'revokeApiKey']);
Route::post('/generate-new-api-key', [ClientController::class, 'generateNewApiKey']);


// Route to check the balance using the ApiClientController
Route::post('/check-balance', [ApiClientController::class, 'checkBalance']);

// Route to send SMS via the SmsController
Route::post('/send-sms', [SmsController::class, 'sendSms']);

// Route to handle Delivery Reports via the SmsController
Route::post('/dlr', [SmsController::class, 'handleDlr']);
