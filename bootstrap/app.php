<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(fn (Throwable $e) => Log::error($e));

        $exceptions->renderable(fn (ValidationException $e) => response()->json([
            'code'    => 'wrong_values',
            'message' => $e->validator->errors()->first(),
            'errors'  => $e->errors(),
        ], 422));

        $exceptions->renderable(fn (Illuminate\Auth\AuthenticationException $e) => response()->json([
            'code' => 'unauthenticated',
        ], 401));

        if (! env('APP_DEBUG') && Request::wantsJson()) {
            $exceptions->renderable(fn (Throwable $e) => response()->json([
                'code'    => 'internal_error',
                'message' => $e->getMessage(),
            ], 500));
        }

        $exceptions->shouldRenderJsonWhen(fn (Request $request, Throwable $e) => $request->wantsJson() || $request->is('api/*'));
    })->create();
