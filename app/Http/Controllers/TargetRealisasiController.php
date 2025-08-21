<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\AssessmentTarget;
use App\Models\Entity;
use App\Models\Assessee;
use Carbon\Carbon;


class TargetRealisasiController extends Controller
{

    // Display a combined report for internal (entity-based) and external (location-based) assessments
    public function index(Request $request)
    {
        // 1. Get a list of available years from assessments table (dynamic, SQLite compatible)
        $availableYears = Assessment::query()
            ->selectRaw('DISTINCT YEAR(assessment_date) as year')
            ->orderByDesc('year')
            ->pluck('year');

        // 2. Get the selected year from the request, default to most recent
        $selectedYear = $request->input('year', $availableYears->first());

        // --- Internal (entity-based) ---
        $targets = AssessmentTarget::query()
            ->where('year', $selectedYear)
            ->whereNotNull('entity_id')
            ->get();

        $realizationsRaw = Assessment::with('assessee')
            ->whereYear('assessment_date', $selectedYear)
            ->whereHas('assessee', function($q) {
                $q->where('assessee_type', 'Internal');
            })
            ->get();

        $realizations = collect();
        foreach ($realizationsRaw as $assessment) {
            $entityId = $assessment->assessee ? $assessment->assessee->entity_id : null;
            $month = $assessment->assessment_date instanceof Carbon
                ? $assessment->assessment_date->format('n')
                : ($assessment->assessment_date ? date('n', strtotime((string)$assessment->assessment_date)) : null);
            if ($entityId && $month) {
                $key = $entityId.'-'.$month;
                if (!isset($realizations[$key])) {
                    $realizations[$key] = (object)[
                        'entity_id' => $entityId,
                        'month' => (int)$month,
                        'realization_count' => 0
                    ];
                }
                $realizations[$key]->realization_count++;
            }
        }
        $realizations = $realizations->values();

        $entities = Entity::query()->get();

        $targetMonthlyTotals = [];
        for ($month = 1; $month <= 12; $month++) {
            $targetMonthlyTotals[$month] = $targets->where('month', $month)->sum('target_count');
        }
        $targetGrandTotal = array_sum($targetMonthlyTotals);

        $realizationMonthlyTotals = [];
        for ($month = 1; $month <= 12; $month++) {
            $realizationMonthlyTotals[$month] = $realizations->where('month', $month)->sum('realization_count');
        }
        $realizationGrandTotal = array_sum($realizationMonthlyTotals);

        // --- External (location-based) ---
        $externalTargetsRaw = AssessmentTarget::query()
            ->where('year', $selectedYear)
            ->whereNull('entity_id')
            ->get();

        // Structure: $externalTargets[location][month] = ['target_count' => ...]
        $externalTargets = [];
        foreach ($externalTargetsRaw as $target) {
            $externalTargets[$target->location][$target->month] = [
                'target_count' => $target->target_count
            ];
        }

        $externalAssessments = Assessment::with('assessee')
            ->whereYear('assessment_date', $selectedYear)
            ->whereHas('assessee', function($q) {
                $q->where('assessee_type', 'Eksternal');
            })
            ->get();

        // Structure: $externalRealisations[location][month] = ['realization_count' => ...]
        $externalRealisations = [];
        foreach ($externalAssessments as $assessment) {
            if (!$assessment->assessee || !$assessment->assessee->location) continue;
            $location = $assessment->assessee->location;
            $month = $assessment->assessment_date instanceof Carbon
                ? $assessment->assessment_date->format('n')
                : ($assessment->assessment_date ? date('n', strtotime((string)$assessment->assessment_date)) : null);
            if ($location && $month) {
                if (!isset($externalRealisations[$location][$month])) {
                    $externalRealisations[$location][$month] = [
                        'realization_count' => 0
                    ];
                }
                $externalRealisations[$location][$month]['realization_count']++;
            }
        }

        $locations = Assessee::query()
            ->where('assessee_type', 'Eksternal')
            ->whereNotNull('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        $externalTargetMonthlyTotals = [];
        for ($month = 1; $month <= 12; $month++) {
            $externalTargetMonthlyTotals[$month] = $externalTargetsRaw->where('month', $month)->sum('target_count');
        }
        $externalTargetGrandTotal = array_sum($externalTargetMonthlyTotals);

        $externalRealizationMonthlyTotals = [];
        for ($month = 1; $month <= 12; $month++) {
            $sum = 0;
            foreach ($locations as $location) {
                $sum += $externalRealisations[$location][$month]['realization_count'] ?? 0;
            }
            $externalRealizationMonthlyTotals[$month] = $sum;
        }
        $externalRealizationGrandTotal = array_sum($externalRealizationMonthlyTotals);

        return view('reports.target-realisasi', [
            // Internal
            'entities' => $entities,
            'targets' => $targets,
            'realizations' => $realizations,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear,
            'targetMonthlyTotals' => $targetMonthlyTotals,
            'targetGrandTotal' => $targetGrandTotal,
            'realizationMonthlyTotals' => $realizationMonthlyTotals,
            'realizationGrandTotal' => $realizationGrandTotal,
            // External
            'locations' => $locations,
            'externalTargets' => $externalTargets,
            'externalRealisations' => $externalRealisations,
            'externalTargetMonthlyTotals' => $externalTargetMonthlyTotals,
            'externalTargetGrandTotal' => $externalTargetGrandTotal,
            'externalRealizationMonthlyTotals' => $externalRealizationMonthlyTotals,
            'externalRealizationGrandTotal' => $externalRealizationGrandTotal,
        ]);
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // ...
        // Logic to show form for creating a new target realization
        return view('target-realisasi.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Logic to store a new target realization
        // Validate and save the target realization data
        $request->validate([
            'year' => 'required|integer',
            'target_count' => 'required|integer',
        ]);
    }

    // Display the specified resource.
    public function show($id)
    {
        // Logic to show a specific target realization
        return view('target-realisasi.show', compact('id'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        // Logic to show form for editing a target realization
        return view('target-realisasi.edit', compact('id'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Logic to update a target realization
        $request->validate([
            'year' => 'required|integer',
            'target_count' => 'required|integer',
        ]);
        // Logic to update the target realization in the database
        return redirect()->route('laporan.target-realisasi')->with('success', 'Target realization updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Logic to delete a target realization
        return redirect()->route('laporan.target-realisasi')->with('success', 'Target realization deleted successfully.');
    }
}
