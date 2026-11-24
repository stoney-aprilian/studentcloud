@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto py-10">
        <x-card title="Masuk ke Akun" padding="p-8">

            @if (session('error'))
                <x-alert type="destructive">{{ session('error') }}</x-alert>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <x-form-input
                    id="email"
                    label="Email"
                    type="email"
                    placeholder="mahasiswa@kampus.ac.id"
                    required
                    :error="$errors->first('email')"
                />

                <x-form-input
                    id="password"
                    label="Kata Sandi"
                    type="password"
                    placeholder="Masukkan kata sandi"
                    required
                    :error="$errors->first('password')"
                />

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-primary border-border rounded focus:ring-primary">
                        <label for="remember" class="ml-2 text-sm text-muted-foreground">Ingat saya</label>
                    </div>

                    <a href="#" class="text-sm text-primary hover:text-secondary underline underline-offset-4">
                        Lupa kata sandi?
                    </a>
                </div>

                <x-button variant="primary" class="w-full">Masuk</x-button>
            </form>

            <div class="mt-6 pt-6 border-t border-border text-center">
                <p class="text-sm text-muted-foreground">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="text-sm font-medium text-primary hover:text-secondary">
                    Daftar sekarang
                </a>
            </div>
        </x-card>
    </div>
@endsection
