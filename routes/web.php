<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('styles', function () {
    return Inertia::render('StyleGuide');
})->name('styles');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
Route::post('/image/upload', [ImageController::class, 'store'])->name('image.store');
Route::delete('/image/delete', [ImageController::class, 'destroy'])->name('image.delete');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
