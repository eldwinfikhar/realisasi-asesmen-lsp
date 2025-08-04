@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard</h1>
    <form method="GET" class="flex items-center gap-2">
        <select name="year" class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
            <option value="">Pilih Tahun</option>
            @foreach($availableYears as $yearOption)
                <option value="{{ $yearOption }}" @if($yearOption == $selectedYear) selected @endif>{{ $yearOption }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Filter</button>
    </form>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
    <x-kpi-card title="Total Asesi Tahun Ini" :value="$totalAssessees" icon="users" />
    <x-kpi-card title="Total Asesmen Tahun Ini" :value="$totalAssessments" icon="clipboard-list" />
    <x-kpi-card title="Asesor Aktif Tahun Ini" :value="$activeAssessors" icon="user-check" />
    <x-kpi-card title="Penggunaan Skema Tahun Ini" :value="$activeSchemes" icon="bookmark-alt" />
    <x-kpi-card title="Penyelesaian Target (%)" :value="$targetCompletion . '%'" icon="check-circle" />
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <!-- Realisasi vs Target Line Chart -->
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6 flex flex-col h-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Tren Realisasi vs Target Asesmen</h2>
        <div class="flex-grow relative" style="height:400px; min-height:320px;">
            <canvas id="assessmentTrendsChart" height="380"></canvas>
        </div>
    </div>
    <!-- Internal vs Eksternal Line Chart -->
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6 flex flex-col h-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Tren Asesmen Internal vs Eksternal</h2>
        <div class="flex-grow relative" style="height:400px; min-height:320px;">
            <canvas id="internalExternalChart" height="380"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <!-- Komposisi Entitas Pie Chart -->
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6 flex flex-col h-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Komposisi Entitas</h2>
        <div class="flex-grow relative" style="height:400px; min-height:320px;">
            <canvas id="targetRealizationChart" height="380"></canvas>
        </div>
    </div>
    <!-- Distribusi Lingkup Pie Chart -->
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6 flex flex-col h-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Sebaran Asesmen per Lingkup</h2>
        <div class="flex-grow relative" style="height:400px; min-height:320px;">
            <canvas id="scopeDistributionData" height="380"></canvas>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded shadow p-6">
    <h1 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Persentase Progres Asesmen per Bulan</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-300 dark:bg-gray-700">
                <tr>
                    <th rowspan="2" class="px-6 py-3 text-left text-lg font-medium dark:text-gray-300 uppercase tracking-wider">Bulan</th>
                    <th colspan="2" class="px-3 py-3 text-center text-lg font-medium dark:text-gray-300 uppercase tracking-wider">Internal (BFG)</th>
                    <th colspan="2" class="px-3 py-3 text-center text-lg font-medium dark:text-gray-300 uppercase tracking-wider">Eksternal</th>
                </tr>
                <tr>
                    <th class="px-3 py-3 text-center text-lg font-medium dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                    <th class="px-3 py-3 text-center text-lg font-medium dark:text-gray-300 uppercase tracking-wider">Persen (%)</th>
                    <th class="px-3 py-3 text-center text-lg font-medium dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                    <th class="px-3 py-3 text-center text-lg font-medium dark:text-gray-300 uppercase tracking-wider">Persen (%)</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @for ($m = 1; $m <= 12; $m++)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ Carbon::create()->month($m)->format('M') }}</td>
                        <td class="px-3 py-4 text-center whitespace-nowrap">{{ $monthlyProgress[$m]['internal_cumulative'] ?? 0 }}</td>
                        <td class="px-3 py-4 text-center whitespace-nowrap">{{ number_format($monthlyProgress[$m]['internal_percent'] ?? 0, 1) }}</td>
                        <td class="px-3 py-4 text-center whitespace-nowrap">{{ $monthlyProgress[$m]['external_cumulative'] ?? 0 }}</td>
                        <td class="px-3 py-4 text-center whitespace-nowrap">{{ number_format($monthlyProgress[$m]['external_percent'] ?? 0, 1) }}</td>
                    </tr>
                @endfor
            </tbody>
            <tfoot class="bg-gray-300 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left font-medium dark:text-gray-300 uppercase tracking-wider">Total</th>
                    <th class="px-3 py-3 text-center font-medium dark:text-gray-300 uppercase tracking-wider">{{ $finalInternalCumulative }}</th>
                    <th class="px-3 py-3 text-center font-medium dark:text-gray-300 uppercase tracking-wider">{{ number_format($finalInternalPercent, 1) }}</th>
                    <th class="px-3 py-3 text-center font-medium dark:text-gray-300 uppercase tracking-wider">{{ $finalExternalCumulative }}</th>
                    <th class="px-3 py-3 text-center font-medium dark:text-gray-300 uppercase tracking-wider">{{ number_format($finalExternalPercent, 1) }}</th>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left font-medium dark:text-gray-300 uppercase tracking-wider">Keseluruhan</th>
                    <th colspan="2" class="px-3 py-3 text-center font-medium dark:text-gray-300 uppercase tracking-wider">{{ $finalTotalCumulative }}</th>
                    <th colspan="2" class="px-3 py-3 text-center font-medium dark:text-gray-300 uppercase tracking-wider">{{ number_format($finalTotalPercent, 1) }}%</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Realisasi vs Target Line Chart ---
        const monthlyRealisations = @json(array_values($monthlyRealisations));
        const monthlyTargets = @json(array_values($monthlyTargets));
        const assessmentTrendsLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        const ctxTrends = document.getElementById('assessmentTrendsChart').getContext('2d');
        new Chart(ctxTrends, {
            type: 'line',
            data: {
                labels: assessmentTrendsLabels,
                datasets: [
                    {
                        label: 'Realisasi',
                        data: monthlyRealisations,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37,99,235,0.1)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#2563eb',
                    },
                    {
                        label: 'Target',
                        data: monthlyTargets,
                        borderColor: '#6b7280', // gray-500
                        backgroundColor: 'rgba(107,114,128,0.1)',
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        borderDash: [8, 6],
                        pointRadius: 4,
                        pointBackgroundColor: '#6b7280',
                        pointBorderColor: '#6b7280',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // --- Internal vs Eksternal Line Chart ---
        const internalExternalChart = @json($internalExternalChart);
        const ctxInternalExternal = document.getElementById('internalExternalChart').getContext('2d');
        new Chart(ctxInternalExternal, {
            type: 'line',
            data: {
                labels: internalExternalChart.labels,
                datasets: [
                    {
                        label: 'Internal',
                        data: internalExternalChart.internal,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37,99,235,0.1)',
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#2563eb',
                    },
                    {
                        label: 'Eksternal',
                        data: internalExternalChart.eksternal,
                        borderColor: '#22c55e', // green-500
                        backgroundColor: 'rgba(34,197,94,0.1)',
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#22c55e',
                        pointBorderColor: '#22c55e',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // --- Komposisi Entitas Pie Chart ---
        const targetRealizationChart = @json($targetRealizationChart);
        const ctxPie = document.getElementById('targetRealizationChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: targetRealizationChart.labels,
                datasets: [{
                    data: targetRealizationChart.data,
                    backgroundColor: [
                        '#2563eb', '#22d3ee', '#f59e42', '#f43f5e', '#a3e635', '#fbbf24', '#6366f1', '#14b8a6', '#eab308', '#f472b6', '#818cf8', '#f87171'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    datalabels: {
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percent = total ? (value / total * 100).toFixed(1) : 0;
                            return percent + '%';
                        },
                        color: '#fff',
                        font: { weight: 'bold' }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // --- Distribusi Lingkup Pie Chart ---
        const scopeDistributionData = @json($scopeDistributionData);
        const ctxScope = document.getElementById('scopeDistributionData').getContext('2d');
        new Chart(ctxScope, {
            type: 'pie',
            data: {
                labels: Object.keys(scopeDistributionData),
                datasets: [{
                    data: Object.values(scopeDistributionData),
                    backgroundColor: [
                        '#2563eb', '#22d3ee', '#f59e42', '#f43f5e', '#a3e635', '#fbbf24', '#6366f1', '#14b8a6', '#eab308', '#f472b6', '#818cf8', '#f87171'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    datalabels: {
                        formatter: (value, context) => {
                            const data = context.chart.data.datasets[0].data;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percent = total ? (value / total * 100).toFixed(1) : 0;
                            return percent + '%';
                        },
                        color: '#fff',
                        font: { weight: 'bold', size: '14px' }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>
@endpush
@endsection