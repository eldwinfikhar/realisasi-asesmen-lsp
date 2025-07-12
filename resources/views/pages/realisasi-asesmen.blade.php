@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Realisasi Asesmen</h1>
        <a href="#" class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded shadow transition">Tambah Asesmen Baru</a>
    </div>
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Asesmen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Asesi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Skema</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Asesor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rekomendasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">2025-07-01</td>
                    <td class="px-6 py-4 whitespace-nowrap">Ahmad Fauzi</td>
                    <td class="px-6 py-4 whitespace-nowrap">Skema A</td>
                    <td class="px-6 py-4 whitespace-nowrap">Budi Santoso</td>
                    <td class="px-6 py-4 whitespace-nowrap">Kompeten</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">2025-07-02</td>
                    <td class="px-6 py-4 whitespace-nowrap">Siti Nurhaliza</td>
                    <td class="px-6 py-4 whitespace-nowrap">Skema B</td>
                    <td class="px-6 py-4 whitespace-nowrap">Dewi Lestari</td>
                    <td class="px-6 py-4 whitespace-nowrap">Belum Kompeten</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">2025-07-03</td>
                    <td class="px-6 py-4 whitespace-nowrap">Budi Santoso</td>
                    <td class="px-6 py-4 whitespace-nowrap">Skema C</td>
                    <td class="px-6 py-4 whitespace-nowrap">Ahmad Fauzi</td>
                    <td class="px-6 py-4 whitespace-nowrap">Kompeten</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">2025-07-04</td>
                    <td class="px-6 py-4 whitespace-nowrap">Dewi Lestari</td>
                    <td class="px-6 py-4 whitespace-nowrap">Skema D</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rizky Hidayat</td>
                    <td class="px-6 py-4 whitespace-nowrap">Kompeten</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">2025-07-05</td>
                    <td class="px-6 py-4 whitespace-nowrap">Lina Marlina</td>
                    <td class="px-6 py-4 whitespace-nowrap">Skema E</td>
                    <td class="px-6 py-4 whitespace-nowrap">Siti Nurhaliza</td>
                    <td class="px-6 py-4 whitespace-nowrap">Belum Kompeten</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
