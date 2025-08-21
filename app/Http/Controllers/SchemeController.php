<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scheme;
use App\Models\Assessment;

class SchemeController extends Controller
{
    public function index()
    {
        $availableYears = Assessment::query()->selectRaw('DISTINCT YEAR(assessment_date) as year')->orderByDesc('year')->pluck('year');
        $availableScopes = Scheme::select('scope')->distinct()->pluck('scope');
        $selectedYear = request('year', $availableYears->first());
        $selectedScope = request('scope', '');
        $showUnused = request('show_unused');
        $search = request('search', '');
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');
        $allowedSorts = ['name', 'scope', 'assessments_count'];
        $allowedDirections = ['asc', 'desc'];
        if (!in_array($sort, $allowedSorts)) $sort = 'name';
        if (!in_array($direction, $allowedDirections)) $direction = 'asc';
        $schemes = Scheme::withCount(['assessments as assessments_count' => function($query) use ($selectedYear) {
            $query->whereYear('assessment_date', $selectedYear);
        }])
        ->when($selectedScope, function($q) use ($selectedScope) {
            $q->where('scope', $selectedScope);
        })
        ->when($showUnused, function($q) use ($selectedYear) {
            $q->whereDoesntHave('assessments', function($query) use ($selectedYear) {
                if (!empty($selectedYear)) {
                    $query->whereYear('assessment_date', $selectedYear);
                }
            });
        })
        ->when($search, function($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })
        ->orderBy($sort, $direction)
        ->get();
        return view('schemes.index', [
            'schemes' => $schemes,
            'availableYears' => $availableYears,
            'availableScopes' => $availableScopes,
            'selectedYear' => $selectedYear,
            'selectedScope' => $selectedScope,
            'showUnused' => $showUnused,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function create()
    {
        $scheme = new Scheme();
        return view('schemes.form', compact('scheme'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'scope' => 'required|string|max:255',
        ]);
        $scheme = Scheme::create($validated);
        return redirect()->route('schemes.index')->with('success', 'Data skema berhasil ditambahkan.');
    }

    public function edit(Scheme $scheme)
    {
        return view('schemes.form', compact('scheme'));
    }

    public function update(Request $request, Scheme $scheme)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'scope' => 'required|string|max:255',
        ]);
        $scheme->update($validated);
        return redirect()->route('schemes.index')->with('success', 'Data skema berhasil diperbarui.');
    }

    public function destroy(Scheme $scheme)
    {
        $scheme->delete();
        return redirect()->route('schemes.index')->with('success', 'Data skema berhasil dihapus.');
    }
}
