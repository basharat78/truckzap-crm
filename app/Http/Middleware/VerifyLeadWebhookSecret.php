<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyLeadWebhookSecret
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('services.lead_webhook.secret');
        $provided = (string) $request->header('X-Webhook-Secret');

        if ($expected === '' || ! hash_equals($expected, $provided)) {
            abort(401, 'Invalid webhook secret.');
        }

        return $next($request);
    }
}
