<?php

use App\Http\Controllers\AcademyController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Todas las rutas de este archivo empiezan por /api

// Registro e inicio de sesión: son públicas, todavía no se tiene token
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas que necesitan la cabecera Authorization: Bearer <token>
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Las 5 rutas REST (index, store, show, update, destroy) de las academias
    Route::apiResource('academies', AcademyController::class);
});
