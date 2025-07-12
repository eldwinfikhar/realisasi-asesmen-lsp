<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\AssessmentTarget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $year = now()->year;
        $month = now()->month;

        // 1. totalAssesseesThisYear
        $totalAssesseesThisYear = Assessment::whereYear('assessment_date', $year)
            ->distinct('assessee_id')
            ->count('assessee_id');

        // 2. assessmentsThisMonth
        $assessmentsThisMonth = Assessment::whereYear('assessment_date', $year)
            ->whereMonth('assessment_date', $month)
            ->count();

        // 3. activeAssessorsThisYear
        $activeAssessorsThisYear = Assessment::whereYear('assessment_date', $year)
            ->distinct('assessor_id')
            ->count('assessor_id');

        // 4. schemesUsedThisYear
        $schemesUsedThisYear = Assessment::whereYear('assessment_date', $year)
            ->distinct('scheme_id')
            ->count('scheme_id');

        // 5. targetCompletionPercentage
        $realization = Assessment::whereYear('assessment_date', $year)->count();
        $target = AssessmentTarget::whereYear('year', $year)->sum('target_count');
        $targetCompletionPercentage = $target > 0 ? round(($realization / $target) * 100, 2) : 0;

        return view('dashboard', compact(
            'totalAssesseesThisYear',
            'assessmentsThisMonth',
            'activeAssessorsThisYear',
            'schemesUsedThisYear',
            'targetCompletionPercentage'
        ));
    }
}
