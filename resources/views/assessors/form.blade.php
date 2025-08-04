@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        {{ isset($assessor) && $assessor->exists ? 'Edit Data Asesor' : 'Tambah Data Asesor' }}
    </h1>
    <form method="POST" action="{{ isset($assessor) && $assessor->exists ? route('assessors.update', $assessor->id) : route('assessors.store') }}">
        @csrf
        @if(isset($assessor) && $assessor->exists)
            @method('PUT')
        @endif
        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Nama Asesor</label>
            <input type="text" name="name" id="name" value="{{ old('name', $assessor->name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" required>
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">
                {{ isset($assessor) && $assessor->exists ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
