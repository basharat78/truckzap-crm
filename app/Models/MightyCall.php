<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MightyCall extends Model
{
    protected $fillable = [
        'mightycall_call_id',
        'direction',
        'call_status',
        'business_number',
        'caller_name',
        'caller_phone',
        'caller_extension',
        'called_name',
        'called_phone',
        'agent_name',
        'agent_extension',
        'duration_ms',
        'recording_filename',
        'recording_url',
        'call_started_at',
        'synced_at',
    ];

    protected $casts = [
        'duration_ms' => 'integer',
        'call_started_at' => 'datetime',
        'synced_at' => 'datetime',
    ];
}
