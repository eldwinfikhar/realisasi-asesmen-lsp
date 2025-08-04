@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        {{ isset($assessee) && $assessee->exists ? 'Edit Data Asesi' : 'Tambah Data Asesi' }}
    </h1>
    <form method="POST" action="{{ isset($assessee) && $assessee->exists ? route('assessees.update', $assessee->id) : route('assessees.store') }}">
        @csrf
        @if(isset($assessee) && $assessee->exists)
            @method('PUT')
        @endif
        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Nama Asesi</label>
            <input type="text" name="name" id="name" value="{{ old('name', $assessee->name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" required>
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="band" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">BoD</label>
            <input type="text" name="band" id="band" value="{{ old('band', $assessee->band ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" required>
            @error('band')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="entity_id" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Entitas</label>
            <select name="entity_id" id="entity_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                <option value="">-- Pilih Entitas --</option>
                @foreach($entities as $entity)
                    <option value="{{ $entity->id }}" {{ old('entity_id', $assessee->entity_id ?? '') == $entity->id ? 'selected' : '' }}>{{ $entity->name }}</option>
                @endforeach
            </select>
            @error('entity_id')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="assessee_type" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Tipe Asesi</label>
            <select name="assessee_type" id="assessee_type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" required>
                <option value="">-- Pilih Tipe Asesi --</option>
                <option value="Internal" {{ old('assessee_type', $assessee->assessee_type ?? '') == 'Internal' ? 'selected' : '' }}>Internal</option>
                <option value="Eksternal" {{ old('assessee_type', $assessee->assessee_type ?? '') == 'Eksternal' ? 'selected' : '' }}>Eksternal</option>
            </select>
            @error('assessee_type')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="location" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Lokasi</label>
            <select name="location" id="location" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                <option value="">-- Pilih Lokasi --</option>
                <option value="Jakarta" {{ old('location', $assessee->location ?? '') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                <option value="Bandung" {{ old('location', $assessee->location ?? '') == 'Bandung' ? 'selected' : '' }}>Bandung</option>
            </select>
            @error('location')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">
                {{ isset($assessee) && $assessee->exists ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
