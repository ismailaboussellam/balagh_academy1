<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsTeacher;
use App\Http\Middleware\IsStudent;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware globaux (global middleware)
        // $middleware->append(SomeMiddleware::class);

        // تسجيل middleware خاص بالروتات
        $middleware->alias([
            'is_admin' => IsAdmin::class,
            'is_teacher' => IsTeacher::class,
            'is_student' => IsStudent::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
