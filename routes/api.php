<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Institution\InstitutionController;
use App\Http\Controllers\Curso\CursoController;
use App\Http\Controllers\CursoInscripcionController;
use App\Http\Controllers\Institution\InstitutionUsersController;

Route::middleware('auth')->group(function () {
    Route::prefix('image')->group(function () {
        Route::post('upload', [ImageController::class, 'store'])->name('image.store');
        Route::delete('delete', [ImageController::class, 'destroy'])->name('image.delete');
    });
});

Route::prefix('institution')->group(function () {
    Route::get('', [InstitutionController::class, 'findAll'])->name('institution.findAll');
    Route::get('{id}', [InstitutionController::class, 'findById'])->name('institution.findById');
    Route::get('courses', [CursoController::class, 'findAllCursos'])->name('curso.findAll');
    Route::get('course/{id}', [CursoController::class, 'findById'])->name('curso.findById');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::post('create', [InstitutionController::class, 'create'])->name('institution.create');
        Route::delete('delete', [InstitutionController::class, 'delete'])->name('institution.delete');
        Route::put('update', [InstitutionController::class, 'update'])->name('institution.update');
        Route::post('{institution_id}/course', [CursoController::class, 'createCurso'])->name('curso.createCurso');
        Route::put('course/{course_id}', [CursoController::class, 'updateCourse'])->name('curso.updateCurso');
        Route::delete('course/{course_id}', [CursoController::class, 'deleteCurso'])->name('curso.deleteCurso');
        Route::prefix('user')->group(function () {
            Route::post('add', [InstitutionUsersController::class, 'addUserToInstitution'])->name('institution.addUser');
            Route::delete('remove', [InstitutionUsersController::class, 'removeUserFromInstitution'])->name('institution.removeUser');
        });
    });
});

Route::prefix('course')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::post('{course_id}/inscription', [CursoInscripcionController::class, 'inscripcion'])->name('curso.inscripcion');
    });
});
