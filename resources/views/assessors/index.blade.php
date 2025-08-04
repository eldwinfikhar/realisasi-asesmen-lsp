@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto p-6">
    {{-- Filter Section --}}
    <div class="flex justify-between items-center mb-6">
        <form method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
            <input type="text" name="search" placeholder="Cari asesor..." value="{{ request('search') }}" class="w-full sm:w-64 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" />
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow">Filter</button>
        </form>
        <a href="{{ route('assessors.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded shadow">
            Tambah Data Asesor +
        </a>
    </div>

    {{-- Tabel Performa Asesor + CRUD --}}
    <div>
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Daftar Asesor</h1>
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-300 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-md font-medium dark:text-gray-300 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => ($sort == 'name' && $direction == 'asc') ? 'desc' : 'asc']) }}" class="hover:underline flex items-center gap-1">
                                Nama Asesor
                                @if(isset($sort) && $sort == 'name')
                                    <span>{!! ($direction ?? 'asc') == 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-24 py-3 text-center text-md font-medium dark:text-gray-300 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'assessments_count', 'direction' => ($sort == 'assessments_count' && $direction == 'asc') ? 'desc' : 'asc']) }}" class="hover:underline flex items-center gap-1">
                                Jumlah Asesmen
                                @if(isset($sort) && $sort == 'assessments_count')
                                    <span>{!! ($direction ?? 'asc') == 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 uppercase tracking-wider">Status Target</th>
                        <th class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @php
                        $filteredAssessors = $assessors;
                        if(request('search')) {
                            $filteredAssessors = $filteredAssessors->filter(function($assessor) {
                                return stripos($assessor->name, request('search')) !== false;
                            });
                        }
                    @endphp
                    @forelse ($filteredAssessors as $assessor)
                        <tr>
                            <td class="px-6 py-4 text-lg whitespace-nowrap">{{ $assessor->name }}</td>
                            <td class="px-24 py-4 text-lg whitespace-nowrap">{{ $assessor->assessments_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-lg whitespace-nowrap">
                                @if (($assessor->assessments_count ?? 0) > 5)
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-800">Tercapai</span>
                                @elseif (($assessor->assessments_count ?? 0) > 3)
                                    <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">Hampir Tercapai</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-red-100 text-red-800">Tidak Tercapai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-lg whitespace-nowrap flex gap-2 justify-center">
                                <a href="{{ route('assessors.edit', $assessor->id) }}" class="px-2 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs flex items-center justify-center" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.06 2.06 0 0 1 2.92 2.91l-9.8 9.8a2 2 0 0 1-.878.51l-3.4.85a.5.5 0 0 1-.61-.62l.85-3.4a2 2 0 0 1 .51-.88l9.8-9.8z" />
                                    </svg>
                                    <span class="ml-1">Edit</span>
                                </a>
                                <form action="{{ route('assessors.destroy', $assessor->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs flex items-center justify-center" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m2 0v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7h12z" />
                                        </svg>
                                        <span class="ml-1">Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data asesor ditemukan untuk filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
