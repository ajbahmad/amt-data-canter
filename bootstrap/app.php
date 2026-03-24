<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Add CSRF and session middleware explicitly for all web routes
        $middleware->web(append: [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
        ]);
        
        // Exclude debug routes from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'debug/*',
        ]);

        // Register RBAC middleware aliases
        $middleware->alias([
            'auth.menu' => \App\Http\Middleware\CheckMenuAccess::class,
            'auth.role' => \App\Http\Middleware\CheckRoleAccess::class,
            'validate.api.client' => \App\Http\Middleware\ValidateApiClient::class,
            'auth.api.token' => \App\Http\Middleware\ValidateApiToken::class,
            'validate.menu.permission' => \App\Http\Middleware\ValidateMenuPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
