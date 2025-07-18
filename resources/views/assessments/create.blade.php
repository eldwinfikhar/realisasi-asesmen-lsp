@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Tambah Data Asesmen Baru</h1>
    <form method="POST" action="{{ route('assessments.store') }}"
        x-data="{
            allAssessees: {{ Js::from($allAssessees ?? []) }},
            allSchemes: {{ Js::from($allSchemes ?? []) }},
            assessee_id: '',
            scheme_id: '',
            selectedAssessee: {},
            selectedScheme: {},
            updateAssessee() {
                this.selectedAssessee = this.allAssessees.find(a => a.id == this.assessee_id) || {};
            },
            updateScheme() {
                this.selectedScheme = this.allSchemes.find(s => s.id == this.scheme_id) || {};
            }
        }"
        @submit.prevent="$el.submit()"
    >
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="assessee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Asesi</label>
                <select name="assessee_id" id="assessee_id"
                    x-model="assessee_id"
                    @change="updateAssessee()"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                    <option value="">Pilih Asesi</option>
                    <template x-for="assessee in allAssessees" :key="assessee.id">
                        <option :value="assessee.id" x-text="assessee.name"></option>
                    </template>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">BoD</label>
                <input type="text" :value="selectedAssessee.band || ''" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded bg-gray-100 dark:bg-gray-700 text-gray-500" disabled>
            </div>
            <div>
                <label for="scheme_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Skema</label>
                <select name="scheme_id" id="scheme_id"
                    x-model="scheme_id"
                    @change="updateScheme()"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                    <option value="">Pilih Skema</option>
                    <template x-for="scheme in allSchemes" :key="scheme.id">
                        <option :value="scheme.id" x-text="scheme.name"></option>
                    </template>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Lingkup</label>
                <input type="text" :value="selectedScheme.lingkup || ''" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded bg-gray-100 dark:bg-gray-700 text-gray-500" disabled>
            </div>
            <div>
                <label for="pre_assessment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal Pra-Asesmen</label>
                <input type="date" name="pre_assessment_date" id="pre_assessment_date" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
            </div>
            <div>
                <label for="pre_assessment_venue" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tempat Pra-Asesmen</label>
                <input type="text" name="pre_assessment_venue" id="pre_assessment_venue" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
            </div>
            <div>
                <label for="assessment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal Asesmen</label>
                <input type="date" name="assessment_date" id="assessment_date" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
            </div>
            <div>
                <label for="assessment_venue" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tempat Asesmen</label>
                <input type="text" name="assessment_venue" id="assessment_venue" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
            </div>
            <div>
                <label for="assessor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Asesor</label>
                <select name="assessor_id" id="assessor_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                    <option value="">Pilih Asesor</option>
                    {{-- @foreach($assessors as $assessor)
                        <option value="{{ $assessor->id }}">{{ $assessor->name }}</option>
                    @endforeach --}}
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Entitas</label>
                <input type="text" :value="selectedAssessee.entity?.name || ''" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded bg-gray-100 dark:bg-gray-700 text-gray-500" disabled>
            </div>
        </div>
        <div class="mt-8 flex gap-4 justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow">Simpan</button>
            <a href="{{ route('assessments.index') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded shadow">Batal</a>
        </div>
    </form>
</div>
@endsection
