<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Assessor;
use App\Models\Assessment;

class AssessorController extends Controller
{
    /**
     * Display a listing of the assessors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 1. Get available years from assessments table
        $availableYears = Assessment::query()->selectRaw('DISTINCT strftime("%Y", assessment_date) as year')->orderByDesc('year')->pluck('year');

        // 2. Get selected year from request
        $selectedYear = request('year', $availableYears->first());

        // 3. Fetch and paginate assessors
        // 3. Get sort and direction from request
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');
        $allowedSorts = ['name', 'assessments_count'];
        $allowedDirections = ['asc', 'desc'];
        if (!in_array($sort, $allowedSorts)) $sort = 'name';
        if (!in_array($direction, $allowedDirections)) $direction = 'asc';

        // 4. Fetch assessors with sorting
        $assessors = Assessor::withCount(['assessments as assessments_count' => function($query) use ($selectedYear) {
            if (!empty($selectedYear)) {
                $query->whereYear('assessment_date', $selectedYear);
            }
        }])
        ->when(request('search'), function($q) {
            $q->where('name', 'like', '%' . request('search') . '%');
        })
        ->orderBy($sort, $direction)
        ->get();

        // 5. Pass to view
        return response(view('pages.laporan-asesor', [
            'assessors' => $assessors,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear,
            'sort' => $sort,
            'direction' => $direction
        ]));
    }

    /**
     * Show the form for creating a new assessor.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assessor = new Assessor();
        return response(view('assessors.form', compact('assessor')));
    }

    /**
     * Store a newly created assessor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Assessor::create($validated);
        return response(redirect()->route('assessors.index')->with('success', 'Data asesor berhasil ditambahkan.'));
    }

    /**
     * Display the specified assessor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assessor = Assessor::withCount('assessments')->findOrFail($id);
        return response(view('assessors.show', compact('assessor'))); 
    }

    /**
     * Show the form for editing the specified assessor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Assessor $assessor)
    {
        return response(view('assessors.form', compact('assessor')));
    }

    /**
     * Update the specified assessor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assessor $assessor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $assessor->update($validated);
        return response(redirect()->route('assessors.index')->with('success', 'Data asesor berhasil diperbarui.'));
    }

    /**
     * Remove the specified assessor from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assessor $assessor)
    {
        $assessor->delete();
        return response(redirect()->route('assessors.index')->with('success', 'Data asesor berhasil dihapus.'));
    }
}
