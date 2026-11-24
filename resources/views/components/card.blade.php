@props(['title' => null, 'padding' => 'p-6', 'shadow' => true])

<?php
    $cardClasses = 'rounded-lg border border-border bg-card';
    if ($shadow) {
        $cardClasses .= ' shadow-sm';
    }
    $cardClasses .= ' ' . $padding;
?>

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    @if ($title)
        <div class="mb-4 border-b border-border pb-2">
            <h3 class="text-sm font-semibold text-foreground">{{ $title }}</h3>
        </div>
    @endif
    {{ $slot }}
</div>
