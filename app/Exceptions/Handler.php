<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    }

    /**
     * To handle general errors
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Task not found.'], 404);
        } 
        
        if ($exception instanceof AuthorizationException) {
            return response()->json(['error' => $exception->getMessage()], 403);
        }

        return parent::render($request, $exception);
    }
}
