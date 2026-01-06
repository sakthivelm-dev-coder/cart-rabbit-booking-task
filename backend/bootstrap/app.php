<?php

use App\Http\Middleware\CorsFix;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cors-fix' => \App\Http\Middleware\CorsFix::class,
        ]);

        // Optional: apply globally
        $middleware->append(\App\Http\Middleware\CorsFix::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
