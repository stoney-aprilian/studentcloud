@props(['items' => [], 'caption' => null, 'striped' => false])

<div class="overflow-x-auto border border-border rounded-md">
    <table class="w-full text-sm text-left border-collapse">
        @if ($caption)
            <caption class="mb-2 text-left font-semibold text-foreground">{{ $caption }}</caption>
        @endif
        <thead>
            <tr class="border-b border-border bg-muted text-muted-foreground">
                @foreach ($items['headers'] ?? [] as $header)
                    <th class="p-3 font-medium">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="text-foreground divide-y divide-border">
            @foreach ($items['rows'] ?? [] as $rowIndex => $row)
                <tr class="{{ $striped && $rowIndex % 2 === 1 ? 'bg-muted' : '' }} hover:bg-muted/50 transition-colors">
                    @foreach ($row as $cell)
                        <td class="p-3">{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
