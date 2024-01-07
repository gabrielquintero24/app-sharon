<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cortes\CorteController;

Route::group(['prefix' => 'corte', 'middleware' => [/* 'auth' */]], function () {
    Route::get('', [CorteController::class, 'index'])->name('corte.index');
});
