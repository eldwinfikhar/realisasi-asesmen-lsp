<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Assessee;
use App\Models\Assessor;
use App\Models\Scheme;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    /**
     * Centralized validation for assessment data.
     * Validates 'band' for internal, 'location' for external.
     */
    private function validatedData(Request $request)
    {
         return $request->validate([
            'assessee_id' => 'required|exists:assessees,id',
            'assessor_id' => 'required|exists:assessors,id',
            'scheme_id' => 'required|exists:schemes,id',
            'pre_assessment_date' => 'required|date',
            'pre_assessment_venue' => 'required|string|max:255',
            'assessment_date' => 'required|date|after_or_equal:pre_assessment_date',
            'assessment_venue' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);
    }
    /**
     * Display a listing of the external assessments.
     */
    public function indexExternal(Request $request)
    {
        // 1. Get all available years from assessments (SQLite compatible)
        $years = Assessment::selectRaw("YEAR(assessment_date) as year")
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        // 2. Determine selected year (default to most recent)
        $year = $request->input('year');
        if (!$year && count($years) > 0) {
            $year = $years[0];
        } elseif (!$year) {
            $year = now()->year;
        }

        // 3. Query all assessments for the selected year, eager loading relationships
        $assessments = Assessment::with(['assessee.entity', 'assessor', 'scheme'])
            ->whereRaw("YEAR(assessment_date) = ?", [$year])
            ->whereHas('assessee', function($query) {
                $query->where('assessee_type', 'Eksternal');
            })
            ->orderBy('assessment_date', 'asc')
            ->orderBy('pre_assessment_date', 'asc')
            ->get();

        // 4. Group by month number (1-12)
        $assessmentsByMonthRaw = $assessments->groupBy(function ($assessment) {
            if (!$assessment->assessment_date) return null;
            $date = $assessment->assessment_date;
            if (!$date instanceof Carbon) {
                $date = Carbon::parse((string)$date);
            }
            return (int)$date->month;
        });

        // 5. Ensure all months 1-12 are present
        $assessmentsByMonth = collect(range(1, 12))->mapWithKeys(function ($month) use ($assessmentsByMonthRaw) {
            return [$month => $assessmentsByMonthRaw->get($month, collect())];
        });

        // 6. Return to view
        return view('assessments.index-external', [
            'assessmentsByMonth' => $assessmentsByMonth,
            'years' => $years,
            'year' => $year,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Get all available years from assessments (SQLite compatible)
        $years = Assessment::selectRaw("YEAR(assessment_date) as year")
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        // 2. Determine selected year (default to most recent)
        $year = $request->input('year');
        if (!$year && count($years) > 0) {
            $year = $years[0];
        } elseif (!$year) {
            $year = now()->year;
        }

        // 3. Query all assessments for the selected year, eager loading relationships
        $assessments = Assessment::with(['assessee.entity', 'assessor', 'scheme'])
            ->whereRaw("YEAR(assessment_date) = ?", [$year])
            ->whereHas('assessee', function($query) {
                $query->where('assessee_type', 'Internal');
            })
            ->orderBy('assessment_date', 'asc')
            ->orderBy('pre_assessment_date', 'asc')
            ->get();

        // 4. Group by month number (1-12)
        $assessmentsByMonthRaw = $assessments->groupBy(function ($assessment) {
            if (!$assessment->assessment_date) return null;
            $date = $assessment->assessment_date;
            if (!$date instanceof Carbon) {
                $date = Carbon::parse((string)$date);
            }
            return (int)$date->month;
        });

        // 5. Ensure all months 1-12 are present
        $assessmentsByMonth = collect(range(1, 12))->mapWithKeys(function ($month) use ($assessmentsByMonthRaw) {
            return [$month => $assessmentsByMonthRaw->get($month, collect())];
        });

        // 6. Return to view
        return view('assessments.index', [
            'assessmentsByMonth' => $assessmentsByMonth,
            'years' => $years,
            'year' => $year,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show form for creating a new assessment
        return view('assessments.form', [
            'assessees' => Assessee::with('entity')->get(),
            'assessors' => Assessor::all(),
            'schemes' => Scheme::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validatedData($request);
        Assessment::create($validatedData);
        return redirect()->route('assessments.index')->with('success', 'Data asesmen internal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Show details of a specific assessment
        $assessment = Assessment::with(['assessee', 'assessor', 'scheme'])
            ->findOrFail($id);
        return view('assessments.show', compact('assessment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assessment $assessment)
    {
        return view('assessments.form', [
            'assessment' => $assessment,
            'assessees'  => Assessee::with('entity')->orderBy('name')->get(),
            'assessors'  => Assessor::orderBy('name')->get(),
            'schemes'    => Scheme::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assessment $assessment)
    {
        $validatedData = $this->validatedData($request);
        $assessment->update($validatedData);
        return redirect()->route('assessments.index')->with('success', 'Data asesmen internal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('assessments.index')->with('success', 'Data asesmen internal berhasil dihapus.');
    }

    /**
     * Show the form for creating a new external assessment.
     */
    public function createExternal()
    {
        return view('assessments.form-eksternal', [
            'assessees' => Assessee::with('entity')->where('assessee_type', 'Eksternal')->get(),
            'assessors' => Assessor::all(),
            'schemes' => Scheme::all(),
        ]);
    }

    /**
     * Store a newly created external assessment in storage.
     */
    public function storeExternal(Request $request)
    {
         $validatedData = $this->validatedData($request);
        Assessment::create($validatedData);
        return redirect()->route('assessments.indexExternal')->with('success', 'Data asesmen eksternal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified external assessment.
     */
    public function editExternal(Assessment $assessment)
    {

        return view('assessments.form-eksternal', [
            'assessment' => $assessment,
            'assessees'  => Assessee::with('entity')->orderBy('name')->get(),
            'assessors'  => Assessor::orderBy('name')->get(),
            'schemes'    => Scheme::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified external assessment in storage.
     */
    public function updateExternal(Request $request, Assessment $assessment)
    {
        $validatedData = $this->validatedData($request);
        $assessment->update($validatedData);
        return redirect()->route('assessments.indexExternal')->with('success', 'Data asesmen eksternal berhasil diperbarui.');
    }

    /**
     * Remove the specified external assessment from storage.
     */
    public function destroyExternal(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('assessments.indexExternal')->with('success', 'Data asesmen eksternal berhasil dihapus.');
    }
}
