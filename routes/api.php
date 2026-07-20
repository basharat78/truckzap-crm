<?php

use App\Http\Controllers\Api\LeadWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('leads/webhook', [LeadWebhookController::class, 'store'])
    ->middleware('verify.lead_webhook')
    ->name('api.leads.webhook');
