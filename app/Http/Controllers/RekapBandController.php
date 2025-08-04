<?php

namespace App\Http\Controllers;

use App\Models\Assessment;

class RekapBandController extends Controller
{
    /**
     * Display a summary table of assessment counts grouped by entity and band.
     */
    public function index()
    {

        // 0. Get a list of available years from assessments table (dynamic, SQLite compatible)
        $availableYears = Assessment::query()->selectRaw('DISTINCT strftime("%Y", assessment_date) as year')->orderByDesc('year')->pluck('year');
        $selectedYear = request('year', $availableYears->first());

        // 1. Fetch all assessments for the selected year, eager load assessee and assessee.entity
        $assessments = Assessment::with(['assessee.entity'])
            ->whereHas('assessee', function($q) {
                $q->where('assessee_type', 'Internal');
            })
            ->when(!empty($selectedYear), function($q) use ($selectedYear) {
                $q->whereYear('assessment_date', $selectedYear);
            })
            ->get();

        // 2. Group by entity name, then by band
        // We'll use Laravel's collection methods for grouping
        $grouped = $assessments->groupBy(function ($assessment) {
            // Get the entity name for each assessment's assessee
            return $assessment->assessee && $assessment->assessee->entity ? $assessment->assessee->entity->name : 'Tanpa Entitas';
        })->map(function ($entityGroup) {
            // For each entity, group by band
            return $entityGroup->groupBy(function ($assessment) {
                return $assessment->assessee ? $assessment->assessee->band : 'Tanpa Band';
            })->map(function ($bandGroup) {
                // For each band, count the number of assessments
                return $bandGroup->count();
            });
        });

        // 3. The result is a nested collection: [entity => [band => count]]
        // Example: ['Bio Farma' => ['I' => 5, 'II' => 10], ...]

        // 4. Calculate totals per band across all entities
        $bands = ['I', 'II', 'III', 'IV', 'V'];
        $totalsPerBand = [];
        foreach ($bands as $band) {
            // Sum for each band across all entities
            $totalsPerBand[$band] = $grouped->reduce(function ($carry, $bandsArr) use ($band) {
                return $carry + ($bandsArr[$band] ?? 0);
            }, 0);
        }

        // 5. Calculate grand total (sum of all bands)
        $grandTotal = array_sum($totalsPerBand);

        // 6. Pass the structured data and totals to the view
        return view('reports.rekap-band', [
            'rekapData' => $grouped,
            'totalsPerBand' => $totalsPerBand,
            'grandTotal' => $grandTotal,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear
        ]);
    }
}
