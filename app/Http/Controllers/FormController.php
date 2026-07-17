<?php

namespace App\Http\Controllers;

use App\Models\HR;
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
            'candidate_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'expected_salary' => 'required|integer|min:0',
            'experience' => 'nullable|integer|min:0',
            'city' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'interviewer' => 'required|string|max:255',
            'interview_date' => 'required|date',
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
            'status' => 'required|string|max:255',
        ]);

        HR::create($validated);

        return redirect()->back()->with('success', 'Your evaluation has been submitted successfully.');
    }
}
