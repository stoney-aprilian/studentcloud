@props(['variant' => 'primary', 'size' => 'md'])

<?php
    $badgeVariant = match ($variant) {
        'primary' => 'bg-primary text-on-primary',
        'secondary' => 'bg-secondary text-on-secondary',
        'accent' => 'bg-accent text-on-accent',
        'success' => 'bg-green-100 text-green-700 border border-green-200',
        'warning' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
        'destructive' => 'bg-destructive text-on-destructive',
        'outline' => 'border border-border bg-card text-foreground',
        'muted' => 'bg-muted text-muted-foreground',
        default => 'bg-primary text-on-primary',
    };
    $badgeSize = match ($size) {
        'sm' => 'px-1.5 py-0 text-[9px]',
        'md' => 'px-2 py-0.5 text-[10px]',
        'lg' => 'px-3 py-1 text-xs',
        default => 'px-2 py-0.5 text-[10px]',
    };
    $badgeClasses = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-semibold text-[10px] uppercase tracking-wider ' . $badgeVariant . ' ' . $badgeSize;
?>

<span {{ $attributes->merge(['class' => $badgeClasses]) }}>
    {{ $slot }}
</span>
