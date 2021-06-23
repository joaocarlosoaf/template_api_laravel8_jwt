<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use function PHPUnit\Framework\returnSelf;

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
        'current_password',
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

        $this->renderable(function(Exception $e, $request) {
            if ($e instanceof NotFoundHttpException){
                if($request->expectsJson())
                    return response()->json(['error' => 'Not found URI'], 404);
            }
            
            if ($e instanceof MethodNotAllowedHttpException){
                if($request->expectsJson())
                    return response()->json(['error' => 'Method not allowed'], 405);
            }

            if ($e instanceof TokenExpiredException)
                return response()->json(['token_expired'], $e->getStatusCode());
            
            if ($e instanceof TokenInvalidException) 
                return response()->json(['token_invalid'], $e->getStatusCode());
            
        });
    }

}
