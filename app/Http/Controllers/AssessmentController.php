<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Query all assessments with their related entities, assessors, and schemes
        $assessments = \App\Models\Assessment::with(['assessee', 'assessor', 'scheme'])
            ->orderBy('assessment_date', 'desc')
            ->paginate(10); // Adjust pagination as needed
        return view('assessments.index', compact('assessments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show form for creating a new assessment
        // return view('assessments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the new assessment
        $request->validate([
            'assessee_id' => 'required|exists:users,id',
            'assessor_id' => 'required|exists:assessors,id',
            'scheme_id' => 'required|exists:schemes,id',
            'assessment_date' => 'required|date',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]); 
        \App\Models\Assessment::create($request->all());
        return redirect()->route('assessments.index')->with('success', 'Assessment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Show details of a specific assessment
        $assessment = \App\Models\Assessment::with(['assessee', 'assessor', 'scheme'])
            ->findOrFail($id);
        return view('assessments.show', compact('assessment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Show form for editing an existing assessment
        $assessment = \App\Models\Assessment::findOrFail($id);
        return view('assessments.edit', compact('assessment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and update the existing assessment
        $request->validate([
            'assessee_id' => 'required|exists:users,id',
            'assessor_id' => 'required|exists:assessors,id',
            'scheme_id' => 'required|exists:schemes,id',
            'assessment_date' => 'required|date',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $assessment = \App\Models\Assessment::findOrFail($id);
        $assessment->update($request->all());

        return redirect()->route('assessments.index')->with('success', 'Assessment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the specified assessment
        $assessment = \App\Models\Assessment::findOrFail($id);
        $assessment->delete();
        return redirect()->route('assessments.index')->with('success', 'Assessment deleted successfully.');
    }
}
