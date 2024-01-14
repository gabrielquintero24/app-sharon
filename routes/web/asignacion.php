<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asignacion\AsignacionController;

Route::group(['prefix' => 'asignacion', 'middleware' => [/* 'auth' */]], function () {
    Route::get('', [AsignacionController::class, 'index'])->name('asignacion.index');
    Route::get('/list', [AsignacionController::class, 'getAsignaciones'])->name('asignacion.list');
    Route::post('/store', [AsignacionController::class, 'store'])->name('asignacion.store');
    Route::post('/update/{asignacion}', [AsignacionController::class, 'update'])->name('asignacion.update');
    Route::get('/show/{id}', [AsignacionController::class, 'getAsignacion'])->name('asignacion.show');
});
