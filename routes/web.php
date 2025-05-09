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
    Route::resource('users', \App\Http\Controllers\UserController::class);

    // Roles routes
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
