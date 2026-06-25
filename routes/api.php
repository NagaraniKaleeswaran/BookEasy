<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\TimeSlotController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ContactController;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/contact', [ContactController::class, 'store']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/services', [ServiceController::class, 'index']);
    
    Route::apiResource('appointments', AppointmentController::class)->except(['create', 'edit']);
    
    Route::get('/available-slots', [TimeSlotController::class, 'index']);
    
    Route::get('/profile', [CustomerController::class, 'profile']);
    Route::get('/appointment-history', [CustomerController::class, 'history']);
    
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    
    Route::get('/contact-messages', [ContactController::class, 'index']);
});
