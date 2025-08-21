<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentTarget;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get total annual targets for internal and external assessments for a given year.
     *
     * @param int $year
     * @return array ['internal' => int, 'external' => int]
     */
    private function getAnnualTargets($year)
    {
        $internal = AssessmentTarget::where('year', $year)
            ->whereNotNull('entity_id')
            ->sum('target_count');
        $external = AssessmentTarget::where('year', $year)
            ->whereNull('entity_id')
            ->sum('target_count');
        return [
            'internal' => $internal,
            'external' => $external,
        ];
    }
    public function index()
    {
        // Get all available years from assessments table
        $availableYears = Assessment::query()
            ->selectRaw('DISTINCT YEAR(assessment_date) as year')
            ->orderByDesc('year')
            ->pluck('year');

        // Get selected year from request, default to most recent year
        $selectedYear = request('year', $availableYears->first());
        $year = $selectedYear;

        // --- KPI Cards ---
        // Total unique assessees (internal & external) who had an assessment
        $totalAssessees = Assessment::whereYear('assessment_date', $year)
            ->distinct('assessee_id')
            ->count('assessee_id');

        // Total count of all assessments
        $totalAssessments = Assessment::whereYear('assessment_date', $year)->count();

        // Total unique assessors
        $activeAssessors = Assessment::whereYear('assessment_date', $year)
            ->distinct('assessor_id')
            ->count('assessor_id');

        // Total unique schemes used
        $activeSchemes = Assessment::whereYear('assessment_date', $year)
            ->distinct('scheme_id')
            ->count('scheme_id');

        // Target completion: total internal assessments / total internal targets
        $internalAssessments = Assessment::whereYear('assessment_date', $year)
            ->whereHas('assessee', function($q) {
                $q->where('assessee_type', 'Internal');
            })
            ->count();
        $internalTarget = AssessmentTarget::where('year', $year)
            ->whereNotNull('entity_id')
            ->sum('target_count');
        $targetCompletion = $internalTarget > 0 ? round(($internalAssessments / $internalTarget) * 100, 2) : 0;

        // --- Charts ---
        $monthlyRealisations = [];
        $monthlyTargets = [];
        $internalMonthlyCounts = [];
        $externalMonthlyCounts = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyRealisations[$m] = Assessment::whereYear('assessment_date', $year)
                ->whereMonth('assessment_date', $m)
                ->count();
            $monthlyTargets[$m] = AssessmentTarget::where('year', $year)
                ->where('month', $m)
                ->sum('target_count');
            $internalMonthlyCounts[$m] = Assessment::whereYear('assessment_date', $year)
                ->whereMonth('assessment_date', $m)
                ->whereHas('assessee', function($q) {
                    $q->where('assessee_type', 'Internal');
                })
                ->count();
            $externalMonthlyCounts[$m] = Assessment::whereYear('assessment_date', $year)
                ->whereMonth('assessment_date', $m)
                ->whereHas('assessee', function($q) {
                    $q->where('assessee_type', 'Eksternal');
                })
                ->count();
        }

        // --- Internal Assessee Distribution by Entity ---
        $entityCompositionData = Assessment::whereYear('assessment_date', $year)
            ->whereHas('assessee', function($q) {
                $q->where('assessee_type', 'Internal');
            })
            ->with('assessee.entity')
            ->get()
            ->groupBy(function($a) {
                return optional($a->assessee->entity)->name ?? 'Tanpa Entitas';
            })
            ->map(function($group) {
                return $group->count();
            });

        // --- Assessment Distribution by Scope ---
        $scopeDistributionData = Assessment::whereYear('assessment_date', $year)
            ->with('scheme')
            ->get()
            ->groupBy(function($a) {
                return optional($a->scheme)->scope ?? 'Tanpa Skema';
            })
            ->map(function($group) {
                return $group->count();
            });

        // --- Monthly Progress Table ---
        $annualTargets = $this->getAnnualTargets($year);

        $internalMonthly = Assessment::with('assessee')
            ->whereYear('assessment_date', $year)
            ->whereHas('assessee', function($q) {
                $q->where('assessee_type', 'Internal');
            })
            ->get()
            ->groupBy(function($a) {
                if ($a->assessment_date instanceof Carbon) {
                    return (int)$a->assessment_date->format('n');
                } else {
                    return (int)date('n', strtotime((string)$a->assessment_date));
                }
            });

        $externalMonthly = Assessment::with('assessee')
            ->whereYear('assessment_date', $year)
            ->whereHas('assessee', function($q) {
                $q->where('assessee_type', 'Eksternal');
            })
            ->get()
            ->groupBy(function($a) {
                if ($a->assessment_date instanceof Carbon) {
                    return (int)$a->assessment_date->format('n');
                } else {
                    return (int)date('n', strtotime((string)$a->assessment_date));
                }
            });

        $internalCumulative = 0;
        $externalCumulative = 0;
        $monthlyProgress = collect();

        for ($m = 1; $m <= 12; $m++) {
            $internalCount = isset($internalMonthly[$m]) ? $internalMonthly[$m]->count() : 0;
            $externalCount = isset($externalMonthly[$m]) ? $externalMonthly[$m]->count() : 0;
            $internalCumulative += $internalCount;
            $externalCumulative += $externalCount;
            $internalPercent = $annualTargets['internal'] > 0 ? round(($internalCumulative / $annualTargets['internal']) * 100, 2) : 0;
            $externalPercent = $annualTargets['external'] > 0 ? round(($externalCumulative / $annualTargets['external']) * 100, 2) : 0;
            $monthlyProgress[$m] = [
                'month' => $m,
                'internal_cumulative' => $internalCumulative,
                'internal_percent' => $internalPercent,
                'external_cumulative' => $externalCumulative,
                'external_percent' => $externalPercent,
            ];
        }

        // --- Monthly Progress Summary Totals ---
        $finalInternalCumulative = $internalCumulative;
        $finalExternalCumulative = $externalCumulative;
        $finalInternalPercent = $annualTargets['internal'] > 0 ? round(($finalInternalCumulative / $annualTargets['internal']) * 100, 1) : 0;
        $finalExternalPercent = $annualTargets['external'] > 0 ? round(($finalExternalCumulative / $annualTargets['external']) * 100, 1) : 0;
        $finalTotalCumulative = $finalInternalCumulative + $finalExternalCumulative;
        $finalTotalTarget = ($annualTargets['internal'] ?? 0) + ($annualTargets['external'] ?? 0);
        $finalTotalPercent = $finalTotalTarget > 0 ? round(($finalTotalCumulative / $finalTotalTarget) * 100, 1) : 0;

        // Prepare chart data variables by chart ID
        $assessmentTrendsChart = [
            'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            'realisasi' => array_values($monthlyRealisations),
            'target' => array_values($monthlyTargets),
        ];
        $internalExternalChart = [
            'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            'internal' => array_values($internalMonthlyCounts),
            'eksternal' => array_values($externalMonthlyCounts),
        ];
        $targetRealizationChart = [
            'labels' => array_keys($entityCompositionData->toArray()),
            'data' => array_values($entityCompositionData->toArray()),
        ];

        return view('dashboard', compact(
            'availableYears',
            'selectedYear',
            'totalAssessees',
            'totalAssessments',
            'activeAssessors',
            'activeSchemes',
            'targetCompletion',
            'monthlyRealisations',
            'monthlyTargets',
            'entityCompositionData',
            'monthlyProgress',
            'internalMonthlyCounts',
            'externalMonthlyCounts',
            'assessmentTrendsChart',
            'internalExternalChart',
            'targetRealizationChart',
            'scopeDistributionData',
            'finalInternalCumulative',
            'finalInternalPercent',
            'finalExternalCumulative',
            'finalExternalPercent',
            'finalTotalCumulative',
            'finalTotalPercent',
        ));
    }
}
