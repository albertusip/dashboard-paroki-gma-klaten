<?php

namespace App\Exceptions;

use Exception;
use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
       if ($exception instanceof NotFoundHttpException) {
            return InvalidRouteException::render();
        } else if ($exception instanceof AuthenticationException) {
            return InvalidTokenException::render();
        } else if ($exception instanceof ModelNotFoundException) {
            return InvalidParameterException::render();
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return InvalidRouteException::render();
        } else if ($exception instanceof MethodNotAllowedException) {
            return InvalidRouteException::render();
        } else if (config('constants.mode') == 'production' && config('constants.debug') == false) {
            if ($exception instanceof QueryException) {
                return InvalidParameterException::render();
            }

            if ($exception instanceof ErrorException) {
                return InvalidParameterException::render();
            }
        }

        return parent::render($request, $exception);
    }
}
