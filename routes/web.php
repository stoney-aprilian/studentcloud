<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\File\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::get('/dashboard', [FileController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('/design', function () {
    return view('design');
})->name('design');

Route::middleware('auth')->group(function () {
    Route::post('/files/upload', [FileController::class, 'upload'])
        ->name('files.upload');
    Route::get('/files/{file}/download', [FileController::class, 'download'])
        ->name('files.download');
});
