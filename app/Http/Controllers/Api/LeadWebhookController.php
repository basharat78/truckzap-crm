<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadWebhookController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'source_message_id' => ['required', 'string'],
            'source_group_id' => ['nullable', 'string'],
            'group_name' => ['nullable', 'string'],
            'sender_name' => ['nullable', 'string'],
            'sender_phone' => ['nullable', 'string'],
            'message' => ['required', 'string'],
            'sent_at' => ['nullable', 'date'],
        ]);

        $lead = Lead::updateOrCreate(
            ['source_message_id' => $data['source_message_id']],
            [
                'source_group_id' => $data['source_group_id'] ?? null,
                'group_name' => $data['group_name'] ?? null,
                'sender_name' => $data['sender_name'] ?? null,
                'sender_phone' => $data['sender_phone'] ?? null,
                'message' => $data['message'],
                'sent_at' => $data['sent_at'] ?? null,
                'synced_at' => now(),
            ]
        );

        return response()->json(['status' => 'ok', 'id' => $lead->id], 201);
    }
}
