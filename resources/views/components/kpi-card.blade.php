@props(['title', 'value', 'icon'])
<div class="flex items-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
        @php
            $iconComponentName = 'icon-' . str_replace('_', '-', $icon);
            $iconComponentView = 'components/icons/' . str_replace('_', '-', $icon);
        @endphp
        @if ($icon && view()->exists($iconComponentView))
            <x-dynamic-component :component="$iconComponentName" class="w-7 h-7 text-blue-600 dark:text-blue-300" />
        @endif
    </div>
    <div>
        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</div>
        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</div>
    </div>
</div>
