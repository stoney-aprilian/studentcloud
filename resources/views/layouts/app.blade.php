<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'StudentCloud') }} - {{ config('app.name', 'StudentCloud') }}</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* fallback inline styles only used before build */
            </style>
        @endif

        @stack('styles')
    </head>
    <body class="bg-background text-foreground font-sans antialiased">

        @if (Route::has('login'))
            <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:p-4">Skip to main content</a>
        @endif

        <header class="border-b border-border bg-card">
            <nav class="flex items-center justify-between px-4 py-3 lg:px-8">
                <div class="flex items-center gap-2 font-semibold text-foreground">
                    <span class="text-accent">Student</span><span class="text-primary">Cloud</span>
                </div>

                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium border border-transparent hover:border-border rounded-md transition-colors text-primary">
                        Dashboard
                    </a>
                    <a href="{{ route('design') }}" class="px-3 py-2 text-sm font-medium border border-transparent hover:border-border rounded-md transition-colors text-muted-foreground">
                        Design System
                    </a>
                </div>

                <div class="ml-auto flex items-center gap-2">
                    @auth
                        <div class="relative inline-block">
                            <button class="px-3 py-2 text-sm font-medium border border-border rounded-md hover:bg-muted transition-colors text-foreground">
                                {{ auth()->user()->name ?? 'Pengguna' }}
                            </button>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                                @csrf
                            </form>
                            <button onclick="document.getElementById('logout-form').submit()" class="px-3 py-2 text-sm font-medium text-destructive hover:bg-red-50 hover:text-red-600 rounded-md transition-colors">
                                Keluar
                            </button>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium border border-border rounded-md hover:bg-muted transition-colors text-foreground">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-3 py-2 text-sm font-medium text-primary hover:text-secondary transition-colors">
                            Daftar
                        </a>
                    @endauth
                </div>
            </nav>
        </header>

        <main id="main" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if (session('status'))
                <div class="mb-4">
                    <x-alert type="success">{{ session('status') }}</x-alert>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="border-t border-border bg-card mt-auto py-6 px-4 text-xs text-muted-foreground">
            <p class="text-center">&copy; {{ now()->year }} StudentCloud. Academic cloud storage for students.</p>
        </footer>

        @stack('scripts')
    </body>
</html>
