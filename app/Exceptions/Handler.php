<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
	
	protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
{
    // Check if the request expects JSON (API request)
    if ($request->expectsJson()) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    // For web requests (if needed), redirect to the login page
    return redirect()->guest(route('login'));
}
}
