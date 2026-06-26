<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocalController;
use App\Http\Controllers\Api\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::get('me/resumen-nutricional', [AuthController::class, 'nutritionSummary'])->middleware('auth:sanctum');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('locales', LocalController::class);
Route::get('locales/{id}/menus', [MenuController::class, 'menusPorLocal']);
Route::apiResource('menus', MenuController::class);
Route::get('productos/tendencias', [ProductoController::class, 'tendencias']);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('categorias-comida', CategoriaComidaController::class);
Route::apiResource('informacion-nutricional', InformacionNutricionalController::class);
Route::post('compras/registrar', [CompraController::class, 'registrar'])->middleware('auth:sanctum');
Route::apiResource('compras', CompraController::class)->middleware('auth:sanctum');
Route::apiResource('desafios', DesafioController::class);
Route::apiResource('demanda-horaria', DemandaHorariaController::class);
Route::get('productos/{id}/informacion-nutricional', [ProductoController::class, 'informacionNutricional']);
Route::put('productos/{id}/categorias', [ProductoController::class, 'syncCategorias']);
Route::apiResource('favoritos', FavoritoController::class);
Route::get('favoritos/mios', [FavoritoController::class, 'mios'])->middleware('auth:sanctum');
Route::get('usuarios/{id}/favoritos', [FavoritoController::class, 'porUsuario']);
Route::apiResource('reportes', ReporteController::class);
Route::apiResource('consejos', ConsejoController::class);