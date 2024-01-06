<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Terceros\ModistaController;

Route::group(['prefix' => 'modista', 'middleware' => [/* 'auth' */]], function () {
    Route::get('', [ModistaController::class, 'index'])->name('modista.index');
});
