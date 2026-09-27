<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ValidarConstanciasController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/validar-constancia/{key}',[ValidarConstanciasController::class, 'validar'])->name('constancia.validar');
