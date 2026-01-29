<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {

            // Only for API
            if (! $request->is('api/*')) {
                return null;
            }

            // 404
            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                return errorResponse([], 'Resource Not Found', 404);
            }

            // Validation
            if ($e instanceof ValidationException) {
                return errorResponse($e->errors(), 'Validation errors', 422);
            }

            // Unauthorized
            if ($e instanceof UnauthorizedHttpException) {
                return errorResponse([], 'Unauthorized', 401);
            }

            // Forbidden
            if ($e instanceof AccessDeniedHttpException) {
                return errorResponse([], 'Forbidden', 403);
            }


        });
    }
}
