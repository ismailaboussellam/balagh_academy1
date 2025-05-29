<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    // ... routes ...

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/filiers', [AdminController::class, 'filiers'])->name('admin.filiers');
    // Route::get('/groups', [AdminController::class, 'groups'])->name('admin.groups');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');
    Route::get('/lessons', [AdminController::class, 'lessons'])->name('admin.lessons');




    // Add these routes to your existing admin.php file
    Route::prefix('cours')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CoursController::class, 'index'])->name('admin.cours.index');
        Route::post('/', [App\Http\Controllers\Admin\CoursController::class, 'store'])->name('admin.cours.store');
        Route::get('/{cours}', [App\Http\Controllers\Admin\CoursController::class, 'show'])->name('admin.cours.details');
        Route::get('/{cours}/edit', [App\Http\Controllers\Admin\CoursController::class, 'edit'])->name('admin.cours.edit');
        Route::put('/{cours}', [App\Http\Controllers\Admin\CoursController::class, 'update'])->name('admin.cours.update');
        Route::delete('/{cours}', [App\Http\Controllers\Admin\CoursController::class, 'destroy'])->name('admin.cours.destroy');
        
        // Files routes
        Route::post('/{cours}/fichier', [App\Http\Controllers\Admin\CoursController::class, 'storeFichier'])->name('admin.cours.fichier.store');
        Route::delete('/fichier/{fichier}', [App\Http\Controllers\Admin\CoursController::class, 'destroyFichier'])->name('admin.cours.fichier.destroy');
        
        // Videos routes
        Route::post('/{cours}/video', [App\Http\Controllers\Admin\CoursController::class, 'storeVideo'])->name('admin.cours.video.store');
        Route::delete('/video/{video}', [App\Http\Controllers\Admin\CoursController::class, 'destroyVideo'])->name('admin.cours.video.destroy');
    });
});
