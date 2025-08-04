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
            @foreach($locations as $location)
            <tr>
                <td rowspan="2" class="px-3 py-4 text-lg whitespace-nowrap">{{ $location }}</td>
                <td class="px-3 py-4 text-center whitespace-nowrap">T</td>
                @for($month = 1; $month <= 12; $month++)
                    <td class="px-3 py-4 text-center whitespace-nowrap">
                        {{ $externalTargets[$location][$month]['target_count'] ?? 0 }}
                    </td>
                @endfor
                <td class="px-3 py-4 text-center whitespace-nowrap">
                    {{ collect(range(1,12))->sum(fn($m) => $externalTargets[$location][$m]['target_count'] ?? 0) }}
                </td>
            </tr>
            <tr>
                <td class="px-3 py-4 font-extrabold text-blue-700 text-center whitespace-nowrap">R</td>
                @for($month = 1; $month <= 12; $month++)
                    <td class="px-3 py-4 font-extrabold text-blue-700 text-center whitespace-nowrap">
                        {{ $externalRealisations[$location][$month]['realization_count'] ?? 0 }}
                    </td>
                @endfor
                <td class="px-3 py-4 font-extrabold text-blue-700 text-center whitespace-nowrap">
                    {{ collect(range(1,12))->sum(fn($m) => $externalRealisations[$location][$m]['realization_count'] ?? 0) }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th rowspan="2" class="px-3 py-4 text-left whitespace-nowrap">TOTAL</th>
                <th class="px-3 py-4 text-center whitespace-nowrap">T</th>
                @for ($month = 1; $month <= 12; $month++)
                    <th class="px-3 py-4 text-center whitespace-nowrap">{{ $externalTargetMonthlyTotals[$month] ?? 0 }}</th>
                @endfor
                <th class="px-3 py-4 text-center whitespace-nowrap">{{ $externalTargetGrandTotal }}</th>
            </tr>
            <tr class="bg-gray-300 font-bold">
                <th class="px-3 py-4 text-center font-extrabold text-blue-700 whitespace-nowrap">R</th>
                @for ($month = 1; $month <= 12; $month++)
                    <th class="px-3 py-4 text-center font-extrabold text-blue-700 whitespace-nowrap">{{ $externalRealizationMonthlyTotals[$month] ?? 0 }}</th>
                @endfor
                <th class="px-3 py-4 text-center font-extrabold text-blue-700 whitespace-nowrap">{{ $externalRealizationGrandTotal ?? 0 }}</th>
            </tr>
        </tfoot>
    </table>
</div>