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
use App\Http\Controllers\SueldosSalariosController;
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
    Route::post('/allowed_menus', [AccionGrupoController::class, 'get_allowed_menus']);
    Route::post('/allowed_table_actions', [AccionGrupoController::class, 'get_allowed_table_actions']);
    Route::post('/allowed_navbar', [AccionGrupoController::class, 'get_allowed_navbar']);
    Route::post('/has_xls_button', [AccionGrupoController::class, 'get_xls_button']);
});

Route::get('/grupo', [GrupoController::class, 'index']);
Route::get('/grupo/{id}', [GrupoController::class, 'show']);
Route::prefix('/grupo')->group(function(){
    Route::post('/store', [GrupoController::class, 'store']);
    Route::put('/{id}', [GrupoController::class, 'update']);
    Route::delete('/{id}', [GrupoController::class, 'destroy']);
});

Route::get('/seccion_menu', [SeccionMenuController::class, 'index']);
Route::get('/seccion_menu/{id}', [SeccionMenuController::class, 'show']);
Route::prefix('/seccion_menu')->group(function(){
    Route::post('/store', [SeccionMenuController::class, 'store']);
    Route::put('/{id}', [SeccionMenuController::class, 'update']);
    Route::delete('/{id}', [SeccionMenuController::class, 'destroy']);
    Route::post('/desc', [SeccionMenuController::class, 'get_seccion_menu']);
});

Route::get('/seccion_menu_input', [SeccionMenuInputController::class, 'index']);
Route::get('/seccion_menu_input/{id}', [SeccionMenuInputController::class, 'show']);
Route::prefix('/seccion_menu_input')->group(function(){
    Route::post('/store', [SeccionMenuInputController::class, 'store']);
    Route::put('/{id}', [SeccionMenuInputController::class, 'update']);
    Route::delete('/{id}', [SeccionMenuInputController::class, 'destroy']);
    Route::post('/inputs', [SeccionMenuInputController::class, 'get_inputs_alta']);
    Route::post('/inputs_modifica', [SeccionMenuInputController::class, 'get_inputs_modifica']);
    Route::post('/table_columns', [SeccionMenuInputController::class, 'get_table_columns']);
    Route::post('/inputs_filtro', [SeccionMenuInputController::class, 'get_inputs_filtro']);
});

Route::get('/sueldos_salarios', [SueldosSalariosController::class, 'index']);
Route::get('/sueldos_salarios/{id}', [SueldosSalariosController::class, 'show']);
Route::prefix('/sueldos_salarios')->group(function(){
    Route::post('/store', [SueldosSalariosController::class, 'store']);
    Route::put('/{id}', [SueldosSalariosController::class, 'update']);
    Route::delete('/{id}', [SueldosSalariosController::class, 'destroy']);
    Route::post('/calcula_sueldos_salarios', [SueldosSalariosController::class, 'calcula_valores_sueldos_salarios']);
    Route::post('/neto_aprox', [SueldosSalariosController::class, 'obten_aproximacion_neto']);
});

Route::get('/user', [UserController::class, 'index']);
Route::prefix('/user')->group(function(){
    Route::post('/authen', [UserController::class, 'authenticate']);
    Route::get('/auth_error', [UserController::class, 'auth_error'])->name('auth_error');
});