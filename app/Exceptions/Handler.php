<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        $this->renderable(function (UnauthorizedException $e, Request $request) {
            if( $request->wantsJson() ){
                return response()->json( [
                    'message' => 'Unauthorized.',
                ], 403);
            }
            //
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if( $request->wantsJson() ){
                return response()->json( [
                    'message' => 'Not found.',
                ], 404);
            }
            //
        });
    }
}
