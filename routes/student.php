<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::middleware(['auth', 'is_student'])->prefix('student')->group(function () {

    Route::get('/lesson', [StudentController::class, 'lessons'])->name('student.lessons');
    Route::get('/lesson/{id}', [StudentController::class, 'showLesson'])->name('student.lessons.show');
    Route::get('/exam', [StudentController::class, 'exams'])->name('student.exams');
    Route::get('/notification', [StudentController::class, 'notifications'])->name('student.notifications');
});
