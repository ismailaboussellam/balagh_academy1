<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FatherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LessonController;



// صفحة البداية
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/system', function () {
    return view('pages.system');
})->name('system');

Route::get('/contact_us', function () {
    return view('pages.contact_us');
})->name('contact_us');

Route::get('/programe', function () {
    return view('pages.program');
})->name('programe');

Route::get('/calendar', function () {
    return view('pages.calendar');
})->name('calendar');


Route::get('/lessons', [LessonController::class, 'index']);
Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy.policy');
Route::view('/terms-conditions', 'legal.terms-conditions')->name('terms.conditions');

// تسجيل الدخول والخروج
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// تسجيل الطالب (بدون auth)
Route::get('student/register', [StudentController::class, 'showRegisterForm'])->name('student.register.form');
Route::post('student/register', [StudentController::class, 'register'])->name('student.register');

Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('student/dashboard', function() {
    return view('dashboard');
})->name('student.dashboard');

// ... existing code ...
Route::get('/lessons', function () {
    return view('lessons.index');
})->name('lessons.index');

Route::get('/exams', function () {
    return view('exams.index');
})->name('exams.index');

Route::get('/notifications', function () {
    return view('notifications.index');
})->name('notifications.index');
// ... existing code ...



// مجموعة محمية بالمصادقة
Route::middleware('auth')->group(function () {
    // بروفايل
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// profile immage picture

Route::post('/profile/upload-image', [ProfileController::class, 'uploadProfileImage'])->name('profile.uploadImage');



Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::get('/admin/lecon', [AdminController::class, 'showLeconForm']);
Route::post('/admin/lecon', [AdminController::class, 'storeLecon']);
Route::delete('/admin/lecon/{id}', [AdminController::class, 'deleteLecon']);

Route::get('/admin/exame', [AdminController::class, 'exameForm']);
Route::post('/admin/exame', [AdminController::class, 'storeExame']);
Route::delete('/admin/exame/{id}', [AdminController::class, 'deleteExame']);

Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/lecon', [AdminController::class, 'showAddLeconForm'])->name('admin.lecon');
});

Route::resource('lessons', LessonController::class);

// auth.php
require __DIR__.'/auth.php';
