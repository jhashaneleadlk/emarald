<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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

        if (App::environment('production')) {
            $this->renderable(function (MethodNotAllowedHttpException $e) {
                abort(404);
            });
        }

        $this->renderable(function (UnauthorizedException $e) {
            if (!request()->isMethod('GET')) {
                return response()->json(['error' => 'You are not authorize for this action'], 403);
            }
            abort(403, 'You are not authorize for this action');
        });
    }
}
