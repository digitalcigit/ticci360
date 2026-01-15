<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                $code = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
                // Use default code 500 if getStatusCode returns 0 or non-standard code for HTTP
                if ($code < 100 || $code > 599) {
                    $code = 500;
                }

                return response()->json([
                    'data' => null,
                    'meta' => [
                        'success' => false,
                        'message' => $e->getMessage(),
                        'timestamp' => now()->toIso8601String(),
                        'debug' => config('app.debug') ? [
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                            'trace' => $e->getTrace(),
                        ] : null,
                    ],
                ], $code);
            }
        });
    }
}
