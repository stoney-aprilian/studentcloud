@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto py-10">
        <x-card title="Daftar Akun Baru" padding="p-8">

            @if (session('error'))
                <x-alert type="destructive">{{ session('error') }}</x-alert>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <x-form-input
                    id="name"
                    label="Nama Lengkap"
                    type="text"
                    placeholder="Masukkan nama lengkap Anda"
                    required
                    :error="$errors->first('name')"
                />

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
                    placeholder="Minimal 8 karakter"
                    required
                    :error="$errors->first('password')"
                />

                <x-form-input
                    id="password_confirmation"
                    label="Konfirmasi Kata Sandi"
                    type="password"
                    placeholder="Ketik ulang kata sandi"
                    required
                    :error="$errors->first('password_confirmation')"
                />

                <x-button variant="primary" class="w-full">Daftar</x-button>
            </form>

            <div class="mt-6 pt-6 border-t border-border text-center">
                <p class="text-sm text-muted-foreground">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="text-sm font-medium text-primary hover:text-secondary">
                    Masuk di sini
                </a>
            </div>
        </x-card>
    </div>
@endsection
