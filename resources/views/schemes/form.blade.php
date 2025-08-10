@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        {{ isset($scheme) && $scheme->exists ? 'Edit Data Skema' : 'Tambah Data Skema' }}
    </h1>
    <form method="POST" action="{{ isset($scheme) && $scheme->exists ? route('schemes.update', $scheme->id) : route('schemes.store') }}">
        @csrf
        @if(isset($scheme) && $scheme->exists)
            @method('PUT')
        @endif
        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Nama Skema</label>
            <input type="text" name="name" id="name" value="{{ old('name', $scheme->name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" required>
            @error('name')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="scope" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Lingkup</label>
            <select name="scope" id="scope" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100" required>
                <option value="">-- Pilih Lingkup --</option>
                <option value="Produksi" {{ old('scope', $scheme->scope ?? '') == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                <option value="Litbang" {{ old('scope', $scheme->scope ?? '') == 'Litbang' ? 'selected' : '' }}>Litbang</option>
                <option value="QC" {{ old('scope', $scheme->scope ?? '') == 'QC' ? 'selected' : '' }}>QC</option>
                <option value="SRK" {{ old('scope', $scheme->scope ?? '') == 'SRK' ? 'selected' : '' }}>SRK</option>
                <option value="Pharmaceutical" {{ old('scope', $scheme->scope ?? '') == 'Pharmaceutical' ? 'selected' : '' }}>Pharmaceutical</option>
            </select>
            @error('scope')
                <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex justify-end gap-2">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">
                {{ isset($scheme) && $scheme->exists ? 'Perbarui' : 'Simpan' }}
            </button>
            <a href="{{ route('schemes.index') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded shadow">Batal</a>
        </div>
    </form>
</div>
@endsection
