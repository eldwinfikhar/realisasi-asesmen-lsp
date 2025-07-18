@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Daftar Asesi Internal</h1>
    <div class="mb-4 flex justify-end">
        <input type="text" placeholder="Cari asesi internal..." class="w-full sm:w-64 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" />
    </div>
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Entitas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 tracking-wider">BoD</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe</th>
                    {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th> --}}
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Ahmad Fauzi</td>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas A</td>
                    <td class="px-6 py-4 whitespace-nowrap">Band 3</td>
                    <td class="px-6 py-4 whitespace-nowrap">Internal</td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td> --}}
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Budi Santoso</td>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas C</td>
                    <td class="px-6 py-4 whitespace-nowrap">Band 1</td>
                    <td class="px-6 py-4 whitespace-nowrap">Internal</td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td> --}}
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Dewi Lestari</td>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas D</td>
                    <td class="px-6 py-4 whitespace-nowrap">Band 4</td>
                    <td class="px-6 py-4 whitespace-nowrap">Internal</td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td> --}}
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Lina Marlina</td>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas F</td>
                    <td class="px-6 py-4 whitespace-nowrap">Band 3</td>
                    <td class="px-6 py-4 whitespace-nowrap">Internal</td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td> --}}
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="max-w-[1440px] mx-auto mt-10 p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Daftar Asesi Eksternal</h1>
    <div class="mb-4 flex justify-end">
        <input type="text" placeholder="Cari asesi eksternal..." class="w-full sm:w-64 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" />
    </div>
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Entitas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 tracking-wider">BoD</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe</th>
                    {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th> --}}
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Siti Nurhaliza</td>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas B</td>
                    <td class="px-6 py-4 whitespace-nowrap">Band 2</td>
                    <td class="px-6 py-4 whitespace-nowrap">Eksternal</td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td> --}}
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Rizky Hidayat</td>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas E</td>
                    <td class="px-6 py-4 whitespace-nowrap">Band 2</td>
                    <td class="px-6 py-4 whitespace-nowrap">Eksternal</td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</button>
                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                    </td> --}}
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
