<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FatherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LessonController;


require __DIR__.'/admin.php';
// صفحات عامة
Route::view('/', 'pages.home')->name('home');
Route::view('/system', 'pages.system')->name('system');
Route::view('/contact_us', 'pages.contact_us')->name('contact_us');
Route::view('/programe', 'pages.program')->name('programe');
Route::view('/calendar', 'pages.calendar')->name('calendar');
Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy.policy');
Route::view('/terms-conditions', 'legal.terms-conditions')->name('terms.conditions');

// دروس وامتحانات وإشعارات (عرض فقط)
Route::view('/lessons', 'lessons.index')->name('lessons.index');
Route::view('/exams', 'exams.index')->name('exams.index');
Route::view('/notifications', 'notifications.index')->name('notifications.index');

// تسجيل الدخول واختيار نوع المستخدم
Route::view('/select_login', 'pages.select_login')->name('select_login');

Route::get('/student/login', [AuthenticatedSessionController::class, 'create'])->name('student_login');
Route::post('/student/login', [AuthenticatedSessionController::class, 'store'])->name('student_login.submit');

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin_login');
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin_login.submit');

Route::get('/teacher/login', [AuthenticatedSessionController::class, 'create'])->name('teacher_login');
Route::post('/teacher/login', [AuthenticatedSessionController::class, 'store'])->name('teacher_login.submit');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/refresh-captcha', [AuthenticatedSessionController::class, 'refreshCaptcha']);

// تسجيل حساب جديد
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

// تسجيل الطالب (بدون auth)
Route::get('student/register', [StudentController::class, 'showRegisterForm'])->name('student.register.form');
Route::post('student/register', [StudentController::class, 'register'])->name('student.register');

// لوحة تحكم الطالب
Route::get('student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
//Route::get('teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

// لوحة تحكم الاستاذ وإدارة الدورات
Route::middleware(['auth', 'is_teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/subjects', [TeacherController::class, 'subjects'])->name('teacher.subjects');
    Route::get('/subjects/create', [TeacherController::class, 'createSubject'])->name('teacher.subjects.create');
    Route::post('/subjects', [TeacherController::class, 'storeSubject'])->name('teacher.subjects.store');
    Route::get('/subjects/{subject}', [TeacherController::class, 'showSubject'])->name('teacher.subjects.show');
    Route::get('/subjects/{subject}/edit', [TeacherController::class, 'editSubject'])->name('teacher.subjects.edit');
    Route::put('/subjects/{subject}', [TeacherController::class, 'updateSubject'])->name('teacher.subjects.update');
    Route::delete('/subjects/{subject}', [TeacherController::class, 'deleteSubject'])->name('teacher.subjects.delete');
    Route::get('/subjects/{subject}/lessons/create', [TeacherController::class, 'createLesson'])->name('teacher.lessons.create');
    Route::post('/subjects/{subject}/lessons', [TeacherController::class, 'storeLesson'])->name('teacher.lessons.store');
    Route::get('/subjects/{subject}/lessons/{lesson}/edit', [TeacherController::class, 'editLesson'])->name('teacher.lessons.edit');
    Route::put('/subjects/{subject}/lessons/{lesson}', [TeacherController::class, 'updateLesson'])->name('teacher.lessons.update');
    Route::delete('/subjects/{subject}/lessons/{lesson}', [TeacherController::class, 'deleteLesson'])->name('teacher.lessons.delete');
    Route::post('/subjects/{subject}/lessons/{lesson}/comments', [TeacherController::class, 'storeComment'])->name('teacher.comments.store');
    Route::post('/subjects/{subject}/lessons/{lesson}/evaluations', [TeacherController::class, 'storeEvaluation'])->name('teacher.evaluations.store');
    Route::get('/subjects/{subject}/lessons/{lesson}', [TeacherController::class, 'showLesson'])->name('teacher.lessons.show');
});




// تحميل صورة الملف الشخصي
Route::post('/profile/upload-image', [ProfileController::class, 'uploadProfileImage'])->name('profile.uploadImage');

// إدارة الملف الشخصي (محمي)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// لوحة تحكم المسؤول وإدارة الدروس والامتحانات (محمي is_admin)
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // دروس
    Route::get('/add-lecon', [AdminController::class, 'showAddLeconForm'])->name('admin.add-lecon');
    Route::post('/lessons', [AdminController::class, 'storeLecon'])->name('admin.lessons.store');
    Route::put('/lessons/{id}', [AdminController::class, 'updateLecon'])->name('admin.lessons.update');
    Route::delete('/lessons/{id}', [AdminController::class, 'deleteLecon'])->name('admin.lessons.destroy');

    // امتحانات
    Route::get('/add-exame', [AdminController::class, 'showAddExameForm'])->name('admin.add-exame');
    Route::post('/exams', [AdminController::class, 'storeExame'])->name('admin.exams.store');
    Route::put('/exams/{id}', [AdminController::class, 'updateExame'])->name('admin.exams.update');
    Route::delete('/exams/{id}', [AdminController::class, 'deleteExame'])->name('admin.exams.destroy');

    // طرق بديلة للوصول إلى النماذج
    Route::get('/lecon', [AdminController::class, 'showAddLeconForm'])->name('admin.lecon');
    Route::get('/exame', [AdminController::class, 'exameForm'])->name('admin.exame');
});

// RESTful route للدروس
Route::resource('lessons', LessonController::class);

// تحميل ملف auth.php
require __DIR__.'/auth.php';
