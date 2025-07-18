@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Target vs Realisasi</h1>
    <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-2 max-w-xl">
        <select name="year" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
            <option value="" {{ request('year') == '' ? 'selected' : '' }}>All Years</option>
            <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>2025</option>
            <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
            <option value="2023" {{ request('year') == '2023' ? 'selected' : '' }}>2023</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow">Filter</button>
    </form>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Entitas</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">T/R</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jan</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Feb</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Mar</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Apr</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">May</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jun</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jul</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aug</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Sep</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Oct</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nov</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Dec</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-700">
            <tr>
                <td rowspan="2" class="px-6 py-4 whitespace-nowrap">Bio Farma</td>
                <td class="px-6 py-4 whitespace-nowrap">T</td>
                <td class="px-6 py-4 whitespace-nowrap">28</td>
                <td class="px-6 py-4 whitespace-nowrap">37</td>
                <td class="px-6 py-4 whitespace-nowrap">10</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">35</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">45</td>
                <td class="px-6 py-4 whitespace-nowrap">35</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">300</td>
            </tr>
            <tr>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">R</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">36</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">23</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">34</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">2</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">41</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">5</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">141</td>
            </tr>
            <tr>
                <td rowspan="2" class="px-6 py-4 whitespace-nowrap">Indofarma</td>
                <td class="px-6 py-4 whitespace-nowrap">T</td>
                <td class="px-6 py-4 whitespace-nowrap">28</td>
                <td class="px-6 py-4 whitespace-nowrap">37</td>
                <td class="px-6 py-4 whitespace-nowrap">10</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">35</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">45</td>
                <td class="px-6 py-4 whitespace-nowrap">35</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">300</td>
            </tr>
            <tr>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">R</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">36</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">23</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">34</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">2</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">41</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">5</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">141</td>
            </tr>
            <tr>
                <td rowspan="2" class="px-6 py-4 whitespace-nowrap">KFP Jakarta</td>
                <td class="px-6 py-4 whitespace-nowrap">T</td>
                <td class="px-6 py-4 whitespace-nowrap">28</td>
                <td class="px-6 py-4 whitespace-nowrap">37</td>
                <td class="px-6 py-4 whitespace-nowrap">10</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">35</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">45</td>
                <td class="px-6 py-4 whitespace-nowrap">35</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">30</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">0</td>
                <td class="px-6 py-4 whitespace-nowrap">300</td>
            </tr>
            <tr>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">R</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">36</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">23</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">34</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">2</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">41</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">5</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">141</td>
            </tr>
        </tbody>
        <tfoot class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th rowspan="2" class="px-6 py-4 whitespace-nowrap">TOTAL</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">T</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">84</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">111</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">30</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">90</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">105</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">60</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">135</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">105</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">90</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">90</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">900</th>
            </tr>
            <tr>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">R</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">108</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">69</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">102</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">6</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">123</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">15</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">432</th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Magang</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">T/R</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jan</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Feb</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Mar</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Apr</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">May</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jun</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jul</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aug</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Sep</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Oct</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nov</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Dec</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <tr>
                <td rowspan="2" class="px-6 py-4 whitespace-nowrap">Bandung</td>
                <td class="px-6 py-4 whitespace-nowrap">T</td>
                <td class="px-6 py-4 whitespace-nowrap">16</td>
                <td class="px-6 py-4 whitespace-nowrap">8</td>
                <td class="px-6 py-4 whitespace-nowrap">6</td>
                <td class="px-6 py-4 whitespace-nowrap">5</td>
                <td class="px-6 py-4 whitespace-nowrap">5</td>
                <td class="px-6 py-4 whitespace-nowrap">5</td>
                <td class="px-6 py-4 whitespace-nowrap">10</td>
                <td class="px-6 py-4 whitespace-nowrap">15</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">150</td>
            </tr>
            <tr>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">R</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">16</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">8</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">8</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">32</td>
            </tr>
            <tr>
                <td rowspan="2" class="px-6 py-4 whitespace-nowrap">Jakarta</td>
                <td class="px-6 py-4 whitespace-nowrap">T</td>
                <td class="px-6 py-4 whitespace-nowrap">4</td>
                <td class="px-6 py-4 whitespace-nowrap">23</td>
                <td class="px-6 py-4 whitespace-nowrap">6</td>
                <td class="px-6 py-4 whitespace-nowrap">5</td>
                <td class="px-6 py-4 whitespace-nowrap">5</td>
                <td class="px-6 py-4 whitespace-nowrap">5</td>
                <td class="px-6 py-4 whitespace-nowrap">10</td>
                <td class="px-6 py-4 whitespace-nowrap">15</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">20</td>
                <td class="px-6 py-4 whitespace-nowrap">153</td>
            </tr>
            <tr>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">R</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">23</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">3</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">0</td>
                <td class="px-6 py-4 font-extrabold text-blue-700 whitespace-nowrap">26</td>
            </tr>
        </tbody>
        <tfoot class="bg-gray-300 dark:bg-gray-600">
            <tr>
                <th rowspan="2" class="px-6 py-4 whitespace-nowrap">TOTAL</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">T</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">20</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">31</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">12</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">10</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">10</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">10</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">20</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">30</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">40</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">40</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">40</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">40</th>
                <th class="px-6 py-4 text-left whitespace-nowrap">303</th>
            </tr>
            <tr>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">R</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">16</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">31</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">11</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">0</th>
                <th class="px-6 py-4 text-left font-extrabold text-blue-700 whitespace-nowrap">58</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection