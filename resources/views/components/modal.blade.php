@props(['id' => 'modal', 'title' => null, 'open' => false, 'size' => 'md'])

@php
    $width = match ($size) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        default => 'max-w-md',
    };
    $modalBackdropClasses = 'fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity ' . ($open ? 'opacity-100' : 'opacity-0 pointer-events-none');
    $modalOverlayClasses = 'fixed inset-0 z-50 flex items-center justify-center';
@endphp

<!-- Backdrop -->
<div {{ $attributes->merge(['class' => $modalBackdropClasses]) }}>
    @if ($open)
        <button class="absolute top-4 right-4 text-muted-foreground hover:text-foreground transition-colors" aria-label="Close modal">
            <span class="sr-only">Tutup</span>
            <span aria-hidden="true">&times;</span>
        </button>
    @endif

    <div class="{{ $width }} bg-card border border-border rounded-lg shadow-lg w-full max-h-[90vh] flex flex-col transition-transform duration-200 {{ $open ? 'scale-100' : 'scale-95 opacity-0 pointer-events-none' }}">
        @if ($title)
            <div class="p-4 border-b border-border flex justify-between items-center">
                <h3 class="text-sm font-semibold text-foreground">{{ $title }}</h3>
                <button class="text-muted-foreground hover:text-foreground transition-colors" aria-label="Tutup modal">
                    <span class="sr-only">Tutup</span>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="p-4 overflow-y-auto">
            {{ $slot }}
        </div>
        <div class="p-3 border-t border-border bg-muted/50 flex justify-end gap-2">
            <button class="px-4 py-2 text-sm font-medium text-muted-foreground hover:bg-muted rounded-md transition-colors">
                Batal
            </button>
            <button class="px-4 py-2 text-sm font-medium text-on-primary bg-primary hover:bg-secondary rounded-md transition-colors">
                Simpan
            </button>
        </div>
    </div>
</div>
