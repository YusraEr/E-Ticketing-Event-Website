<?php

use App\Http\Middleware\IsNotAuth;
use Illuminate\Foundation\Application;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OrganizerMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin' => AdminMiddleware::class,
            'is_organizer' => OrganizerMiddleware::class,
            'is_user' => UserMiddleware::class,
            'is_not_auth' => IsNotAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
