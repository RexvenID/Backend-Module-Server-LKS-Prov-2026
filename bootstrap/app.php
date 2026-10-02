<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*'),
        );

        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid field',
                    'errors' => $e->errors(),
                ],
                422
            );
        }
        );

        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Unauthenticated.',
                ],
                401
            );
        }
        );

        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 403) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Forbidden access',
                ], 403);
            }

            if ($e->getStatusCode() === 404) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Not found',
                ], 404);
            }
        });


    })->create();
