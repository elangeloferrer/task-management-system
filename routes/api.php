<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::middleware('frontend')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', [AuthController::class, 'getAuthenticatedUser']);
    });

    Route::middleware(['auth:sanctum', 'checkAdmin:admin'])->group(function () {

        Route::get('/users', [UserController::class, 'index']);
    });
});
