<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BrokerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Broker;
use Illuminate\Support\Facades\Validator;





class BrokerController extends Controller
{
    public function index(BrokerDataTable $dataTable) :  View | JsonResponse
    {
        return $dataTable->render('admin.brokers.index');
    }
    public function create() : RedirectResponse | View
    {
        return view('admin.brokers.create');
    }

    public function store(Request $request ) 
    {

        $validated = $request->validate([

            'company_name' => 'required|string|max:255',
            'dispatcher_name' => 'nullable|string|max:255',
            'mc_number' => 'nullable|string|max:255',
            'dot_number' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'email' => 'required|email|unique:brokers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'equipment_type' => 'array',
            'equipment_type.*' => 'string|max:255',
            'credit_score' => 'nullable|integer|min:0|max:850',
            'notes' => 'nullable|string',
            'operating_states' => 'array',
            'operating_states.*' => 'string|max:255',
            'days_to_pay' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,pending,blacklisted',
        ]);

        Broker::create($validated);

        return redirect()->route('admin.brokers.index')->with('success', __('Broker created successfully.'));
    }
    public function edit(Broker $broker) : RedirectResponse | View
    {
        return view('admin.brokers.edit', compact('broker'));
    }
    public function update(Request $request, Broker $broker) : RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'dispatcher_name' => 'nullable|string|max:255',
            'mc_number' => 'nullable|string|max:255',
            'dot_number' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'email' => 'required|email|unique:brokers,email,' . $broker->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'equipment_type' => 'array',
            'equipment_type.*' => 'string|max:255',
            'credit_score' => 'nullable|integer|min:0|max:850',
            'notes' => 'nullable|string',
            'operating_states' => 'array',
            'operating_states.*' => 'string|max:255',
            'days_to_pay' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,pending,blacklisted',
        ]);

        $broker->update($validated);

        return redirect()->route('admin.brokers.index')->with('success', __('Broker updated successfully.'));
    }
    public function destroy(Broker $broker) 
    {
        $broker->delete();


        return response()->json(['success' => true]);
    

    
    }
}
