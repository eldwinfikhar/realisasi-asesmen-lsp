@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        {{ isset($scheme) && $scheme->exists ? 'Edit Data Skema' : 'Tambah Data Skema' }}
    </h1>
    <form method="POST" action="{{ isset($scheme) && $scheme->exists ? route('schemes.update', $scheme->id) : route('schemes.store') }}">
        @csrf
        @if(isset($scheme) && $scheme->exists)
            @method('PUT')
        @endif
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Nama Skema</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ old('name', $scheme->name ?? '') }}" required>
            @error('name')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="scope" class="block font-semibold mb-1">Lingkup</label>
            <input type="text" name="scope" id="scope" class="w-full border rounded px-3 py-2" value="{{ old('scope', $scheme->scope ?? '') }}" required>
            @error('scope')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            {{ isset($scheme) && $scheme->exists ? 'Update' : 'Create' }}
        </button>
        <a href="{{ route('schemes.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection
