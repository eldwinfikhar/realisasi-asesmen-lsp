@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Laporan Penggunaan Skema</h1>
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <input type="text" placeholder="Cari skema..." class="w-full sm:w-64 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" />
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 rounded" />
            <span class="ml-2 text-gray-700 dark:text-gray-200">Show unused schemes</span>
        </label>
    </div>
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Skema</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lingkup</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Penggunaan</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Skema A</td>
                    <td class="px-6 py-4 whitespace-nowrap">Lingkup Nasional</td>
                    <td class="px-6 py-4 whitespace-nowrap">25</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Skema B</td>
                    <td class="px-6 py-4 whitespace-nowrap">Lingkup Regional</td>
                    <td class="px-6 py-4 whitespace-nowrap">12</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Skema C</td>
                    <td class="px-6 py-4 whitespace-nowrap">Lingkup Nasional</td>
                    <td class="px-6 py-4 whitespace-nowrap">0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Skema D</td>
                    <td class="px-6 py-4 whitespace-nowrap">Lingkup Lokal</td>
                    <td class="px-6 py-4 whitespace-nowrap">7</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Skema E</td>
                    <td class="px-6 py-4 whitespace-nowrap">Lingkup Regional</td>
                    <td class="px-6 py-4 whitespace-nowrap">0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Skema F</td>
                    <td class="px-6 py-4 whitespace-nowrap">Lingkup Nasional</td>
                    <td class="px-6 py-4 whitespace-nowrap">18</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
