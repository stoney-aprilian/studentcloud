@props(['type' => 'info', 'dismissible' => false])

@php
    $config = [
        'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-800', 'icon' => 'info'],
        'success' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-800', 'icon' => 'check-circle'],
        'warning' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-800', 'icon' => 'alert-triangle'],
        'error' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-800', 'icon' => 'alert-circle'],
        'destructive' => ['bg' => 'bg-destructive/10', 'border' => 'border-destructive/30', 'text' => 'text-destructive', 'icon' => 'alert-circle'],
    ][$type] ?? $config['info'];
    $alertClasses = 'flex items-start gap-3 rounded-md border p-4 ' . $config['bg'] . ' ' . $config['border'] . ' ' . $config['text'];
@endphp

<div {{ $attributes->merge(['class' => $alertClasses]) }}>
    <div class="flex h-5 shrink-0 items-center justify-center">
        <span aria-hidden="true">{{ $config['icon'] }}</span>
    </div>
    <div class="text-sm leading-relaxed">
        {{ $slot }}
    </div>
</div>
