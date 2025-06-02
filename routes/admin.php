<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\FilierGroupController;
use App\Http\Controllers\Admin\ProfController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\EmploiController;


Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    // ... routes ...

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    // Route::get('/filiers', [AdminController::class, 'filiers'])->name('admin.filiers');
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

    

    
    Route::get('/filiers', [FilierGroupController::class, 'index'])->name('admin.filiers.index');
    Route::post('/filiers/store', [FilierGroupController::class, 'storeFilier'])->name('admin.filiers.store');
    Route::put('/filiers/{id}/update', [FilierGroupController::class, 'updateFilier'])->name('admin.filiers.update');
    Route::delete('/filiers/{id}/destroy', [FilierGroupController::class, 'destroyFilier'])->name('admin.filiers.destroy');
    
    Route::post('/groupes/store', [FilierGroupController::class, 'storeGroupe'])->name('admin.groupes.store');
    Route::put('/groupes/{id}/update', [FilierGroupController::class, 'updateGroupe'])->name('admin.groupes.update');
    Route::delete('/groupes/{id}/destroy', [FilierGroupController::class, 'destroyGroupe'])->name('admin.groupes.destroy');


    

    Route::get('/teachers', [ProfController::class, 'index'])->name('admin.teachers.index');
    Route::post('/teachers/store', [ProfController::class, 'store'])->name('admin.teachers.store');
    Route::put('/teachers/{id}/update', [ProfController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/teachers/{id}/destroy', [ProfController::class, 'destroy'])->name('admin.teachers.destroy');


    

Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('admin.students.update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('admin.students.destroy');



Route::get('/emplois', [EmploiController::class, 'index'])->name('admin.emplois.index');
Route::post('/emplois', [EmploiController::class, 'store'])->name('admin.emplois.store');
Route::put('/emplois/{emploi}', [EmploiController::class, 'update'])->name('admin.emplois.update');
Route::delete('/emplois/{emploi}', [EmploiController::class, 'destroy'])->name('admin.emplois.destroy');

});
