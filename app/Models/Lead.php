<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'source_message_id',
        'source_group_id',
        'group_name',
        'sender_name',
        'sender_phone',
        'message',
        'sent_at',
        'synced_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'synced_at' => 'datetime',
    ];
}
