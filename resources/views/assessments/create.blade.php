@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Add Assessment</h1>
    <form action="{{ route('assessments.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="assessee_id" class="block text-gray-700 dark:text-gray-300 mb-2">Assessee</label>
            <select name="assessee_id" id="assessee_id" class="w-full border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900">
                <option value="">Select Assessee</option>
                @foreach($assessees as $assessee)
                    <option value="{{ $assessee->id }}">{{ $assessee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="assessor_id" class="block text-gray-700 dark:text-gray-300 mb-2">Assessor</label>
            <select name="assessor_id" id="assessor_id" class="w-full border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900">
                <option value="">Select Assessor</option>
                @foreach($assessors as $assessor)
                    <option value="{{ $assessor->id }}">{{ $assessor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="scheme_id" class="block text-gray-700 dark:text-gray-300 mb-2">Scheme</label>
            <select name="scheme_id" id="scheme_id" class="w-full border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900">
                <option value="">Select Scheme</option>
                @foreach($schemes as $scheme)
                    <option value="{{ $scheme->id }}">{{ $scheme->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="pre_assessment_date" class="block text-gray-700 dark:text-gray-300 mb-2">Pre-Assessment Date</label>
            <input type="date" name="pre_assessment_date" id="pre_assessment_date" class="w-full border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900" />
        </div>
        <div class="mb-4">
            <label for="assessment_date" class="block text-gray-700 dark:text-gray-300 mb-2">Assessment Date</label>
            <input type="date" name="assessment_date" id="assessment_date" class="w-full border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900" />
        </div>
        <div class="mb-4">
            <label for="assessment_venue" class="block text-gray-700 dark:text-gray-300 mb-2">Assessment Venue</label>
            <input type="text" name="assessment_venue" id="assessment_venue" class="w-full border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900" />
        </div>
        <div class="mb-6">
            <label for="notes" class="block text-gray-700 dark:text-gray-300 mb-2">Notes</label>
            <textarea name="notes" id="notes" rows="3" class="w-full border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900"></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold">Save</button>
        </div>
    </form>
</div>
@endsection
