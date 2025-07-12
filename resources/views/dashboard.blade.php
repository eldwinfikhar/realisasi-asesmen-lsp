@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
    <x-kpi-card title="Total Assessees This Year" :value="150" icon="user-group" />
    <x-kpi-card title="Assessments This Month" :value="32" icon="calendar" />
    <x-kpi-card title="Active Assessors This Year" :value="12" icon="identification" />
    <x-kpi-card title="Schemes Used This Year" :value="7" icon="collection" />
    <x-kpi-card title="Target Completion (%)" :value="85.5 . '%'" icon="chart-bar" />
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Assessment Trends</h2>
        <canvas id="assessmentTrendsChart" height="200"></canvas>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Target vs Realization</h2>
        <canvas id="targetRealizationChart" height="200"></canvas>
    </div>
</div>
<div class="bg-white dark:bg-gray-800 rounded shadow p-6">
    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Rekap Realisasi per Entitas</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Entitas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Target</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Realisasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pencapaian (%)</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas A</td>
                    <td class="px-6 py-4 whitespace-nowrap">100</td>
                    <td class="px-6 py-4 whitespace-nowrap">90</td>
                    <td class="px-6 py-4 whitespace-nowrap">90%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas B</td>
                    <td class="px-6 py-4 whitespace-nowrap">80</td>
                    <td class="px-6 py-4 whitespace-nowrap">60</td>
                    <td class="px-6 py-4 whitespace-nowrap">75%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas C</td>
                    <td class="px-6 py-4 whitespace-nowrap">120</td>
                    <td class="px-6 py-4 whitespace-nowrap">100</td>
                    <td class="px-6 py-4 whitespace-nowrap">83.3%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas D</td>
                    <td class="px-6 py-4 whitespace-nowrap">60</td>
                    <td class="px-6 py-4 whitespace-nowrap">55</td>
                    <td class="px-6 py-4 whitespace-nowrap">91.7%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas E</td>
                    <td class="px-6 py-4 whitespace-nowrap">90</td>
                    <td class="px-6 py-4 whitespace-nowrap">70</td>
                    <td class="px-6 py-4 whitespace-nowrap">77.8%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
