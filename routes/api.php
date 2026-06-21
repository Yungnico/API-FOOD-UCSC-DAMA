<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocalController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\FavoritoController;
use App\Http\Controllers\Api\ReporteController;
use App\Http\Controllers\Api\ConsejoController;
use App\Http\Controllers\Api\CategoriaComidaController;
use App\Http\Controllers\Api\InformacionNutricionalController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\DesafioController;
use App\Http\Controllers\Api\DemandaHorariaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('locales', LocalController::class);
Route::apiResource('menus', MenuController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('categorias-comida', CategoriaComidaController::class);
Route::apiResource('informacion-nutricional', InformacionNutricionalController::class);
Route::post('compras/registrar', [CompraController::class, 'registrar'])->middleware('auth:sanctum');
Route::apiResource('compras', CompraController::class);
Route::apiResource('desafios', DesafioController::class);
Route::apiResource('demanda-horaria', DemandaHorariaController::class);
Route::get('productos/{id}/informacion-nutricional', [ProductoController::class, 'informacionNutricional']);
Route::put('productos/{id}/categorias', [ProductoController::class, 'syncCategorias']);
Route::apiResource('favoritos', FavoritoController::class);
Route::apiResource('reportes', ReporteController::class);
Route::apiResource('consejos', ConsejoController::class);