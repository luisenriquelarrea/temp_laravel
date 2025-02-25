<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeccionMenuController;
use App\Http\Controllers\SeccionMenuInputController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AccionController;
use App\Http\Controllers\AccionGrupoController;
use App\Http\Controllers\AccionBasicaController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/accion', [AccionController::class, 'index']);
Route::get('/accion/{id}', [AccionController::class, 'show']);
Route::prefix('/accion')->group(function(){
    Route::post('/store', [AccionController::class, 'store']);
    Route::put('/{id}', [AccionController::class, 'update']);
    Route::delete('/{id}', [AccionController::class, 'destroy']);
    Route::post('/filteredList', [AccionController::class, 'filteredList']);
});

Route::get('/accion_basica', [AccionBasicaController::class, 'index']);
Route::get('/accion_basica/{id}', [AccionBasicaController::class, 'show']);
Route::prefix('/accion_basica')->group(function(){
    Route::post('/store', [AccionBasicaController::class, 'store']);
    Route::put('/{id}', [AccionBasicaController::class, 'update']);
    Route::delete('/{id}', [AccionBasicaController::class, 'destroy']);
    Route::post('/filteredList', [AccionBasicaController::class, 'filteredList']);
});

Route::get('/accion_grupo', [AccionGrupoController::class, 'index']);
Route::get('/accion_grupo/{id}', [AccionGrupoController::class, 'show']);
Route::prefix('/accion_grupo')->group(function(){
    Route::post('/store', [AccionGrupoController::class, 'store']);
    Route::put('/{id}', [AccionGrupoController::class, 'update']);
    Route::delete('/{id}', [AccionGrupoController::class, 'destroy']);
    Route::post('/filteredList', [AccionGrupoController::class, 'filteredList']);
});

Route::get('/grupo', [GrupoController::class, 'index']);
Route::get('/grupo/{id}', [GrupoController::class, 'show']);
Route::prefix('/grupo')->group(function(){
    Route::post('/store', [GrupoController::class, 'store']);
    Route::put('/{id}', [GrupoController::class, 'update']);
    Route::delete('/{id}', [GrupoController::class, 'destroy']);
    Route::post('/filteredList', [GrupoController::class, 'filteredList']);
});

Route::get('/menu', [MenuController::class, 'index']);
Route::get('/menu/{id}', [MenuController::class, 'show']);
Route::prefix('/menu')->group(function(){
    Route::post('/store', [MenuController::class, 'store']);
    Route::put('/{id}', [MenuController::class, 'update']);
    Route::delete('/{id}', [MenuController::class, 'destroy']);
    Route::post('/filteredList', [MenuController::class, 'filteredList']);
});

Route::get('/seccion_menu', [SeccionMenuController::class, 'index']);
Route::get('/seccion_menu/{id}', [SeccionMenuController::class, 'show']);
Route::prefix('/seccion_menu')->group(function(){
    Route::post('/store', [SeccionMenuController::class, 'store']);
    Route::put('/{id}', [SeccionMenuController::class, 'update']);
    Route::delete('/{id}', [SeccionMenuController::class, 'destroy']);
    Route::post('/filteredList', [SeccionMenuController::class, 'filteredList']);
});

Route::get('/seccion_menu_input', [SeccionMenuInputController::class, 'index']);
Route::get('/seccion_menu_input/{id}', [SeccionMenuInputController::class, 'show']);
Route::prefix('/seccion_menu_input')->group(function(){
    Route::post('/store', [SeccionMenuInputController::class, 'store']);
    Route::put('/{id}', [SeccionMenuInputController::class, 'update']);
    Route::delete('/{id}', [SeccionMenuInputController::class, 'destroy']);
    Route::post('/filteredList', [SeccionMenuInputController::class, 'filteredList']);
});

Route::prefix('/user')->group(function(){
    Route::post('/authenticate', [UserController::class, 'authenticate']);
});