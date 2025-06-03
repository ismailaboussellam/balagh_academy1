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
use App\Http\Controllers\CoursFrontController;

require __DIR__.'/admin.php'; // تضمين مسارات إدارة المسؤولين
require __DIR__.'/student.php'; // تضمين مسارات إدارة الطلاب
require __DIR__.'/auth.php'; // تضمين مسارات المصادقة (تسجيل دخول/تسجيل خروج)

// صفحات عامة (متاحة لجميع المستخدمين)
Route::view('/', 'pages.home')->name('home'); // عرض صفحة الرئيسية
Route::view('/system', 'pages.system')->name('system'); // عرض صفحة النظام
Route::view('/contact_us', 'pages.contact_us')->name('contact_us'); // عرض صفحة التواصل معنا
Route::view('/programe', 'pages.program')->name('programe'); // عرض صفحة البرنامج
Route::view('/calendar', 'pages.calendar')->name('calendar'); // عرض صفحة التقويم
Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy.policy'); // عرض صفحة سياسة الخصوصية
Route::view('/terms-conditions', 'legal.terms-conditions')->name('terms.conditions'); // عرض صفحة الشروط والأحكام

// مسارات عرض الدروس والامتحانات والإشعارات (عرض فقط)
Route::get('/exams', [TeacherController::class, 'indexExams'])->name('exams.index'); // عرض قائمة الامتحانات
Route::view('/lessons', 'lessons.index')->name('lessons.index'); // عرض قائمة الدروس
Route::view('/notifications', 'notifications.index')->name('notifications.index'); // عرض قائمة الإشعارات

// مسارات اختيار نوع تسجيل الدخول
Route::view('/select_login', 'pages.select_login')->name('select_login'); // عرض صفحة اختيار نوع المستخدم لتسجيل الدخول

// مسارات تسجيل الدخول حسب نوع المستخدم
Route::get('/student/login', [AuthenticatedSessionController::class, 'create'])->name('student_login'); // عرض نموذج تسجيل دخول الطالب
Route::post('/student/login', [AuthenticatedSessionController::class, 'store'])->name('student_login.submit'); // معالجة تسجيل دخول الطالب
Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin_login'); // عرض نموذج تسجيل دخول المسؤول
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin_login.submit'); // معالجة تسجيل دخول المسؤول
Route::get('/teacher/login', [AuthenticatedSessionController::class, 'create'])->name('teacher_login'); // عرض نموذج تسجيل دخول الأستاذ
Route::post('/teacher/login', [AuthenticatedSessionController::class, 'store'])->name('teacher_login.submit'); // معالجة تسجيل دخول الأستاذ
Route::post('/login', [AuthenticatedSessionController::class, 'store']); // معالجة تسجيل الدخول العام
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout'); // معالجة تسجيل الخروج
Route::get('/refresh-captcha', [AuthenticatedSessionController::class, 'refreshCaptcha']); // تحديث صورة التحقق (Captcha)

// مسارات تسجيل حساب جديد
Route::get('register', [RegisteredUserController::class, 'create'])->name('register'); // عرض نموذج التسجيل
Route::post('register', [RegisteredUserController::class, 'store']); // معالجة التسجيل

// مسارات تسجيل الطالب (بدون الحاجة إلى مصادقة مسبقة)
Route::get('student/register', [StudentController::class, 'showRegisterForm'])->name('student.register.form'); // عرض نموذج تسجيل الطالب
Route::post('student/register', [StudentController::class, 'register'])->name('student.register'); // معالجة تسجيل الطالب

// لوحة تحكم الطالب
Route::get('student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard'); // عرض لوحة تحكم الطالب

// لوحة تحكم الأستاذ وإدارة الدورات (محمية بمصادقة الأستاذ)
Route::middleware(['auth', 'is_teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard'); // عرض لوحة تحكم الأستاذ
    Route::get('/exams', [TeacherController::class, 'indexExams'])->name('teacher.exams'); // عرض قائمة الامتحانات
    Route::get('/subjects', [TeacherController::class, 'subjects'])->name('teacher.subjects'); // عرض قائمة المواد
    Route::get('/subjects/create', [TeacherController::class, 'createSubject'])->name('teacher.subjects.create'); // عرض نموذج إضافة مادة
    Route::post('/subjects', [TeacherController::class, 'storeSubject'])->name('teacher.subjects.store'); // معالجة إضافة مادة
    Route::get('/subjects/{subject}', [TeacherController::class, 'showSubject'])->name('teacher.subjects.show'); // عرض تفاصيل مادة
    Route::get('/subjects/{subject}/edit', [TeacherController::class, 'editSubject'])->name('teacher.subjects.edit'); // عرض نموذج تعديل مادة
    Route::put('/subjects/{subject}', [TeacherController::class, 'updateSubject'])->name('teacher.subjects.update'); // معالجة تعديل مادة
    Route::delete('/subjects/{subject}', [TeacherController::class, 'deleteSubject'])->name('teacher.subjects.delete'); // معالجة حذف مادة
    Route::get('/subjects/{subject}/lessons/create', [TeacherController::class, 'createLesson'])->name('teacher.lessons.create'); // عرض نموذج إضافة درس
    Route::post('/subjects/{subject}/lessons', [TeacherController::class, 'storeLesson'])->name('teacher.lessons.store'); // معالجة إضافة درس
    Route::get('/subjects/{subject}/lessons/{lesson}/edit', [TeacherController::class, 'editLesson'])->name('teacher.lessons.edit'); // عرض نموذج تعديل درس
    Route::put('/subjects/{subject}/lessons/{lesson}', [TeacherController::class, 'updateLesson'])->name('teacher.lessons.update'); // معالجة تعديل درس
    Route::delete('/subjects/{subject}/lessons/{lesson}', [TeacherController::class, 'deleteLesson'])->name('teacher.lessons.delete'); // معالجة حذف درس
    Route::post('/subjects/{subject}/lessons/{lesson}/comments', [TeacherController::class, 'storeComment'])->name('teacher.comments.store'); // معالجة إضافة تعليق
    Route::post('/subjects/{subject}/lessons/{lesson}/evaluations', [TeacherController::class, 'storeEvaluation'])->name('teacher.evaluations.store'); // معالجة إضافة تقييم
    Route::get('/subjects/{subject}/lessons/{lesson}', [TeacherController::class, 'showLesson'])->name('teacher.lessons.show'); // عرض تفاصيل درس
    Route::get('/subjects/{subject}/exams/create', [TeacherController::class, 'createExam'])->name('teacher.exams.create'); // عرض نموذج إضافة امتحان
    Route::post('/subjects/{subject}/exams', [TeacherController::class, 'storeExam'])->name('teacher.exams.store'); // معالجة إضافة امتحان
    Route::get('/subjects/{subject}/exams/{exam}/edit', [TeacherController::class, 'editExam'])->name('teacher.exams.edit'); // عرض نموذج تعديل امتحان
    Route::put('/subjects/{subject}/exams/{exam}', [TeacherController::class, 'updateExam'])->name('teacher.exams.update'); // معالجة تعديل امتحان
    Route::delete('/subjects/{subject}/exams/{exam}', [TeacherController::class, 'destroyExam'])->name('teacher.exams.destroy'); // معالجة حذف امتحان
    Route::get('/subjects/{subject}/exams/{exam}', [TeacherController::class, 'showExam'])->name('teacher.exams.show'); // عرض تفاصيل امتحان
    Route::get('/teacher/subjects', [TeacherController::class, 'subjects'])->name('teacher.subjects'); // عرض قائمة المواد (تكرار، يمكن حذفه)

    // إدارة التعليقات
    Route::get('/subjects/{subject}/lessons/{lesson}/comments', [TeacherController::class, 'showLessonComments'])->name('teacher.comments.index'); // عرض قائمة التعليقات
    Route::post('/comments/{comment}/reply', [TeacherController::class, 'replyToComment'])->name('teacher.comments.reply'); // معالجة إضافة رد على تعليق

    // إضافة مسارات جديدة لإدارة التعليقات (تعديل وحذف)
    Route::put('/comments/{comment}', [TeacherController::class, 'updateComment'])->name('teacher.comments.update'); // معالجة تعديل تعليق
    Route::delete('/comments/{comment}', [TeacherController::class, 'deleteComment'])->name('teacher.comments.delete'); // معالجة حذف تعليق

    // إضافة مسارات جديدة لإدارة التقييمات (تعديل وحذف)
    Route::put('/evaluations/{evaluation}', [TeacherController::class, 'updateEvaluation'])->name('teacher.evaluations.update'); // معالجة تعديل تقييم
    Route::delete('/evaluations/{evaluation}', [TeacherController::class, 'deleteEvaluation'])->name('teacher.evaluations.delete'); // معالجة حذف تقييم
});

// إدارة الدورات (جبهة المستخدم)
Route::get('/cours', [CoursFrontController::class, 'index'])->name('cours.index'); // عرض قائمة الدورات
Route::get('/cours/{id}/details', [CoursFrontController::class, 'details'])->name('cours.details'); // عرض تفاصيل دورة
Route::get('/cours/{id}/learn', [CoursFrontController::class, 'learn'])->name('cours.learn'); // عرض صفحة التعلم لدورة
Route::post('/cours/{id}/payment', [CoursFrontController::class, 'payment'])->name('cours.payment'); // معالجة الدفع لدورة

// تحميل صورة الملف الشخصي
Route::post('/profile/upload-image', [ProfileController::class, 'uploadProfileImage'])->name('profile.uploadImage'); // معالجة تحميل صورة الملف الشخصي

// إدارة الملف الشخصي (محمي بمصادقة)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // عرض نموذج تعديل الملف الشخصي
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // معالجة تحديث الملف الشخصي
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // معالجة حذف الملف الشخصي
});

// لوحة تحكم المسؤول وإدارة الدروس والامتحانات (محمي بمصادقة المسؤول)
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); // عرض لوحة تحكم المسؤول

    // إدارة الدروس
    Route::get('/add-lecon', [AdminController::class, 'showAddLeconForm'])->name('admin.add-lecon'); // عرض نموذج إضافة درس
    Route::post('/lessons', [AdminController::class, 'storeLecon'])->name('admin.lessons.store'); // معالجة إضافة درس
    Route::put('/lessons/{id}', [AdminController::class, 'updateLecon'])->name('admin.lessons.update'); // معالجة تعديل درس
    Route::delete('/lessons/{id}', [AdminController::class, 'deleteLecon'])->name('admin.lessons.destroy'); // معالجة حذف درس

    // إدارة الامتحانات
    Route::get('/add-exame', [AdminController::class, 'showAddExameForm'])->name('admin.add-exame'); // عرض نموذج إضافة امتحان
    Route::post('/exams', [AdminController::class, 'storeExame'])->name('admin.exams.store'); // معالجة إضافة امتحان
    Route::put('/exams/{id}', [AdminController::class, 'updateExame'])->name('admin.exams.update'); // معالجة تعديل امتحان
    Route::delete('/exams/{id}', [AdminController::class, 'deleteExame'])->name('admin.exams.destroy'); // معالجة حذف امتحان

    // طرق بديلة للوصول إلى النماذج
    Route::get('/lecon', [AdminController::class, 'showAddLeconForm'])->name('admin.lecon'); // عرض نموذج إضافة درس (بديل)
    Route::get('/exame', [AdminController::class, 'exameForm'])->name('admin.exame'); // عرض نموذج إضافة امتحان (بديل)
});

// مسار RESTful للدروس
Route::resource('lessons', LessonController::class); // تعريف مسارات CRUD للدروس
