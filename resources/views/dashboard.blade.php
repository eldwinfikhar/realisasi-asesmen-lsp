@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
    <x-kpi-card title="Total Asesi Tahun Ini" :value="150" icon="user-group" />
    <x-kpi-card title="Total Asesmen Tahun Ini" :value="32" icon="calendar" />
    <x-kpi-card title="Asesor Aktif Tahun Ini" :value="12" icon="identification" />
    <x-kpi-card title="Penggunaan Skema Tahun Ini" :value="7" icon="collection" />
    <x-kpi-card title="Penyelesaian Target (%)" :value="85.5 . '%'" icon="chart-bar" />
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Assessment Trends</h2>
        <canvas id="assessmentTrendsChart" height="200"></canvas>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Target vs Realization</h2>
        <canvas id="targetRealizationChart" height="200"></canvas>
    </div>
</div>
{{-- <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Persentase Progres Asesmen per Bulan</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Entitas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Target</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Realisasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pencapaian (%)</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas A</td>
                    <td class="px-6 py-4 whitespace-nowrap">100</td>
                    <td class="px-6 py-4 whitespace-nowrap">90</td>
                    <td class="px-6 py-4 whitespace-nowrap">90%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas B</td>
                    <td class="px-6 py-4 whitespace-nowrap">80</td>
                    <td class="px-6 py-4 whitespace-nowrap">60</td>
                    <td class="px-6 py-4 whitespace-nowrap">75%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas C</td>
                    <td class="px-6 py-4 whitespace-nowrap">120</td>
                    <td class="px-6 py-4 whitespace-nowrap">100</td>
                    <td class="px-6 py-4 whitespace-nowrap">83.3%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas D</td>
                    <td class="px-6 py-4 whitespace-nowrap">60</td>
                    <td class="px-6 py-4 whitespace-nowrap">55</td>
                    <td class="px-6 py-4 whitespace-nowrap">91.7%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Entitas E</td>
                    <td class="px-6 py-4 whitespace-nowrap">90</td>
                    <td class="px-6 py-4 whitespace-nowrap">70</td>
                    <td class="px-6 py-4 whitespace-nowrap">77.8%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div> --}}
<div class="bg-white dark:bg-gray-800 rounded shadow p-6">
    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Persentase Progres Asesmen per Bulan</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th rowspan="2" class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bulan</th>
                    <th colspan="2" class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Internal (BFG)</th>
                    <th colspan="2" class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Eksternal</th>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Persen (%)</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Persen (%)</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Jan</td>
                    <td class="px-6 text-center py-4 whitespace-nowrap">70</td>
                    <td class="px-6 text-center py-4 whitespace-nowrap">7,0</td>
                    <td class="px-6 text-center py-4 whitespace-nowrap">16</td>
                    <td class="px-6 text-center py-4 whitespace-nowrap">16,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Feb</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">107</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">17,7</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">31</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">47,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Mar</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">127</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">30,4</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">11</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">58,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Apr</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">59</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">36,3</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">58,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Mei</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">160</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">52,3</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">58,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Jun</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">88</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">61,1</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">58,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Jul</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">61,1</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Agu</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">61,1</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Sep</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">61,1</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Okt</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">61,1</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Nov</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">61,1</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16,0</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">Des</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">0</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">61,1</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">16,0</td>
                </tr>
            </tbody>
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">611</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">61,1</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">58</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">58,0</th>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keseluruhan</th>
                    <th colspan="2" class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">669</th>
                    <th colspan="2" class="px-6 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">66,9%</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
