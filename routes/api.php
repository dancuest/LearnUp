<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {});
Route::post('/image/upload', [ImageController::class, 'store'])->name('image.store');
Route::delete('/image/delete', [ImageController::class, 'destroy'])->name('image.delete');
