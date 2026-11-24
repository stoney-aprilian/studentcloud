@props(['id', 'label', 'type' => 'text', 'value' => null, 'placeholder' => null, 'error' => null, 'required' => false, 'helper' => null])

<?php
    $inputClasses = 'block w-full rounded-md border border-border bg-card px-3 py-2 text-sm text-foreground shadow-sm placeholder:text-muted-foreground focus:border-primary focus:ring-1 focus:ring-ring outline-none transition-colors';
    if ($error) {
        $inputClasses .= ' border-destructive focus:ring-destructive';
    } else {
        $inputClasses .= ' border-border';
    }
?>

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-foreground mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-destructive ml-0.5" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <input
        id="{{ $id }}"
        name="{{ $id }}"
        type="{{ $type }}"
        value="{{ $value ?? old($id) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : null }}
        {{ $attributes->except(['class'])->merge(['class' => $inputClasses]) }}>

    @if ($error)
        <p class="mt-1 text-xs text-destructive" id="{{ $id }}-error">{{ $error }}</p>
    @endif

    @if ($helper)
        <p class="mt-1 text-xs text-muted-foreground" id="{{ $id }}-helper">{{ $helper }}</p>
    @endif
</div>
