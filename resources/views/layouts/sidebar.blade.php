<aside class="w-64 bg-white dark:bg-gray-800 shadow-lg fixed inset-y-0 left-0 z-30 flex flex-col">
    <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
        <span class="text-xl font-bold text-gray-800 dark:text-gray-100">LSP Dashboard</span>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2" x-data="{ masterOpen: false, laporanOpen: false }">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium">
            <x-icons.home/>
            Dashboard
        </a>

        <!-- Data Master Dropdown -->
        <div class="space-y-1" x-data="{ open: false }" @keydown.escape="open = false">
            <button @click="masterOpen = !masterOpen" type="button" class="flex items-center w-full px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium focus:outline-none" :aria-expanded="masterOpen">
                <x-icons.master-data/>
                Data Master
                <svg :class="{'rotate-180': masterOpen}" class="ml-auto h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="masterOpen" x-transition class="ml-7 mt-1 space-y-1" @click.away="masterOpen = false">
                <a href="{{ route('assessees.index') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">Daftar Asesi</a>
                <a href="{{ route('assessors.index') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">Laporan Asesor</a>
                <a href="{{ route('schemes.index') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">Laporan Skema</a>
            </div>
        </div>

        <!-- Realisasi Asesmen Dropdown -->
        <div class="space-y-1" x-data="{ open: false }" @keydown.escape="open = false">
            <button @click="open = !open" type="button" class="flex items-center w-full px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium focus:outline-none" :aria-expanded="open">
                <x-icons.assessments/>
                Realisasi Asesmen
                <svg :class="{'rotate-180': open}" class="ml-auto h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="open" x-transition class="ml-7 mt-1 space-y-1" @click.away="open = false">
                <a href="{{ route('assessments.index') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">Internal</a>
                <a href="{{ route('assessments.indexExternal') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">Eksternal</a>
            </div>
        </div>

        <!-- Laporan Dropdown -->
        <div class="space-y-1" x-data="{ open: false }" @keydown.escape="open = false">
            <button @click="laporanOpen = !laporanOpen" type="button" class="flex items-center w-full px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium focus:outline-none" :aria-expanded="laporanOpen">
                <x-icons.reports/>
                Laporan
                <svg :class="{'rotate-180': laporanOpen}" class="ml-auto h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="laporanOpen" x-transition class="ml-7 mt-1 space-y-1" @click.away="laporanOpen = false">
                <a href="{{ route('laporan.rekap-band') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">Rekap per Band</a>
                <a href="{{ route('laporan.target-realisasi') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">Target Realisasi</a>
            </div>
        </div>
    </nav>
</aside>
