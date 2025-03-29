<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::match(['get', 'post'], 'styles', function () {
    return Inertia::render('StyleGuide');
})->name('styles');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
Route::post('/image/upload', [ImageController::class, 'store'])->name('image.store');
Route::delete('/image/delete', [ImageController::class, 'destroy'])->name('image.delete');
// routes/web.php
Route::get('/test-s3-connection', function () {
    try {
        $fileContent = 'Test content ' . now();
        Storage::disk('s3')->put('test.txt', $fileContent);

        $exists = Storage::disk('s3')->exists('test.txt');
        $url = Storage::disk('s3')->url('test.txt');

        return [
            'success' => $exists,
            'url' => $url,
            'config' => config('filesystems.disks.s3')
        ];
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
