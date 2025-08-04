@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Rekap Band per Entitas</h1>
    <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-2 max-w-xl">
        <select name="year" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
            <option value="" {{ empty($selectedYear) ? 'selected' : '' }}>Semua Tahun</option>
            @foreach($availableYears as $year)
                <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow">Filter</button>
    </form>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th rowspan="2" class="px-6 py-3 text-left text-sm font-medium dark:text-gray-300 uppercase tracking-wider">Nama Entitas</th>
                <th colspan="5" class="px-6 py-3 text-center text-sm font-medium dark:text-gray-300 uppercase tracking-wider">Band</th>
                <th rowspan="2" class="px-6 py-3 text-center text-sm font-medium dark:text-gray-300 uppercase tracking-wider">Total</th>
            </tr>
            <tr>
                <th class="px-6 py-3 text-left text-sm font-medium dark:text-gray-300 uppercase tracking-wider">I</th>
                <th class="px-6 py-3 text-left text-sm font-medium dark:text-gray-300 uppercase tracking-wider">II</th>
                <th class="px-6 py-3 text-left text-sm font-medium dark:text-gray-300 uppercase tracking-wider">III</th>
                <th class="px-6 py-3 text-left text-sm font-medium dark:text-gray-300 uppercase tracking-wider">IV</th>
                <th class="px-6 py-3 text-left text-sm font-medium dark:text-gray-300 uppercase tracking-wider">V</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y dividn e-gray-200 dark:divide-gray-700">
            @foreach($rekapData as $entityName => $bands)
            <tr>
                <td class="px-6 py-4 text-lg whitespace-nowrap">{{ $entityName }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $bands['I'] ?? 0 }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $bands['II'] ?? 0 }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $bands['III'] ?? 0 }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $bands['IV'] ?? 0 }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $bands['V'] ?? 0 }}</td>
                <td class="px-6 py-4 text-center whitespace-nowrap">
                    {{ collect([$bands['I'] ?? 0, $bands['II'] ?? 0, $bands['III'] ?? 0, $bands['IV'] ?? 0, $bands['V'] ?? 0])->sum() }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th class="px-6 py-4 text-left whitespace-nowrap">JUMLAH</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">{{ $totalsPerBand['I'] ?? 0 }}</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">{{ $totalsPerBand['II'] ?? 0 }}</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">{{ $totalsPerBand['III'] ?? 0 }}</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">{{ $totalsPerBand['IV'] ?? 0 }}</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">{{ $totalsPerBand['V'] ?? 0 }}</th>
                <th class="px-6 py-4 text-center whitespace-nowrap">{{ $grandTotal ?? 0 }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
