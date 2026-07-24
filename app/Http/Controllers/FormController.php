<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'dispatcher_name' => 'required|string|max:255',
            'mc_number' => 'required|string|max:255',
            'dot_number' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:brokers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'equipment_type' => 'required|array',
            'equipment_type.*' => 'string|max:255',
            'operating_states' => 'required|array',
            'operating_states.*' => 'string|max:255',
            'credit_score' => 'nullable|integer|min:0|max:850',
            'days_to_pay' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        Broker::create($validated);

        return redirect()->back()->with('success', 'Your broker application has been submitted successfully.');
    }
}
