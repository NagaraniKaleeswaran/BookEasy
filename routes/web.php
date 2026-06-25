<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaffAvailabilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('public.home'); })->name('home');
Route::get('/services', function () { return view('public.services'); })->name('services');
Route::get('/contact', function () { return view('public.contact'); })->name('contact');
Route::get('/book', function () { return view('public.book'); })->name('book');

// Replace default dashboard route with our Admin Dashboard
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('appointments', AppointmentController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('staff-availability', StaffAvailabilityController::class);
});

// Regular auth routes (Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
