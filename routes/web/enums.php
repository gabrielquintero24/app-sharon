<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Configuration\ConfigurationController;

Route::group(['prefix' => 'enums', 'middleware' => [/* 'auth' */]], function () {
    Route::get('/types/{name}', [ConfigurationController::class, 'listEnums'])->name('enums.list');
});
