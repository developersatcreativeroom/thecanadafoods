<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //

        // $middleware->use([
        //     \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
        //     // \Illuminate\Http\Middleware\TrustHosts::class,
        //     \Illuminate\Http\Middleware\TrustProxies::class,
        //     \Illuminate\Http\Middleware\HandleCors::class,
        //     \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        //     \Illuminate\Http\Middleware\ValidatePostSize::class,
        //     \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        //     \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        // ]);

        $middleware->alias([
            // 'auth' => \App\Http\Middleware\Authenticate::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'permissions' => \App\Http\Middleware\Permission::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'remove.page1' => \App\Http\Middleware\RemovePageOne::class,
            
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
