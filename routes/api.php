<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DoctorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas de Agendamento
Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index']);
    Route::post('/', [AppointmentController::class, 'store']);
    Route::get('/{appointment}', [AppointmentController::class, 'show']);
    Route::put('/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/{appointment}', [AppointmentController::class, 'destroy']);
    Route::get('/analytics', [AppointmentController::class, 'analytics']);
    Route::get('/search', [AppointmentController::class, 'search']);
});

// Rotas de Autenticação
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Rotas de Usuário
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::get('/appointments', [UserController::class, 'appointments']);
});

// Rotas de Médico
Route::middleware(['auth:sanctum', 'role:doctor'])->group(function () {
    Route::get('/doctor/appointments', [DoctorController::class, 'appointments']);
    Route::put('/doctor/appointments/{appointment}', [DoctorController::class, 'updateAppointment']);
    Route::get('/doctor/schedule', [DoctorController::class, 'schedule']);
}); 