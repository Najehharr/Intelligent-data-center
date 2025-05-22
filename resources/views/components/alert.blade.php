@props(['type' => 'info'])

@php
    $colors = [
        'error' => 'text-red-600 border-red-500 bg-red-100',
        'success' => 'text-green-600 border-green-500 bg-green-100',
        'warning' => 'text-yellow-600 border-yellow-500 bg-yellow-100',
        'info' => 'text-blue-600 border-blue-500 bg-blue-100',
    ];
    $icon = [
        'error' => '❗',
        'success' => '✔️',
        'warning' => '⚠️',
        'info' => 'ℹ️',
    ];
@endphp

<div class="flex items-center p-4 mb-4 text-sm border rounded {{ $colors[$type] ?? $colors['info'] }}">
    <span class="mr-3 text-2xl">
        {{ $icon[$type] ?? $icon['info'] }}
    </span>
    <div>
        {{ $slot }}
    </div>
</div>
