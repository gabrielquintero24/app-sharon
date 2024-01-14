<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cortes\CorteController;
use App\Http\Controllers\Cortes\CorteEspecificacionController;

Route::group(['prefix' => 'corte', 'middleware' => [/* 'auth' */]], function () {
    Route::get('', [CorteController::class, 'index'])->name('corte.index');
    Route::get('/list', [CorteController::class, 'getCortes'])->name('corte.list');
    Route::get('/show/{id}', [CorteController::class, 'getCorte'])->name('corte.show');
    Route::post('/store', [CorteController::class, 'store'])->name('corte.store');
    Route::post('/update/{corte}', [CorteController::class, 'update'])->name('corte.update');
    Route::get('/nombres-ids', [CorteController::class, 'listCorteNombresAndIds'])->name('corte.nombres-ids');
});


Route::group(['prefix' => 'corte-especificacion', 'middleware' => [/* 'auth' */]], function () {
    Route::get('', [CorteEspecificacionController::class, 'index'])->name('corte-especificacion.index');
    Route::get('/list', [CorteEspecificacionController::class, 'getVinculaciones'])->name('corte-especificacion.list');
    Route::post('/store', [CorteEspecificacionController::class, 'store'])->name('corte-especificacion.store');
    Route::post('/update/{CorteEspecificacion}', [CorteEspecificacionController::class, 'update'])->name('corte-especificacion.update');
    Route::get('/show/{id}', [CorteEspecificacionController::class, 'getVinculacion'])->name('corte-especificacion.show');
});

