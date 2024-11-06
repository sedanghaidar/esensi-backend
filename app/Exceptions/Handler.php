<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function unauthenticated($request, AuthenticationException $ex)
    {
        if ($request->is('api/*')) { // for routes starting with `/api`
            return response()->json([
                'success' => false, 'code' => 401,
                'message' => $ex->getMessage(),
                'result' => null,
            ], 401);
        }

        return redirect('/login'); // for normal routes
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
