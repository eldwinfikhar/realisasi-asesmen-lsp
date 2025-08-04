@extends('layouts.app')

@section('content')
<div x-data="{ tab: 'internal' }">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mr-6">Target vs Realisasi</h1>
        <div class="flex gap-2">
            <button type="button" @click="tab = 'internal'" :class="tab === 'internal' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded font-semibold focus:outline-none">Internal</button>
            <button type="button" @click="tab = 'eksternal'" :class="tab === 'eksternal' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded font-semibold focus:outline-none">Eksternal</button>
        </div>
        <form method="GET" class="flex items-center gap-2 ml-auto">
            <select name="year" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                @foreach($availableYears as $year)
                    <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow">Filter</button>
        </form>
    </div>

    <div x-show="tab === 'internal'">
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-300 dark:bg-gray-600">
                    @php use Carbon\Carbon; @endphp
                    <tr>
                        <th class="px-3 py-3 text-left text-sm font-medium dark:text-gray-300 uppercase tracking-wider">Entitas</th>
                        <th class="px-3 py-3 text-center text-sm font-medium dark:text-gray-300 uppercase tracking-wider">T/R</th>
                        @foreach(range(1,12) as $m)
                            <th class="px-3 py-3 text-center text-sm font-medium dark:text-gray-300 uppercase tracking-wider">{{ Carbon::create()->month($m)->format('M') }}</th>
                        @endforeach
                        <th class="px-3 py-3 text-center text-sm font-medium dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-700">
                    @foreach($entities as $entity)
                    <tr>
                        <td rowspan="2" class="px-3 py-4 text-lg whitespace-nowrap">{{ $entity->name }}</td>
                        <td class="px-3 py-4 text-center whitespace-nowrap">T</td>
                        @php
                            $monthlyTargets = [];
                            for ($month = 1; $month <= 12; $month++) {
                                $target = $targets->first(function($t) use ($entity, $month) {
                                    return $t->entity_id == $entity->id && $t->month == $month;
                                });
                                $monthlyTargets[$month] = $target ? $target->target_count : 0;
                            }
                        @endphp
                        @for($month = 1; $month <= 12; $month++)
                            <td class="px-3 py-4 text-center whitespace-nowrap">{{ $monthlyTargets[$month] }}</td>
                        @endfor
                        <td class="px-3 py-4 text-center whitespace-nowrap">{{ array_sum($monthlyTargets) }}</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-4 font-extrabold text-blue-700 text-center whitespace-nowrap">R</td>
                        @php
                            $monthlyRealisasi = [];
                            for ($month = 1; $month <= 12; $month++) {
                                $real = $realizations->first(function($r) use ($entity, $month) {
                                    return $r->entity_id == $entity->id && $r->month == $month;
                                });
                                $monthlyRealisasi[$month] = $real ? $real->realization_count : 0;
                            }
                        @endphp
                        @for($month = 1; $month <= 12; $month++)
                            <td class="px-3 py-4 font-extrabold text-blue-700 text-center whitespace-nowrap">{{ $monthlyRealisasi[$month] }}</td>
                        @endfor
                        <td class="px-3 py-4 font-extrabold text-blue-700 text-center whitespace-nowrap">{{ array_sum($monthlyRealisasi) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-300 dark:bg-gray-600">
                    <tr>
                        <th rowspan="2" class="px-3 py-4 text-left whitespace-nowrap">TOTAL</th>
                        <th class="px-3 py-4 text-center whitespace-nowrap">T</th>
                        @for($month = 1; $month <= 12; $month++)
                            <th class="px-3 py-4 text-center whitespace-nowrap">{{ $targetMonthlyTotals[$month] ?? 0 }}</th>
                        @endfor
                        <th class="px-3 py-4 text-center whitespace-nowrap">{{ $targetGrandTotal ?? 0 }}</th>
                    </tr>
                    <tr>
                        <th class="px-3 py-4 text-center font-extrabold text-blue-700 whitespace-nowrap">R</th>
                        @for($month = 1; $month <= 12; $month++)
                            <th class="px-3 py-4 text-center font-extrabold text-blue-700 whitespace-nowrap">{{ $realizationMonthlyTotals[$month] ?? 0 }}</th>
                        @endfor
                        <th class="px-3 py-4 text-center font-extrabold text-blue-700 whitespace-nowrap">{{ $realizationGrandTotal ?? 0 }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div x-show="tab === 'eksternal'">
        @include('reports.target-realisasi-eksternal')
    </div>
</div>
@endsection