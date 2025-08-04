@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Realisasi Asesmen Eksternal</h1>
    <div class="flex items-center gap-4">
        
        <form method="GET" action="{{ route('assessments.indexExternal') }}" class="flex items-center gap-4">
            <select name="year" id="year" class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Filter</button>
        </form>
        <a href="{{ route('assessments.createExternal') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow">
            Tambah Data Asesmen +
        </a>
    </div>
</div>

@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

@php use Carbon\Carbon; @endphp

@foreach($assessmentsByMonth as $monthName => $assessments)
    <h2 class="text-xl font-semibold mt-10 mb-4 text-gray-700 dark:text-gray-200">{{ Carbon::create()->month($monthName)->translatedFormat('F') }} {{ $year }}</h2>
    @if($assessments->isNotEmpty())
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-300 dark:bg-gray-700">
                    <tr>
                        <th rowspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">No.</th>
                        <th rowspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Asesi</th>
                        <th rowspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Lokasi</th>
                        <th rowspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Skema</th>
                        <th rowspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Lingkup</th>
                        <th colspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Pra-Asesmen</th>
                        <th colspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Asesmen</th>
                        <th rowspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Asesor</th>
                        <th rowspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Entitas</th>
                        <th rowspan="2" class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Aksi</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Tgl</th>
                        <th class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Tempat</th>
                        <th class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Tgl</th>
                        <th class="px-6 py-3 text-center text-md font-medium dark:text-gray-300 tracking-wider">Tempat</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @php $counter = 1; @endphp
                    @foreach($assessments as $assessment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $counter }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessee->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessee->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->scheme->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->scheme->scope }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->pre_assessment_date ? Carbon::parse($assessment->pre_assessment_date)->format('d-m-Y') : '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->pre_assessment_venue }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessment_date ? Carbon::parse($assessment->assessment_date)->format('d-m-Y') : '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessment_venue }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessee->entity->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <a href="{{ route('assessments.editExternal', $assessment->id) }}" class="px-2 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.06 2.06 0 0 1 2.92 2.91l-9.8 9.8a2 2 0 0 1-.878.51l-3.4.85a.5.5 0 0 1-.61-.62l.85-3.4a2 2 0 0 1 .51-.88l9.8-9.8z" />
                                    </svg>
                                    <span class="ml-1">Edit</span>
                                </a>
                                <form action="{{ route('assessments.destroyExternal', $assessment->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m2 0v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7h12z" />
                                        </svg>
                                        <span class="ml-1">Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @php $counter++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 mb-8 rounded">
            Data asesmen di bulan ini belum ada.
        </div>
    @endif
@endforeach
@endsection
