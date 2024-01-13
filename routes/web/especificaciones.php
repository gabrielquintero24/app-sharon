<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Especificacion\EspecificacionController;

Route::group(['prefix' => 'especificaciones', 'middleware' => [/* 'auth' */]], function () {
    Route::get('', [EspecificacionController::class, 'index'])->name('especificaciones.index');
    Route::get('/list', [EspecificacionController::class, 'getEspecificaciones'])->name('especificaciones.list');
});
