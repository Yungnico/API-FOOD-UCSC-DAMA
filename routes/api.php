<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocalController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\FavoritoController;
use App\Http\Controllers\Api\ReporteController;
use App\Http\Controllers\Api\ConsejoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('locales', LocalController::class);
Route::apiResource('menus', MenuController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('favoritos', FavoritoController::class);
Route::apiResource('reportes', ReporteController::class);
Route::apiResource('consejos', ConsejoController::class);