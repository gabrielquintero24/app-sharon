<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Terceros\ModistaController;

Route::group(['prefix' => 'modista', 'middleware' => [/* 'auth' */]], function () {
    Route::get('', [ModistaController::class, 'index'])->name('modista.index');
    Route::get('/list', [ModistaController::class, 'getModistas'])->name('modista.list');
    Route::get('/show/{id}', [ModistaController::class, 'getModista'])->name('modista.show');
    Route::post('/store', [ModistaController::class, 'store'])->name('modista.store');
    Route::post('/update/{modista}', [ModistaController::class, 'update'])->name('modista.update');
    Route::get('/nombres-ids', [ModistaController::class, 'listModistaNombresAndIds'])->name('modista.nombres-ids');
});
