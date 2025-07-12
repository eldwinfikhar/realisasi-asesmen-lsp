<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessor;

class AssessorReportController extends Controller
{
    public function index()
    {
        // Query all assessors with their assessment count
        $assessors = Assessor::withCount('assessments')->get();
        return view('reports.assessor-report', compact('assessors'));
    }
}
