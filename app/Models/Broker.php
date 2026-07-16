<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    use HasFactory;

    protected $fillable = [
        'dispatcher_name',
        'company_name',
        'mc_number',
        'dot_number',
        'website',
        'status',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'equipment_type',
        'operating_states',
        'credit_score',
        'days_to_pay',
        'notes'
    ];

    protected $casts = [
        'equipment_type' => 'array',
        'operating_states' => 'array',
    ];
}
