<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// V1 API Routes with dashboard middleware group
Route::prefix('v1')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', function (){return Inertia::render('Dashboard');})->name('dashboard');;

    // Users routes
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::resource('users', \App\Http\Controllers\UserController::class)->except('index');

    // Roles routes
    Route::get('roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
