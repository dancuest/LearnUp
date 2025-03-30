<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Route::prefix('image')->group(function () {
    Route::post('upload', [ImageController::class, 'store'])->name('image.store');
    Route::delete('delete', [ImageController::class, 'destroy'])->name('image.delete');
});
