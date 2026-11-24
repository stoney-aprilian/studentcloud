@props(['label' => 'Pilih', 'items' => [], 'value' => null, 'name' => null, 'id' => null, 'error' => null])

@php
    $selectClasses = 'block w-full rounded-md border border-border bg-card px-3 py-2 text-sm text-foreground shadow-sm focus:border-primary focus:ring-1 focus:ring-ring outline-none transition-colors';
    if ($error) {
        $selectClasses .= ' border-destructive focus:ring-destructive';
    } else {
        $selectClasses .= ' border-border';
    }
@endphp

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    @if ($label)
        <label for="{{ $id ?? $name }}" class="block text-sm font-medium text-foreground mb-1.5">{{ $label }}</label>
    @endif

    <div class="relative">
        <select
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            {{ $attributes->except(['class'])->merge(['class' => $selectClasses]) }}>
            @foreach ($items as $item)
                <option value="{{ $item['value'] ?? $item }}" {{ old($name ?? $id, $value) == ($item['value'] ?? $item) ? 'selected' : null }}>
                    {{ $item['label'] ?? $item }}
                </option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="h-4 w-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    @if ($error)
        <p class="mt-1 text-xs text-destructive" id="{{ ($id ?? $name) }}-error">{{ $error }}</p>
    @endif
</div>
