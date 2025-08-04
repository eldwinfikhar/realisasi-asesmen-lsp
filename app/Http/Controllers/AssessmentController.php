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
    private function validateAssessmentData(Request $request, ?Assessment $assessment = null)
    {
        // Determine assessee type
        $assessee = null;
        if ($request->has('assessee_id')) {
            $assessee = Assessee::find($request->input('assessee_id'));
        } else if ($assessment) {
            $assessee = $assessment->assessee ?? null;
        }
        $assesseeType = $assessee->assessee_type ?? null;

        $rules = [
            'assessee_id' => 'required|exists:assessees,id',
            'assessor_id' => 'required|exists:assessors,id',
            'scheme_id' => 'required|exists:schemes,id',
            'pre_assessment_date' => 'required|date',
            'pre_assessment_venue' => 'required|string|max:255',
            'assessment_date' => 'required|date',
            'assessment_venue' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ];

        if ($assesseeType === 'Internal') {
            $rules['band'] = 'required|string|max:255';
        } elseif ($assesseeType === 'Eksternal') {
            $rules['location'] = 'nullable|string|max:255';
        }

        return $request->validate($rules);
    }
    /**
     * Display a listing of the external assessments.
     */
    public function indexExternal(Request $request)
    {
        // 1. Get all available years from assessments (SQLite compatible)
        $years = Assessment::selectRaw("strftime('%Y', assessment_date) as year")
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
            ->whereRaw("strftime('%Y', assessment_date) = ?", [$year])
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
            if (!$date instanceof \Carbon\Carbon) {
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
        $years = Assessment::selectRaw("strftime('%Y', assessment_date) as year")
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
            ->whereRaw("strftime('%Y', assessment_date) = ?", [$year])
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
            if (!$date instanceof \Carbon\Carbon) {
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
        // Validate and store the new assessment
        $this->validateAssessmentData($request, null);
        Assessment::create($request->all());
        return redirect()->route('assessments.index')->with('success', 'Assessment created successfully.');
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
    public function edit(string $id)
    {
        // Show form for editing an existing assessment
        $assessment = Assessment::findOrFail($id);
        // Include related entities for dropdowns
        return view('assessments.form', [
            'assessment' => $assessment,
            'assessees' => Assessee::with('entity')->get(),
            'assessors' => Assessor::all(),
            'schemes' => Scheme::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and update the existing assessment
        $assessment = Assessment::findOrFail($id);
        $this->validateAssessmentData($request, $assessment);
        $assessment->update($request->all());
        return redirect()->route('assessments.index')->with('success', 'Assessment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the specified assessment
        $assessment = Assessment::findOrFail($id);
        $assessment->delete();
        return redirect()->route('assessments.index')->with('success', 'Assessment deleted successfully.');
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
        $this->validateAssessmentData($request, null);
        $assessment = new Assessment($request->all());
        $assessment->save();
        return redirect()->route('assessments.indexExternal')->with('success', 'External assessment created successfully.');
    }

    /**
     * Show the form for editing the specified external assessment.
     */
    public function editExternal($id)
    {
        $assessment = Assessment::findOrFail($id);
        return view('assessments.form-eksternal', [
            'assessment' => $assessment,
            'assessees' => Assessee::with('entity')->where('assessee_type', 'Eksternal')->get(),
            'assessors' => Assessor::all(),
            'schemes' => Scheme::all(),
        ]);
    }

    /**
     * Update the specified external assessment in storage.
     */
    public function updateExternal(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->validateAssessmentData($request, $assessment);
        $assessment->update($request->all());
        return redirect()->route('assessments.indexExternal')->with('success', 'External assessment updated successfully.');
    }

    /**
     * Remove the specified external assessment from storage.
     */
    public function destroyExternal($id)
    {
        $assessment = Assessment::findOrFail($id);
        $assessment->delete();
        return redirect()->route('assessments.indexExternal')->with('success', 'External assessment deleted successfully.');
    }
}
