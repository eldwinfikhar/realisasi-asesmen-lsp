@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        {{ isset($assessee) && $assessee->exists ? 'Edit Data Asesi' : 'Tambah Data Asesi' }}
    </h1>
    <form method="POST" action="{{ isset($assessee) && $assessee->exists ? route('assessees.update', $assessee->id) : route('assessees.store') }}"
        x-data="{
            tipeAsesi: '{{ old('assessee_type', $assessee->assessee_type ?? '') }}',
            location: '{{ old('location', $assessee->location ?? '') }}',
            band: '{{ old('band', $assessee->band ?? '') }}',
        }"
        x-init="
            $watch('tipeAsesi', value => {
                if (value === 'Internal') location = '';
                if (value === 'Eksternal') band = '';
            })
        "
    >
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
            <select name="band" id="band" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" 
                :disabled="tipeAsesi === 'Eksternal'"
                x-model="band"
                >
                <option value="">-- Pilih BoD --</option>
                <option value="I" {{ old('band', $assessee->band ?? '') == 'I' ? 'selected' : '' }}>I</option>
                <option value="II" {{ old('band', $assessee->band ?? '') == 'II' ? 'selected' : '' }}>II</option>
                <option value="III" {{ old('band', $assessee->band ?? '') == 'III' ? 'selected' : '' }}>III</option>
                <option value="IV" {{ old('band', $assessee->band ?? '') == 'IV' ? 'selected' : '' }}>IV</option>
                <option value="V" {{ old('band', $assessee->band ?? '') == 'V' ? 'selected' : '' }}>V</option>
            </select>
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
            <select name="assessee_type" id="assessee_type"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100"
                required
                x-model="tipeAsesi">
                <option value="">-- Pilih Tipe Asesi --</option>
                <option value="Internal">Internal</option>
                <option value="Eksternal">Eksternal</option>
            </select>
            @error('assessee_type')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="location" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Lokasi</label>
            <select name="location" id="location"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100"
                :disabled="tipeAsesi === 'Internal'"
                x-model="location">
                <option value="">-- Pilih Lokasi --</option>
                <option value="Jakarta">Jakarta</option>
                <option value="Bandung">Bandung</option>
            </select>
            @error('location')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex justify-end gap-2">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">
                {{ isset($assessee) && $assessee->exists ? 'Perbarui' : 'Simpan' }}
            </button>
            <a href="{{ route('assessees.index') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded shadow">Batal</a>
        </div>
    </form>
</div>
@endsection