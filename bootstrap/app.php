<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // <-- PASTIKAN INI ADA

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ... (Middleware web default Laravel mungkin sudah ada di sini) ...

        // Tambahkan alias untuk middleware AdminMiddleware
        $middleware->alias([
            'admin' => AdminMiddleware::class, // <-- PASTIKAN BARIS INI ADA
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();