<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HR;
use App\DataTables\HRDataTable;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
class HRController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( HRDataTable $DataTable ) : view | jsonResponse
    {
       
        return $DataTable->render('admin.hr.index');
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hr.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'candidate_name'=> 'required|string|max:255',
            'phone'=> 'required|string|max:255',
            'email'=> 'required|string|max:255',
            'position'=> 'nullable|string|max:255',
            'department'=> 'nullable|string|max:255',
            'expected_salary'=> 'nullable|integer|max:255',
            'experience'=> 'nullable|integer|max:255',
            'city'=> 'nullable|string|max:255',
            'reference'=> 'nullable|string|max:255',
            'interviewer'=> 'required|string|max:255',
            'interview_date'=> 'nullable|date',
            'communication' => 'nullable|integer|max:255',
            'english' => 'nullable|integer|max:255',
            'computer_skills'=> 'nullable|integer|max:255',
            'confidence'=> 'nullable|integer|max:255',
            'learning_ability' => 'nullable|integer|max:255',
            'dispatch_knowledge'=> 'nullable|integer|max:255',
            'negotiation_skills'=> 'nullable|integer|max:255',
            'typing_speed'=> 'nullable|integer|max:255',
            'total_score' => 'nullable|integer|max:255',
            'strengths'=> 'nullable|string|max:255',
            'weaknesses' => 'nullable|string|max:255',
            'comments'=> 'nullable|string|max:255',
            'recommendation'=> 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',

        ]);
      
        HR ::create($validated);
     

        return redirect()->route('admin.hr.index')->with('success', __('Broker created successfully.'));
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HR $hr , string $id)
    {
        
        return view('admin.hr.edit', compact('hr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
