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
    public function index(HRDataTable $dataTable): View|JsonResponse
    {
        if (request()->ajax()) {
            return $dataTable->render('admin.hr.index');
        }

        $statusCounts = HR::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return $dataTable->render('admin.hr.index', compact('statusCounts'));
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
            'expected_salary'=> 'nullable|integer|min:0',
            'experience'=> 'nullable|integer|min:0',
            'city'=> 'nullable|string|max:255',
            'reference'=> 'nullable|string|max:255',
            'interviewer'=> 'required|string|max:255',
            'interview_date'=> 'nullable|date',
            'communication' => 'nullable|integer|min:1|max:10',
            'english' => 'nullable|integer|min:1|max:10',
            'computer_skills'=> 'nullable|integer|min:1|max:10',
            'confidence'=> 'nullable|integer|min:1|max:10',
            'learning_ability' => 'nullable|integer|min:1|max:10',
            'dispatch_knowledge'=> 'nullable|integer|min:1|max:10',
            'negotiation_skills'=> 'nullable|integer|min:1|max:10',
            'typing_speed'=> 'nullable|integer|min:0',
            'total_score' => 'nullable|integer|min:0',
            'strengths'=> 'nullable|string|max:255',
            'weaknesses' => 'nullable|string|max:255',
            'comments'=> 'nullable|string|max:255',
            'recommendation'=> 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',

        ]);
      
        HR ::create($validated);
     

        return redirect()->route('admin.hr.index')->with('success', __('Interview evaluation created successfully.'));
      
    }

    /**
     * Display the specified resource.
     */
    public function show(HR $hr): JsonResponse
    {
        return response()->json(['hr' => $hr]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HR $hr)
    {
        return view('admin.hr.edit', compact('hr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HR $hr)
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|integer|min:0',
            'experience' => 'nullable|integer|min:0',
            'city' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'interviewer' => 'required|string|max:255',
            'interview_date' => 'nullable|date',
            'communication' => 'nullable|integer|min:1|max:10',
            'english' => 'nullable|integer|min:1|max:10',
            'computer_skills' => 'nullable|integer|min:1|max:10',
            'confidence' => 'nullable|integer|min:1|max:10',
            'learning_ability' => 'nullable|integer|min:1|max:10',
            'dispatch_knowledge' => 'nullable|integer|min:1|max:10',
            'negotiation_skills' => 'nullable|integer|min:1|max:10',
            'typing_speed' => 'nullable|integer|min:0',
            'total_score' => 'nullable|integer|min:0',
            'strengths' => 'nullable|string|max:255',
            'weaknesses' => 'nullable|string|max:255',
            'comments' => 'nullable|string|max:255',
            'recommendation' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $hr->update($validated);

        return redirect()->route('admin.hr.index')->with('success', __('Interview evaluation updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HR $hr): JsonResponse
    {
        $hr->delete();

        return response()->json(['success' => true]);
    }
}
