<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessorController extends Controller
{
    /**
     * Display a listing of the assessors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Query all assessors with their assessment count
        $assessors = \App\Models\Assessor::withCount('assessments')->get();
        return response(view('assessors.index', compact('assessors')));
    }

    /**
     * Show the form for creating a new assessor.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('assessors.create'));
    }

    /**
     * Store a newly created assessor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:assessors,email',
        ]);

        \App\Models\Assessor::create($request->all());
        return response(redirect()->route('assessors.index')->with('success', 'Assessor created successfully.'));
    }

    /**
     * Display the specified assessor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assessor = \App\Models\Assessor::withCount('assessments')->findOrFail($id);
        return response(view('assessors.show', compact('assessor'))); 
    }

    /**
     * Show the form for editing the specified assessor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assessor = \App\Models\Assessor::findOrFail($id);
        return response(view('assessors.edit', compact('assessor')));
    }

    /**
     * Update the specified assessor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:assessors,email,' . $id,
        ]);
        $assessor = \App\Models\Assessor::findOrFail($id);
        $assessor->update($request->all());
        return response(redirect()->route('assessors.index')->with('success', 'Assessor updated successfully.'));
    }

    /**
     * Remove the specified assessor from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assessor = \App\Models\Assessor::findOrFail($id);
        $assessor->delete();
        return response(redirect()->route('assessors.index')->with('success', 'Assessor deleted successfully.'));
    }
}
