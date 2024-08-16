<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TaskController;


Route::middleware(['cors'])->group(function () {
    Route::post('/register/user', [RegisteredUserController::class, 'store'])->name('api.register.user');
    Route::post('/login/user', [AuthenticatedSessionController::class, 'apiStore'])->name('api.login.user');
    Route::post('/logout/user', [AuthenticatedSessionController::class, 'destroy'])->name('api.logout.user');
});

Route::prefix('/')->middleware(['auth:sanctum'])->group(function () {
    Route::resource('task', TaskController::class);
});
