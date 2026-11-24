@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Sidebar -->
        <aside class="lg:col-span-3 hidden lg:block space-y-1">
            <nav class="space-y-0.5" aria-label="Navigasi utama">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium border-r-2 border-primary bg-primary/10 text-primary rounded-r-lg transition-colors hover:bg-primary/20" aria-current="page">
                    <span aria-hidden="true">📁</span>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium border-r-2 border-transparent text-foreground/70 bg-card hover:bg-muted hover:text-foreground transition-colors rounded-r-lg">
                    <span aria-hidden="true">📂</span>
                    My Files
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium border-r-2 border-transparent text-foreground/70 bg-card hover:bg-muted hover:text-foreground transition-colors rounded-r-lg">
                    <span aria-hidden="true">⏱️</span>
                    Recent Files
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium border-r-2 border-transparent text-foreground/70 bg-card hover:bg-muted hover:text-foreground transition-colors rounded-r-lg">
                    <span aria-hidden="true">⭐</span>
                    Starred
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium border-r-2 border-transparent text-foreground/70 bg-card hover:bg-muted hover:text-foreground transition-colors rounded-r-lg">
                    <span aria-hidden="true">🗑️</span>
                    Trash
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium border-r-2 border-transparent text-foreground/70 bg-card hover:bg-muted hover:text-foreground transition-colors rounded-r-lg">
                    <span aria-hidden="true">💾</span>
                    Storage
                </a>
            </nav>

            <div class="mt-8 p-4 rounded-lg border border-border bg-card">
                <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-3">Akun</h3>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-muted flex items-center justify-center text-xs font-medium text-foreground">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1) . substr(auth()->user()->name, strpos(auth()->user()->name, ' ') + 1, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-foreground">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-muted-foreground">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="lg:col-span-9 space-y-6">
            <!-- Header -->
            <header class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-xl font-semibold text-foreground">Dashboard</h1>
                    <p class="text-sm text-muted-foreground">Selamat datang kembali. Berikut adalah ringkasan penyimpanan dan berkas Anda.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" id="upload-trigger" class="px-4 py-2 text-sm font-medium border border-border rounded-md hover:bg-muted transition-colors text-foreground">
                        Unggah Berkas
                    </button>
                    <input type="file" id="file-picker" class="sr-only" />
                </div>
            </header>

            @if (session('success'))
                <div class="mb-4">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4">
                    <x-alert type="destructive">{{ $errors->first() }}</x-alert>
                </div>
            @endif

            <!-- Breadcrumb -->
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Dashboard', 'url' => route('dashboard')],
            ]" label="Navigasi dashboard" />

            <!-- Storage Overview -->
            <x-card title="Ringkasan Penyimpanan" padding="p-6">
                @php
                    $totalBytes = $files->sum('size');
                    $totalGB = $totalBytes / (1024 * 1024 * 1024);
                    $limitGB = 5.0;
                    $percent = min(100, round(($totalGB / $limitGB) * 100));
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="p-4 rounded-lg border border-border bg-muted">
                        <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Total kapasitas</p>
                        <p class="text-lg font-semibold text-foreground mt-1">{{ number_format($limitGB, 2) }} GB</p>
                    </div>
                    <div class="p-4 rounded-lg border border-border bg-primary/10">
                        <p class="text-xs font-medium text-primary uppercase tracking-wider">Digunakan</p>
                        <p class="text-lg font-semibold text-primary mt-1"><span id="storage-used">{{ number_format($totalGB, 2) }}</span> GB</p>
                    </div>
                    <div class="p-4 rounded-lg border border-border bg-card">
                        <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Tersedia</p>
                        <p class="text-lg font-semibold text-foreground mt-1"><span id="storage-available">{{ number_format(max(0, $limitGB - $totalGB), 2) }}</span> GB</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-foreground">Penggunaan storage</span>
                        <span class="text-muted-foreground font-mono" id="storage-percent">{{ $percent }}%</span>
                    </div>
                    <x-progress-bar id="storage-progress" :value="$percent" max="100" label="Penggunaan storage saat ini" variant="primary" />
                </div>

                @if ($percent >= 80)
                    <div class="mt-4 p-3 rounded-md border border-yellow-200 bg-yellow-50 text-yellow-800 text-sm flex items-start gap-3">
                        <span aria-hidden="true">⚠️</span>
                        <div>
                            <p class="font-medium">Peringatan penggunaan storage</p>
                            <p class="text-xs text-yellow-700 mt-0.5">Penggunaan storage Anda telah melewati 80%. Pertimbangkan untuk menghapus berkas yang tidak diperlukan.</p>
                        </div>
                    </div>
                @endif
            </x-card>

            <!-- File and Folder Overview -->
            <x-card title="Berkas dan Folder" padding="p-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                    <div class="text-sm text-muted-foreground">
                        <span id="file-count" class="font-medium text-foreground">{{ $files->count() }}</span> item ditemukan
                    </div>
                    <div class="flex items-center gap-2 text-xs text-muted-foreground">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            Folder
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            Berkas
                        </span>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="empty-state" class="{{ $files->count() > 0 ? 'hidden' : '' }} text-center py-16 border border-border rounded-lg bg-card">
                    <div class="w-12 h-12 rounded-full bg-muted flex items-center justify-center mx-auto mb-4">
                        <span class="text-xl">📂</span>
                    </div>
                    <h3 class="text-lg font-semibold text-foreground mb-2">Tidak ada berkas</h3>
                    <p class="text-muted-foreground text-sm max-w-xs mx-auto">Mulai dengan mengunggah berkas akademik Anda.</p>
                    <button type="button" id="upload-trigger-empty" class="mt-4 px-4 py-2 text-sm font-medium border border-border rounded-md hover:bg-muted transition-colors text-foreground">
                        Unggah Berkas Pertama
                    </button>
                </div>

                <!-- Error State -->
                <div id="error-state" class="hidden text-center py-16 border border-destructive/20 rounded-lg bg-red-50">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4 text-destructive">
                        <span class="text-xl">⚠️</span>
                    </div>
                    <h3 class="text-lg font-semibold text-destructive mb-2">Gagal memuat berkas</h3>
                    <p class="text-sm text-red-700 max-w-xs mx-auto mb-4">Silakan periksa koneksi dan coba lagi.</p>
                    <button type="button" class="px-4 py-2 text-sm font-medium text-muted-foreground hover:bg-red-50 rounded-md transition-colors" onclick="location.reload()">
                        Coba Lagi
                    </button>
                </div>

                <!-- File Table -->
                <div id="file-table-container" class="overflow-x-auto border border-border rounded-md {{ $files->count() > 0 ? '' : 'hidden' }}">
                    <table class="w-full text-sm text-left border-collapse">
                        <caption class="mb-2 text-left font-semibold text-foreground">Daftar berkas dan folder</caption>
                        <thead>
                            <tr class="border-b border-border bg-muted text-muted-foreground">
                                <th class="p-3 font-medium">Nama</th>
                                <th class="p-3 font-medium">Tipe</th>
                                <th class="p-3 font-medium">Ukuran</th>
                                <th class="p-3 font-medium">Diunggah</th>
                                <th class="p-3 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="file-table-body" class="text-foreground divide-y divide-border">
                            @foreach ($files as $file)
                                <tr class="border-b border-border hover:bg-muted/50 transition-colors">
                                    <td class="p-3">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded bg-muted flex items-center justify-center text-xs">
                                                {{ strtoupper(pathinfo($file->name, PATHINFO_EXTENSION)) }}
                                            </span>
                                            <span class="text-sm font-medium text-foreground">{{ $file->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-xs font-medium text-muted-foreground">
                                            {{ $file->folder ? 'Folder' : strtoupper($file->mime_type === 'application/pdf' ? 'PDF' : ($file->mime_type === 'image/jpeg' || $file->mime_type === 'image/png' ? 'Gambar' : 'Berkas')) }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-xs text-muted-foreground font-mono">{{ $file->size > 0 ? number_format($file->size / 1024, 2) . ' KB' : '-' }}</span>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-xs text-muted-foreground">{{ $file->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="p-3">
                                        <a href="{{ route('files.download', $file->id) }}" class="p-2 text-primary hover:text-secondary transition-colors" title="Unduh">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Upload Area -->
            <x-card title="Unggah Berkas" padding="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-muted-foreground mb-4">Pilih berkas untuk diunggah ke akun Anda.</p>

                        <div
                            id="dropzone"
                            class="border-2 border-dashed border-border rounded-lg bg-card p-8 text-center hover:border-primary hover:bg-primary/5 transition-colors cursor-pointer min-h-[200px] flex flex-col items-center justify-center gap-3"
                            data-dropzone
                        >
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 4.25v2.25a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25V4.25M3 7.5h18M4.5 15.75l3 3m0 0l3-3m-3 3v-6.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-medium text-foreground">Seret berkas di sini</p>
                            <p class="text-xs text-muted-foreground">ATAU</p>
                            <label class="text-sm font-medium text-primary underline underline-offset-4 hover:text-secondary cursor-pointer">
                                Pilih berkas dari komputer
                            </label>
                        </div>

                        <input type="file" id="file-picker-hidden" class="sr-only" multiple />

                        <p class="text-xs text-muted-foreground mt-3">
                            Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP, RAR. Maksimal ukuran berkas: 10 MB.
                        </p>

                        <!-- Upload status messages -->
                        <div id="upload-status" class="mt-3 hidden"></div>
                    </div>

                    <div class="space-y-3" id="recent-uploads">
                        @foreach ($files->take(3) as $file)
                            <div class="flex items-center justify-between p-3 rounded-lg border border-border bg-muted">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-medium">
                                        {{ strtoupper(pathinfo($file->name, PATHINFO_EXTENSION)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-foreground">{{ $file->name }}</p>
                                        <p class="text-xs text-muted-foreground">{{ number_format($file->size / 1024, 2) }} KB • {{ $file->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('files.download', $file->id) }}" class="text-xs font-medium text-primary hover:text-secondary underline underline-offset-4">
                                    Unduh
                                </a>
                            </div>
                        @endforeach
                        @if ($files->isEmpty())
                            <p class="text-xs text-muted-foreground text-center py-4">Belum ada berkas yang diunggah.</p>
                        @endif
                    </div>
                </div>
            </x-card>
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        const dropzone = document.getElementById('dropzone');
        const filePicker = document.getElementById('file-picker-hidden');
        const uploadTrigger = document.getElementById('upload-trigger');
        const uploadTriggerEmpty = document.getElementById('upload-trigger-empty');
        const uploadStatus = document.getElementById('upload-status');

        // File type icon mapping (kept for backward compatibility if needed)
        const FILE_TYPE_ICONS = {
            'PDF': '<svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
            'Dokumen': '<svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
            'Gambar': '<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
            'Arsip': '<svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>',
            'File': '<svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
            'Folder': '<svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>'
        };

        const MAX_SIZE = 10 * 1024 * 1024; // 10 MB
        const VALID_TYPES = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'rar'];

        function showUploadStatus(message, type = 'success') {
            uploadStatus.className = 'mt-3 p-3 rounded-md ' + (type === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200');
            uploadStatus.textContent = message;
            uploadStatus.classList.remove('hidden');
            setTimeout(() => {
                if (type === 'success') {
                    location.reload();
                } else {
                    uploadStatus.classList.add('hidden');
                }
            }, type === 'success' ? 800 : 5000);
        }

        function showUploadError(message) {
            showUploadStatus(message, 'error');
        }

        function handleFileSelect(files) {
            if (files.length === 0) return;

            const file = files[0];

            const ext = file.name.split('.').pop().toLowerCase();
            if (!VALID_TYPES.includes(ext)) {
                showUploadError('Berkas "' + file.name + '" tidak didukung.');
                return;
            }
            if (file.size > MAX_SIZE) {
                showUploadError('Berkas "' + file.name + '" terlalu besar (maksimum 10 MB).');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('/files/upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                },
            })
                .then(response => {
                    if (response.status === 419) {
                        showUploadError('Sesi kedaluwarsa. Silakan muat ulang halaman dan coba lagi.');
                        throw new Error('CSRF token mismatch');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showUploadStatus('Berkas "' + data.file.original_name + '" berhasil diunggah.');
                    } else {
                        showUploadError(data.message || 'Gagal mengunggah berkas.');
                    }
                })
                .catch(() => {
                    // Error already handled above for 419
                });
        }

        // Dropzone interactions
        if (dropzone && filePicker) {
            dropzone.addEventListener('click', () => filePicker.click());
            uploadTrigger.addEventListener('click', () => filePicker.click());
            if (uploadTriggerEmpty) {
                uploadTriggerEmpty.addEventListener('click', () => filePicker.click());
            }
            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('border-primary', 'bg-primary/5');
            });
            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-primary', 'bg-primary/5');
            });
            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-primary', 'bg-primary/5');
                const files = Array.from(e.dataTransfer.files);
                handleFileSelect(files);
            });
            filePicker.addEventListener('change', (e) => {
                const files = Array.from(e.target.files);
                handleFileSelect(files);
            });
        }
    </script>
@endpush
