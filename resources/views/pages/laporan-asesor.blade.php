@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Laporan Performa Asesor</h1>
    <div class="mb-4 flex justify-end">
        <input type="text" placeholder="Cari asesor..." class="w-full sm:w-64 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" />
    </div>
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Asesor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Asesmen Dilakukan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Target</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Ahmad Fauzi</td>
                    <td class="px-6 py-4 whitespace-nowrap">25</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded bg-green-100 text-green-800 text-xs">Tercapai</span></td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Siti Nurhaliza</td>
                    <td class="px-6 py-4 whitespace-nowrap">18</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs">Hampir Tercapai</span></td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Budi Santoso</td>
                    <td class="px-6 py-4 whitespace-nowrap">30</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded bg-green-100 text-green-800 text-xs">Tercapai</span></td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Dewi Lestari</td>
                    <td class="px-6 py-4 whitespace-nowrap">12</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded bg-red-100 text-red-800 text-xs">Belum Tercapai</span></td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Rizky Hidayat</td>
                    <td class="px-6 py-4 whitespace-nowrap">22</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded bg-green-100 text-green-800 text-xs">Tercapai</span></td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Lina Marlina</td>
                    <td class="px-6 py-4 whitespace-nowrap">15</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs">Hampir Tercapai</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
