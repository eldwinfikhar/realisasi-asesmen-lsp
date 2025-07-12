@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Assessments</h1>
    {{-- href="{{ route('assessments.create') }}" --}}
    <a href="" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow">
        Add Assessment
    </a>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assessee</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assessor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Scheme</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assessment Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Venue</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($assessments as $assessment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessee->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessor->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->scheme->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessment_date ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessment_venue ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <a href="{{ route('assessments.edit', $assessment) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">Edit</a>
                        <form action="{{ route('assessments.destroy', $assessment) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
