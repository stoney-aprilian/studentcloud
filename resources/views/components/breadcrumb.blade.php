@props(['items' => [], 'separator' => '/', 'label' => null])

<nav class="flex flex-wrap items-center gap-1 text-sm mb-6" aria-label="Breadcrumb">
    @if ($label)
        <h2 class="sr-only">{{ $label }}</h2>
    @endif

    <ol class="flex flex-wrap items-center gap-1" aria-hidden="true">
        @foreach ($items as $index => $item)
            <li class="flex items-center gap-1">
                @if ($index < count($items) - 1)
                    <a href="{{ $item['url'] ?? '#' }}" class="text-muted-foreground hover:text-primary transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-foreground font-medium" aria-current="page">{{ $item['label'] }}</span>
                @endif
                @if ($index < count($items) - 1)
                    <span class="text-muted-foreground">{{ $separator }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
