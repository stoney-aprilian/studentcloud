@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <header class="mb-2">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Design System', 'url' => route('design')],
            ]" />
            <h1 class="text-2xl font-semibold text-foreground">Design System</h1>
            <p class="text-muted-foreground mt-1">Referensi konsistensi warna, tipografi, komponen, dan state untuk StudentCloud.</p>
        </header>

        <!-- Color Tokens -->
        <x-card title="Color Tokens" padding="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-lg border border-border bg-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-md border" style="background-color: #2563EB;"></div>
                        <span class="text-xs font-mono text-muted-foreground">#2563EB</span>
                    </div>
                    <p class="text-xs text-muted-foreground">Primary</p>
                    <p class="text-[10px] text-muted-foreground mt-0.5">--color-primary</p>
                </div>
                <div class="p-4 rounded-lg border border-border bg-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-md border" style="background-color: #3B82F6;"></div>
                        <span class="text-xs font-mono text-muted-foreground">#3B82F6</span>
                    </div>
                    <p class="text-xs text-muted-foreground">Secondary</p>
                    <p class="text-[10px] text-muted-foreground mt-0.5">--color-secondary</p>
                </div>
                <div class="p-4 rounded-lg border border-border bg-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-md border" style="background-color: #D97706;"></div>
                        <span class="text-xs font-mono text-muted-foreground">#D97706</span>
                    </div>
                    <p class="text-xs text-muted-foreground">Accent</p>
                    <p class="text-[10px] text-muted-foreground mt-0.5">--color-accent</p>
                </div>
                <div class="p-4 rounded-lg border border-border bg-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-md border" style="background-color: #F8FAFC;"></div>
                        <span class="text-xs font-mono text-muted-foreground">#F8FAFC</span>
                    </div>
                    <p class="text-xs text-muted-foreground">Background</p>
                    <p class="text-[10px] text-muted-foreground mt-0.5">--color-background</p>
                </div>
                <div class="p-4 rounded-lg border border-border bg-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-md border" style="background-color: #FFFFFF;"></div>
                        <span class="text-xs font-mono text-muted-foreground">#FFFFFF</span>
                    </div>
                    <p class="text-xs text-muted-foreground">Card</p>
                    <p class="text-[10px] text-muted-foreground mt-0.5">--color-card</p>
                </div>
                <div class="p-4 rounded-lg border border-border bg-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-md border" style="background-color: #F1F5FD;"></div>
                        <span class="text-xs font-mono text-muted-foreground">#F1F5FD</span>
                    </div>
                    <p class="text-xs text-muted-foreground">Muted</p>
                    <p class="text-[10px] text-muted-foreground mt-0.5">--color-muted</p>
                </div>
                <div class="p-4 rounded-lg border border-border bg-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-md border" style="background-color: #E4ECFC;"></div>
                        <span class="text-xs font-mono text-muted-foreground">#E4ECFC</span>
                    </div>
                    <p class="text-xs text-muted-foreground">Border</p>
                    <p class="text-[10px] text-muted-foreground mt-0.5">--color-border</p>
                </div>
                <div class="p-4 rounded-lg border border-border bg-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-md border" style="background-color: #DC2626;"></div>
                        <span class="text-xs font-mono text-muted-foreground">#DC2626</span>
                    </div>
                    <p class="text-xs text-muted-foreground">Destructive</p>
                    <p class="text-[10px] text-muted-foreground mt-0.5">--color-destructive</p>
                </div>
            </div>
        </x-card>

        <!-- Typography -->
        <x-card title="Typography" padding="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-3xl font-semibold text-foreground">Fira Sans — Heading</h2>
                    <h1 class="text-2xl font-semibold text-foreground mt-4">H1 — Page title</h1>
                    <h2 class="text-xl font-semibold text-foreground mt-3">H2 — Section title</h2>
                    <h3 class="text-lg font-semibold text-foreground mt-3">H3 — Subsection</h3>
                    <h4 class="text-base font-semibold text-foreground mt-3">H4 — Card title</h4>
                    <p class="text-lg text-foreground mt-4">Body teks reguler dengan Fira Sans untuk konten utama dan paragraf.</p>
                    <p class="text-base text-muted-foreground mt-2">Body teks kecil (secondary) untuk keterangan dan deskripsi ringan.</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider mb-3">Fira Code — Metadata teknis</h2>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 font-mono text-sm">
                            <span class="text-muted-foreground">File size:</span>
                            <span class="text-foreground">2.4 MB</span>
                        </div>
                        <div class="flex items-center gap-3 font-mono text-sm">
                            <span class="text-muted-foreground">Uploaded:</span>
                            <span class="text-foreground">2026-11-24 20:33</span>
                        </div>
                        <div class="flex items-center gap-3 font-mono text-sm">
                            <span class="text-muted-foreground">File ID:</span>
                            <span class="text-foreground">sc_file_8a7b3c</span>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Buttons -->
        <x-card title="Buttons" padding="p-6">
            <div class="flex flex-wrap gap-3">
                <x-button variant="primary">Primary</x-button>
                <x-button variant="secondary">Secondary</x-button>
                <x-button variant="accent">Accent</x-button>
                <x-button variant="outline">Outline</x-button>
                <x-button variant="ghost">Ghost</x-button>
                <x-button variant="destructive">Destructive</x-button>
                <x-button variant="primary" size="sm">Primary Small</x-button>
                <x-button variant="primary" size="lg">Primary Large</x-button>
                <x-button variant="primary" disabled>Disabled</x-button>
                <x-button variant="primary" loading>Loading</x-button>
            </div>
        </x-card>

        <!-- Badges -->
        <x-card title="Badges" padding="p-6">
            <div class="flex flex-wrap gap-3">
                <x-badge variant="primary">Primary</x-badge>
                <x-badge variant="secondary">Secondary</x-badge>
                <x-badge variant="accent">Accent</x-badge>
                <x-badge variant="success">Success</x-badge>
                <x-badge variant="warning">Warning</x-badge>
                <x-badge variant="destructive">Destructive</x-badge>
                <x-badge variant="outline">Outline</x-badge>
                <x-badge variant="muted">Muted</x-badge>
            </div>
        </x-card>

        <!-- Cards -->
        <x-card title="Cards" padding="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-card title="Card default" padding="p-4">
                    Konten card standar dengan padding dan border ringan.
                </x-card>
                <x-card title="Card tanpa shadow" padding="p-4" :shadow="false">
                    Card tanpa bayangan, hanya border.
                </x-card>
            </div>
        </x-card>

        <!-- Alerts -->
        <x-card title="Alerts" padding="p-6">
            <div class="space-y-3">
                <x-alert type="info">Ini adalah pesan informasi standar.</x-alert>
                <x-alert type="success">Berhasil diunggah ke Storage.</x-alert>
                <x-alert type="warning">Peringatan: penggunaan storage mendekati batas 80%.</x-alert>
                <x-alert type="error">Gagal mengunggah berkas. Silakan coba lagi.</x-alert>
            </div>
        </x-card>

        <!-- Form Inputs -->
        <x-card title="Form Inputs" padding="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-form-input id="email" label="Email" type="email" placeholder="mahasiswa@kampus.ac.id" />
                <x-form-input id="name" label="Nama lengkap" value="Budi Santoso" />
                <x-form-input id="password" label="Kata sandi" type="password" />
                <x-form-input id="search" label="Pencarian berkas" placeholder="Ketik nama file..." helper="Cari berdasarkan nama atau tipe file" />
                <x-form-input id="error-field" label="Field dengan error" error="Berkas tidak valid atau terlalu besar." />
            </div>
        </x-card>

        <!-- Dropdown -->
        <x-card title="Dropdown / Select" padding="p-6">
            <div class="max-w-sm">
                @php
                    $fileTypeItems = [
                        ['value' => 'pdf', 'label' => 'PDF'],
                        ['value' => 'doc', 'label' => 'Word Document'],
                        ['value' => 'xls', 'label' => 'Excel Spreadsheet'],
                        ['value' => 'jpg', 'label' => 'Image'],
                    ];
                @endphp
                <x-dropdown label="Tipe berkas" name="file_type" value="pdf" :items="$fileTypeItems" />
            </div>
        </x-card>

        <!-- Table -->
        <x-card title="Table" padding="p-6">
            <x-table :items="[
                'headers' => ['Nama berkas', 'Tipe', 'Ukuran', 'Diunggah', 'Status'],
                'rows' => [
                    ['Kuis Matematika.pdf', 'PDF', '342 KB', '2 jam lalu', 'Selesai'],
                    ['Tugas Pemrograman.docx', 'Word', '1.2 MB', '5 jam lalu', 'Selesai'],
                    ['Presentasi AI.pptx', 'PowerPoint', '5.8 MB', '1 hari lalu', 'Selesai'],
                    ['Catatan Kuliah.txt', 'Text', '45 KB', '2 hari lalu', 'Draft'],
                ],
            ]" caption="Daftar berkas terbaru" striped />
        </x-card>

        <!-- Progress Bar -->
        <x-card title="Storage Usage (Progress Bar)" padding="p-6">
            <x-progress-bar value="72" max="100" label="Penggunaan storage" variant="primary" />
            <x-progress-bar value="85" max="100" label="Peringatan 80%" variant="warning" />
            <x-progress-bar value="96" max="100" label="Peringatan 95%" variant="destructive" />
        </x-card>

        <!-- States -->
        <x-card title="Empty, Loading, dan Error States" padding="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="border border-border rounded-lg p-8 text-center">
                    <p class="text-muted-foreground text-sm">Tidak ada berkas</p>
                    <p class="text-xs text-muted-foreground mt-1">Mulai dengan mengunggah berkas akademik.</p>
                </div>
                <div class="border border-border rounded-lg p-8 text-center">
                    <div class="animate-pulse inline-block w-8 h-8 bg-primary rounded-full"></div>
                    <p class="text-muted-foreground text-sm mt-3">Memuat berkas...</p>
                </div>
                <div class="border border-destructive rounded-lg p-8 text-center text-destructive">
                    <p class="text-sm">Gagal memuat</p>
                    <p class="text-xs mt-1">Silakan periksa koneksi dan coba lagi.</p>
                </div>
            </div>
        </x-card>

        <!-- Focus & Hover states note -->
        <x-card title="Interaksi (Focus & Hover)" padding="p-6">
            <ul class="text-sm text-muted-foreground space-y-2 list-disc pl-5">
                <li>Semua elemen interaktif memiliki <code>cursor-pointer</code> dan hover state 150–200 ms.</li>
                <li>Focus visible dengan ring 2px warna primary (#2563EB) untuk navigasi keyboard.</li>
                <li><code>prefers-reduced-motion</code> dinonaktifkan animasi non-esensial.</li>
                <li>Target sentuh minimal 44 px pada elemen mobile.</li>
                <li>Teks pada background amber (#D97706) menggunakan warna gelap (#000000) untuk kontras.</li>
            </ul>
        </x-card>
    </div>
@endsection
