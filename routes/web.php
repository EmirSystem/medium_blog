<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard - Rol bazlı yönlendirme
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->isSuperAdmin()) {
        return view('admin.dashboard');
    }

    return view('yazar.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Route'ları
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/blogs/pending', function () {
        return view('admin.blogs.pending');
    })->name('admin.blogs.pending');
});

// Yazar Route'ları
Route::middleware(['auth', 'verified'])->prefix('yazar')->group(function () {
    Route::get('/blogs', function () {
        return view('yazar.blogs.index');
    })->name('yazar.blogs.index');
});

// Profil Route'ları
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
