<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/filiers', [AdminController::class, 'filiers'])->name('admin.filiers');
    Route::get('/groups', [AdminController::class, 'groups'])->name('admin.groups');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');
    Route::get('/lessons', [AdminController::class, 'lessons'])->name('admin.lessons');
});