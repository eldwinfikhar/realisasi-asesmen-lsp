<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessor;
use App\Models\Assessment;
use Illuminate\Validation\Rule;


class AssessorController extends Controller
{
    /**
     * Display a listing of the assessors.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // 1. Get available years from assessments table
        $availableYears = Assessment::query()->selectRaw('DISTINCT strftime("%Y", assessment_date) as year')->orderByDesc('year')->pluck('year');

        // 2. Get selected year from request
        $selectedYear = request('year', $availableYears->first());

        // 3. Fetch and paginate assessors
        $showUnused = request('show_unused');
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');
        $allowedSorts = ['name', 'assessments_count'];
        $allowedDirections = ['asc', 'desc'];
        if (!in_array($sort, $allowedSorts)) $sort = 'name';
        if (!in_array($direction, $allowedDirections)) $direction = 'asc';

        // 4. Fetch assessors with sorting and show_unused filter
        $assessors = Assessor::withCount(['assessments as assessments_count' => function($query) use ($selectedYear) {
            if (!empty($selectedYear)) {
                $query->whereYear('assessment_date', $selectedYear);
            }
        }])
        ->when(request('search'), function($q) {
            $q->where('name', 'like', '%' . request('search') . '%');
        })
        ->when($showUnused, function($q) use ($selectedYear) {
            $q->whereDoesntHave('assessments', function($query) use ($selectedYear) {
                if (!empty($selectedYear)) {
                    $query->whereYear('assessment_date', $selectedYear);
                }
            });
        })
        ->orderBy($sort, $direction)
        ->get();

        // 5. Pass to view
        return view('assessors.index', [
            'assessors' => $assessors,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear,
            'sort' => $sort,
            'direction' => $direction,
            'showUnused' => $showUnused,
        ]);
    }

    /**
     * Show the form for creating a new assessor.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $assessor = new Assessor();
        return view('assessors.form', compact('assessor'));
    }

    /**
     * Store a newly created assessor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:assessors,name',
        ]);
        Assessor::create($validated);
        return redirect()->route('assessors.index')->with('success', 'Data asesor berhasil ditambahkan.');
    }

    /**
     * Display the specified assessor.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $assessor = Assessor::withCount('assessments')->findOrFail($id);
        return view('assessors.show', compact('assessor'));
    }

    /**
     * Show the form for editing the specified assessor.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Assessor $assessor)
    {
        return view('assessors.form', compact('assessor'));
    }

    /**
     * Update the specified assessor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Assessor $assessor)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('assessors', 'name')->ignore($assessor->id),
            ],
        ]);
        $assessor->update($validated);
        return redirect()->route('assessors.index')->with('success', 'Data asesor berhasil diperbarui.');
    }

    /**
     * Remove the specified assessor from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Assessor $assessor)
    {
        $assessor->delete();
        return redirect()->route('assessors.index')->with('success', 'Data asesor berhasil dihapus.');
    }
}
