<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [App\Http\Controllers\AuthController::class, 'Login']);

Route::middleware(['APIAuth'])->group(function () {

    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('gerente', [App\Http\Controllers\AuthController::class, 'Gerente']);

    Route::get('grupos', [App\Http\Controllers\GrupoController::class, 'Grupos']);
    Route::get('grupo/{id}', [App\Http\Controllers\GrupoController::class, 'Grupo']);

    // Apenas gerente de nível 2
    Route::middleware(['GerenteN2'])->group(function () {
        
        Route::post('grupo', [App\Http\Controllers\GrupoController::class, 'Criar']);
        Route::put('grupo', [App\Http\Controllers\GrupoController::class, 'Editar']);
        Route::delete('grupo', [App\Http\Controllers\GrupoController::class, 'Deletar']);

    });

    Route::get('clientes', [App\Http\Controllers\ClienteController::class, 'Clientes']);
    Route::get('cliente/{id}', [App\Http\Controllers\ClienteController::class, 'Cliente']);
    Route::post('cliente', [App\Http\Controllers\ClienteController::class, 'Criar']);
    Route::put('cliente', [App\Http\Controllers\ClienteController::class, 'Editar']);
    Route::delete('cliente', [App\Http\Controllers\ClienteController::class, 'Deletar']);

});
