@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Rekap Band per Entitas</h1>
    <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-2 max-w-xl">
        <select name="year" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
            <option value="" {{ request('year') == '' ? 'selected' : '' }}>All Years</option>
            <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>2025</option>
            <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
            <option value="2023" {{ request('year') == '2023' ? 'selected' : '' }}>2023</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow">Filter</button>
    </form>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th rowspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama Entitas</th>
                <th colspan="5" class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Band</th>
                <th rowspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Total</th>
            </tr>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">I</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">II</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">III</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">IV</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">V</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">Bio Farma</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">3</td>
                <td class="px-6 py-4 whitespace-nowrap">37</td>
                <td class="px-6 py-4 whitespace-nowrap">101</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">141</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">Indofarma</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">7</td>
                <td class="px-6 py-4 whitespace-nowrap">21</td>
                <td class="px-6 py-4 whitespace-nowrap">113</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">141</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">KF Plant Jakarta</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">KFP Banjaran Prod</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">1</td>
                <td class="px-6 py-4 whitespace-nowrap">12</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">43</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">KFP Banjaran RnD</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">1</td>
                <td class="px-6 py-4 whitespace-nowrap">11</td>
                <td class="px-6 py-4 whitespace-nowrap">6</td>
                <td class="px-6 py-4 whitespace-nowrap">18</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">KFA</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">KFTD</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">Phapros</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">Lucas Djaja</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
            </tr>
        </tbody>
        <tfoot class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th class="px-6 py-4 text-left whitespace-nowrap">JUMLAH</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">12</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">195</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">258</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">146</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">611</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
