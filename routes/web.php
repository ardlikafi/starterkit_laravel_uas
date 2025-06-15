<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;

Route::middleware(['auth'])->group(function () {
    Route::resource('news', NewsController::class);
    Route::resource('categories', CategoryController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/pages', function () {
        return '<h1>Admin Pages</h1><p>Halaman ini masih dalam pengembangan.</p>';
    });
    Route::get('/admin/settings', function () {
        return '<h1>Admin Settings</h1><p>Halaman ini masih dalam pengembangan.</p>';
    });
});

require __DIR__.'/auth.php';
