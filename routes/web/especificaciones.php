<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Especificacion\EspecificacionController;

Route::group(['prefix' => 'especificaciones', 'middleware' => [/* 'auth' */]], function () {
    Route::get('', [EspecificacionController::class, 'index'])->name('especificaciones.index');
    Route::get('/list', [EspecificacionController::class, 'getEspecificaciones'])->name('especificaciones.list');
    Route::post('/store', [EspecificacionController::class, 'store'])->name('especificaciones.store');
    Route::post('/update/{especificacion}', [EspecificacionController::class, 'update'])->name('especificaciones.update');
    Route::get('/show/{id}', [EspecificacionController::class, 'getEspecificacion'])->name('especificaciones.show');
    Route::get('/nombres-ids', [EspecificacionController::class, 'listEspecificacionNombresAndIds'])->name('especificaciones.nombres-ids');
});
