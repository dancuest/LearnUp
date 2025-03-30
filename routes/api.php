<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Institution\InstitutionController;
use App\Http\Controllers\Institution\InstitutionUsersController;

Route::prefix('image')->group(function () {
    Route::post('upload', [ImageController::class, 'store'])->name('image.store');
    Route::delete('delete', [ImageController::class, 'destroy'])->name('image.delete');
});

Route::prefix('institution')->group(function () {
    Route::get('find/{id}', [InstitutionController::class, 'findById'])->name('institution.findById');
    Route::get('find', [InstitutionController::class, 'findAll'])->name('institution.findAll');

    Route::middleware('auth')->group(function () {
        Route::post('create', [InstitutionController::class, 'store'])->name('institution.create');
        Route::delete('delete', [ImageController::class, 'delete'])->name('image.delete');
        Route::put('update', [InstitutionController::class, 'update'])->name('institution.update');
        Route::prefix('user')->group(function () {
            Route::post('add', [InstitutionUsersController::class, 'addUserToInstitution'])->name('institution.addUser');
            Route::delete('remove', [InstitutionUsersController::class, 'removeUserFromInstitution'])->name('institution.removeUser');
        });
    });
});
