@extends('layouts.app')

@section('content')
{{-- Data Sorting Function --}}
@php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'asc');
    function sortLink($column, $label, $currentSort, $currentDirection) {
        $newDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
        $params = array_merge(request()->query(), ['sort' => $column, 'direction' => $newDirection]);
        $url = url()->current() . '?' . http_build_query($params);
        $icon = '';
        if ($currentSort === $column) {
            $icon = $currentDirection === 'asc' ? '<span class="ml-1">&uarr;</span>' : '<span class="ml-1">&darr;</span>';
        }
        return '<a href="' . $url . '" class="hover:underline flex items-center">' . $label . $icon . '</a>';
    }
    $internalAssessees = $assessees->filter(fn($a) => $a->assessee_type === 'Internal');
    $externalAssessees = $assessees->filter(fn($a) => $a->assessee_type === 'Eksternal');
@endphp

<div class="max-w-[1440px] mx-auto p-6">
    {{-- Filter Section --}}
    <div class="flex justify-end items-center mb-6 gap-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
            <input type="text" name="filter_value" value="{{ request('filter_value') ?? '' }}" placeholder="Cari asesi internal..." class="w-full sm:w-64 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" />
            <select name="filter_by" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                <option value="name" @if(request('filter_by') == 'name') selected @endif>Nama Lengkap</option>
                <option value="entity" @if(request('filter_by') == 'entity') selected @endif>Entitas</option>
                <option value="band" @if(request('filter_by') == 'band') selected @endif>BoD</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded">Filter</button>
        </form>
        <a href="{{ route('assessees.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded shadow">
            Tambah Data Asesi +
        </a>
    </div>

    {{-- Tabel Asesi INTERNAL --}}
    <div class="">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Daftar Asesi Internal</h1>
        @if($internalAssessees->isNotEmpty())
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-300 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 uppercase tracking-wider">{!! sortLink('name', 'Nama Lengkap', $currentSort, $currentDirection) !!}</th>
                            <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 uppercase tracking-wider">{!! sortLink('entity', 'Entitas', $currentSort, $currentDirection) !!}</th>
                            <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 tracking-wider">{!! sortLink('band', 'BoD', $currentSort, $currentDirection) !!}</th>
                            <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($internalAssessees as $assessee)
                        <tr>
                            <td class="px-6 py-4 text-lg whitespace-nowrap">{{ $assessee->name }}</td>
                            <td class="px-6 py-4 text-lg whitespace-nowrap">{{ $assessee->entity ? $assessee->entity->name : '-' }}</td>
                            <td class="px-9 py-4 text-lg whitespace-nowrap">{{ $assessee->band }}</td>
                            <td class="px-6 py-4 text-lg whitespace-nowrap flex gap-2">
                                <button class="px-2 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs flex items-center justify-center" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.06 2.06 0 0 1 2.92 2.91l-9.8 9.8a2 2 0 0 1-.878.51l-3.4.85a.5.5 0 0 1-.61-.62l.85-3.4a2 2 0 0 1 .51-.88l9.8-9.8z" />
                                    </svg>
                                    <span class="ml-1">Edit</span>
                                </button>
                                <button class="px-2 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs flex items-center justify-center" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m2 0v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7h12z" />
                                    </svg>
                                    <span class="ml-1">Hapus</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow">
                Tidak ada data asesi internal ditemukan.
            </div>
        @endif
    </div>

    {{-- Tabel Asesi EKSTERNAL --}}
    <div class="mt-10"s>
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Daftar Asesi Eksternal</h1>
        @if($externalAssessees->isNotEmpty())
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-300 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 uppercase tracking-wider">{!! sortLink('name', 'Nama Lengkap', $currentSort, $currentDirection) !!}</th>
                            <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 uppercase tracking-wider">{!! sortLink('entity', 'Entitas', $currentSort, $currentDirection) !!}</th>
                            <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 tracking-wider">{!! sortLink('band', 'BoD', $currentSort, $currentDirection) !!}</th>
                            <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($externalAssessees as $assessee)
                        <tr>
                            <td class="px-6 py-4 text-lg whitespace-nowrap">{{ $assessee->name }}</td>
                            <td class="px-6 py-4 text-lg whitespace-nowrap">{{ $assessee->entity ? $assessee->entity->name : '-' }}</td>
                            <td class="px-9 py-4 text-lg whitespace-nowrap">{{ $assessee->band }}</td>
                            <td class="px-6 py-4 text-lg whitespace-nowrap flex gap-2">
                                <button class="px-2 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs flex items-center justify-center" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.06 2.06 0 0 1 2.92 2.91l-9.8 9.8a2 2 0 0 1-.878.51l-3.4.85a.5.5 0 0 1-.61-.62l.85-3.4a2 2 0 0 1 .51-.88l9.8-9.8z" />
                                    </svg>
                                    <span class="ml-1">Edit</span>
                                </button>
                                <button class="px-2 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs flex items-center justify-center" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m2 0v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7h12z" />
                                    </svg>
                                    <span class="ml-1">Hapus</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow">
                Tidak ada data asesi eksternal ditemukan.
            </div>
        @endif
    </div>
</div>
@endsection
