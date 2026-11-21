<?php

use App\Http\Controllers\AcademyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Todas las rutas de este archivo empiezan por /api

// Registro e inicio de sesión: son públicas, todavía no se tiene token
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Ruta no-REST para ver los cursos de una academia: también es pública
Route::get('/academy/{academy}/courses', [AcademyController::class, 'courses']);

// Rutas que necesitan la cabecera Authorization: Bearer <token>
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Las 5 rutas REST (index, store, show, update, destroy) de cada recurso
    Route::apiResource('academies', AcademyController::class);
    Route::apiResource('courses', CourseController::class);

    // Rutas no-REST de la relación N:N entre cursos y estudiantes
    Route::get('/course/{course}/students', [CourseController::class, 'students']);
    Route::post('/courses/{course}/enroll/{student}', [CourseController::class, 'enroll']);
});
