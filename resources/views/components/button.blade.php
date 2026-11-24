@props(['type' => 'submit', 'variant' => 'primary', 'size' => 'md', 'disabled' => false, 'loading' => false])

<?php
    $buttonVariant = match ($variant) {
        'primary' => 'bg-primary text-on-primary hover:bg-secondary',
        'secondary' => 'bg-secondary text-on-secondary hover:bg-secondary/90',
        'accent' => 'bg-accent text-on-accent hover:bg-accent/90',
        'outline' => 'border border-border bg-card text-foreground hover:bg-muted',
        'destructive' => 'bg-destructive text-on-destructive hover:bg-destructive/90',
        'ghost' => 'text-foreground hover:bg-muted',
        default => 'bg-primary text-on-primary hover:bg-secondary',
    };
    $buttonSize = match ($size) {
        'sm' => 'px-2.5 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2 text-sm',
    };
    $buttonClasses = 'inline-flex items-center justify-center gap-2 rounded-md font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ' . $buttonVariant . ' ' . $buttonSize;
?>

<button
    type="{{ $type }}"
    {{ $attributes->merge(['disabled' => $disabled || $loading ? true : null, 'class' => $buttonClasses]) }}>
    @if ($loading)
        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
    {{ $slot }}
</button>
