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
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e, $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            // 404 Not Found
            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                return errorResponse([], 'Resource Not Found', 404);
            }

            // Validation Errors
            if ($e instanceof ValidationException) {
                return errorResponse($e->errors(), 'Validation errors', 422);
            }

            // Unauthorized (not logged in / invalid token)
            if ($e instanceof UnauthorizedHttpException) {
                return errorResponse([], 'Unauthorized', 401);
            }

            // Forbidden (no permission)
            if ($e instanceof AccessDeniedHttpException) {
                return errorResponse([], 'Forbidden', 403);
            }

            // Any other server error
            return errorResponse(
                [],
                app()->isProduction() ? 'Server error' : $e->getMessage(),
                500
            );
        });
    }
}
