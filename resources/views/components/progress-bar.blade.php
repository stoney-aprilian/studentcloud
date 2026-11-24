@props(['value' => 0, 'max' => 100, 'label' => null, 'height' => 'h-1.5', 'variant' => 'primary'])

@php
    $percent = $max > 0 ? min(100, max(0, round(($value / $max) * 100))) : 0;
    $color = match ($variant) {
        'primary' => 'bg-primary',
        'secondary' => 'bg-secondary',
        'accent' => 'bg-accent',
        'destructive' => 'bg-destructive',
        'success' => 'bg-green-600',
        'warning' => 'bg-yellow-600',
        default => 'bg-primary',
    };
    $progressContainerClasses = 'w-full flex flex-col gap-2';
    $progressBarClasses = 'absolute top-0 left-0 ' . $height . ' ' . $color . ' transition-all duration-300';
@endphp

<div {{ $attributes->merge(['class' => $progressContainerClasses]) }}>
    <div class="flex justify-between text-xs text-muted-foreground">
        <span>{{ $label }}</span>
        <span>{{ $percent }}%</span>
    </div>

    <div class="relative {{ $height }} w-full overflow-hidden rounded-full border border-border bg-muted">
        <div class="{{ $progressBarClasses }}" style="width: {{ $percent }}%;" role="progressbar" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
