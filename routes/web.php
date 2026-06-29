<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('sprints', App\Http\Controllers\SprintController::class)->middleware('auth');
});

require __DIR__.'/settings.php';
